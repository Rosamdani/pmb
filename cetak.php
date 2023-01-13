<?php
// memanggil library FPDF
session_start();
if(!isset($_SESSION['cetak'])){
    header("Location:login.php");
}
require('fpdf/fpdf.php');
// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('l', 'mm', 'A3');
// membuat halaman baru
$pdf->AddPage();
// setting jenis font yang akan digunakan
$pdf->SetFont('Arial', 'B', 16);
// mencetak string
$pdf->Cell(190, 7, 'HASIL SELEKSI PERGURUAN TINGGI', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 7, 'UNIVERSITAS AHMAD DAHLAN', 0, 1, 'C');
// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10, 7, '', 0, 1);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 6, 'NAMA', 1, 0);
$pdf->Cell(50, 6, 'NIK', 1, 0);
$pdf->Cell(25, 6, 'ALAMAT', 1, 0);
$pdf->Cell(50, 6, 'SEKOLAH', 1, 0);
$pdf->Cell(50, 6, 'ALAMAT SEKOLAH', 1, 0);
$pdf->Cell(30, 6, 'NILAI', 1, 0);
$pdf->Cell(30, 6, 'STATUS', 1, 1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 6, $_SESSION['nama'], 1, 0);
$pdf->Cell(50, 6, $_SESSION['nik'], 1, 0);
$pdf->Cell(25, 6, $_SESSION['alamat'], 1, 0);
$pdf->Cell(50, 6, $_SESSION['sekolah'], 1, 0);
$pdf->Cell(50, 6, $_SESSION['alamat_sekolah'], 1, 0);
$pdf->Cell(30, 6, $_SESSION['nilai'], 1, 0);
$pdf->Cell(30, 6, $_SESSION['status'], 1, 0);

$pdf->Output();