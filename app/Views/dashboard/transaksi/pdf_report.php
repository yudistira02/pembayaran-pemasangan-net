<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            font-size: 14px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Laporan Transaksi</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pelanggan</th>
                    <th>Alamat</th>
                    <th>Kategori Pembayaran</th>
                    <th>Tipe Pembayaran</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach ($data as $index => $item): 
                    $total += $item['total'];
                ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $item['name'] ?></td>
                    <td><?= $item['alamat'] ?></td>
                    <td><?= $item['kategori_pembayaran'] === 'bulanan' ? 'Bulanan' : 'Instalasi Baru' ?></td>
                    <td><?= $item['type_pembayaran'] === '1' ? 'Online' : 'COD (Cash On Delivery)' ?></td>
                    <td><?= number_format($item['total'], 0, ',', '.') ?></td>
                    <td><?= $item['status'] === '0' ? 'Belum Bayar' : 'Sudah Bayar' ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="5" style="text-align: right;"><strong>Total:</strong></td>
                    <td><strong><?= number_format($total, 0, ',', '.') ?></strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
