<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Review</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body>
    <?php
    session_start();
    if (empty($_SESSION['username'])) {
        echo "
            <script>
                alert('Anda belum login. Silakan login terlebih dahulu.');
                document.location.href = 'login.php';
            </script>
        ";
        exit;
    }
    ?>
    <section class="h-100 w-100 bg-white" style="box-sizing: border-box">
        <style scoped>
            @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap");

            .navbar-1-1.navbar-light .navbar-nav .nav-link {
                color: #092a33;
                transition: 0.3s;
            }

            .navbar-1-1.navbar-light .navbar-nav .nav-link.active {
                font-weight: 500;
            }

            .navbar-1-1 .btn-get-started {
                border-radius: 20px;
                padding: 12px 30px;
                font-weight: 500;
            }

            .navbar-1-1 .btn-get-started-blue {
                background-color: #0ec8f8;
                transition: 0.3s;
            }

            .navbar-1-1 .btn-get-started-blue:hover {
                background-color: #3ad8ff;
                transition: 0.3s;
            }
        </style>
        <nav class="navbar-1-1 navbar navbar-expand-lg navbar-light p-4 px-md-4 mb-3 bg-body"
            style="font-family: Poppins, sans-serif">
            <div class="container">
                <div>
                    Halo <?php echo $_SESSION['username']; ?>!
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link px-md-4 active" aria-current="page" href="homepage_admin.php">Daftar
                                Akun</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-md-4" href="kritik_admin.php">Kritik dan Saran</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-md-4" href="review_admin.php">Review</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <a class="btn btn-get-started btn-get-started-blue text-white" href="logout.php"
                            style="background-color: #E465A6;">Logout</a>
                    </div>
                </div>
            </div>
        </nav>

        <div align="center">
            <h1>Review Konsumen</h1>
        </div>
        <div class="container" align="center">
            <center>
                <table class="table table-light table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Review</th>
                            <th scope="col">Gambar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        function xor_decrypt($data, $key) {
                            $out = '';
                            for ($i = 0; $i < strlen($data); $i++) {
                                $out .= chr(ord($data[$i]) ^ ord($key[$i % strlen($key)]));
                            }
                            return $out;
                        }

                        include 'config.php';
                        $query = mysqli_query($connection, "SELECT * from review");
                        $s = 1;
                        while ($data = mysqli_fetch_array($query)) {
                            ?>
                            <tr>
                                <td> <?php echo $s++ ?></td>
                                <td>
                                    <?php
                                    $message = base64_decode($data['review']);
                                    $secret_key = "12345678901234567890123456789012";
                                    $decrypt1 = xor_decrypt($message, $secret_key);
                                    $final = str_rot13($decrypt1);
                                    echo htmlspecialchars($final);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $base64_encrypted = base64_decode($data['image']);
                                    $image_decrypted = xor_decrypt($base64_encrypted, $secret_key);
                                    $image_base64 = base64_encode($image_decrypted);
                                    echo '<img src="data:image/jpeg;base64,' . $image_base64 . '" width="200" height="200" />';
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </center>
        </div>
    </section>
</body>
</html>