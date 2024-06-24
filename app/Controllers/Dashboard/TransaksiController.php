<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Jadwal;
use Midtrans\Config;
use Midtrans\Snap;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

class TransaksiController extends BaseController
{
    protected $transaksiModel;
    protected $pelangganModel;
    protected $jadwalModel;

    public function __construct()
    {
        $this->transaksiModel = new Transaksi();
        $this->pelangganModel = new Pelanggan();
        $this->jadwalModel = new Jadwal();
    }

    public function export()
    {
        $startDate = $this->request->getPost('startDate');
        $endDate = $this->request->getPost('endDate');
        $format = $this->request->getPost('format');

        if (empty($startDate) || empty($endDate)) {
            return redirect()->back()->with('error', 'Please select both start and end dates.');
        }

        $transaksiModel = new Transaksi();
        $data = $transaksiModel->select('
                                    transaksi.*, 
                                    pelanggan.id as id_pelanggan,
                                    pelanggan.alamat as alamat, 
                                    users.name as name,
                                ')
                                ->join('pelanggan', 'pelanggan.id = transaksi.pelanggan_id')
                                ->join('users', 'users.id = pelanggan.user_id')
                                ->where('transaksi.created_at >=', $startDate)
                                ->where('transaksi.created_at <=', $endDate)
                                ->where('transaksi.status', '1')
                                ->findAll();

        if ($format == 'pdf') {
            $this->exportPdf($data);
        } elseif ($format == 'excel') {
            $this->exportExcel($data);
        } else {
            return redirect()->back()->with('error', 'Invalid export format.');
        }
    }

    private function exportPdf($data)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        $html = view('dashboard/transaksi/pdf_report', ['data' => $data]);

        $dompdf->loadHtml($html);

        $dompdf->render();

        $dompdf->stream('laporan_transaksi.pdf', array('Attachment' => 0));
    }

