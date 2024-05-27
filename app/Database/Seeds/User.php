<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\User as ModelUser;

class User extends Seeder
{
    public function run()
    {
        $data = [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => password_hash('admin', PASSWORD_DEFAULT),
            'usertype' => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $model = new ModelUser();
        $model->insert($data);
    }
}
