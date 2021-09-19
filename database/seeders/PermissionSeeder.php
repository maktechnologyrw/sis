<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create students']);
        Permission::create(['name' => 'edit students']);
        Permission::create(['name' => 'delete students']);
        Permission::create(['name' => 'view students']);
        Permission::create(['name' => 'create teachers']);
        Permission::create(['name' => 'edit teachers']);
        Permission::create(['name' => 'delete teachers']);
        Permission::create(['name' => 'view teachers']);
        Permission::create(['name' => 'add marks to students']);
        Permission::create(['name' => 'edit eligible marks']);
        Permission::create(['name' => 'delete eligible marks']);
        Permission::create(['name' => 'view own students']);
        Permission::create(['name' => 'view own students marks']);
        Permission::create(['name' => 'view own students reports']);
        Permission::create(['name' => 'view own students attendance']);
        Permission::create(['name' => 'create students attendance list']);
        Permission::create(['name' => 'edit students attendance list']);
        Permission::create(['name' => 'view students attendance list']);
        Permission::create(['name' => 'view students attendance']);
        Permission::create(['name' => 'delete students attendance list']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'admin']);
        
        $role1->givePermissionTo('create students');
        $role1->givePermissionTo('edit students');
        $role1->givePermissionTo('delete students');
        $role1->givePermissionTo('view students');
        $role1->givePermissionTo('create teachers');
        $role1->givePermissionTo('edit teachers');
        $role1->givePermissionTo('delete teachers');
        $role1->givePermissionTo('view teachers');

        $role2 = Role::create(["name" => "teacher"]);

        $role2->givePermissionTo('view students');
        $role2->givePermissionTo('add marks to students');
        $role2->givePermissionTo('edit eligible marks');
        $role2->givePermissionTo('delete eligible marks');
        $role2->givePermissionTo('create students attendance list');
        $role2->givePermissionTo('edit students attendance list');
        $role2->givePermissionTo('view students attendance list');
        $role2->givePermissionTo('view students attendance');
        $role2->givePermissionTo('delete students attendance list');

        $role3 = Role::create(["name" => "parent"]);

        $role3->givePermissionTo('view own students');
        $role3->givePermissionTo('view own students marks');
        $role3->givePermissionTo('view own students reports');
        $role3->givePermissionTo('view own students attendance');
    }
}
