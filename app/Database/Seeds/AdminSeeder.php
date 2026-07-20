<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $users = auth()->getProvider();

        $existing = $users->findByCredentials([
            'email' => 'admin@testportal.com'
        ]);

        if ($existing) {
            echo "Admin already exists.";
            return;
        }

        $user = new User([
            'username' => 'admin',
            'email' => 'admin@testportal.com',
            'password' => 'Admin@123'
        ]);

        $users->save($user);

        $user = $users->findByCredentials([
            'email' => 'admin@testportal.com'
        ]);

        $user->addGroup('admin');

        echo "Admin Created Successfully.";
    }
}
