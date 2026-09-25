<?php
// Jalankan session di baris paling atas
session_start();

// panggil koneksi database
include "koneksi.php";
$username = mysqli_escape_string($koneksi, $_POST['username']);
$pass = md5($_POST['password']);
$password = mysqli_escape_string($koneksi, $pass);

// cek username, terdaftar atau tidak
$cek_user = mysqli_query($koneksi, "SELECT * FROM tuser WHERE username = '$username'");
$user_valid = mysqli_fetch_array($cek_user);

// Uji jika username terdaftar
if($user_valid){
    // Jika username terdaftar
    // cek password sesuai atau tidak
    if($password == $user_valid['password']) {
        // JIka password sesuai, buat session
        $_SESSION['username'] = $user_valid['username'];
        $_SESSION['nama_pengguna'] = $user_valid['nama_pengguna'];

        // Redirect ke halaman admin/dashboard jika berhasil
        echo "<script>alert('Login Berhasil!');
        document.location='admin.php'</script>";
    }else{
        echo "<script>alert('Maaf, Login Gagal, Password anda tidak terdaftar');
        document.location='index.php'</script>";
    }
}else{
    echo "<script>alert('Maaf, Login Gagal, Username anda tidak terdaftar');
    document.location='index.php'</script>";
}

?>