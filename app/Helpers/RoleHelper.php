<?php

namespace App\Helpers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

use Spatie\Permission\Models\Permission;

class RoleHelper
{
    /**
     * Assign a role to a user by role name.
     */
    public static function assignRole(User $user, string $roleName): void
    {
        try {
            $role = Role::where('name', $roleName)->first();


            if (! $user->hasRole($role->name)) {
                $user->assignRole($role->name);
            }

            Log::info("Role '{$roleName}' assigned to user ID {$user->id}");
        } catch (\Throwable $e) {
            Log::error("Failed to assign role '{$roleName}' to user ID {$user->id}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Remove a role from a user by role name.
     */
    public static function unassignRole(User $user, string $roleName): void
    {
        try {
            if ($user->hasRole($roleName)) {
                $user->removeRole($roleName);
                Log::info("Role '{$roleName}' unassigned from user ID {$user->id}");
            } else {
                Log::warning("User ID {$user->id} does not have role '{$roleName}'");
            }
        } catch (\Throwable $e) {
            Log::error("Failed to unassign role '{$roleName}' from user ID {$user->id}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Return all model class names (fully qualified).
     *
     * @return array
     */
    public static function getAllModels(): array
    {
        $models = [];
        $modelPath = app_path('Models');

        if (! File::exists($modelPath)) {
            return $models;
        }

        foreach (File::allFiles($modelPath) as $file) {
            $relativePath = $file->getRelativePathname();
            $class = 'App\\Models\\' . str_replace(
                ['/', '.php'],
                ['\\', ''],
                $relativePath
            );

            if (class_exists($class)) {
                $models[] = $class;
            }
        }

        return $models;
    }

     /**
     * Return all model short names that can have permissions.
     */
    public static function getAllModelShortNames(): array
    {
        return [
            'user',
            'teacher',
            'student',
            'guardian',
            'school',
            // Add more models here
        ];
    }

    /**
     * Return all actions available for permissions.
     */
    public static function getAllActions(): array
    {
        return [
            'create',
            'edit',
            'delete',
            'view',
            // Add more actions here (export, approve, etc.)
        ];
    }

     /**
     * Assign a permission (string) to a given role.
     *
     * @param string $roleName
     * @param string $permissionName
     * @return bool
     */
    public static function assignPermissionToRole(string $roleName, string $permissionName): bool
    {
        try {
            // Ensure the role exists
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Ensure the permission exists
            $permission = Permission::firstOrCreate(['name' => $permissionName]);

            // Assign permission to role
            if (! $role->hasPermissionTo($permission)) {
                $role->givePermissionTo($permission);
            }

            return true;
        } catch (\Exception $e) {
            Log::error("Failed to assign permission '{$permissionName}' to role '{$roleName}': ".$e->getMessage());
            return false;
        }
    }

    /**
     * Get all roles with their permissions (including permission IDs).
     *
     * @return array
     */
    public static function getRolesWithPermissions(): array
    {
        return Role::with('permissions')->get()->map(function ($role) {
            return [
                'role'        => $role->name,
                'permissions' => $role->permissions->map(function ($permission) {
                    return [
                        'id'   => $permission->id,
                        'name' => $permission->name,
                    ];
                })->toArray(),
            ];
        })->toArray();
    }
}
