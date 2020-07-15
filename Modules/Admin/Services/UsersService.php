<?php

namespace Modules\Admin\Services;

use Spatie\Permission\Models\Role;

class UsersService
{
    public function getRoles()
    {
        return Role::all()->pluck('name', 'id');
    }

    public function shareForCRUD()
    {
        $roles = collect($this->getRoles())
            ->map(fn($val, $key) => ['value' => $key, 'label' => ucfirst($val)])->values();

        share(compact('roles'));
    }
}
