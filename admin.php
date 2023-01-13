<?php
session_start();
include "koneksi.php";

if ($_SESSION['kelas'] != "admin") {
    header("login.php");
}

if (isset($_GET['submit-logout'])) {
    session_destroy();
    header("Location:index.php");
}

if(isset($_POST['submit-status'])){
    $id = $_POST['id'];
    $status = $_POST['submit-status'];

    $query = mysqli_query($con, "UPDATE pendaftar SET `status` = '$status' WHERE id_pendaftar = '$id'");
    if($query){
        $berhasil = "Berhasil mengubah status";
    }else{
        $gagal = "Gagal mengubah status";

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

    <section class="w-[98%] mt-24 mx-auto">
        <div class="font-semibold text-center text-2xl mb-10">
            Data Pendaftar
        </div>
        <p class="text-green-300 mx-10"><?=@$berhasil?></p>
        <p class="text-red-300 mx-10"><?=@$gagal?></p>
        <table class="mx-auto mb-10">
            <thead>
                <tr>
                    <th class="border">Nama</th>
                    <th class="border">NIK</th>
                    <th class="border">Alamat</th>
                    <th class="border">Nama Sekolah Asal</th>
                    <th class="border">Alamat Sekolah Asal</th>
                    <th class="border">Pilihan 1</th>
                    <th class="border">Pilihan 2</th>
                    <th class="border">Nilai UN</th>
                    <th class="border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $query = mysqli_query($con, "SELECT * FROM pendaftar");
                if ($query->num_rows > 0) {
                    while($row = mysqli_fetch_array($query)){
                ?>

                    <tr>
                        <form action="" method="POST">
                        <input type="hidden" name="id" value="<?=$row['id_pendaftar']?>">
                        <td class="border pb-4 text-center px-2"><?=$row['nama']?></td>
                        <td class="border pb-4 text-center px-2"><?=$row['alamat']?></td>
                        <td class="border pb-4 text-center px-2"><?=$row['nik']?></td>
                        <td class="border pb-4 text-center px-2"><?=$row['sekolah']?></td>
                        <td class="border pb-4 text-center px-2"><?=$row['alamat_sekolah']?></td>
                        <td class="border pb-4 text-center px-2"><?=$row['pil1']?></td>
                        <td class="border pb-4 text-center px-2"><?=$row['pil2']?></td>
                        <td class="border pb-4 text-center px-2"><?=$row['nilai']?></td>
                        <td class="border pb-4 text-center px-2">
                            <button name="submit-status" value="Dalam proses" class=" rounded my-1 px-2 py-1 bg-yellow-300">Dalam proses</button>
                            <button name="submit-status" value="Diterima" class=" rounded my-1 px-2 py-1 bg-green-300">Diterima</button>
                            <button name="submit-status" value="Ditolak" class=" rounded my-1 px-2 py-1 bg-red-300">Ditolak</button>
                        </td>
                        </form>
                    </tr>

                <?php
                    }
                } else {
                ?>

                    <tr>
                        <td colspan="9" class="text-center">Belum ada pendaftar!</td>
                    </tr>

                <?php
                }

                ?>
            </tbody>
        </table>
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
                    <a href="#" class="px-3 py-1 hover:bg-red-400 tsext-white mr-1 rounaded"><i class="fa-brands fa-youtube"></i></i></a>
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