<?php
// Cek apakah data dikirim via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Tangkap data dari form Register_Page.php
    $nama     = trim($_POST['nama']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // 2. Validasi Format Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Format email tidak valid! Harap masukkan email yang benar.'); window.history.back();</script>";
        exit;
    }

    // 3. Hash password demi keamanan
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // 4. Format baris data: Nama | Email | Password_Hash
    $data_user = $nama . " | " . $email . " | " . $password_hash . PHP_EOL;

    // 5. Simpan & tumpuk data ke file users.txt (tanpa MySQL)
    file_put_contents('users.txt', $data_user, FILE_APPEND);

    // 6. Notifikasi berhasil dan pindah ke halaman login
    echo "<script>alert('Berhasil daftar!'); window.location.href='login.php';</script>";
} else {
    // Jika file diakses langsung tanpa submit form, lempar balik ke form register
    header("Location: Register_Page.php");
    exit;
}
?>