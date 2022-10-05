<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (['user_create', 'user_edit', 'user_read', 'user_delete'] as $name)
        {
            Permission::create([
                'name' => $name
            ])->roles()->attach(1);
        }
    }
}
