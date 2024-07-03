<?php
session_start();
include 'koneksi.php';
require('fpdf186/fpdf.php');

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

$countries = $conn->query("SELECT negara.*, groups.group_name FROM negara JOIN groups ON negara.group_id = groups.id");

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(40, 10, 'Group');
$pdf->Cell(40, 10, 'Country');
$pdf->Cell(20, 10, 'Wins');
$pdf->Cell(20, 10, 'Draws');
$pdf->Cell(20, 10, 'Losses');
$pdf->Cell(20, 10, 'Points');
$pdf->Ln();

while ($row = $countries->fetch_assoc()) {
    $pdf->Cell(40, 10, $row['group_name']);
    $pdf->Cell(40, 10, $row['country_name']);
    $pdf->Cell(20, 10, $row['wins']);
    $pdf->Cell(20, 10, $row['draws']);
    $pdf->Cell(20, 10, $row['losses']);
    $pdf->Cell(20, 10, $row['points']);
    $pdf->Ln();
}

$pdf->Output();
?>
