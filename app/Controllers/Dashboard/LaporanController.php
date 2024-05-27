<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\Laporan;
use App\Models\Transaksi;
use App\Models\Jadwal;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanController extends BaseController
{
    protected $laporanModel;
    protected $transaksiModel;
    protected $jadwalModel;

    public function __construct()
    {
        $this->laporanModel = new Laporan();
        $this->transaksiModel = new Transaksi();
        $this->jadwalModel = new Jadwal();
    }

    public function index()
    {
        return view('dashboard/rekap/transaksi/index', [
            'title' => 'Rekap Transaksi',
            'data' => $this->laporanModel
                ->select('
                                laporan.*, 
                                users.name as name
                            ')
                ->join('users', 'users.id = laporan.author')
                ->where('kategori', 'transaksi')
                ->findAll(),
        ]);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'author' => session()->get('id') ?? '1',
                'start_date' => $this->request->getPost('start_date'),
                'end_date' => $this->request->getPost('end_date'),
                'kategori' => 'transaksi',
            ];

            $create = $this->laporanModel->insert($data);

            if (!$create) {
                return redirect()->to('dashboard/rekap/transaksi')->with('error', 'Gagal membuat laporan');
            }
            return redirect()->to('dashboard/rekap/transaksi')->with('success', 'Berhasil membuat laporan');
        }

        return view('dashboard/rekap/transaksi/create', [
            'title' => 'Rekap Transaksi',
        ]);
    }

    public function update($id)
    {
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'author' => session()->get('id'),
                'start_date' => $this->request->getPost('start_date'),
                'end_date' => $this->request->getPost('end_date'),
                'kategori' => 'transaksi',
            ];

            $update = $this->laporanModel->update($id, $data);

            if (!$update) {
                return redirect()->to('dashboard/rekap/transaksi')->with('error', 'Gagal update laporan');
            }
            return redirect()->to('dashboard/rekap/transaksi')->with('success', 'Berhasil update laporan');
        }

        return view('dashboard/rekap/transaksi/update', [
            'title' => 'Rekap Transaksi',
            'data' => $this->laporanModel->where('id', $id)->first(),
        ]);
    }

    public function delete($id)
    {
        $delete = $this->laporanModel->delete($id);

        if (!$delete) {
            return redirect()->to('dashboard/rekap/transaksi')->with('error', 'Gagal delete laporan');
        }
        return redirect()->to('dashboard/rekap/transaksi')->with('success', 'Berhasil delete laporan');
    }

    public function export($id)
    {
        $date = $this->laporanModel->find($id);

        $startDate = $date['start_date'] . ' 00:00:00';
        $endDate = $date['end_date'] . ' 23:59:59';

        $data = $this->transaksiModel
            ->select('
                        transaksi.*,
                        pelanggan.alamat as alamat,
                        pelanggan.nomor_whatsapp as nomor,
                        users.name as nama_pelanggan,
                        users.email as email_pelanggan,
                    ')
            ->join('pelanggan', 'pelanggan.id = transaksi.pelanggan_id')
            ->join('users', 'users.id = pelanggan.user_id')
            ->where('transaksi.created_at >=', $startDate)
            ->where('transaksi.created_at <=', $endDate)
            ->get()
            ->getResultArray();

        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->mergeCells('A1:I1');
        $spreadsheet->getActiveSheet()->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Laporan Transaksi')
            ->setCellValue('A2', 'Nama Pelanggan')
            ->setCellValue('B2', 'Email Pelanggan')
            ->setCellValue('C2', 'Alamat')
            ->setCellValue('D2', 'Nomor WhatsApp')
            ->setCellValue('E2', 'Total')
            ->setCellValue('F2', 'Keterangan')
            ->setCellValue('G2', 'Kategori Pembayaran')
            ->setCellValue('H2', 'Metode Pembayaran')
            ->setCellValue('I2', 'Tanggal');
        $column = 3;

        foreach ($data as $data) {
            $status = $data['status'] === '1' ? 'Berhasil' : 'Diproses';
            $kategori = $data['kategori_pembayaran'] === 'pasang_baru' ? 'Pasang Baru' : 'Bulanan';
            $metode = $data['type_pembayaran'] === '1' ? 'Online' : 'Tunai/Cash';
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $data['nama_pelanggan'])
                ->setCellValue('B' . $column, $data['email_pelanggan'])
                ->setCellValue('C' . $column, $data['alamat'])
                ->setCellValue('D' . $column, $data['nomor'])
                ->setCellValue('E' . $column, $data['total'])
                ->setCellValue('F' . $column, $status)
                ->setCellValue('G' . $column, $kategori)
                ->setCellValue('H' . $column, $metode)
                ->setCellValue('I' . $column, $data['created_at']);
            $column++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan Transaksi_' . $date['start_date'] . '_-_' . $date['end_date'];

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function indexJadwal()
    {
        return view('dashboard/rekap/jadwal/index', [
            'title' => 'Rekap Jadwal',
            'data' => $this->laporanModel
                ->select('
                                laporan.*, 
                                users.name as name
                            ')
                ->join('users', 'users.id = laporan.author')
                ->where('kategori', 'jadwal')
                ->findAll(),
        ]);
    }

    public function createJadwal()
    {
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'author' => session()->get('id') ?? '1',
                'start_date' => $this->request->getPost('start_date'),
                'end_date' => $this->request->getPost('end_date'),
                'kategori' => 'jadwal',
            ];

            $create = $this->laporanModel->insert($data);

            if (!$create) {
                return redirect()->to('dashboard/rekap/jadwal')->with('error', 'Gagal membuat laporan');
            }
            return redirect()->to('dashboard/rekap/jadwal')->with('success', 'Berhasil membuat laporan');
        }

        return view('dashboard/rekap/jadwal/create', [
            'title' => 'Rekap Jadwal',
        ]);
    }

    public function updateJadwal($id)
    {
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'author' => session()->get('id'),
                'start_date' => $this->request->getPost('start_date'),
                'end_date' => $this->request->getPost('end_date'),
                'kategori' => 'jadwal',
            ];

            $update = $this->laporanModel->update($id, $data);

            if (!$update) {
                return redirect()->to('dashboard/rekap/jadwal')->with('error', 'Gagal update laporan');
            }
            return redirect()->to('dashboard/rekap/jadwal')->with('success', 'Berhasil update laporan');
        }

        return view('dashboard/rekap/jadwal/update', [
            'title' => 'Rekap Jadwal',
            'data' => $this->laporanModel->where('id', $id)->first(),
        ]);
    }

    public function deleteJadwal($id)
    {
        $delete = $this->laporanModel->delete($id);

        if (!$delete) {
            return redirect()->to('dashboard/rekap/jadwal')->with('error', 'Gagal delete laporan');
        }
        return redirect()->to('dashboard/rekap/jadwal')->with('success', 'Berhasil delete laporan');
    }

    public function exportJadwal($id)
    {
        $date = $this->laporanModel->find($id);

        $startDate = $date['start_date'] . ' 00:00:00';
        $endDate = $date['end_date'] . ' 23:59:59';

        $data = $this->jadwalModel
            ->select('
                            jadwal.*,
                            pelanggan.geolocation as geolocation,
                            pelanggan.alamat as alamat,
                            user_pelanggan.name as nama_pelanggan,
                            user_teknisi.name as nama_teknisi
            ')
            ->join('pelanggan', 'jadwal.pelanggan_id = pelanggan.id')
            ->join('users as user_pelanggan', 'pelanggan.user_id = user_pelanggan.id')
            ->join('users as user_teknisi', 'jadwal.teknisi_id = user_teknisi.id')
            ->where('jadwal.created_at >=', $startDate)
            ->where('jadwal.created_at <=', $endDate)
            ->get()
            ->getResultArray();

        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->getStyle('D')->getNumberFormat()
            ->setFormatCode('#,##0.00');
        $spreadsheet->getActiveSheet()->mergeCells('A1:G1');
        $spreadsheet->getActiveSheet()->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Laporan Jadwal')
            ->setCellValue('A2', 'Nama Pelanggan')
            ->setCellValue('B2', 'Nama Teknisi')
            ->setCellValue('C2', 'ID Tiket Laporan')
            ->setCellValue('D2', 'Waktu Pemasangan')
            ->setCellValue('E2', 'Geolocation')
            ->setCellValue('F2', 'Alamat')
            ->setCellValue('G2', 'Tipe Jadwal');
        $column = 3;

        foreach ($data as $data) {
            $status = $data['status'] === '1' ? 'Berhasil' : 'Diproses';
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $data['nama_pelanggan'])
                ->setCellValue('B' . $column, $data['nama_teknisi'])
                ->setCellValue('C' . $column, $data['ticket_id'])
                ->setCellValue('D' . $column, $data['waktu_pemasangan'])
                ->setCellValue('E' . $column, $data['geolocation'])
                ->setCellValue('F' . $column, $data['alamat'])
                ->setCellValue('G' . $column, $status);
            $column++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan Transaksi_' . $date['start_date'] . '_-_' . $date['end_date'];

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
