<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Jadwal;
use App\Models\Paket;
use App\Models\Pelanggan;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;

class Home extends BaseController
{
    public function index()
    {
        return view('home/home', [
            'title' => 'Home',
        ]);
    }

    public function paket()
    {
        $data = new Paket();
        return view('home/paket', [
            'title' => 'Paket',
            'data' => $data->findAll()
        ]);
    }

    public function informasi()
    {
        return view('home/informasi', [
            'title' => 'Informasi'
        ]);
    }

    public function profile($id)
    {
        $model = new User();
        $pelanggan = new Pelanggan();
        $jadwal = new Jadwal();

        if ($this->request->getMethod() === 'POST') {
            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
            ];

            $update = $model->update($id, $data);

            if (!$update) {
                return redirect()->to('home/profile/'.$id)->with('error', 'Gagal update profile');
            }

            return redirect()->to('home/profile/'.$id)->with('success', 'Berhasil update profile');
        }

        $findPelanggan = $pelanggan->where('user_id', session()->id)->first();
        $findJadwal = $jadwal->where('pelanggan_id', $findPelanggan['id'])->where('type_jadwal', 'instalasi_baru')->first();
        return view('home/profile', [
        //dd([
            'title' => 'Profile',
            'data' => $model->where('id', $id)->first(),
            'pemasangan' => $findPelanggan,
            'jadwal' => $findJadwal,
        ]);
    }

    public function password($id)
    {
        $model = new User();
        if ($this->request->getMethod() === 'POST') {
            $old_password = $this->request->getPost('old_password');
            $new_password = $this->request->getPost('new_password');
            $confirm_new_password = $this->request->getPost('confirm_new_password');

            if ($new_password === $confirm_new_password) {
                return redirect()->to('home/profile')->with('error', 'Password tidak sama!');
            }

            $user = $model->where('id', $id)->first();
            $isPasswordMatch = password_verify($old_password[0], $user['password']);

            if (!$isPasswordMatch) {
                return redirect()->to('home/profile/'.$id)->with('error', 'Password salah!');
            }

            $update = $model->update($id,['password' => password_hash($new_password[0], PASSWORD_DEFAULT)]);

            if (!$update) {
                return redirect()->to('home/profile/'.$id)->with('error', 'Gagal update password');
            }

            return redirect()->to('home/profile/'.$id)->with('success', 'Berhasil update password');
        }
    }
}
