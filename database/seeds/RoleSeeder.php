<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'user',
            'description' => 'Can view, upload, download documents and follow, chat with other user',
        ]);

        Role::create([
            'name' => 'admin',
            'description' => 'Can manage user, document',
        ]);
    }
}
