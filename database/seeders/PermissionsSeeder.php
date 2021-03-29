<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin' => [
                'label' => 'Admin'
            ],
            'editor' => [
                'label' => 'Editor'
            ],
            'mobile-user' => [
                'label' => 'Mobile user'
            ],
            'media-user' => [
                'label' => 'Media user'
            ]
        ];

        foreach ($roles as $key => $data) {
            if (!($role = Role::where('name', '=', $key)->first())) {
                $role = new Role(['name' => $key]);
                $role->save();
            }
        }
    }
}
