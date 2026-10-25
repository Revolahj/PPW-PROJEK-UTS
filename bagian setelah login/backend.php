<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Tangkap input dari form login
    $email_input    = $_POST['email'];
    $password_input = $_POST['password'];

//bagian if yang di dalamnya server itu harus di masukkan ke bagian method form di html supaya bisa bergerak

    $login_berhasil = false;
    $nama_pengguna  = "";
    $FileUser='../users.txt';
    
    // 2. Cek apakah file users.txt ada
    if (file_exists($FileUser)) {
        // Ambil semua baris data
        $baris_data = file($FileUser, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($baris_data as $baris) {
            // Pecah data berdasarkan pemisah " | " (Nama | Email | Password_Hash)
            $data = explode(" | ", $baris);

            if (count($data) === 3) {
                $saved_nama     = $data[0];
                $saved_email    = $data[1];
                $saved_password = $data[2];

                // 3. Cocokkan email dan verifikasi password hash-nya
                if ($email_input === trim($saved_email) && password_verify($password_input, trim($saved_password))) {
                    $login_berhasil = true;
                    $nama_pengguna  = $saved_nama;
                    break;
                }
            }
        }
    }

    // 4. Pengkondisian Hasil Login sesuai Gambar UI Anda
    if ($login_berhasil) {
        // Jika COCOK: Simpan sesi dan arahkan ke Halaman Berhasil Login (Gambar ke-2)
        $_SESSION['user_nama'] = $nama_pengguna;
        header("Location: halaman setelah projek.html");
        exit;
    } else {
        // Jika TIDAK COCOK: Arahkan ke Halaman Gagal Login (Gambar ke-1)
        header("Location: gagal login.html");
        exit;
    }

} else {
    header("Location: login.php");
    exit;
}
?>