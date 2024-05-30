<?php

namespace App\Controllers\Authentication;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\Pelanggan;

class AuthController extends BaseController
{
    protected $userModel;
    protected $pelangganModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->pelangganModel = new Pelanggan();
    }

    public function login()
    {
        if ($this->request->getMethod() === 'POST') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            if (!empty($email) && !empty($password)) {
                $user = $this->userModel->where('email', $email)->first();

                if ($user && password_verify($password, $user['password'])) {
                    $checkPelangganOrNot = $this->pelangganModel->where('user_id', $user['id'])->first();
                    session()->set([
                        'isLoggedIn' => true,
                        'userType' => $user['usertype'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'id' => $user['id'],
                        'pelanggan' => $checkPelangganOrNot ? true : false,
                    ]);

                    $response = [
                        'status' => 'success',
                        'message' => 'Berhasil login!',
                        'redirect' => $checkPelangganOrNot ? '/' : '/dashboard',
                    ];
                    return $this->response->setJSON($response);
                }
            }

            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid email or password.']);
        }

        return view('auth/login');
    }

    public function register()
    {
        if ($this->request->getMethod() === 'POST') {
            $userData = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
                'usertype' => 'pelanggan',
            ];

            $findEmail = $this->userModel->where('email', $userData['email'])->first();
            if ($findEmail) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Email sudah terdaftar!'
                ]);
            }

            if ($this->userModel->insert($userData)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Berhasil daftar, silahkan login!',
                    'redirect' => '/login'
                ]);
            }

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal daftar!'
            ]);
        }

        return view('auth/register');
    }

    public function logout()
    {
        session()->destroy();

        return $this->response->setJSON([
            'status' => true,
            'icon' => 'success',
            'title' => 'Success!',
            'text' => 'Logout berhasil.'
        ]);
    }
}
