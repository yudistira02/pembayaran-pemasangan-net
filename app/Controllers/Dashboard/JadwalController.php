<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\Jadwal;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Ticket;
use App\Models\User;

class JadwalController extends BaseController
{
    protected $jadwalModel;
    protected $transaksiModel;
    protected $pelangganModel;


    public function __construct()
    {
        $this->jadwalModel = new Jadwal();
        $this->transaksiModel = new Transaksi();
        $this->pelangganModel = new Pelanggan();
    }

    public function index()
    {
        if (session()->userType === 'teknisi') {
            $data = $this->jadwalModel
                ->select('jadwal.*, users.name as name, pelanggan.geolocation as geolocation, pelanggan.alamat as alamat')
                ->join('pelanggan', 'pelanggan.id = jadwal.pelanggan_id')
                ->join('users', 'users.id = pelanggan.user_id')
                ->where('jadwal.teknisi_id', session()->id)
                ->get()
                ->getResultArray();
        } else {
            $data = $this->jadwalModel
                ->select('jadwal.*, users.name as name, pelanggan.geolocation as geolocation, pelanggan.alamat as alamat')
                ->join('pelanggan', 'pelanggan.id = jadwal.pelanggan_id')
                ->join('users', 'users.id = pelanggan.user_id')
                ->findAll();
        }

        return view('dashboard/jadwal/index', [
            //dd([
            'title' => 'Jadwal',
            'data' => $data
        ]);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'GET') {
            return view('dashboard/rekap/jadwal/create', [
                'title' => 'Tambah Jadwal',
                'transaksi' => $this->transaksiModel->findAll(),
            ]);
        }

        $data = [
            'pelanggan_id' => $this->request->getPost('pelanggan_id'),
            'bukti_kegiatan' => $this->request->getPost('bukti_kegiatan'),
            'type_jadwal' => $this->request->getPost('type_jadwal'),
            'status' => '0',
        ];

        $create = $this->jadwalModel->insert($data);

        if (!$create) {
            return redirect()->to('dashboard/jadwal')->with('error', 'Gagal tambah jadwal');
        }
        return redirect()->to('dashboard/jadwal')->with('success', 'Berhasil tambah jadwal');
    }

    public function update($id)
    {
        if ($this->request->getMethod() === 'POST') {
            $data = [];
            $bukti_kegiatan = $this->request->getFile('bukti_kegiatan');
            if ($bukti_kegiatan && $bukti_kegiatan->isValid() && !$bukti_kegiatan->hasMoved()) {
                $extension = $bukti_kegiatan->getExtension();
                $allowedExtensions = ['jpg', 'jpeg'];

                if (in_array($extension, $allowedExtensions)) {
                    $newName = $bukti_kegiatan->getRandomName();

                    try {
                        $bukti_kegiatan->move('uploads', $newName);
                        $data['bukti_kegiatan'] = $newName;
                    } catch (\Exception $e) {
                        return redirect()->to('dashboard/jadwal')->with('error', 'Failed to upload bukti kegiatan.');
                    }
                } else {
                    return redirect()->to('dashboard/jadwal')->with('error', 'Only JPG and JPEG files are allowed for bukti kegiatan.');
                }
            }

            $foto_pelanggan = $this->request->getFile('foto_pelanggan');
            if ($foto_pelanggan && $foto_pelanggan->isValid() && !$foto_pelanggan->hasMoved()) {
                $extension = $foto_pelanggan->getExtension();
                $allowedExtensions = ['jpg', 'jpeg'];

                if (in_array($extension, $allowedExtensions)) {
                    $newName = $foto_pelanggan->getRandomName();

                    try {
                        $foto_pelanggan->move('uploads', $newName);
                        $data['foto_pelanggan'] = $newName;
                    } catch (\Exception $e) {
                        return redirect()->to('dashboard/jadwal')->with('error', 'Failed to upload foto pelanggan.');
                    }
                } else {
                    return redirect()->to('dashboard/jadwal')->with('error', 'Only JPG and JPEG files are allowed for foto pelanggan.');
                }
            }

            if ($this->request->getPost('waktu_pemasangan')) {
                $data['waktu_pemasangan'] = $this->request->getPost('waktu_pemasangan');
            }

            if ($this->request->getPost('status')) {
                $data['status'] = $this->request->getPost('status');
            }

            if ($this->request->getPost('teknisi_id')) {
                $data['teknisi_id'] = $this->request->getPost('teknisi_id');
            }

            if (empty($data)) {
                return redirect()->to('dashboard/jadwal')->with('error', 'No data to update.');
            }

            $jadwal = new Jadwal();
            $ticket = new Ticket();
            $pelanggan = new Pelanggan();

            if ($this->request->getPost('status')) {
                $findJadwal = $jadwal->where('id', $id)->where('type_jadwal', 'instalasi_baru')->first();

                if ($findJadwal) {
                    $findPelanggan = $pelanggan->where('id', $findJadwal['pelanggan_id'])->first();
                    if ($findPelanggan && $findPelanggan['status'] === '0') {
                        $pelanggan->update($findPelanggan['id'], ['status' => $this->request->getPost('status')]);
                    }
                }
            }

            $getJadwal = $jadwal->find($id);
            if (!$getJadwal) {
                return redirect()->to('dashboard/jadwal')->with('error', 'Jadwal not found.');
            }

            $update = $this->jadwalModel->update($id, $data);
            if ($getJadwal['type_jadwal'] === 'perbaikan') {
                $getTicket = $ticket->where('id', $getJadwal['ticket_id'])->first();
                if ($getTicket) {
                    $ticket->update($getTicket['id'], ['status' => '1']);
                }
            }

            if (!$update) {
                return redirect()->to('dashboard/jadwal')->with('error', 'Failed to update schedule.');
            }

            return redirect()->to('dashboard/jadwal')->with('success', 'Schedule updated successfully.');
        }

        $jadwalModel = new Jadwal();
        $userModel = new User();

        $jadwalData = $jadwalModel->find($id);

        // Get the chosen waktu_pemasangan
        $waktuPemasangan = $this->request->getVar('waktu_pemasangan');

        // Get all technicians from the user table
        $allTechnicians = $userModel->where('usertype', 'teknisi')->findAll();

        if ($waktuPemasangan) {
            // Get all technician IDs scheduled for the chosen waktu_pemasangan
            $scheduledTechnicians = $jadwalModel->where('waktu_pemasangan', $waktuPemasangan)->findAll();
            $scheduledTechnicianIds = array_column($scheduledTechnicians, 'teknisi_id');

            // Filter out technicians who are not scheduled for the chosen waktu_pemasangan
            $availableTechnicians = array_filter($allTechnicians, function ($technician) use ($scheduledTechnicianIds) {
                return !in_array($technician['id'], $scheduledTechnicianIds);
            });
        } else {
            // If no waktu_pemasangan is chosen, all technicians are available
            $availableTechnicians = $allTechnicians;
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['teknisi' => array_values($availableTechnicians)]);
        }

        return view('dashboard/jadwal/update', [
            'title' => 'Jadwal',
            'data' => $jadwalData,
            'teknisi' => $availableTechnicians
        ]);
    }

    public function delete($id)
    {
        $delete = $this->jadwalModel->delete($id);

        if (!$delete) {
            return redirect()->to('dashboard/jadwal')->with('error', 'Gagal delete jadwal');
        }
        return redirect()->to('dashboard/jadwal')->with('success', 'Berhasil delete jadwal');
    }
}
