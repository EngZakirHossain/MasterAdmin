<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRolePermissionArray =[
            'Index Role',
            'Create Role',
            'Edit Role',
            'Delete Role',
        ];
        $adminModulePermissionArray =[
            'Index Module',
            'Create Module',
            'Edit Module',
            'Delete Module',
        ];
        $adminPermissionArray =[
            'Index Permission',
            'Create Permission',
            'Edit Permission',
            'Delete Permission',
        ];
        $adminDashboardPermissionArray =[
            'Access Dashboard',
            'Report Dashboard',
        ];
        $adminUserPermissionArray =[
            'Index User',
            'Create User',
            'Edit User',
            'Delete User',
        ];


        //access Dashboard
        $adminDashboardModule = Module::where('module_name','Admin Dashboard')->select('id')->first();

        Permission::updateOrCreate([
            'module_id'=>$adminDashboardModule->id,
            'permission_name'=> $adminDashboardPermissionArray[0],
            'permission_slug'=> Str::slug($adminDashboardPermissionArray[0]),
        ]);

        //Role Management
        $roleManagment = Module::where('module_name','Role Management')->select('id')->first();

        for($i=0; $i<count($adminRolePermissionArray); $i++){
                    Permission::updateOrCreate([
                        'module_id'=>$roleManagment->id,
                        'permission_name'=> $adminRolePermissionArray[$i],
                        'permission_slug'=> Str::slug($adminRolePermissionArray[$i]),
                    ]);
        }
        //Module Management
        $moduleManagment = Module::where('module_name','Module Management')->select('id')->first();

        for($i=0; $i<count($adminRolePermissionArray); $i++){
                    Permission::updateOrCreate([
                        'module_id'=>$moduleManagment->id,
                        'permission_name'=> $adminModulePermissionArray[$i],
                        'permission_slug'=> Str::slug($adminModulePermissionArray[$i]),
                    ]);
        }
        //Permission Management
        $permissionManagment = Module::where('module_name','Permission Management')->select('id')->first();

        for($i=0; $i<count($adminRolePermissionArray); $i++){
                    Permission::updateOrCreate([
                        'module_id'=>$permissionManagment->id,
                        'permission_name'=> $adminPermissionArray[$i],
                        'permission_slug'=> Str::slug($adminPermissionArray[$i]),
                    ]);
        }


        //User Management
        $userManagmentModule = Module::where('module_name','User Management')->select('id')->first();

        for($i=0; $i<count($adminUserPermissionArray); $i++){
                    Permission::updateOrCreate([
                        'module_id'=>$userManagmentModule->id,
                        'permission_name'=> $adminUserPermissionArray[$i],
                        'permission_slug'=> Str::slug($adminUserPermissionArray[$i]),
                    ]);
        }

    }
}
