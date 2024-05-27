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

                    return redirect()->to($checkPelangganOrNot ? '/' :'/dashboard');
                }
            }

            return redirect()->back()->with('error', 'Invalid email or password.');
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

            if ($this->userModel->insert($userData)) {
                return redirect()->to('/login')->with('success', 'Berhasil daftar, silahkan login!');
            }

            session()->setFlashdata('error', 'Failed to register user.');
            return redirect()->to('/register');
        }

        return view('auth/register');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Berhasil logout!');
    }
}
