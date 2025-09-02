<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Helpers\RoleHelper;
use Spatie\Permission\Contracts\Permission as ContractsPermission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Get all models (already lowercase short names from RoleHelper)
        $models = RoleHelper::getAllModelShortNames();

        // Define your standard actions
        $actions = ['create', 'edit', 'delete', 'view'];

        foreach ($models as $model) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$model}.{$action}",
                    'guard_name' => 'web',
                ]);
            }
        }
            $permissions = Permission::all();
            $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
            $schoolAdmin = Role::firstOrCreate(['name' => 'school-admin']);
         foreach($permissions as $permission) {
             $superAdmin->givePermissionTo($permission);
             $schoolAdmin->givePermissionTo($permission);
         }

        // Always clear permission cache after seeding
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
