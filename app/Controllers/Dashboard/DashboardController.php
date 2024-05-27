<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\Jadwal;
use App\Models\Paket;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends BaseController
{
    protected $paketModel;
    protected $pelangganModel;
    protected $transaksiModel;
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->paketModel = new Paket();
        $this->pelangganModel = new Pelanggan();
        $this->transaksiModel = new Transaksi();
    }

    public function index()
    {
        $data = null;

        if (session()->has('pelanggan')) {
            $data = $this->pelangganModel->where('user_id', session()->get('id'))->first();
        }

        $pemasangan = new Jadwal();
        $transaksi = new Transaksi();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Fetch and format dataPemasangan
        $dataPemasangan = $pemasangan->select("DATE(created_at) as day, COUNT(*) as count", false)
            ->where('type_jadwal', 'instalasi_baru')
            ->where('MONTH(created_at)', $currentMonth, false)
            ->where('YEAR(created_at)', $currentYear, false)
            ->groupBy('day')
            ->orderBy('day')
            ->findAll();

        $dataPemasanganFormatted = array_map(function ($item) {
            return ['label' => $item['day'], 'value' => $item['count']];
        }, $dataPemasangan);

        // Fetch and format dataTransaksi
        $dataTransaksi = $transaksi->select("DATE(created_at) as day, COUNT(*) as count", false)
            ->where('MONTH(created_at)', $currentMonth, false)
            ->where('YEAR(created_at)', $currentYear, false)
            ->groupBy('day')
            ->orderBy('day')
            ->findAll();

        $dataTransaksiFormatted = array_map(function ($item) {
            return ['label' => $item['day'], 'value' => $item['count']];
        }, $dataTransaksi);

        return view('dashboard/index', [
            'title' => 'Dashboard',
            'paketCount' => $this->paketModel->countAll(),
            'pelangganCount' => $this->pelangganModel->countAll(),
            'transaksiCount' => $this->transaksiModel->countAll(),
            'data' => $data,
            'dataPemasangan' => $dataPemasanganFormatted,
            'dataTransaksi' => $dataTransaksiFormatted,
        ]);
    }

    public function profile($id)
    {
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
            ];

            $update = $this->userModel->update($id, $data);

            if (!$update) {
                return redirect()->to('dashboard/profile/'.$id)->with('error', 'Gagal update profile');
            }

            return redirect()->to('dashboard/profile/'.$id)->with('success', 'Berhasil update profile');
        }

        return view('dashboard/profile', [
        //dd([
            'title' => 'Update Profile',
            'data' => $this->userModel->where('id', $id)->first(),
        ]);
    }

    public function password($id)
    {
        if ($this->request->getMethod() === 'POST') {
            $old_password = $this->request->getPost('old_password');
            $new_password = $this->request->getPost('new_password');
            $confirm_new_password = $this->request->getPost('confirm_new_password');

            if ($new_password === $confirm_new_password) {
                return redirect()->to('dashboard/profile')->with('error', 'Password tidak sama!');
            }

            $user = $this->userModel->where('id', $id)->first();
            $isPasswordMatch = password_verify($old_password, $user['password']);

            if (!$isPasswordMatch) {
                return redirect()->to('dashboard/profile/'.$id)->with('error', 'Password salah!');
            }

            $update = $this->userModel->update($id,['password' => password_hash($new_password, PASSWORD_BCRYPT)]);

            if (!$update) {
                return redirect()->to('dashboard/profile/'.$id)->with('error', 'Gagal update password');
            }

            return redirect()->to('dashboard/profile/'.$id)->with('success', 'Berhasil update password');
        }
    }
}
