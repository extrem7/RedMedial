<?php


namespace App\Services;


use Spatie\Permission\Models\Role;

class UsersService
{
    public function getRoles()
    {
        return Role::all()->pluck('name', 'id');
    }
}
