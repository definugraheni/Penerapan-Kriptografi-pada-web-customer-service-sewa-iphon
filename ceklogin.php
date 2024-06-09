<?php
session_start();
include "config.php";
include "encryption_functions.php"; // Pastikan Anda memiliki file ini dan fungsi-fungsinya

$username = $_POST['username'];
$password = $_POST['password'];

// Mengambil data user dari database
$query = mysqli_query($connection, "SELECT * FROM account WHERE username='$username'") or die(mysqli_error($connection));
$cek = mysqli_num_rows($query);

if ($cek > 0) {
    $row = mysqli_fetch_assoc($query);
    $hashed_password = $row['password'];

    if (verify_password($password, $hashed_password)) {
        $_SESSION['username'] = $username;

        if ($username == "admin") {
            header("location:homepage_admin.php");
        } else {
            header("location:homepage.php");
        }
    } else {
        echo "
            <script>
                alert('Login gagal! Username atau password Anda salah.');
                document.location.href = 'login.php';
            </script>
        ";
    }
} else {
    echo "
        <script>
            alert('Login gagal! Username atau password Anda salah.');
            document.location.href = 'login.php';
        </script>
    ";
}
?>