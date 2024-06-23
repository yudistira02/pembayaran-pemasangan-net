<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\Paket;
use App\Models\Jadwal;

class PelangganController extends BaseController
{
    protected $transaksiModel;
    protected $pelangganModel;
    protected $paketModel;
    protected $jadwalModel;

    public function __construct()
    {
        $this->transaksiModel = new Transaksi();
        $this->pelangganModel = new Pelanggan();
        $this->paketModel = new Paket();
        $this->jadwalModel = new Jadwal();
    }

    public function createTagihanBulanan($id)
    {
        $pelanggan = $this->pelangganModel->find($id);
        $transaksi = $this->transaksiModel
            ->where('pelanggan_id', $id)
            ->where('kategori_pembayaran', 'bulanan')
            ->where('status', '0')
            ->first();

        if ($transaksi) {
            return redirect()->to('dashboard/pelanggan')->with('error', 'Gagal tambah tagihan, pelanggan sudah ada tagihan bulanan');
        }

        $paket = $this->paketModel->find($pelanggan['paket']);
        $data = [
            'pelanggan_id' => $pelanggan['id'],
            'total' => $paket['harga'] + 2000,
            'status' => '0',
            'kategori_pembayaran' => 'bulanan',
            'type_pembayaran' => '1',
        ];

        $create = $this->transaksiModel->insert($data);


        if (!$create) {
            return redirect()->to('dashboard/pelanggan')->with('error', 'Gagal tambah tagihan');
        }
        return redirect()->to('dashboard/pelanggan')->with('success', 'Berhasil tambah tagihan');
    }

    public function index()
    {
        return view('dashboard/pelanggan/index', [
            //dd([
            'title' => 'Pelanggan',
            'data' => $this->pelangganModel
                ->select('
                                        pelanggan.*,
                                        users.name as nama,
                                        users.email as email,
                                        paket.nama as nama_paket,
                                        paket.kecepatan as kecepatan_paket
                                    ')
                ->join('paket', 'pelanggan.paket = paket.id')
                ->join('users', 'pelanggan.user_id = users.id')
                ->get()
                ->getResultArray()
        ]);
    }

    public function update($id)
    {
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'user_id' => $this->request->getPost('user_id'),
                'nomor_whatsapp' => $this->request->getPost('nomor_whatsapp'),
                'geolocation' => $this->request->getPost('geolocation'),
                'alamat' => $this->request->getPost('alamat'),
                'paket' => $this->request->getPost('paket'),
                'foto_diri' => $this->request->getPost('foto_diri'),
                'status' => $this->request->getPost('status'),
            ];

            $update = $this->pelangganModel->update($id, $data);

            if (!$update) {
                return redirect()->to('dashboard/pelanggan')->with('error', 'Gagal update pelanggan');
            }
            return redirect()->to('dashboard/pelanggan')->with('success', 'Berhasil update pelanggan');
        }

        return view('dashboard/pelanggan/update', [
            //dd([
            'title' => 'Pelanggan',
            'data' => $this->pelangganModel->where('id', $id)->first()
        ]);
    }

    public function lengkapiInformasi($id)
    {
        if ($this->request->getMethod() === 'POST') {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'nomor_whatsapp' => 'required|regex_match[/^08[1-9][0-9]{8,12}$/]',
                'geolocation' => 'required',
                'paket' => 'required',
                'foto_diri' => 'uploaded[foto_diri]|max_size[foto_diri,1024]|is_image[foto_diri]|mime_in[foto_diri,image/jpg,image/jpeg]',
                'type_pembayaran' => 'required'
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            $foto_diri = $this->request->getFile('foto_diri');
            $newName = $foto_diri->getRandomName();
            $foto_diri->move('uploads', $newName);

            $data = [
                'user_id' => $id,
                'nomor_whatsapp' => $this->request->getPost('nomor_whatsapp'),
                'geolocation' => $this->request->getPost('geolocation'),
                'alamat' => $this->request->getPost('alamat'),
                'paket' => $this->request->getPost('paket'),
                'foto_diri' => $newName,
                'status' => '0',
            ];

            $create = $this->pelangganModel->insert($data);

            //dd($create);
            if (!$create) {
                return redirect()->back()->withInput()->with('error', 'Gagal melengkapi informasi');
            }

            if ($this->request->getPost('type_pembayaran') === '1') {
                $pelanggan = $this->pelangganModel->where('user_id', $id)->first();
                $data_paket = $this->paketModel->find($data['paket']);
                $data_transaksi = [
                    'pelanggan_id' => $pelanggan['id'],
                    'total' => $data_paket['harga'] + 2000,
                    'status' => '0',
                    'kategori_pembayaran' => 'pasang_baru',
                    'type_pembayaran' => $this->request->getPost('type_pembayaran'),
                ];

                $transaksi = $this->transaksiModel->insert($data_transaksi);

                if (!$transaksi) {
                    return redirect()->back()->withInput()->with('error', 'Gagal membuat transaksi');
                }
            }

            if ($this->request->getPost('type_pembayaran') === '0') {
                $pelanggan = $this->pelangganModel->where('user_id', $id)->first();
                $data_paket = $this->paketModel->find($data['paket']);
                $data_transaksi = [
                    'pelanggan_id' => $pelanggan['id'],
                    'total' => $data_paket['harga'] + 2000,
                    'status' => '0',
                    'kategori_pembayaran' => 'pasang_baru',
                    'type_pembayaran' => $this->request->getPost('type_pembayaran'),
                ];

                $data_jadwal = [
                    'pelanggan_id' => $pelanggan['id'],
                    'ticket_id' => null,
                    'waktu_pemasangan' => null,
                    'bukti_kegiatan' => null,
                    'type_jadwal' => 'instalasi_baru',
                    'status' => '0',
                ];

                $this->transaksiModel->insert($data_transaksi);
                $this->jadwalModel->insert($data_jadwal);
            }

            return redirect()->back()->with('success', 'Berhasil melengkapi informasi! Silahkan login kembali.');
            session()->destroy();
        }

        return view('home/pelanggan/insertInformasi', [
            'title' => 'Lengkapi Pendaftaran Internet Anda',
            'paket' => $this->paketModel->findAll(),
        ]);
    }
}