    private function exportExcel($data)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Nama Pelanggan');
        $sheet->setCellValue('B1', 'Alamat');
        $sheet->setCellValue('C1', 'Kategori Pembayaran');
        $sheet->setCellValue('D1', 'Tipe Pembayaran');
        $sheet->setCellValue('E1', 'Total');
        $sheet->setCellValue('F1', 'Tanggal Pembayaran');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        $row = 2;
        $totalAmount = 0;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item['name']);
            $sheet->setCellValue('B' . $row, $item['alamat']);
            $sheet->setCellValue('C' . $row, $item['kategori_pembayaran']);
            $sheet->setCellValue('D' . $row, $item['type_pembayaran'] === '1' ? 'Online' : 'COD');
            $sheet->setCellValue('E' . $row, $item['total']);
            $sheet->setCellValue('F' . $row, $item['updated_at']);

            $totalAmount += $item['total'];
            $row++;
        }

        $sheet->setCellValue('D' . $row, 'Total');
        $sheet->setCellValue('E' . $row, $totalAmount);

        $sheet->getStyle('D' . $row . ':E' . $row)->getFont()->setBold(true);

        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $filename = 'laporan_transaksi.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function index()
    {
        return view('dashboard/transaksi/index', [
            'title' => 'Data Transaksi',
            'data' => $this->transaksiModel->select('
                                transaksi.*, 
                                pelanggan.id as id_pelanggan,
                                pelanggan.alamat as alamat, 
                                users.name as name,
                            ')
                ->join('pelanggan', 'pelanggan.id = transaksi.pelanggan_id')
                ->join('users', 'users.id = pelanggan.user_id')
                ->get()
                ->getResultArray(),
        ]);
    }

    public function detail($id)
    {
        $responseSuccess = [
            'status' => 'success',
            'message' => 'Berhasil Validasi Pembayaran'
        ];

        $reponseError = [
            'status' => 'error',
            'message' => 'Gagal Update Pembayaran'
        ];


        $transaksi = new Transaksi();
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'status' => '1',
            ];

            $update = $transaksi->update($id, $data);

            if (!$update) {
                return $this->response->setJSON($reponseError, 200);
            }
            return $this->response->setJSON($responseSuccess, 200);
        }

        return view('dashboard/transaksi/detail', [
            'title' => 'Detail Transaksi',
            'data' => $transaksi->where('id', $id)->first(),
        ]);
    }

    public function detailPelanggan($id)
    {
        return view('home/transaksi/detail', [
            //dd([
            'title' => 'Detail Transaksi',
            'data' => $this->transaksiModel->select('
                transaksi.*, 
                pelanggan.nomor_whatsapp as nomor,
                pelanggan.id as id_pelanggan,
                pelanggan.alamat as alamat, 
                users.name as name,
                users.email as email,
            ')
                ->join('pelanggan', 'pelanggan.id = transaksi.pelanggan_id')
                ->join('users', 'users.id = pelanggan.user_id')
                ->where('transaksi.id', $id)
                ->first(),
        ]);
    }

    public function delete($id)
    {
        $delete = $this->transaksiModel->delete($id);

        if (!$delete) {
            return redirect()->to('dashboard/transaksi')->with('message', 'Berhasil delete transaksi');
        }
        return redirect()->to('dashboard/transaksi')->with('message', 'Berhasil delete transaksi');
    }

    public function transaksiSaya($id)
    {
        $id_pelanggan = $this->pelangganModel->where('user_id', $id)->first();
        return view('home/transaksi/historyTransaksi', [
            'title' => 'Transaksi Saya',
            'data' => $this->transaksiModel->select('
                                        transaksi.*, 
                                        pelanggan.nomor_whatsapp as nomor,
                                        pelanggan.alamat as alamat, 
                                        users.name as name,
                                        users.email as email,
                                    ')
                ->join('pelanggan', 'pelanggan.id = transaksi.pelanggan_id')
                ->join('users', 'users.id = pelanggan.user_id')
                ->where('transaksi.pelanggan_id', $id_pelanggan['id'])
                ->get()
                ->getResultArray(),
        ]);
    }

    public function bayarOnline($id)
    {
        $data = $this->transaksiModel->select('
                                            transaksi.*, 
                                            pelanggan.nomor_whatsapp as nomor,
                                            pelanggan.alamat as alamat, 
                                            paket.nama as nama_paket,
                                            paket.kecepatan as kecepatan_paket,
                                            users.name as name,
                                            users.email as email,
                                        ')
            ->join('pelanggan', 'pelanggan.id = transaksi.pelanggan_id')
            ->join('paket', 'pelanggan.paket = paket.id')
            ->join('users', 'users.id = pelanggan.user_id')
            ->where('transaksi.id', $id)
            ->get()->getResultObject();
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        if (!is_numeric($data[0]->total)) {
            return 'Invalid total amount. Please check transaction data.';
        }

        $grossAmount = intval($data[0]->total);

        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . time(),
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $data[0]->name,
                'email' => $data[0]->email,
                'phone' => $data[0]->nomor,
                'billing_address' => [
                    'address' => $data[0]->alamat,
                ],
            ],
            'item_details' => [
                [
                    'id' => $data[0]->id,
                    'price' => $grossAmount,
                    'quantity' => 1,
                    'name' => $data[0]->nama_paket . '-' . $data[0]->kecepatan_paket
                ],
            ],
            'callbacks' => [
                'finish' => 'http://localhost:8080/home/transaksi/saya/bayar/online'
            ]
        ];

        $snapToken = json_encode(Snap::getSnapToken($params));

        return $this->response->setJSON($snapToken);
    }

    function generateUniqueNumericId($model, $min = 100000, $max = 999999)
    {
        do {
            $uniqueId = random_int($min, $max);
            $exists = $model->where('pelanggan_id', $uniqueId)->first();
        } while ($exists); 

        return $uniqueId;
    }

    public function updatePaymentStatus()
    {
        $findPelanggan = $this->pelangganModel->where('user_id', session()->id)->first();
        $transaksi = $this->transaksiModel
            ->where('status', '0')
            ->where('pelanggan_id', $findPelanggan['id'])
            ->first();

        if ($transaksi['kategori_pembayaran'] === 'bulanan') {
            $this->transaksiModel->update($transaksi['id'], ['status' => '1']);
        } else {
            $id = $this->generateUniqueNumericId($this->pelangganModel);

            $this->transaksiModel->update($transaksi['id'], [
                'status' => '1',
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            $this->pelangganModel->update($findPelanggan['id'], [
                'pelanggan_id' => $id
            ]);

            $data_jadwal = [
                'pelanggan_id' => $findPelanggan['id'],
                'ticket_id' => null,
                'waktu_pemasangan' => null,
                'bukti_kegiatan' => null,
                'foto_pelanggan' => null,
                'type_jadwal' => 'instalasi_baru',
                'status' => '0',
            ];

            $this->jadwalModel->insert($data_jadwal);
        }

        return redirect()->to('home/transaksi/saya/detail/' . $transaksi['id'])->with('message', 'Pembayaran berhasil!');
    }
}
