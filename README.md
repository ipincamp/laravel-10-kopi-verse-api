# Coffee Shop

Coffee Shop adalah aplikasi yang dirancang untuk mempermudah pelanggan dalam melihat menu, memesan kopi, dan mengelola proses pemesanan secara efisien. Aplikasi ini dirancang untuk meningkatkan pengalaman pelanggan sekaligus mendukung operasional yang lebih terstruktur bagi barista dan kasir.

---

## 🚀 Fitur Utama
- **Katalog Menu**: Menampilkan daftar menu lengkap dengan detail seperti harga, rating, dan kategori.
- **Pemesanan Online**: Pesan kopi dari mana saja melalui aplikasi.
- **QR Code untuk Order**: Proses pemesanan dan pembayaran menggunakan kode QR yang unik.
- **Manajemen Admin**: Admin dapat mengelola produk, pengguna, stok, dan laporan penjualan.
- **Opsi Tanpa Login**: Pemesanan tetap bisa dilakukan tanpa login, dengan pembayaran di tempat.

---

## 🖥️ Teknologi yang Digunakan
- **Frontend**: [Flutter](https://flutter.dev/) v3.24.5
- **Backend**: [Laravel](https://laravel.com/docs/10.x/installation) v10.48.25
- **Database**: [MySQL](https://sg-mirrors.vhost.vn/mariadb//mariadb-10.11.10/winx64-packages/mariadb-10.11.10-winx64.zip) v10.11.10-MariaDB

---

## 🖥️ Spesifikasi Server
- [PHP](https://flutter.dev/) v8.3.8
- [Composer](https://laravel.com/docs/10.x/installation) v2.7.7

---

## 📚 Cara Instalasi
1. Clone repository:
   ```bash
   git clone https://github.com/ipincamp/laravel-10-coffee-shop-api.git
   ```
2. Masuk ke direktori proyek dan salin environment:
   ```bash
   cd laravel-10-coffee-shop-api
   cp .env.example .env
   ```
3. Instal dependensi dan generate key:
   ```bash
   composer install
   php artisan key:generate
   ```
4. Jalankan migrasi dan seeder:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```
5. Jalankan server:
   ```bash
   php artisan serve
   ```

---

## 🎯 Cara Menggunakan Aplikasi
1. **Pelanggan**
   - Login atau daftar akun.
   - Telusuri menu dan pilih item.
   - Cetak QR Code untuk memproses pesanan.
   - Lakukan pembayaran di tempat dengan memindai QR Code.
   - Berikan rating untuk kopi setelah selesai.

2. **Kasir**
   - Pindai QR Code pelanggan.
   - Lakukan konfirmasi pembayaran dan proses order.

3. **Admin**
   - Kelola produk, stok, pengguna, dan laporan penjualan melalui panel admin.

---

## 📈 Roadmap
- Penambahan metode pembayaran digital.
- Fitur pelacakan pesanan secara real-time.
- Sistem notifikasi untuk status pesanan.

---

## 🤝 Kontribusi
Kontribusi sangat dihargai! Silakan buat pull request atau laporkan isu di tab [Issues](https://github.com/ipincamp/laravel-10-coffee-shop-api/issues).

---

## 🛠️ Lisensi
Proyek ini dilisensikan di bawah [MIT License](./LICENSE).
