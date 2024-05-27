# Proyek X

Deskripsi proyek.

## Instalasi dan Menjalankan CodeIgniter 4 (CI4)

1. **Unduh Proyek:**
   - Clone repositori ini ke direktori lokal Anda.

3. **Konfigurasi:**
   - Buka file `.env` dan atur konfigurasi database sesuai dengan pengaturan server Anda.

4. **Instalasi Dependensi:**
   - Buka terminal atau command prompt, lalu navigasikan ke direktori proyek.
   - Jalankan perintah berikut untuk menginstal dependensi:
     ```
     npm install
     ```

     ```
     composer install
     ```

5. **Jalankan Server Lokal:**
   - Anda dapat menggunakan server bawaan PHP untuk menjalankan proyek CI4. Jalankan perintah berikut di terminal atau command prompt:
     ```
     php spark serve
     ```
   - Proyek Anda akan dijalankan pada alamat `http://localhost:8080`.


## Penggunaan

### Configurasi Tailwind CSS

1. **Jalankan Tailwind CSS dengan Mode Watch:**
   - Buka terminal atau command prompt, dan jalankan perintah berikut:
     ```
     npx tailwindcss -i public/assets/css/input.css -o public/assets/css/output.css --watch
     ```
     - `styles.css`: Nama file CSS utama Anda.
     - `output.css`: Nama file untuk hasil output.
     - `--watch`: Opsi ini akan memantau perubahan pada file `styles.css` dan secara otomatis menghasilkan output `output.css` setiap kali ada perubahan.

2. **Penggunaan Tailwind CSS:**
   - Gunakan Tailwind CSS di file CSS Anda dengan mengimpornya:
     ```css
    @tailwind base;
    @tailwind components;
    @tailwind utilities;
     ```



-fitur admin 
1.Ngga bisa delete akun akun pelanggan dan teknisi

2.waktu rekap transaksi tampilan kategori pembayarannya di excel ping,   'bulanan' dan 'instalasi baru'
 
3.aksi fitur laporan tidak ada yg berfungsi eror

-fitur user 
1.setelah melakukan pembayaran bulanan status tetep 'belum bayar' padahal sukses

Ada bugnya pas waktu klik tambah biaya bulanan malah jadwal si A ada lagi ping
