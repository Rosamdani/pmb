<?php
session_start();
include "koneksi.php";


if (!isset($_SESSION['id_user'])) {
    header("Location:login.php");
}
$id_user = $_SESSION['id_user'];


if (isset($_GET['submit-logout'])) {
    session_destroy();
    header("Location:index.php");
}

if (isset($_POST['submit-delete'])) {
    $query = mysqli_query($con, "DELETE FROM pendaftar WHERE id_user = '$id_user'");
    if ($query) {
        header("Location:index.php");
    } else {
        $gagal = "*Data gagal dihapus!";
    }
}
if (isset($_POST['submit-edit'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $nik = $_POST['nik'];
    $sekolah = $_POST['sekolah'];
    $alamat_sekolah = $_POST['alamat_sekolah'];
    $nilai = $_POST['nilai'];

    $query = mysqli_query($con, "UPDATE pendaftar SET `nama` = '$nama', `alamat` = '$alamat', `nik` = '$nik', `sekolah` = '$sekolah', `alamat_sekolah` = '$alamat_sekolah', `nilai` = '$nilai' WHERE id_user = '$id_user'");
    if ($query) {
        $berhasil = "Berhasil mengubah data diri";
    } else {
        $_SESSION['gagal_hapus'] = "Gagal mengubah status";
    }
}

if (isset($_POST['submit-cetak'])) {
    $_SESSION['cetak'] = true;
    $_SESSION['nama'] = $_POST['nama'];
    $_SESSION['nik'] = $_POST['nik'];
    $_SESSION['alamat'] = $_POST['alamat'];
    $_SESSION['pil1'] = $_POST['pil1'];
    $_SESSION['pil2'] = $_POST['pil2'];
    $_SESSION['sekolah'] = $_POST['sekolah'];
    $_SESSION['alamat_sekolah'] = $_POST['alamat_sekolah'];
    $_SESSION['nilai'] = $_POST['nilai'];
    $_SESSION['status'] = $_POST['status'];
    header("Location:cetak.php");
}

$query = mysqli_query($con, "SELECT * FROM pendaftar WHERE id_user = '$id_user'");
if ($query) {
    while ($row = mysqli_fetch_array($query)) {
        $nama = $row['nama'];
        $nik = $row['nik'];
        $alamat = $row['alamat'];
        $sekolah = $row['sekolah'];
        $alamat_sekolah = $row['alamat_sekolah'];
        $nilai = $row['nilai'];
        $pil1 = $row['pil1'];
        $pil2 = $row['pil2'];
        $status = $row['status'];
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
                <a href="#" class="hover:bg-slate-700 px-3 h-full flex items-center justify-center font-bold text-white"><i class="fa-solid fa-house text-white"></i></a>
            </li>
            <li class="h-full">
                <a href="#" class="bg-slate-700 px-3 h-full flex items-center justify-center text-white text-sm">Hasil Seleksi</a>
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



    <section class="w-[96%] mx-auto bg-white flex box-border mt-10 border-2">
        <div class="w-[50%] border-r-2 border-slate-200 box-border bg-slate-200">
            <div class="container flex h-[60px] items-center pl-4">
                DATA DIRI ANDA
            </div>
            <div class="px-6 py-2 text-slate-500 bg-white">
                <form action="" method="POST">
                    <?php if (isset($_SESSION['gagal_hapus'])) {
                    ?>
                        <p class="bg-red-400 rounded-sm text-white flex w-full h-10 justify-center items-center"><?= @$_SESSION['gagal_hapus'] ?></p>

                    <?php
                    } ?>
                    <p class="text-green-300 mx-10"><?= @$berhasil ?></p>
                    <p class="text-red-300 mx-10"><?= @$gagal ?></p>
                    <hr>
                    <p>Data Diri</p>
                    <hr>
                    <div class="container h-10 rounded-sm text-slate-500 items-center border-slate-300 overflow-hidden flex mt-2">
                        Nama :
                        <input required type="text" value="<?= @$nama ?>" name="nama" class="w-[80%] px-3">
                    </div>
                    <p class="text-red-400"><?= @$errorNama ?></p>
                    <div class="container h-10 rounded-sm text-slate-500 items-center border-slate-300 overflow-hidden flex mt-2">
                        NIK :
                        <input required type="text" value="<?= @$nik ?>" name="nik" class="w-[80%] px-3">
                    </div>
                    <p class="text-red-400"><?= @$errorNik ?></p>
                    <div class="container h-10 rounded-sm text-slate-500 items-center border-slate-300 overflow-hidden flex mt-2">
                        Alamat :
                        <input required type="text" value="<?= @$alamat ?>" name="alamat" class="w-[80%] px-3">
                    </div>
                    <p class="text-red-400"><?= @$errorAlamat ?></p>
                    <div class="container h-10 rounded-sm text-slate-500 items-center border-slate-300 overflow-hidden flex mt-2">
                        Jurusan Pilihan 1 :
                        <input required type="text" readonly value="<?= @$pil1 ?>" name="pil1" class="w-[40%] px-3">
                    </div>
                    <p class="text-red-400"><?= @$errorAlamat ?></p>
                    <div class="container h-10 rounded-sm text-slate-500 items-center border-slate-300 overflow-hidden flex mt-2">
                        Jurusan Pilihan 2 :
                        <input required type="text" readonly value="<?= @$pil2 ?>" name="pil2" class="w-[40%] px-3">
                    </div>
                    <p class="text-red-400"><?= @$errorAlamat ?></p>
                    <hr class="mt-7">
                    <p>Data Sekolah</p>
                    <hr>
                    <div class="container h-10 rounded-sm text-slate-500 items-center border-slate-300 overflow-hidden flex mt-2">
                        Nama Sekolah:
                        <input required type="text" value="<?= @$sekolah ?>" name="sekolah" class="w-[60%] px-3">
                    </div>
                    <p class="text-red-400"><?= @$errorNamaSekolah ?></p>
                    <div class="container h-10 rounded-sm text-slate-500 items-center border-slate-300 overflow-hidden flex mt-2">
                        Alamat Sekolah :
                        <input required type="text" value="<?= @$alamat_sekolah ?>" name="alamat_sekolah" class="w-[60%] px-3">
                    </div>
                    <p class="text-red-400"><?= @$errorAlamatSekolah ?></p>
                    <div class="container h-10 rounded-sm text-slate-500 items-center border-slate-300 overflow-hidden flex mt-2">
                        Nilai UTBK :
                        <input required type="text" value="<?= @$nilai ?>" name="nilai" class="w-[60%] px-3">
                    </div>
                    <p class="text-red-400"><?= @$errorNilai ?></p>
                    <input type="hidden" name="status" value="<?= @$status ?>">
                    <div class="container h-10 rounded-sm text-slate-500 items-center border-slate-300 overflow-hidden flex mt-2">
                        Status :
                        <p class="px-3 py-1 <?php if ($status == "Belum diproses") {
                                                echo "bg-blue-300";
                                            } else if ($status == "Dalam proses") {
                                                echo "bg-yellow-300";
                                            } else if ($status == "Ditolak") {
                                                echo "bg-red-300";
                                            } else if ($status == "Diterima") {
                                                echo "bg-green-300";
                                            }  ?> rounded-full ml-5"><?= @$status ?></p>
                    </div>
                    <div class="container h-10 rounded-sm overflow-hidden flex mt-4">
                        <?php
                        if ($status != "Ditolak") {
                        ?>

                            <button name="<?php if ($status == "Belum diproses") {
                                                echo "submit-edit";
                                            } else if ($status == "Dalam proses") {
                                                echo "submit-cetak";
                                            } else if ($status == "Diterima") {
                                                echo "submit-cetak";
                                            } ?>" class="w-24 hover:bg-emerald-600 h-full bg-emerald-500 rounded text-white font-semibold">
                                <?php if ($status == "Belum diproses") {
                                    echo "Edit";
                                } else if ($status == "Dalam proses") {
                                    echo "Cetak";
                                } else if ($status == "Diterima") {
                                    echo "Cetak";
                                } ?>
                            </button>

                        <?php
                        }

                        ?>

                        <?php if ($status == "Belum diproses") {
                        ?>

                            <button name="submit-delete" class="w-24 hover:bg-red-600 h-full bg-red-500 rounded text-white font-semibold ml-6">Hapus</button>

                        <?php
                        }
                        ?>
                    </div>
                </form>
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
                        Anda bisa mengedit data diri dan data sekolah asal, selama status seleksi masih belum di proses (<span class="text-blue-500">biru</span>)!
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