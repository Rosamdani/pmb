<?php

include "koneksi.php";
session_start();

if (isset($_POST['submit-regis'])) {
    $valid = true;
    $_SESSION['accept'] = false;
    $_SESSION['errorCaptcha'] = "";
    $_SESSION['errorEmail'] = "";
    $_SESSION['errorPass'] = "";
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repass = $_POST['re-password'];


    //Validasi
    if ($password != $repass) {
        $valid = false;
        $_SESSION['errorPass'] = "*Password tidak sama";
    } else if (!preg_match('/^[A-Za-z0-9]{8,}$/', $password)) {
        $valid = false;
        $_SESSION['errorPass'] = "*Password minimal 8 karakter, minimal 1 huruf, minimal 1 angka";
    }

    if (!preg_match('/^[a-zA-Z ]+$/', $_POST['nama'])) {
        $valid = false;
        $_SESSION['errorNama'] = "*Nama tidak boleh selain huruf!";
    }

    if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $_POST['email'])) {
        $valid = false;
        $_SESSION['errorEmail'] = "*Format email salah!";
    }

    if ($_POST['captcha'] != $_SESSION['captcha_code']) {
        $valid = false;
        $_SESSION['errorCaptcha'] = "*Captcha salah!";
    }

    $query1 = mysqli_query($con, "SELECT * FROM users");
    if ($query1->num_rows > 0) {
        while ($row = mysqli_fetch_array($query1)) {
            if ($email == $row['email']) {
                $valid = false;
                $_SESSION['errorEmail'] = "*Email sudah terdaftar silahkan login";
            }
        }
    }


    if ($valid) {
        $user = "user";
        $password = md5($password);
        $query2 = mysqli_query($con, "INSERT INTO users (`nama_user`,`email`,`password`,`kelas`) VALUES ('$nama','$email','$password','$user')");
        if ($query2) {
            $query1 = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");
            $data = mysqli_fetch_array($query1);
            $_SESSION['id_user'] = $data['id_user'];
            $_SESSION['kelas'] = $data['kelas'];
            $_SESSION['accept'] = true;
            header("Location:index.php");
        } else {
            $error ="*Gagal membuat akun!";
        }
    } else {
        header("Location:registrasi.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/18d10060f1.js" crossorigin="anonymous"></script>
    <title>Beranda</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,600;0,700;0,800;1,400&display=swap');

        * {
            font-family: Poppins;
        }

        .hero {
            background-image: url("assets/image/uad.png");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="box-border bg-slate-100">
    <nav class="container h-12 bg-slate-600 flex fixed top-0">
        <ul class="h-full flex">
            <li class="h-full">
                <a href="#" class="px-3 hover:bg-emerald-600 bg-emerald-500 h-full flex items-center justify-center font-bold text-white">PENDAFTARAN</a>
            </li>
            <li class="h-full">
                <a href="#" class="hover:bg-slate-700 px-3 h-full flex items-center justify-center font-bold text-white"><i class="fa-solid fa-house text-white"></i></a>
            </li>
            <li class="h-full">
                <a href="#" class="hover:bg-slate-700 px-3 h-full flex items-center justify-center text-white text-sm">Asrama Mahasiswa</a>
            </li>
        </ul>
    </nav>

    <section class="container py-12 mt-12 text-white font-semibold px-10 text-lg items-center hero">
        <p>PENDAFTARAN</p>
        <p>MAHASISWA BARU UAD</p>
    </section>

    <section class="w-[96%] mx-auto bg-white flex box-border">
        <div class="w-[50%] border-r-2 border-slate-200 box-border bg-slate-200">
            <div class="container py-4 bg-emerald-500 px-4 text-lg text-white">
                REGISTRASI
            </div>
            <form method="POST" action="" class="px-4 py-2 text-slate-500 bg-white">
                <p class="text-red-400"><?= @$error?></p>
                <div class="container h-10 rounded-sm border border-slate-300 overflow-hidden flex mt-4">
                    <div class="w-12 h-full flex items-center justify-center bg-slate-200">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <input required type="text" placeholder="Nama" name="nama" class="w-full outline-emerald-300 px-3">
                </div>
                <p class="text-red-400"><?= @$_SESSION['errorNama'] ?></p>
                <div class="container h-10 rounded-sm border border-slate-300 overflow-hidden flex mt-4">
                    <div class="w-12 h-full flex items-center justify-center bg-slate-200">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <input required type="text" placeholder="Email" name="email" class="w-full outline-emerald-300 px-3">
                </div>
                <p class="text-red-400"><?= @$_SESSION['errorEmail'] ?></p>
                <div class="container h-10 rounded-sm border border-slate-300 overflow-hidden flex mt-4">
                    <div class="w-12 h-full flex items-center justify-center bg-slate-200">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input required type="password" placeholder="Password" name="password" class="w-full outline-emerald-300 px-3">
                </div>
                <div class="container h-10 rounded-sm border border-slate-300 overflow-hidden flex mt-4">
                    <div class="w-12 h-full flex items-center justify-center bg-slate-200">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input required type="password" placeholder="Ulangi Password" name="re-password" class="w-full outline-emerald-300 px-3">
                </div>
                <p class="text-red-400"><?= @$_SESSION['errorPass'] ?></p>
                <div class="container h-10 rounded-sm overflow-hidden flex mt-4 justify-between">
                    <img src="captcha.php" alt="" class="rounded-sm w-32 h-full bg-cover">
                    <a href="registrasi.php" class="h-full w-14 rounded-sm bg-emerald-400 flex items-center justify-center text-white"><i class="fa-solid fa-arrows-rotate"></i></a>
                </div>
                <div class="container h-10 rounded-sm border border-slate-300 overflow-hidden flex mt-4">
                    <div class="w-12 h-full flex items-center justify-center bg-slate-200">
                        <i class="fa-solid fa-barcode"></i>
                    </div>
                    <input required type="text" placeholder="Captcha" name="captcha" class="w-full outline-emerald-300 px-3">
                </div>
                <p class="text-red-400"><?= @$_SESSION['errorCaptcha'] ?></p>
                <div class="container h-10 rounded-sm overflow-hidden flex mt-4">
                    <button name="submit-regis" type="submit" class="w-24 hover:bg-emerald-600 h-full bg-emerald-500 rounded text-white font-semibold">
                        Registrasi
                    </button>
                </div>
                <div class="container h-10 rounded-sm overflow-hidden justify-center items-center flex mt-4">
                    <p>Sudah Punya akun?<a href="login.php" class="text-emerald-500 font-semibold">&nbsp; Login!</a></p>
                </div>
            </form>
            <div class="container px-4 py-5 bg-emerald-50 mb-10 border-emerald-300 border-l-4 mt-10 text-justify text-slate-500">
                <ul class="mb-3">
                    <li class="text-slate-600 font-semibold">Layanan Informasi Pendaftaran</li>
                    <li>Hari dan jam kerja</li>
                    <li>Senin-Jumat pukul 08.00 - 16.00 WIB</li>
                </ul>
            </div>
            <div class="container px-4 py-5 bg-red-50 mb-10 border-red-300 border-l-4 mt-10 text-justify text-slate-500">
                <p><span class="text-slate-600 font-semibold">Pengumuman Hasil Seleksi</span> dapat dilihat melalui akun Saudara. Silakan login terlebih dahulu.</p>
            </div>
        </div>
        <div class="container border-green-500 box-border text-justify text-slate-400">
            <div class="container py-[15px] text-lg uppercase font-semibold px-4 border-slate-200 border-b-2">
                Informasi Penting / information
            </div>
            <div class="container px-4">
                <ol type="1" class="w-[90%] mt-3 list-decimal px-4">
                    <li class="mb-3">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quia, vel?
                    </li>
                    <li class="mb-3">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum nisi, sint impedit repellendus sunt totam in cupiditate neque qui est.
                    </li>
                    <li class="mb-3">
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ab, culpa? Hic officia sit vitae excepturi quaerat doloribus delectus ullam consequatur quo esse officiis dolor inventore recusandae placeat, alias repellat animi!
                    </li>
                    <li class="mb-3">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ipsa, quo? Sapiente, soluta temporibus ex dolore porro nam sit ratione eos pariatur repellat aspernatur eaque? Ad labore corporis quam laborum qui. Ducimus pariatur magnam nulla et provident fuga quasi eveniet reiciendis facere hic, eos quo eum itaque est consectetur nam quas.
                    </li>
                    <li class="mb-3">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam obcaecati quibusdam ea magnam itaque accusantium unde, dicta nihil minus quaerat.
                    </li>
                    <li class="mb-3">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis fugit tempore perspiciatis accusamus libero repellat quis aut natus sed praesentium blanditiis, ab deserunt minus asperiores, odit deleniti, expedita atque aperiam sequi alias officiis? Rem nemo nostrum nisi? Quos, veritatis ratione.
                    </li>
                </ol>
            </div>
        </div>
    </section>

    <footer class="container pt-5 bg-slate-600">
        <div class="container justify-between flex px-10">
            <ul class=" mr-10">
                <li class="mb-3 text-white font-bold text-lg">Alamat Kampus</li>
                <li class="mb-3 text-white font-light"><span class="font-semibold">Kampus 1</span> <br>
                    Jl. Kapas 9, Semaki, Umbulharjo, Yogyakarta 55166</li>
                <li class="mb-3 text-white font-light"><span class="font-semibold">Kampus 1</span> <br>
                    Jl. Kapas 9, Semaki, Umbulharjo, Yogyakarta 55166</li>
                <li class="mb-3 text-white font-light"><span class="font-semibold">Kampus 1</span> <br>
                    Jl. Kapas 9, Semaki, Umbulharjo, Yogyakarta 55166</li>
                <li class="mb-3 text-white font-light"><span class="font-semibold">Kampus 1</span> <br>
                    Jl. Kapas 9, Semaki, Umbulharjo, Yogyakarta 55166</li>
            </ul>
            <ul class="mr-10">
                <li class="mb-3 text-white font-bold text-lg">Sosial Media</li>
                <li class="mb-3 text-white font-light">
                    <a href="#" class="px-3 py-1 hover:bg-pink-400 text-white mr-1 rounded"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="px-3 py-1 hover:bg-blue-400 text-white mr-1 rounded"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="px-3 py-1 hover:bg-sky-400 text-white mr-1 rounded"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="px-3 py-1 hover:bg-red-400 text-white mr-1 rounded"><i class="fa-brands fa-youtube"></i></i></a>
                </li>
            </ul>
            <ul class="mr-10">
                <li class="mb-3 text-white font-bold text-lg">Kontak</li>
                <li class="mb-3 text-white font-light">
                    <p>Nail : (+62) 853634646</p>
                    <p>Rosyam : (+62) 853654336</p>
                </li>
            </ul>
        </div>
        <div class="container flex h-10 justify-between bg-slate-700 items-center px-5">
            <p class="text-white">&copy;Nail, <?= date("Y") ?>. All Right Reserved</p>
            <ul class="mr-10 flex items-center">
                <li class="text-white">Follow Nail : </li>
                <li class="text-white font-light">
                    <a href="#" class="px-3 py-1 hover:bg-pink-400 text-white mr-1 rounded"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="px-3 py-1 hover:bg-blue-400 text-white mr-1 rounded"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="px-3 py-1 hover:bg-sky-400 text-white mr-1 rounded"><i class="fa-brands fa-twitter"></i></a>
                </li>
            </ul>
        </div>
    </footer>
</body>

</html>