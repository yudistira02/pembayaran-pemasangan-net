<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\Ticket;
use App\Models\Jadwal;

class UserController extends BaseController
{
    protected $userModel;
    protected $pelangganModel;
    protected $transaksiModel;
    protected $ticketModel;
    protected $jadwalModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->transaksiModel = new Transaksi();
        $this->jadwalModel = new Jadwal();
        $this->pelangganModel = new Pelanggan();
        $this->ticketModel = new Ticket();
    }

    public function index()
    {
        return view('dashboard/user/index', [
            //dd([
            'title' => 'User',
            'data' => $this->userModel->where('id !=', session()->get('id'))->get()->getResultArray(),
        ]);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            $password = $this->request->getPost('password');
            $confirmPassword = $this->request->getPost('konfirmasi_password');

            if ($password !== $confirmPassword) {
                return redirect()->to('dashboard/user/create')->with('error', 'Password dan Konfirmasi Password tidak cocok');
            }

            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'usertype' => $this->request->getPost('usertype'),
            ];

            $create = $this->userModel->insert($data);

            if (!$create) {
                return redirect()->to('dashboard/user')->with('error', 'Gagal tambah user');
            }
            return redirect()->to('dashboard/user')->with('success', 'Berhasil tambah user');
        }

        return view('dashboard/user/create', [
            'title' => 'User',
        ]);
    }

    public function update($id)
    {
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash(PASSWORD_BCRYPT, $this->request->getPost('password')),
                'usertype' => $this->request->getPost('usertype'),
            ];

            $update = $this->userModel->update($id, $data);

            if (!$update) {
                return redirect()->to('dashboard/user')->with('error', 'Gagal update user');
            }
            return redirect()->to('dashboard/user')->with('success', 'Berhasil update user');
        }

        return view('dashboard/user/update', [
            'title' => 'User',
            'data' => $this->userModel->where('id', $id)->first()
        ]);
    }

    public function delete($id)
    {
        $responseSuccess = [
            'status' => 'success',
            'message' => 'Berhasil Menghapus user'
        ];

        $reponseError = [
            'status' => 'error',
            'message' => 'Gagal Menghapus user'
        ];

        $user = $this->userModel->find($id);
        if ($user && $user['usertype'] === 'admin') {
            $delete = $this->userModel->delete($id);
            if ($delete) {
                return $this->response->setJSON($responseSuccess);
            } else {
                return $this->response->setJSON($reponseError);
            }
        }

        if ($user && $user['usertype'] === 'teknisi') {
            $this->deleteInBatches($this->jadwalModel, 'teknisi_id', $id);
            if ($this->userModel->delete($id)) {
                return $this->response->setJSON($responseSuccess);
            } else {
                return $this->response->setJSON($reponseError);
            }
        }

        if ($user && $user['usertype'] === 'pelanggan') {
            $findPelanggan = $this->pelangganModel->where('user_id', $id)->first();
            if ($findPelanggan) {
                $this->deleteInBatches($this->jadwalModel, 'pelanggan_id', $findPelanggan['id']);
                $this->deleteInBatches($this->ticketModel, 'id_pelanggan', $findPelanggan['id']);
                $this->deleteInBatches($this->transaksiModel, 'pelanggan_id', $findPelanggan['id']);
                $this->pelangganModel->delete($findPelanggan['id']);

                if ($this->userModel->delete($id)) {
                    return $this->response->setJSON($responseSuccess);
                } else {
                    return $this->response->setJSON($reponseError);
                }
            } else {
                if ($this->userModel->delete($id)) {
                    return $this->response->setJSON($responseSuccess);
                } else {
                    return $this->response->setJSON($reponseError);
                }
            }
        }
    }

    private function deleteInBatches($model, $column, $value, $batchSize = 1000)
    {
        do {
            $records = $model->where($column, $value)->limit($batchSize)->findAll();
            if (!empty($records)) {
                $ids = [];
                foreach ($records as $record) {
                    $ids[] = $record['id'];
                }
                $model->delete($ids);
            }
        } while (!empty($records));
    }
}
