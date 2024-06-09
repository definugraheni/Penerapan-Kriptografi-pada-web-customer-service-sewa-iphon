<?php
function xor_encrypt($data, $key) {
    $out = '';
    for ($i = 0; $i < strlen($data); $i++) {
        $out .= chr(ord($data[$i]) ^ ord($key[$i % strlen($key)]));
    }
    return $out;
}

function xor_decrypt($data, $key) {
    return xor_encrypt($data, $key); // Karena XOR enkripsi dan dekripsi adalah operasi yang sama
}

function hash_password($password) {
    $salt = 'custom_salt_value'; // Anda bisa menggunakan nilai salt yang lebih kompleks dan disimpan di tempat yang aman
    return base64_encode(xor_encrypt($password, $salt));
}

function verify_password($password, $hashed_password) {
    $salt = 'custom_salt_value';
    $decrypted_password = xor_decrypt(base64_decode($hashed_password), $salt);
    return $password === $decrypted_password;
}
?>