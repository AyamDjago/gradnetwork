# GradNetwork 🎓⚡

**GradNetwork** adalah sistem dasbor pelacakan dan manajemen data alumni bergaya *Comic-Book / Pop-Art*. Aplikasi ini dirancang agar ringan, mudah digunakan, dan menyajikan data statistik kelulusan serta status karier alumni secara visual yang interaktif.

## ✨ Fitur Utama
- **Desain Estetik & Ramah Mata:** Mengadopsi palet warna pastel bergaya komik dengan pola *halftone* (titik-titik latar) dan gaya *border* tebal.
- **Statistik Interaktif:** Menampilkan metrik utama jumlah data alumni berdasarkan status (Tervalidasi, Perlu Validasi, Data Rancu) yang dilengkapi dengan *Pie Chart* dinamis.
- **Pencarian Cepat:** Tabel data alumni yang mendukung pencarian *real-time* dan penyaringan berdasarkan status validasi.

## 🛠️ Teknologi yang Digunakan
- **Frontend:** HTML5, Vanilla JavaScript, Tailwind CSS (via CDN), Chart.js (untuk grafik statistik), FontAwesome.
- **Backend:** PHP 8+ (Murni tanpa *framework*).
- **Database:** MySQL.
- **Tools Bantuan:** Python (skrip impor CSV ke MySQL).

## 🚀 Cara Menjalankan Aplikasi di Lokal (Laragon / XAMPP)

### Prasyarat
Pastikan komputer Anda sudah terinstal **Laragon** atau **XAMPP**, dan ekstensi PDO/MySQL PHP sudah aktif.

### Langkah-langkah Instalasi
1. **Pindahkan Folder Proyek**
   Letakkan folder proyek ini (misalnya `UI-D4`) ke dalam direktori *web root* Anda:
   - Jika memakai **Laragon**: `C:\laragon\www\`
   - Jika memakai **XAMPP**: `C:\xampp\htdocs\`

2. **Setup Database**
   - Buka aplikasi manajemen *database* Anda (HeidiSQL, DBeaver, atau phpMyAdmin).
   - Buat *database* baru dengan nama: `db_alumni`
   - Untuk memindahkan data dari CSV ke *database*, Anda dapat langsung menjalankan skrip Python yang telah disediakan di dalam folder proyek:
     ```bash
     python sql/import_csv.py
     ```
     *(Pastikan Python dan modul `mysql-connector-python` sudah terinstal di komputer Anda).*

3. **Konfigurasi Environment (`.env`)**
   Sesuaikan kredensial *database* pada file `.env` di *root* proyek Anda:
   ```env
   DB_HOST=localhost
   DB_NAME=db_alumni
   DB_USER=root
   DB_PASS=          # Kosongkan jika menggunakan Laragon/XAMPP bawaan
   
   ADMIN_USERNAME=admin
   ADMIN_PASSWORD=adminganteng
   ```

4. **Akses Aplikasi**
   - Jalankan server Apache dan MySQL di Laragon/XAMPP.
   - Buka *browser* dan akses: 
     - Laragon (menggunakan Auto Virtual Host): `http://ui-d4.test`
     - XAMPP: `http://localhost/UI-D4`
   - Login menggunakan kredensial yang ada di `.env` (misal: *username*: `admin`, *password*: `adminganteng`).

## 📁 Struktur Direktori Penting
- `/api/` : Berisi *endpoint* PHP untuk menghubungkan *frontend* dengan MySQL.
- `/css/` : *Custom CSS* untuk animasi, *scrollbar*, dan elemen desain khusus.
- `/js/` : Logika *frontend* (konfigurasi, autentikasi, penyortiran, dan *rendering* UI).
- `/sql/` : Menyimpan file panduan dan skrip pembantu koneksi DB (`import_csv.py`).

---
Dibuat dengan ❤️ untuk kemudahan administrasi alumni.
