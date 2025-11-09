<?php
require '../../../db/db.php'; // Sesuaikan dengan struktur folder kamu

// Cek apakah form sudah dikirim
if (isset($_POST['username']) && isset($_POST['password'])) {

    // Ambil data dari form dan bersihkan dari karakter berbahaya
    $username = mysqli_real_escape_string($db, trim($_POST['username']));
    $password = mysqli_real_escape_string($db, trim($_POST['password']));

    // Validasi sederhana
    if (empty($username) || empty($password)) {
        echo "Username dan password tidak boleh kosong.";
        exit;
    }

    // Cek apakah username sudah terdaftar
    $check_query = "SELECT * FROM admin WHERE username = '$username'";
    $check_result = mysqli_query($db, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "Username sudah digunakan, silakan pilih yang lain.";
        exit;
    }

    // Enkripsi password agar aman
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Simpan ke database
    $insert_query = "INSERT INTO admin (username, password) VALUES ('$username', '$hashed_password')";
    $result = mysqli_query($db, $insert_query);

    if ($result) {
        echo "Registrasi berhasil. <a href='../login.php'>Login sekarang</a>";
    } else {
        echo "Terjadi kesalahan saat registrasi.";
    }

} else {
    // Jika form tidak dikirim dengan benar
    echo "Form belum dikirim.";
}
?>
