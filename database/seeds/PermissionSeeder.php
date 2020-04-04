<?php

use Illuminate\Database\Seeder;
use  App\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'permission' => 'All'
        ]);
        Permission::create([
            'permission' => 'Add_Task'
        ]);
        Permission::create([
            'permission' => 'Edit_Task'
        ]);
        Permission::create([
            'permission' => 'Delete_Task'
        ]);

        Permission::create([
            'permission' => 'Add_SubTask'
        ]);
        Permission::create([
            'permission' => 'Edit_SubTask'
        ]);
        Permission::create([
            'permission' => 'Delete_SubTask'
        ]);
        Permission::create([
            'permission' => 'Add_CheckList'
        ]);
        Permission::create([
            'permission' => 'Delete_CheckList'
        ]);
    }
}
