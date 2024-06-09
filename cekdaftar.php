<?php
    session_start();
include "config.php";
include "encryption_functions.php";

$username = $_POST['username'];
$password = $_POST['password'];

// Enkripsi password menggunakan fungsi custom
$hashed_password = hash_password($password);

// Masukkan data ke database
$query = mysqli_query($connection, "INSERT INTO account (username, password) VALUES ('$username', '$hashed_password')") or die(mysqli_error($connection));

if ($query) {
    echo "
        <script>
            alert('Pendaftaran berhasil, silakan login');
            document.location.href = 'login.php';
        </script>
    ";
} else {
    echo "Proses gagal";
}
?>
?>