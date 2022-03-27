/*=========================================================================================
    File Name: app-user-list.js
    Description: User List page
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent

==========================================================================================*/
Dropzone.autoDiscover = false;
$(function () {
    'use strict';
    var select = $('.select2');
    var   rangePickr = $('.flatpickr-range');
    var csrf= $('meta[name="csrf-token"]').attr('content');
    Dropzone.autoDiscover = false;
    var dtUserTable = $('.users-list-table'),
        passwordmodal=$('#chnagepassmodal') ;
    var admin_id= $('meta[name="admin-id"]').attr('content');

    var startdate;
    var finishdate;
    var assetPath = '../../../app-assets/',
        userView = 'app-user-view.html',
        userEdit = 'app-user-edit.html';
    if ($('body').attr('data-framework') === 'laravel') {
        assetPath = $('body').attr('data-asset-path');
        userView = assetPath + 'app/user/view';
        userEdit = assetPath + 'app/user/edit';
    }
    select.each(function () {
        var $this = $(this);
        $this.wrap('<div class="position-relative"></div>');
        $this.select2({
            // the following code is used to disable x-scrollbar when click in select input and
            // take 100% width in responsive also
            dropdownAutoWidth: true,
            width: '100%',
            dropdownParent: $this.parent()
        });
    });

    if (rangePickr.length) {
        rangePickr.flatpickr({
            mode: 'range',
            dateFormat: "Y-m-d",
            altFormat: "Y-m-d",
            defaultDate: [new Date(), new Date()],
            onClose: function (selectedDates, dateStr, instance) {
                var _this=this;
                console.log(selectedDates);
                var dateArr=selectedDates.map(function(date){return _this.formatDate(date,'d-m-Y');});
                startdate=dateArr[0];
                finishdate=dateArr[1];
                dtUserTable.DataTable().destroy();
                initUserTable();
            },
            onReady: function (selectedDates, dateStr, instance) {
                var _this=this;

                var dateArr=selectedDates.map(function(date){return _this.formatDate(date,'d-m-Y');});
                startdate=dateArr[0];
                finishdate=dateArr[1];

            }

        });
    }


    var handleDropzone = function () {



        var myDropzoneOptions = {
            maxFilesize: 1,
            acceptedFiles: '.xls,.xlsx',
            addRemoveLinks: true,
            clickable: true,
            headers: {
                'X-CSRF-TOKEN': csrf

            }
        };
        var myDropzone = new Dropzone('#m-dropzone-import', myDropzoneOptions);



        myDropzone.on('success', function (file) {
            $('#import_users_jobs').attr('disabled',false)

        });



    }
     handleDropzone()

    window.Echo.channel('ExportChannel'+admin_id)
        .listen('ExportCompleted', (e) => {
            console.log(e);
           window.location.replace("/storage/"+e.file)
        });
    $('body').on('click','#import_users_jobs',function (){
        $('#import_users_jobs').attr('disabled',true)
        var send_sms=$('#sms_checkswitch').is(':checked')
        var send_email=$('#email_check_switch').is(':checked')
        $.ajax({
            url: '/ISP/users/Import_xlsx',
            type: 'get',
            dataType: "json",
            data:{send_sms:send_sms,send_email:send_email},

            success: function(res){
                toastr['success'](  "Users Added to the Queue , will inform you when finish", 'Success!', {
                    closeButton: true,
                    tapToDismiss: false,

                });


            },
            error:function(res){
                console.log(res)
                toastr['error']( "Please Try again Later", 'Error!', {
                    closeButton: true,
                    tapToDismiss: false,

                });

            }

        });

    })
    function  initUserTable() {
        var search_date=$('#search_by_date  option:selected').text();
        if(search_date=='None'){
            search_date="Register Date"
        }
        $('#date_th').html(search_date)
        var table = dtUserTable.dataTable({
            processing: true,
            serverSide: true,
            autoFill: false,
            autocomlete:false,
            "lengthMenu": [[50,100, 200, 500, 1000], [50,100, 200, 500, 1000]],
            // bFilter:false,
            search : {
                search : '' //set search field as empty
            },


            initComplete: function() {
                // $(this.api().table().container()).find('input').wrap('<form>').parent().attr('autocomplete', 'false') ;
                // $(this.api().table().container()).find('input').attr('autocomplete', 'false');
                // this.api().columns().every( function () {
                //     var that = this;
                //
                //     $( 'input', this.footer() ).on( 'keyup change clear', function () {
                //         if ( that.search() !== this.value ) {
                //             that
                //                 .search( this.value )
                //                 .draw();
                //         }
                //     } );
                // } );
            },
        dom:
                '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
                '<"col-lg-12 col-xl-6" l>' +
                '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
                '>t' +
                '<"d-flex justify-content-between mx-2 row mb-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',


        // Buttons with Dropdown
            buttons: [
                {
                    text: ' <i data-feather="search"></i>',
                    className: 'btn btn-icon btn-outline-primary',
                    attr: {
                        id: 'search_div',
                        style:"margin:10px;border-radius: 10px",
                        status:"show"
                    },
                    init: function (api, node, config) {
                        $(node).removeClass('btn-secondary');
                    },
                    action: function (e, dt, node, config)
                    {
                        //This will send the page to the location specified
                        //   window.location.href = '/ISP/users/adduser';
                    },
                },
                {
                    text: ' <i data-feather="plus"></i>',
                    className: 'btn btn-icon btn-outline-info',
                    attr: {
                        id: 'add_modal',
                        style:"margin:10px;border-radius: 10px"
                    },
                    init: function (api, node, config) {
                        $(node).removeClass('btn-secondary');
                    },
                    action: function (e, dt, node, config)
                    {
                        //This will send the page to the location specified
                        window.location.href = '/ISP/users/adduser';
                    },
                },

                {
                    text: ' <i data-feather="download"></i>',
                    className: 'btn btn-icon btn-outline-success',
                    attr: {
                        id: 'import_modal_btn_s',
                        style:"margin:10px;border-radius: 10px"
                    },
                    init: function (api, node, config) {
                        $(node).removeClass('btn-secondary');
                    },
                    action: function (e, dt, node, config)
                    {  window.location.href = '/Import/import_customers';
                        //This will send the page to the location specified
                     //   window.location.href = '/ISP/users/adduser';
                    },
                },
                {
                    text: ' <i data-feather="upload"></i>',
                    className: 'btn btn-icon btn-outline-primary',
                    attr: {
                        id: 'export_modal_btn',
                        style:"margin:10px;border-radius: 10px"
                    },
                    init: function (api, node, config) {
                        $(node).removeClass('btn-secondary');
                    },
                    action: function (e, dt, node, config)
                    {
                        //This will send the page to the location specified
                        //   window.location.href = '/ISP/users/adduser';
                    },
                },

            ],
            ajax: {
                url: "/ISP/users/get_all_users",
                data  : {
                    status: $('#status_filter').val(),
                    owner: $('#owner_filter').val(),
                    search_by: $('#search_by_date').val(),
                    startdate:startdate,
                    enddate:finishdate,
                    ipaddress:$('#ip_address').val(),
                    type:$('#type').val(),
                    date:$('#date').val(),
                    plan:$('#plan').val(),
                    group:$('#group').val(),
                    onlinestatus:$('#online_status').val()
                }
            },
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    orderable: false,

                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: true,


                },
                {
                    data: 'online',
                    name: 'online',
                    orderable: true,


                },
                {
                    data: 'username',
                    name: 'username',


                },
                {
                    data: 'fullname',
                    name: 'fullname',
                    orderable: true,


                },

                {
                    data: 'phone',
                    name: 'phone',
                    orderable: true,


                },
                {
                    data: 'address',
                    name: 'address',
                    orderable: true,


                },
                {
                    data: 'plan',
                    name: 'profiles.srvname',
                    orderable: true,


                },
                {
                    data: 'acctype',
                    name: 'acctype',
                    orderable: true,


                },
                {
                    data: 'owner',
                    name: 'owner',
                    orderable: true,


                },
                {
                    data: 'mac',
                    name: 'mac',
                    orderable: true,


                },

                {
                    data: 'dynamic_date',
                    name: 'dynamic_date',
                    orderable: true,


                },
                {
                    data: 'expiration',
                    name: 'expiration',
                    orderable: true,


                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: "25%"
                }
            ],


            drawCallback: function( settings ) {
                feather.replace();
            },
            language: {
                sLengthMenu: "Show _MENU_",
                paginate: {
                    // remove previous & next text from pagination
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },

        });
        fill_users_status()
      //  $("#DataTables_Table_0_filter").append('<select id="filter_column  "    class="form-control" style="float:right ;margin-top: 15px"><option value="0">ID</option><option value="1">Username</option></select>');
    }

$('body').on('change','#filter_column',function(){
    var val_column=$(this).val()
    dtUserTable.DataTable().column(val_column).visible(false);

})


    initUserTable()

    //fill_users_status()
    get_leads_filter()
    $('body').on('click','#search_div',function (){
        var status=$(this).attr('status')
        if(status=='show') {
            $('#search_row').show();
            $('#DataTables_Table_0_filter').show()
            $('input[type=search]').val('')
            $(this).attr('status','hide')

        }
        else{
            $('#search_row').hide();
            $('input[type=search]').val('')
            $(this).attr('status','show')
        }
    })

    $('body').on('input','#ip_address',function (){
        dtUserTable.DataTable().destroy();
        initUserTable()
    });
    $('body').on('change','#search_by_date',function(){
        dtUserTable.DataTable().destroy();
        initUserTable()
    })
    $('body').on('change','#online_status',function(){
        dtUserTable.DataTable().destroy();
        initUserTable()



    })
    // Form Validation
    $('#checkall').change(function(){

        if($(this).is(':checked')){
            $('.usercheckbox').prop('checked', true);
        }else{
            $('.usercheckbox').prop('checked', false);
        }
    });
    $('body').on('click',"#delete_record",function(){
         Metronic.blockUI({
            target: dtUserTable,
            animate: true,
            boxed: true,
            message: "Loading"
        });
        var deleteids_arr = [];
        // Read all checked checkboxes
        $('.usercheckbox:checkbox:checked').each(function () {

            deleteids_arr.push($(this).val());
        });

        console.log(deleteids_arr);
        // Check checkbox checked or not
        if(deleteids_arr.length > 0){

            // Confirm alert
            var confirmdelete = confirm("Do you really want to Delete records?");
            if (confirmdelete == true) {
                $.ajax({
                    url: '/ISP/users/deletebulk',
                    type: 'post',
                    dataType: "json",
                    data: {deleteids_arr: deleteids_arr},
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    success: function(res){
                        toastr['success']('👋 '+ res.msg, 'Success!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                        dtUserTable.DataTable().destroy();
                        initUserTable()
                       // fill_users_status()
                        Metronic.unblockUI(dtUserTable);
                    },
                    error:function(res){
                        toastr['error'](  res.msg, 'Success!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                        dtUserTable.DataTable().destroy();
                        initUserTable()
                        //fill_users_status()
                        Metronic.unblockUI(dtUserTable);
                    }

                });
            }
            else{
                Metronic.unblockUI(dtUserTable);
            }
        }
        else{
            Metronic.unblockUI(dtUserTable);
        }
    });
    $('body').on('click',"#change_owner",function(){


        var deleteids_arr = [];
        // Read all checked checkboxes
        $('.usercheckbox:checkbox:checked').each(function () {

            deleteids_arr.push($(this).val());
        });


        // Check checkbox checked or not
        if(deleteids_arr.length > 0){

            // Confirm alert
          $('#ownermodal').modal('show')



        }
    });
    $('body').on('click',"#block_users",function(){

        Metronic.blockUI({
            target: dtUserTable,
            animate: true,
            boxed: true,
            message: "Loading"
        });
        var deleteids_arr = [];
        // Read all checked checkboxes
        $('.usercheckbox:checkbox:checked').each(function () {

            deleteids_arr.push($(this).val());
        });

        console.log(deleteids_arr);
        // Check checkbox checked or not
        if(deleteids_arr.length > 0){

            // Confirm alert
            var confirmdelete = confirm("Do you really want to Block Selected Users?");
            if (confirmdelete == true) {
                $.ajax({
                    url: '/ISP/users/block_bulk',
                    type: 'post',
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    data: {deleteids_arr: deleteids_arr},
                    success: function(res){
                        toastr['success']('👋 '+ res.msg, 'Success!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                        dtUserTable.DataTable().destroy();
                        initUserTable()
                   //     fill_users_status()
                        Metronic.unblockUI(dtUserTable);
                    },
                    error:function(res){
                        toastr['error'](  res.msg, 'Success!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                        dtUserTable.DataTable().destroy();
                        initUserTable()
                      //  fill_users_status()
                        Metronic.unblockUI(dtUserTable);
                    }

                });
            }
            else{
                Metronic.unblockUI(dtUserTable);
            }
        }
        else{
            Metronic.unblockUI(dtUserTable);
        }
    });

    $('body').on('click','#add_users_to_group',function(){

        $.ajax({
            url: '/Groups/get_all',
            type: 'get',
            dataType: "json",

            success: function(data){
                $('#group_select').empty()
                var toAppend = '';
                $.each(data,function(i,o){
                    toAppend += '<option value="'+o.id+'">'+o.name+'</option>';
                });

                $('#group_select').append(toAppend);
                $('.change_group_modal').modal('show');
            },
            error:function(data){
                $('#group_select').empty()
                var toAppend = '';
                $.each(data,function(i,o){
                    toAppend += '<option value="'+o.id+'">'+o.name+'</option>';
                });

                $('#group_select').append(toAppend);
                $('.change_group_modal').modal('show');
            }

        });



    })
    $('body').on('click','#unblock_users',function(){

        Metronic.blockUI({
            target: dtUserTable,
            animate: true,
            boxed: true,
            message: "Loading"
        });
        var deleteids_arr = [];
        // Read all checked checkboxes
        $('.usercheckbox:checkbox:checked').each(function () {

            deleteids_arr.push($(this).val());
        });

        console.log(deleteids_arr);
        // Check checkbox checked or not
        if(deleteids_arr.length > 0){

            // Confirm alert
            var confirmdelete = confirm("Do you really want to unBlock Selected Users?");
            if (confirmdelete == true) {
                $.ajax({
                    url: '/ISP/users/unblock_bulk',
                    type: 'post',
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    data: {deleteids_arr: deleteids_arr},
                    success: function(res){
                        toastr['success']('👋 '+ res.msg, 'Success!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                        dtUserTable.DataTable().destroy();
                        initUserTable()
                       // fill_users_status()
                        Metronic.unblockUI(dtUserTable);
                    },
                    error:function(res){
                        toastr['error'](  res.msg, 'Success!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                        dtUserTable.DataTable().destroy();
                        initUserTable()
                     //   fill_users_status()
                        Metronic.unblockUI(dtUserTable);
                    }

                });
            }
            else{
                Metronic.unblockUI(dtUserTable);
            }
        }
        else{
            Metronic.unblockUI(dtUserTable);
        }
    });
    $('body').on('click','#save_owner',function(){

        Metronic.blockUI({
            target: $('#ownermodal'),
            animate: true,
            boxed: true,
            message: "Loading"
        });

        var owner=$('#owner_bulk').val();
        var deleteids_arr = [];
        // Read all checked checkboxes
        $('.usercheckbox:checkbox:checked').each(function () {

            deleteids_arr.push($(this).val());
        });

        $.ajax({
            url: '/ISP/users/change_ownerbulk',
            type: 'post',
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            data: {deleteids_arr: deleteids_arr,owner:owner},
            success: function(res){
                toastr['success']('👋 '+ res.msg, 'Success!', {
                    closeButton: true,
                    tapToDismiss: false,

                });
                Metronic.unblockUI($('#ownermodal'));
                $('#ownermodal').modal('hide')
                dtUserTable.DataTable().destroy();
                initUserTable()
             //   fill_users_status()

            }
        });
    });

    $('#save_group').click(function() {
        Metronic.blockUI({
            target: $('#change_group_modal'),
            animate: true,
            boxed: true,
            message: "Loading"
        });

        var group_id=$('#group_select').val();
        var deleteids_arr = [];
        // Read all checked checkboxes
        $('.usercheckbox:checkbox:checked').each(function () {

            deleteids_arr.push($(this).val());
        });

        $.ajax({
            url: '/ISP/users/change_users_group',
            type: 'get',
            dataType: "json",
            data: {deleteids_arr: deleteids_arr,group_id:group_id},
            success: function(res){
                toastr['success']('👋 '+ res.msg, 'Success!', {
                    closeButton: true,
                    tapToDismiss: false,

                });
                Metronic.unblockUI($('#change_group_modal'));
                $('#change_group_modal').modal('hide')


            }
        });
    });

    $('body').on('click','#export_modal_btn',function(){
        $.ajax({
            url: "/Export/get_columns",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType: "json",
            data:{"type":"Customers"},

            success: function (res) {
                console.log(res)
                var tdata=res
                var html="";


                    for(var i=0;i<tdata.length;i++) {
                        console.log(tdata[i]['HeadName'])
                        html+=' <div class="custom-control custom-checkbox">\n' +
                            '              <input type="checkbox" class="custom-control-input export_checkbox" id="'+tdata[i]['HeadName']+'"  value="'+tdata[i]['value']+'"  />\n' +
                            '              <label class="custom-control-label" for="'+tdata[i]['HeadName']+'">'+tdata[i]['HeadName']+'</label>\n' +
                            '            </div>'
                    }


                $('#export_body').html(html)




                },
            error: function (res) {


            }
        });
        $('#export_modal').modal('show');
    })
    $('body').on('click','#export_btn',function(){

        var checkedVals = $('.export_checkbox:checkbox:checked').map(function() {
            return this.value;
        }).get();
        var checkednames = $('.export_checkbox:checkbox:checked').map(function() {
            return $(this).next('label').text();
        }).get();
        Metronic.blockUI({
            target: 'body',
            animate: true,
            boxed: true,

        });
// window.location.replace("/Export/Customers?checkedVals="+checkedVals+"&checkednames="+checkednames+"&status="+$('#status_filter').val()+"&owner="+$('#owner_filter').val()+"&search_by="+$('#search_by_date').val()
//     +"&startdate="+startdate+"&enddate="+finishdate+"&ipaddress="+$('#ip_address').val()+"&type="+$('#type').val()+"&date="+$('#date').val()+"&onlinestatus="+$('#online_status').val()) ;
//
//         Metronic.unblockUI('body');
        $.ajax({
            url: "/Export/Customers",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType: "json",
            data:{checkedVals:checkedVals,checkednames:checkednames ,      status: $('#status_filter').val(),
                owner: $('#owner_filter').val(),
                search_by: $('#search_by_date').val(),
                startdate:startdate,
                enddate:finishdate,
                ipaddress:$('#ip_address').val(),
                type:$('#type').val(),
                date:$('#date').val(),
                onlinestatus:$('#online_status').val(),
                searchtext: $('.dataTables_filter input').val()

            },

            success: function (data) {
                toastr['success']('👋 '+ data.msg, 'Success!', {
                    closeButton: true,
                    tapToDismiss: false,

                });
                Metronic.unblockUI('body');
            },



            error: function (res) {
                toastr['error']( "Error ! Please Try again Later", 'Error!', {
                    closeButton: true,
                    tapToDismiss: false,

                });
                Metronic.unblockUI('body');

            }
        });

    })


    $('body').on('change', '.blockswitch', function () {
        Metronic.blockUI({
            target: dtUserTable,
            animate: true,
            boxed: true,

        });
        var username=$(this).data('username')
        var id=$(this).data('id')
        var status=$(this).is(':checked')
        $.ajax({
            url: "/ISP/users/block",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType: "json",
            data:{username:username,id:id,status:status},

            success: function (res) {

                Metronic.unblockUI(dtUserTable);
                toastr['success']('👋 '+ res.msg, 'Success!', {
                    closeButton: true,
                    tapToDismiss: false,

                });
                dtUserTable.DataTable().destroy()
                initUserTable();

            },
            error: function (res) {
                Metronic.unblockUI(dtUserTable);
                toastr['error'](' Error! Please try again Later', 'Error!', {
                    closeButton: true,
                    tapToDismiss: false,

                });
                dtUserTable.DataTable().destroy()
                initUserTable();

            }
        });

    });
    function get_leads_filter(){
        $.ajax({
            url: "/ISP/users/fill_users_status",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType: "json",

            success: function (res) {
                console.log(res)
                $('#users_status_filter').html('')
                // res.forEach(function(obj) {
                //     var html1=  '            <a href="javascript:void(0)" class="list-group-item status_list" data-name="'+obj.name+'" data-id="'+obj.id+'"><div class="badge badge-'+obj.status_name+'">'+obj.name+'</div> </a>';
                //
                //
                //
                //     $('#users_status_filter').append(html1)
                //
                // })


            },
            error: function (res) {


            }
        });


    }


    $('body').on('click','#import_modal_btn',function(){
        $('#import_users_modal').modal('show')
    })
    function fill_users_status(){
        $.ajax({
            url: "/ISP/users/fill_users_status",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType: "json",

            success: function (res) {
                var html="<span id='status_div'>";
                res.forEach(function(obj) {
                    html+='<a href="javascript:void(0)" class="status_list" style="margin:10px;font-size: 15px;" data-name="'+obj.name+'" data-id="'+obj.id+'"><span class="badge badge-'+obj.status_name+'">'+obj.name+': '+obj.users_count+'</span></a>'
                });
                html+="</span>";
                $('#status_div').html("");

                $('#DataTables_Table_0_length').append(html)
                // res.forEach(function(obj) {
                //     var html='         <div class="transaction-item">\n' +
                //         '                    <div class="font-weight-bolder text-danger" style="width: 5px"><div class="badge badge-'+obj.status_name+'">'+obj.name+'</div></div>\n' +
                //         '                    <div class="font-weight-bolder  ">'+obj.users_count+'</div>\n' +
                //         '\n' +
                //
                //         '                </div>' +
                //         '<hr>'
                //     $('#user_status_table').append(html)
                //
                // })


            },
            error: function (res) {


            }
        });



    }

    $('body').on('change', '#status_filter', function () {
        var status=$(this).val()
        dtUserTable.DataTable().destroy();
        initUserTable()


    });
    $('body').on('change', '#owner_filter', function () {
        var status=$(this).val()
        dtUserTable.DataTable().destroy();
        initUserTable()


    });
    $('body').on('click', '.status_list', function () {
        var status=$(this).data('name')

        $('#status_filter').val(status)

        $("#status_filter").change();

    });


    $('body').on('click', '#delete_user', function () {
        var username=$(this).data('username')
        areyousure(username)


    });
    function delete_function(username) {
        Metronic.blockUI({
            target: dtUserTable,
            animate: false,
            boxed: true,
            message: "Loading"
        });

        $.ajax({
            url: "/ISP/users/Delete",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType: "json",
            data: {username: username},
            success: function (res) {
                console.log(res)
                console.log(res.success)
                if (res.success == "true") {
                    toastr['success']('👋 '+ res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                    dtUserTable.DataTable().destroy();
                    initUserTable()
                 //   fill_users_status()
                    Metronic.unblockUI(dtUserTable);
                } else {   Metronic.unblockUI(dtUserTable);
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                }
            },
            error: function (res) {
                Metronic.unblockUI(dtUserTable);
                toastr['error']('👋 Please Try Again Later.', 'Error!', {
                    closeButton: true,
                    tapToDismiss: false,

                });

            }
        });
    }
    function areyousure(username){

        Swal.fire({
            title: 'Are you sure? ',
            text: "You will not be able to restore it !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-outline-danger ml-1'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                delete_function(username)
            }
            else
                return "false";
        });



    }


    function  clearall(){
        $('#full_name').val('');
        $('#email').val('');

        $('#phone').val('');




    }
    $('body').on('click', '#view_pass', function () {
        $('#password').attr('type', 'text')


    });
    $('body').on('click', '#change_pass_btn', function () {
        var username=$(this).data('username');
        $('#username').val(username)
        $('#password').attr('type', 'password')
        Metronic.blockUI({
            target: $('#chnagepassmodal'),
            animate: false,
            boxed: true,
            message: "Loading"
        });

        var username=$("#username").val()
        $.ajax({
            url: "/ISP/GetUserPassword",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            data: {username: username},
            success: function (res) {
                passwordmodal.modal('show')
                $('#password').val(res.password)


                Metronic.unblockUI('#chnagepassmodal');

            },
            error: function (res) {
                passwordmodal.modal('show')
                $('#password').val(res.password)
                Metronic.unblockUI('#chnagepassmodal');;


            }
        });




    });
    $('body').on('click', '#save_pass', function () {
        var username=$('#username').val();
        var password=$('#password_user').val();
        Metronic.blockUI({
            target: $('#chnagepassmodal'),
            animate: false,
            boxed: true,
            message: "Loading"
        });


        $.ajax({
            url: "/ISP/change_password",
            method: "get",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            dataType:"json",
            data: {username: username,password:password},
            success: function (res) {
                console.log(res)
                if (res.success == "true") {
                    toastr['success']('👋 '+ res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                    passwordmodal.modal('hide')


                } else {
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                }




                Metronic.unblockUI('#chnagepassmodal');

            },
            error: function (res) {
                if (res.success == "true") {
                    toastr['success']('👋 '+ res.msg, 'Success!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });
                    passwordmodal.modal('hide')


                } else {
                    toastr['error']('👋 ' + res.msg, 'Error!', {
                        closeButton: true,
                        tapToDismiss: false,

                    });

                }

                Metronic.unblockUI('#chnagepassmodal');;


            }
        });




    });

    $('body').on('click','#renew_customers',function(){
        var deleteids_arr = [];
        $('.usercheckbox:checkbox:checked').each(function () {

            deleteids_arr.push($(this).val());
        });
        if(deleteids_arr.length > 0) {
            $('#renewmodal').modal('show');
        }




    })
    $('body').on('change','#change_plan',function (){
        if(this.checked) {
        $('#plan_div').show()
        }
        else{
            $('#plan_div').hide()
        }
    })

    $('body').on('click','#save_pass_bulk',function(){
        var deleteids_arr = [];
        // Read all checked checkboxes
        $('.usercheckbox:checkbox:checked').each(function () {

            deleteids_arr.push($(this).val());
        });
       var password=$('#user_password').val();

        if(deleteids_arr.length > 0 && password.length > 0) {
            Swal.fire({
                title: 'Are you sure? ',
                text: "You will not be able to restore it !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Reset  Password!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1'
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: "/ISP/users/reset_password_bulk",
                        method: "post",
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        },
                        dataType: "json",
                        data: {deleteids_arr: deleteids_arr,password:password },
                        success: function (res) {

                            if (res.success == "true") {

                                toastr['success']('👋 ' + res.msg, 'Success!', {
                                    closeButton: true,
                                    tapToDismiss: false,

                                });
                            } else {
                                toastr['error']('👋 ' + res.msg, 'Error!', {
                                    closeButton: true,
                                    tapToDismiss: false,

                                });

                            }

                        },
                        error: function (res) {

                            if (res.success == "true") {

                                toastr['success']('👋 ' + res.msg, 'Success!', {
                                    closeButton: true,
                                    tapToDismiss: false,

                                });
                            } else {
                                toastr['error']('👋 ' + res.msg, 'Error!', {
                                    closeButton: true,
                                    tapToDismiss: false,

                                });
                            }

                        }
                    });
                }
                else
                    return "false";
            });

        }

    })
    $('body').on('click','#release_mac',function(){
        var deleteids_arr = [];
        // Read all checked checkboxes
        $('.usercheckbox:checkbox:checked').each(function () {

            deleteids_arr.push($(this).val());
        });

        if(deleteids_arr.length > 0) {
            Swal.fire({
                title: 'Are you sure? ',
                text: "You will not be able to restore it !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Release  it!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1'
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: "/ISP/users/release_mac",
                        method: "post",
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        },
                        dataType: "json",
                        data: {deleteids_arr: deleteids_arr },
                        success: function (res) {

                            if (res.success == "true") {

                                toastr['success']('👋 ' + res.msg, 'Success!', {
                                    closeButton: true,
                                    tapToDismiss: false,

                                });
                            } else {
                                toastr['error']('👋 ' + res.msg, 'Error!', {
                                    closeButton: true,
                                    tapToDismiss: false,

                                });

                            }

                        },
                        error: function (res) {

                            if (res.success == "true") {

                                toastr['success']('👋 ' + res.msg, 'Success!', {
                                    closeButton: true,
                                    tapToDismiss: false,

                                });
                            } else {
                                toastr['error']('👋 ' + res.msg, 'Error!', {
                                    closeButton: true,
                                    tapToDismiss: false,

                                });
                            }

                        }
                    });
                }
                else
                    return "false";
            });

        }

    })













    $('body').on('click','#renew_btn',function (){
        var comment=$('#renewcomment').val();
        Metronic.blockUI({
            target: dtUserTable,
            animate: true,
            boxed: true,
            message: "Loading"
        });
        var deleteids_arr = [];
        // Read all checked checkboxes
        $('.usercheckbox:checkbox:checked').each(function () {

            deleteids_arr.push($(this).val());
        });

       var plan=$('#select_plan_renew').val()
       var values=$('input[name="renewradio"]:checked').val();
        var payment_collected=$('#payment_collected').is(':checked');
        var change_plan=$('#change_plan').is(':checked');
        if(deleteids_arr.length > 0) {
            $.ajax({
                url: "/ISP/users/renewbulk",
                method: "post",
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                dataType: "json",
                data: {deleteids_arr: deleteids_arr,comment:comment, plan:plan, payment_collected:payment_collected,change_plan:change_plan,values:values},
                success: function (res) {

                    if (res.success == "true") {

                        toastr['success']('👋 ' + res.msg, 'Success!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                    } else {
                        toastr['error']('👋 ' + res.msg, 'Error!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });

                    }
                    $('#renewmodal').modal('hide');
                    Metronic.unblockUI(dtUserTable);;
                },
                error: function (res) {

                    if (res.success == "true") {

                        toastr['success']('👋 ' + res.msg, 'Success!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                    } else {
                        toastr['error']('👋 ' + res.msg, 'Error!', {
                            closeButton: true,
                            tapToDismiss: false,

                        });
                    }
                    $('#renewmodal').modal('hide');
                    Metronic.unblockUI(dtUserTable);;
                }
            });
        }

    })

});
