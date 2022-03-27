<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // Create Roles
        $super_admin = Role::create(['name' => 'super admin']);
        $admin = Role::create(['name' => 'administrator']);
        $manager = Role::create(['name' => 'manager']);
        $executive = Role::create(['name' => 'executive']);
        $user = Role::create(['name' => 'user']);

      
        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $perms) {
            Permission::firstOrCreate(['name' => $perms]);
        }

        // Assign Permissions to Roles
        $admin->givePermissionTo(Permission::all());
        $manager->givePermissionTo('view_backend');
        $executive->givePermissionTo('view_backend');

        Schema::enableForeignKeyConstraints();
    }
}
