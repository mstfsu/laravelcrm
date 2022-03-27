<?php


namespace App\Library;

use mysqli;
use PDO;
use ZipArchive;

class BackupMysql
{
    private $dir ='';  //folder to store ZIP archive with SQL backup
    protected $conn_mod = 'mysqli';  // 'pdo', or 'mysqli'
    public $mysql = [];  //data for connection to database [host, user, pass, dbname]
    protected $conn = false;            // stores the connection to mysql
    public $fetch = 'assoc';        // 'assoc' - columns with named index, 'num' - columns numerically indexed, Else - both
    public $num_rows =0;  //number of rows in select results
    public $error = false;          // to store and check for errors
  function  __construct( $dir ='backup'){

        if($dir !='') $this->dir =   $dir ;
    }
    public function restore($zp){
echo  $this->dir ."/" .$zp;
        $zip = new ZipArchive();
       // $ss=$zip->open($this->dir ."/" .$zp);

        if($zip->open($this->dir ."/". $zp) === TRUE) {

            $sql = $zip->getFromIndex(0);  //Get the backup content of the first file in ZIP
            $sql = preg_replace('/^-- # .*[\r\n]*/m', '', $sql);  //removes sql comments
            $zip->close();

            //if $sql size <50 MB execute with PHP, else from Shell
            if(floor(strlen($sql)/(1024*1024)) <50){
//        $resql = $this->multiQuery($zip->open($this->dir . 'temp.spl'));
//        $sql ='';  //free memory
//        $re = ($resql) ? $this->langTxt('ok_res_backup') : $this->langTxt('er_res_backup');

                if(file_put_contents($this->dir .'temp.sql', $sql)) {

                    $restore_file = realpath($this->dir . 'temp.sql');

                    $cmd = "mysql -h {$this->mysql['host']} -u {$this->mysql['user']} -p{$this->mysql['pass']} {$this->mysql['dbname']} < $restore_file";

                    exec($cmd, $out, $ere);

                    $re = (!$ere) ? "Database has been restored successfully": "Error Restore Backup";
                    unlink($this->dir .'temp.sql');  //delete the temp.sql
                }
            }
            else if(function_exists('exec')){

                //put the SQL into a temp.sql
                if(file_put_contents($this->dir .'temp.sql', $sql)){
                    $zip ='';  $sql ='';  //free memory

                    //get mysql.exe lcation, build command that can execute sql in shell (with exec())
                    $resql = $this->sqlExec("SHOW VARIABLES LIKE 'basedir'");
                    $mysql_exe = $resql[0]['Value']. '/bin/mysql';
                    $cmd = $mysql_exe ." -h {$this->mysql['host']} --user={$this->mysql['user']} --password={$this->mysql['pass']}  -D {$this->mysql['dbname']} < ". realpath($this->dir .'temp.sql');
                    exec($cmd, $out, $ere);
                    $re = (!$ere) ? "Database has been restored successfully " : "Error Restore Database";

                    @unlink($this->dir .'temp.sql');  //delete the temp.sql
                }
                else $re = sprintf("Error write in ", $this->dir);
            }
            else $this->langTxt('er_exec');
        }
        else {echo "no";
            $re = sprintf("Error Open file ", $zp);
        }

        return $re;
    }
    private function sqlExec($sql) {
        if($this->conn === false || $this->conn === NULL) $this->setConn($this->mysql);      // sets the connection to mysql
        $this->affected_rows = 0;  // resets previous registered data
        $re = true;

        // if there is a connection set ($conn property not false)
        if($this->conn !== false) {
            // gets the first word in $sql, to determine whenb SELECT query
            $ar_mode = explode(' ', trim($sql), 2);
            $mode = strtolower($ar_mode[0]);
            $this->error = false;   // to can perform current $sql if previous has error

            // execute query
            if($this->conn_mod == 'pdo') {
                try {
                    if($mode == 'select' || $mode == 'show') {
                        $sqlre = $this->conn->query($sql);
                        $re = $this->getSelectPDO($sqlre);
                    }
                    else $this->conn->exec($sql);
                }
                catch(\PDOException $e) { $this->setSqlError($e->getMessage()); }
            }
            else if($this->conn_mod == 'mysqli') {
                $sqlre = $this->conn->query($sql);
                if($sqlre){
                    if($mode == 'select' || $mode == 'show') $re = $this->getSelectMySQLi($sqlre);
                }
                else {
                    if(isset($this->conn->error_list[0]['error'])) $this->setSqlError($this->conn->error_list[0]['error']);
                    else $this->setSqlError('Unable to execute the SQL query');
                }
            }
        }

        // sets to return false in case of error
        if($this->error !== false) $re = false;
        return $re;
    }
    protected function setConn($mysql) {
        // sets the connection method, check if can use pdo or mysqli
        if($this->conn_mod == 'pdo') {
            if(extension_loaded('PDO') === true) $this->conn_mod = 'pdo';
            else if(extension_loaded('mysqli') === true) $this->conn_mod = 'mysqli';
        }
        else if($this->conn_mod == 'mysqli') {
            if(extension_loaded('mysqli') === true) $this->conn_mod = 'mysqli';
            else if(extension_loaded('PDO') === true) $this->conn_mod = 'pdo';
        }

        if($this->conn_mod == 'pdo') $this->connPDO($mysql);
        else if($this->conn_mod == 'mysqli') $this->connMySQLi($mysql);
        else $this->setSqlError($this->langTxt('er_conn'));
    }
    protected function connPDO($mysql) {
        try {
            // Connect and create the PDO object
            $this->conn = new PDO("mysql:host=".$mysql['host']."; dbname=".$mysql['dbname'], $mysql['user'], $mysql['pass']);

            // Sets to handle the errors in the ERRMODE_EXCEPTION mode
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Sets transfer with encoding UTF-8
            $this->conn->exec('SET character_set_client="utf8",character_set_connection="utf8",character_set_results="utf8";');
        }
        catch(\PDOException $e) {
            $this->setSqlError($e->getMessage());
        }
    }

    protected function connMySQLi($mysql) {
        // if the connection is successfully established
        if($this->conn = new mysqli($mysql['host'], $mysql['user'], $mysql['pass'], $mysql['dbname'])) {
            $this->conn->query('SET character_set_client="utf8",character_set_connection="utf8",character_set_results="utf8";');
        }
        else if (mysqli_connect_errno()) $this->setSqlError('MySQL connection failed: '. mysqli_connect_error());

    }
    public function setMysql($conn_data){
        $this->mysql = $conn_data;
    }

    protected function getSelectMySQLi($sqlre) {
        $re = [];
        $fetch = ($this->fetch == 'assoc') ? MYSQLI_ASSOC :(($this->fetch == 'num') ? MYSQLI_NUM : MYSQLI_BOTH);
        // gets the results to return
        while($row = $sqlre->fetch_array($fetch)) {
            $re[] = $row;
        }
        $this->num_rows = count($re);  //number of returned rows

        return $re;
    }

}
