<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\Paket;

class PaketController extends BaseController
{
    protected $paketModel;

    public function __construct()
    {
        $this->paketModel = new Paket();
    }
    
    public function index()
    {
        return view('dashboard/paket/index', [
            'title' => 'Paket',
            'data' => $this->paketModel->findAll(),
        ]);
    }

    public function create() 
    {
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'nama' => $this->request->getPost('nama'),
                'kecepatan' => $this->request->getPost('kecepatan'),
                'harga' => $this->request->getPost('harga'),
            ];

            $create = $this->paketModel->insert($data);

            if(!$create) {
                return redirect()->to('dashboard/paket')->with('error', 'Gagal update paket');
            }
            return redirect()->to('dashboard/paket')->with('success', 'Berhasil update paket');
        }

        return view('dashboard/paket/create', [
            'title' => 'Paket',
        ]);
    }

    public function update($id)
    {
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'nama' => $this->request->getPost('nama'),
                'kecepatan' => $this->request->getPost('kecepatan'),
                'harga' => $this->request->getPost('harga'),
            ];

            $update = $this->paketModel->update($id, $data);

            if(!$update) {
                return redirect()->to('dashboard/paket')->with('error', 'Gagal update paket');
            }
            return redirect()->to('dashboard/paket')->with('success', 'Berhasil update paket');
        }

        return view('dashboard/paket/update', [
            'title' => 'Paket',
            'data' => $this->paketModel->where('id', $id)->first()
        ]);
    }

    public function delete($id)
    {
        $delete = $this->paketModel->delete($id);

        if(!$delete) {
            return redirect()->to('dashboard/paket')->with('error', 'Gagal delete paket');
        }
        return redirect()->to('dashboard/paket')->with('success', 'Berhasil delete paket');
    }
}
