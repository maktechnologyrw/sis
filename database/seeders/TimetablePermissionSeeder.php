<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class TimetablePermissionSeeder extends Seeder
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
        Permission::create(['name' => 'create timetable']);
        Permission::create(['name' => 'edit timetable']);
        Permission::create(['name' => 'delete timetable']);
        Permission::create(['name' => 'propose timetable slots']);
        Permission::create(['name' => 'approve timetable slots']);
        Permission::create(['name' => 'deny timetable slots']);

        $admin = Role::where("name", "admin")->first();

        $admin->givePermissionTo('create timetable');
        $admin->givePermissionTo('edit timetable');
        $admin->givePermissionTo('delete timetable');
        $admin->givePermissionTo('propose timetable slots');
        $admin->givePermissionTo('approve timetable slots');
        $admin->givePermissionTo('deny timetable slots');

        $teacher = Role::where("name", "teacher")->first();

        $teacher->givePermissionTo('propose timetable slots');
    }
}
