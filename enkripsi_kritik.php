<?php 
include "config.php"; // Sertakan file konfigurasi untuk koneksi database

$comment = $_POST['comment']; // Ambil komentar dari permintaan POST

// Fungsi Rot13 untuk mengenkripsi komentar
function Rot13($comment) {
    for ($i = 0; $i < strlen($comment); $i++) {
        $c = ord($comment[$i]); // Dapatkan nilai ASCII dari karakter

        // Periksa apakah karakter berada dalam rentang tertentu dan geser 13 posisi
        if (($c >= ord('n') && $c <= ord('z')) || ($c >= ord('N') && $c <= ord('Z'))) {
            $c -= 13;
        } elseif (($c >= ord('a') && $c <= ord('m')) || ($c >= ord('A') && $c <= ord('M'))) {
            $c += 13;
        }
        $comment[$i] = chr($c); // Ubah nilai ASCII kembali menjadi karakter
    }
    return $comment;
}

$rot13 = Rot13($comment); // Terapkan fungsi Rot13 pada komentar

// Fungsi XOR untuk enkripsi dan dekripsi
function xor_encrypt($data, $key) {
    $out = '';
    for ($i = 0; $i < strlen($data); $i++) {
        $out .= chr(ord($data[$i]) ^ ord($key[$i % strlen($key)]));
    }
    return $out;
}

$key = "12345678901234567890123456789012"; // Kunci rahasia untuk enkripsi
$ciphertext = xor_encrypt($rot13, $key); // Enkripsi komentar yang sudah di-Rot13 dengan metode XOR

// Masukkan komentar terenkripsi ke dalam database
$query = mysqli_query($connection, "INSERT INTO kritik VALUES ('', '" . mysqli_real_escape_string($connection, $ciphertext) . "')") or die (mysqli_error($connection));

if ($query) {
    echo "
        <script>
            alert('Kritik dan saran telah terkirim. Terima kasih atas kepedulian Anda.');
            document.location.href = 'homepage.php';
        </script>
    ";
} else {
    echo "proses gagal";
}

// Bagian yang dikomentari untuk dekripsi dan pembalikan Rot13
/*
$cek2 = xor_encrypt($ciphertext, $key); // Dekripsi data menggunakan XOR dengan kunci yang sama
$final = Rot13($cek2); // Balikkan enkripsi Rot13
echo $final;
*/
?>