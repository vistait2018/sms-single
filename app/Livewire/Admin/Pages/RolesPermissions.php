<?php

namespace App\Livewire\Admin\Pages;

use App\Helpers\RoleHelper;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

#[Layout('layouts.app')]
#[Title('Roles & Permissions')]
class RolesPermissions extends Component
{
    public $roles;
    public $models;
    public $actions;
    public $permissionsMatrix = [];

    // token used to replace '.' in permission names for Livewire binding
    // Make this public so it can be accessed in the view if needed for a direct call,
    // though we'll primarily use it internally.
    public string $sep = '__';

    public function mount()
    {
        $this->roles   = Role::with('permissions')->get();
        $this->models  = RoleHelper::getAllModelShortNames();
        $this->actions = RoleHelper::getAllActions();

        $this->buildPermissionsMatrix();
    }

    private function buildPermissionsMatrix(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // eager-load fresh relations
        $this->roles = Role::with('permissions')->get();

        $this->permissionsMatrix = [];
        foreach ($this->roles as $role) {
            $owned = $role->permissions->pluck('name')->all(); // array of strings
            foreach ($this->models as $model) {
                foreach ($this->actions as $action) {
                    $permName = "{$model}.{$action}";
                    // Sanitize the key when building the matrix
                    $sanitizedKey = $this->sanitize($permName);
                    $this->permissionsMatrix[$role->id][$sanitizedKey] = in_array($permName, $owned, true);
                }
            }
        }
    }

    public function updateRolePermissions(int $roleId): void
    {
        $role = Role::find($roleId);
        if (! $role) return;

        $data = $this->permissionsMatrix[$roleId] ?? [];

        // Figure out the set of permissions the role SHOULD have (true boxes)
        $toAssign = [];
        foreach ($data as $key => $isChecked) {
            // Unsanitize the key received from the Livewire binding
            $permName = $this->unsanitize($key);
            // Ensure the permission exists for guard web
            Permission::firstOrCreate(['name' => $permName, 'guard_name' => 'web']);
            if ($isChecked) {
                $toAssign[] = $permName;
            }
        }

        // Sync in one shot (adds missing, removes unchecked)
        $role->syncPermissions($toAssign);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Refresh just this role’s row in the matrix
        $this->buildPermissionsMatrix(); // Rebuilds with sanitized keys

        session()->flash('success', "Permissions for '{$role->name}' updated successfully ✅");
    }

    // This method is fine as it is.
    public function sanitize(string $perm): string
    {
        return str_replace('.', $this->sep, $perm);
    }

    // This method is fine as it is.
    public function unsanitize(string $key): string
    {
        return str_replace($this->sep, '.', $key);
    }

    public function render()
    {
        return view('livewire.admin.pages.roles-permissions');
    }
}