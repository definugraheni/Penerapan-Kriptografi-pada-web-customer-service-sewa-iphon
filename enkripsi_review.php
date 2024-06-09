<?php
include "config.php"; // Sambungkan ke database

// Mendapatkan data dari form
$komentar = $_POST['comment'];

// Memeriksa apakah file diunggah
if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    // Membaca file gambar yang diunggah
    $file = $_FILES['file']['tmp_name'];
    $isi_file = file_get_contents($file);

    // Fungsi enkripsi XOR
    function xor_encrypt($data, $kunci) {
        $hasil = '';
        for ($i = 0; $i < strlen($data); $i++) {
            $hasil .= chr(ord($data[$i]) ^ ord($kunci[$i % strlen($kunci)]));
        }
        return $hasil;
    }

    // Kunci rahasia untuk XOR
    $kunci_rahasia = "12345678901234567890123456789012";
    $gambar_terenkripsi = base64_encode(xor_encrypt($isi_file, $kunci_rahasia));
} else {
    die("File tidak ditemukan atau terjadi kesalahan saat mengunggah.");
}

// Melakukan enkripsi ROT13 menggunakan fungsi bawaan PHP
$rot13 = str_rot13($komentar);

// Enkripsi komentar menggunakan XOR
$teks_terenkripsi = base64_encode(xor_encrypt($rot13, $kunci_rahasia));

// Masukkan data ke database dengan aman menggunakan prepared statement
$stmt = $connection->prepare("INSERT INTO review (review, image) VALUES (?, ?)");
$stmt->bind_param("ss", $teks_terenkripsi, $gambar_terenkripsi);

if ($stmt->execute()) {
    echo "
        <script>
            alert('Review telah terkirim. Terima kasih atas kepedulian Anda.');
            document.location.href = 'homepage.php';
        </script>
    ";
} else {
    echo "Proses gagal";
}
?>