<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['accept'])) {
    header("Location:login.php");
}

if (!isset($_SESSION['daftar'])) {
    header("Location:index.php");
}

if (isset($_GET['submit-logout'])) {
    session_destroy();
    header("Location:index.php");
}

if (isset($_POST['submit-daftar'])) {
    $sekolah = $_POST['sekolah'];
    $alamat = $_POST['alamat'];
    $nilai = $_POST['nilai'];
    $id_user = $_SESSION['id_user'];
    $hasil = "Belum diproses";

    $query = mysqli_query($con, "UPDATE pendaftar SET `sekolah` = '$sekolah', `alamat_sekolah` = '$alamat', `nilai` = '$nilai', `status` = '$hasil' WHERE id_user = '$id_user'");
    if ($query) {
        $_SESSION['daftar2'] = true;
        header("Location:seleksi.php");
    } else {
        $gagal = "*Data gagal ditambahkan!";
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
    <script src="https://kit.fontawesome.com/a13d2f4f0a.js" crossorigin="anonymous"></script>
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

<body>
    <nav class="container h-12 bg-slate-600 flex fixed top-0 justify-between">
        <ul class="h-full flex">
            <li class="h-full">
                <a href="#" class="px-3 hover:bg-emerald-600 bg-emerald-500 h-full flex items-center justify-center font-bold text-white">PENDAFTARAN</a>
            </li>
            <li class="h-full">
                <a href="#" class="bg-slate-700 px-3 h-full flex items-center justify-center font-bold text-white"><i class="fa-solid fa-house text-white"></i></a>
            </li>
            <li class="h-full">
                <a href="#" class="hover:bg-slate-700 px-3 h-full flex items-center justify-center text-white text-sm">Hasil Seleksi</a>
            </li>
            <li class="h-full">
                <a href="#" class="hover:bg-slate-700 px-3 h-full flex items-center justify-center text-white text-sm">Asrama Mahasiswa</a>
            </li>
        </ul>
        <form class="h-full">
            <button class="h-full px-6 hover:bg-slate-700 text-white text-sm" name="submit-logout">
                Logout
            </button>
        </form>
    </nav>

    <form action="" method="post" class="bg-body">


        <div class="container pt-12 mt-10">
            <div class="m-auto w-[400px] flex justify-between">
                <a href="index.php" class="flex items-center">
                    <div class="text-white px-[13px] py-1 rounded-full bg-slate-600 mr-3">1</div>
                    Data Diri
                </a>
                <button disabled class="flex items-center">
                    <div class="text-white px-[12px] py-1 rounded-full bg-slate-600 mr-3">2</div>
                    Data Sekolah Asal
                </button>
            </div>
            <div class="w-[400px] mx-auto h-5 bg-slate-200 rounded-full mt-4">
                <div class="w-[100%] h-full bg-emerald-500 rounded-full"></div>
            </div>
        </div>

        <section class="w-[96%] mx-auto bg-white flex box-border mt-10 border-2">
            <div class="w-[80%] border-r-2 border-slate-200 box-border bg-slate-200">
                <div class="container flex h-[60px] items-center pl-4">
                    ISI DATA SEKOLAH ASAL
                </div>
                <div class="px-4 py-2 text-slate-500 bg-white">
                    <?php if (isset($gagal)) {
                    ?>
                        <p class="bg-red-400 rounded-sm text-white flex w-full h-10 justify-center items-center"><?= @$_SESSION['gagal'] ?></p>

                    <?php
                    } ?>
                    <div class="container h-10 rounded-sm border border-slate-300 overflow-hidden flex mt-4">
                        <div class="w-12 h-full flex items-center justify-center bg-slate-200">
                            <i class="fa-solid fa-school"></i>
                        </div>
                        <input required type="text" placeholder="Nama sekolah asal" name="sekolah" class="w-full outline-emerald-300 px-3">
                    </div>
                    <p class="text-red-400"><?= @$errorSekolah ?></p>
                    <div class="container h-10 rounded-sm border border-slate-300 overflow-hidden flex mt-4">
                        <div class="w-12 h-full flex items-center justify-center bg-slate-200">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <input required type="text" placeholder="Alamat Sekolah" name="alamat" class="w-full outline-emerald-300 px-3">
                    </div>
                    <p class="text-red-400"><?= @$errorAlamatSekolah ?></p>
                    <div class="container h-10 rounded-sm border border-slate-300 overflow-hidden flex mt-4">
                        <div class="w-12 h-full flex items-center justify-center bg-slate-200">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <input required type="number" placeholder="Total nilai UTBK" name="nilai" class="w-full outline-emerald-300 px-3">
                    </div>
                    <p class="text-red-400"><?= @$errorNilai ?></p>
                    <div class="container h-10 rounded-sm overflow-hidden flex mt-4">
                        <button name="submit-daftar" class="w-24 hover:bg-emerald-600 h-full bg-emerald-500 rounded text-white font-semibold">
                            <i class="fa-sharp fa-solid fa-circle-chevron-right"></i>
                        </button>
                    </div>
                </div>
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
    </form>
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
                    <a href="#" class="px-3 py-1 hover:bg-red-400 text-white mr-1 rounaded"><i class="fa-brands fa-youtube"></i></i></a>
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