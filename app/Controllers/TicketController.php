<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pelanggan;
use App\Models\Ticket;
use App\Models\Jadwal;
use CodeIgniter\HTTP\ResponseInterface;

class TicketController extends BaseController
{
    public function index()
    {
        $ticket = new Ticket();
        $pelanggan = new Pelanggan();

        $findPelanggan = $pelanggan->where('user_id', session()->id)->first();

        return view('home/lapor/index', [
            'title' => 'Data Laporan Saya',
            'data' => $ticket->where('id_pelanggan', $findPelanggan['id'])->findAll(),
        ]);
    }

    public function create()
    {
        $ticket = new Ticket();
        $pelanggan = new Pelanggan();
    
        $findPelanggan = $pelanggan->where('user_id', session()->id)->first();
    
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'id_pelanggan' => $findPelanggan['id'],
                'keluhan' => $this->request->getPost('keluhan'),
                'status' => '0'
            ];
    
            $create = $ticket->insert($data);
    
            if (!$create) {
                return redirect()->to('home/laporan/saya/'.session()->id)->with('error', 'Failed to create ticket.');
            }
            return redirect()->to('home/laporan/saya/'.session()->id)->with('success', 'Ticket created successfully.');
        }

        return view('home/lapor/create', [
            'title' => 'Buat Laporan',
            'data' => null
        ]);
    }    

    public function update($id)
    {
        $ticket = new Ticket();
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'keluhan' => $this->request->getPost('keluhan'),
            ];

            $update = $ticket->update($id, $data);

            if(!$update) {
                return redirect()->to('home/laporan/saya/'.session()->id)->with('error', 'Gagal update paket');
            }
            return redirect()->to('home/laporan/saya/'.session()->id)->with('success', 'Berhasil update paket');
        }

        return view('home/lapor/update', [
            'title' => 'Update Laporan',
            'data' => $ticket->find($id),
        ]);
    }

    public function delete($id)
    {
        $ticket = new Ticket();
        $delete = $ticket->delete($id);

        if(session()->userType === 'admin') {
            if(!$delete) {
                return redirect()->to('dashboard/laporan')->with('error', 'Gagal delete paket');
            }
            return redirect()->to('dashboard/laporan')->with('success', 'Berhasil delete paket');
        }

        if(!$delete) {
            return redirect()->to('home/laporan/saya/'.session()->id)->with('error', 'Gagal delete paket');
        }
        return redirect()->to('home/laporan/saya/'.session()->id)->with('success', 'Berhasil delete paket');
        
    }

    public function indexAdmin()
    {
        $ticket = new Ticket();
        $jadwal = new Jadwal();
    
        // Retrieve all tickets
        $tickets = $ticket
            ->select('
                ticket.*,
                pelanggan.nomor_whatsapp as nomor,
                pelanggan.foto_diri as foto_pelanggan,
                users.name as nama
            ')
            ->join('pelanggan', 'pelanggan.id = ticket.id_pelanggan')
            ->join('users', 'users.id = pelanggan.user_id')
            ->findAll();
    
        // Retrieve all schedules with associated ticket data
        $schedulesWithTickets = $jadwal
            ->select('jadwal.*, users.name as name, pelanggan.geolocation as geolocation, pelanggan.alamat as alamat, ticket.id as id_ticket')
            ->join('pelanggan', 'pelanggan.id = jadwal.pelanggan_id')
            ->join('users', 'users.id = pelanggan.user_id')
            ->join('ticket', 'ticket.id = jadwal.ticket_id')
            ->findAll();
    
        return view('dashboard/lapor/index', [
        //dd([   
            'title' => 'Data Laporan Pelanggan',
            'data' => $tickets, // Pass ticket data
            'schedulesWithTickets' => $schedulesWithTickets, // Pass schedules with tickets
        ]);
    }    

    public function createAdmin($id)
    {
        $jadwal = new Jadwal();
        $ticket = new Ticket();

        $findPelanggan = $ticket->find($id);
        if ($this->request->getMethod() === 'POST') {
            $existingJadwal = $jadwal->where('pelanggan_id', $findPelanggan['id_pelanggan'])
                ->where('status', '0')
                ->Where('type_jadwal', 'perbaikan')
                ->first();
            
            if ($existingJadwal) {
                return redirect()->to('dashboard/laporan')->with('error', 'You already have a pending ticket or a scheduled repair.');
            }

            dd($existingJadwal);

            $data = [
                'pelanggan_id' => $findPelanggan['id_pelanggan'],
                'waktu_pemasangan' => $this->request->getPost('waktu_pemasangan'),
                'ticket_id' => $id,
                'type_jadwal' => 'perbaikan',
                'status' => '0',
            ];

            $create = $jadwal->insert($data);

            if(!$create) {
                return redirect()->to('dashboard/laporan')->with('error', 'Gagal membuat jadwal');
            }
            return redirect()->to('dashboard/laporan')->with('success', 'Berhasil membuat jadwal');
        }

        return view('dashboard/lapor/create', [
            'title' => 'Buat Jadwal',
            'id' => $id,
        ]);
    }

    public function updateAdmin($id)
    {
        $ticket = new Ticket();
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'keluhan' => $this->request->getPost('keluhan'),
                'status' => $this->request->getPost('status'),
            ];

            $update = $ticket->update($id, $data);

            if(!$update) {
                return redirect()->to('dashboard/laporan/')->with('error', 'Gagal update paket');
            }
            return redirect()->to('dashboard/laporan/')->with('success', 'Berhasil update paket');
        }

        return view('dashboard/lapor/update', [
            'title' => 'Update Laporan',
            'data' => $ticket->find($id),
        ]);
    }
}
