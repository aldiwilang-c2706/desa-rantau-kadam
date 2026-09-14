# TUTORIAL INSTALASI

## 1. Install XAMPP
Install XAMPP, lalu Start Apache dan MySQL.

## 2. Copy project
Extract folder ke:
C:\xampp\htdocs\desa-rantau-kadam

## 3. Import database
Buka http://localhost/phpmyadmin
Pilih Import -> pilih `schema.sql` -> Go.
Database `desa_rantau_kadam` akan dibuat.

## 4. Cek koneksi
Buka `config/config.php`.
Default XAMPP:
DB_HOST = 127.0.0.1
DB_NAME = desa_rantau_kadam
DB_USER = root
DB_PASS = kosong

Jika MySQL kamu memakai password, isi DB_PASS.

## 5. Buat admin
Buka:
http://localhost/desa-rantau-kadam/install.php

Isi username, nama lengkap, password minimal 8 karakter.
Setelah sukses, HAPUS `install.php`.

## 6. Login
http://localhost/desa-rantau-kadam/login.php

Panel:
http://localhost/desa-rantau-kadam/admin/

## 7. Isi data
Masuk Admin -> Profil Desa dan ganti data contoh.
Kemudian tambah berita, pengumuman, galeri, potensi, perangkat, dokumen, dan user.

## 8. Upload
Gambar JPG/JPEG/PNG maksimal 2 MB.
PDF maksimal 5 MB.
Folder upload:
uploads/images
uploads/docs

Jika upload terlalu besar, cek php.ini:
upload_max_filesize = 10M
post_max_size = 12M
Lalu restart Apache.

## 9. Google Maps
Edit iframe di `kontak.php` dan ganti query lokasi dengan lokasi kantor desa resmi.

## 10. Logo
Saat ini `RK` adalah placeholder. Ganti dengan logo resmi desa/Musi Rawas Utara pada header dan halaman login.

## 11. Deployment hosting
Upload project ke public_html, buat database MySQL, import schema.sql, ubah DB_* di config.php, pastikan folder uploads writable, buat admin sekali, hapus install.php, dan aktifkan HTTPS.

## 12. Troubleshooting
`could not find driver`: aktifkan pdo_mysql pada php.ini.
Database error: cek DB_HOST/DB_NAME/DB_USER/DB_PASS.
Upload error: cek ekstensi fileinfo, permission folder, dan limit upload.
404: pastikan nama folder `desa-rantau-kadam` atau ubah BASE_URL di config.php.
