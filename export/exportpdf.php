<?php
// Set timezone agar waktu sesuai dengan WIB/WITA/WIT
date_default_timezone_set('Asia/Jakarta');

include "../koneksi.php";

// vendor autoloader
require '../vendor/autoload.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
// Inisialisasi Dompdf
$dompdf = new Dompdf();

// Ambil data tanggal dari POST form
$tgl1 = $_POST['tanggala'];
$tgl2 = $_POST['tanggalb'];

// 4. Susun struktur HTML dokumen PDF
$html = '
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Data Pengunjung</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            margin: 10px;
        }
        h2 {
            text-align: center;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        p.periode {
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 10pt;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th {
            background-color: #f2f2f2;
            padding: 8px;
            text-align: center;
            font-weight: bold;
        }
        td {
            padding: 6px 8px;
            vertical-align: top;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

    <h2>Rekapitulasi Data Pengunjung</h2>
    <p class="periode">Periode: ' . date('d-m-Y', strtotime($tgl1)) . ' s/d ' . date('d-m-Y', strtotime($tgl2)) . '</p>

    <table>
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="15%">Tanggal</th>
                <th width="25%">Nama Pengunjung</th>
                <th width="25%">Alamat</th>
                <th width="15%">Tujuan</th>
                <th width="15%">No. HP</th>
            </tr>
        </thead>
        <tbody>';

// 5. Query data dari database
$tampil = mysqli_query($koneksi, "SELECT * FROM ttamu WHERE tanggal BETWEEN '$tgl1' AND '$tgl2' ORDER BY tanggal ASC");
$no = 1;

while ($data = mysqli_fetch_array($tampil)) {
    $html .= '
            <tr>
                <td class="text-center">' . $no++ . '</td>
                <td class="text-center">' . date('d-m-Y', strtotime($data['tanggal'])) . '</td>
                <td>' . html_entity_decode($data['nama'], ENT_NOQUOTES, 'UTF-8') . '</td>
                <td>' . html_entity_decode($data['alamat'], ENT_NOQUOTES, 'UTF-8') . '</td>
                <td>' . html_entity_decode($data['tujuan'], ENT_NOQUOTES, 'UTF-8') . '</td>
                <td>' . html_entity_decode($data['nope'], ENT_NOQUOTES, 'UTF-8') . '</td>
            </tr>';
}

$html .= '
        </tbody>
    </table>

</body>
</html>';

// $html = '
// <!DOCTYPE html>
// <html lang="id">
// <head>
//     <meta charset="UTF-8">
//     <title>Surat Penugasan</title>
//     <style>
//         body {
//             font-family: Arial, Helvetica, sans-serif;
//             font-size: 12pt;
//             line-height: 1.4;
//             margin: 20px 30px;
//         }

//         /* Styling Kop Surat */
//         .header-table {
//             width: 100%;
//             border-collapse: collapse;
//             margin-bottom: 5px;
//         }
//         .header-table td {
//             vertical-align: middle;
//         }
//         .logo {
//             width: 80px;
//             text-align: center;
//         }
//         .logo img {
//             width: 75px;
//             height: auto;
//         }
//         .header-text {
//             text-align: center;
//         }
//         .header-text h3 {
//             margin: 0;
//             font-size: 13pt;
//             font-weight: bold;
//             text-transform: uppercase;
//         }
//         .header-text h2 {
//             margin: 2px 0;
//             font-size: 15pt;
//             font-weight: bold;
//             text-transform: uppercase;
//         }
//         .header-text p {
//             margin: 0;
//             font-size: 9.5pt;
//             font-style: italic;
//         }

//         /* Garis Kop Surat */
//         .line-double {
//             border-top: 3px solid #000;
//             border-bottom: 1px solid #000;
//             height: 2px;
//             margin-bottom: 25px;
//         }

//         /* Judul Surat */
//         .title-section {
//             text-align: center;
//             margin-bottom: 25px;
//         }
//         .title-section h3 {
//             margin: 0;
//             font-size: 14pt;
//             text-decoration: underline;
//             font-weight: bold;
//             letter-spacing: 1px;
//         }
//         .title-section p {
//             margin: 3px 0 0 0;
//             font-size: 11pt;
//         }

//         /* Form / Data Content */
//         .content-table {
//             width: 100%;
//             border-collapse: collapse;
//             margin-left: 15px;
//             margin-bottom: 15px;
//         }
//         .content-table td {
//             padding: 3px 0;
//             vertical-align: top;
//         }

//         .text-justify {
//             text-align: justify;
//         }

//         /* Tanda Tangan */
//         .ttd-table {
//             width: 100%;
//             margin-top: 30px;
//             border-collapse: collapse;
//         }
//         .ttd-box {
//             width: 40%;
//             float: right;
//             text-align: left;
//         }
//         .stempel-box {
//             border: 1px solid #000;
//             width: 140px;
//             height: 60px;
//             margin: 10px 0;
//             text-align: center;
//             line-height: 25px;
//             font-size: 10pt;
//             padding-top: 8px;
//         }
//     </style>
// </head>
// <body>

//     <!-- KOP SURAT -->
//     <table class="header-table">
//         <tr>
//             <td class="logo">
//                 <!-- Gantilah link gambar di bawah dengan path logo lokal milik Anda, misal: logo.png -->
//                 <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Lambang_Kabupaten_Lombok_Timur.svg/1200px-Lambang_Kabupaten_Lombok_Timur.svg.png" alt="Logo">
//             </td>
//             <td class="header-text">
//                 <h3>PEMERINTAH KABUPATEN LOMBOK TIMUR</h3>
//                 <h3>DINAS PENDIDIKAN PEMUDA DAN OLAH RAGA</h3>
//                 <h2>SMP NEGERI 3 PRINGGABAYA</h2>
//                 <p>Jln. Raya Bagik - Bagikpapan, Kec. Pringgabaya Lotim &#9742; (0376) 2703040 KP. 83654</p>
//                 <p>E-mail: smpnegeri3pringgabaya@yahoo.com</p>
//                 <p>Website: smpn3pringgabaya.sch.id</p>
//             </td>
//         </tr>
//     </table>

//     <div class="line-double"></div>

//     <!-- JUDUL SURAT -->
//     <div class="title-section">
//         <h3>SURAT PENUGASAN</h3>
//         <p>Nomor : 421.3/56/SMPN.3/2014</p>
//     </div>

//     <!-- ISI SURAT -->
//     <p>Yang bertanda tangan di bawah ini :</p>
    
//     <table class="content-table">
//         <tr>
//             <td width="22%">Nama</td>
//             <td width="3%">:</td>
//             <td width="75%">Muhadis, S.Pd.</td>
//         </tr>
//         <tr>
//             <td>NIP.</td>
//             <td>:</td>
//             <td>19651231 199403 1 xxx</td>
//         </tr>
//         <tr>
//             <td>Pangkat/Gol. Ruang</td>
//             <td>:</td>
//             <td>Pembina IV/a</td>
//         </tr>
//         <tr>
//             <td>Jabatan</td>
//             <td>:</td>
//             <td>Kepala Sekolah</td>
//         </tr>
//     </table>

//     <p>Dengan ini menugaskan :</p>

//     <table class="content-table">
//         <tr>
//             <td width="22%">Nama</td>
//             <td width="3%">:</td>
//             <td width="75%">Abdul Kahar Muzakkir, S.Pd.</td>
//         </tr>
//         <tr>
//             <td>Nip</td>
//             <td>:</td>
//             <td>19690925 199303 1 xxx</td>
//         </tr>
//         <tr>
//             <td>Pangkat/Gol. Ruang</td>
//             <td>:</td>
//             <td>Pembina, IV/a</td>
//         </tr>
//         <tr>
//             <td>Jabatan</td>
//             <td>:</td>
//             <td>Guru / OPS</td>
//         </tr>
//         <tr>
//             <td>E-mail</td>
//             <td>:</td>
//             <td>kaharmuzakkir@yahoo.com</td>
//         </tr>
//         <tr>
//             <td>Telp/HP</td>
//             <td>:</td>
//             <td>(0376) 29xxx / 087 763 xxx xxx</td>
//         </tr>
//         <tr>
//             <td>Unit Kerja</td>
//             <td>:</td>
//             <td>SMP Negeri 3 Pringgabaya</td>
//         </tr>
//     </table>

//     <p class="text-justify">
//         Untuk mengelola data pendidikan pada situs <a href="http://sdm-data.kemdikbud.go.id">http://sdm-data.kemdikbud.go.id</a>.<br>
//         Demikian Surat Penugasan ini dikeluarkan untuk dapat dilaksanakan dengan baik dan penuh rasa tanggung jawab.
//     </p>

//     <!-- TANDA TANGAN -->
//     <div class="ttd-box">
//         <p style="margin:0;">Pringgabaya, 7 Juli 2014<br>Kepala Sekolah</p>
        
//         <div class="stempel-box">
//             Tanda tangan<br>dan stempel
//         </div>

//         <p style="margin:0;">
//             <strong><u>MUHADIS, S.Pd.</u></strong><br>
//             NIP. 19651231 199403 1 xxx
//         </p>
//     </div>

// </body>
// </html>
// ';

// Load HTML ke Dompdf
$dompdf->loadHtml($html);

// Ubah ukuran kertas ke A4 dan orientasi Potrait/Landscape
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// =========================================================================
// TAMBAHAN: MEMBUAT WATERMARK TANGGAL & WAKTU CETAK (FOOTER)
// =========================================================================
$canvas = $dompdf->getCanvas();

// Ambil ukuran halaman
$w = $canvas->get_width();
$h = $canvas->get_height();

// Format tanggal dan waktu cetak saat ini (misal: Dicetak pada: 15-09-2026 14:30:05)
$teks_watermark = "© " . date('Y') . " Asfahany's Tech | Dicetak pada: " . date("d-m-Y H:i:s");

// Pilih Font dan Ukuran
$font = $dompdf->getFontMetrics()->get_font("Arial", "italic");
$size = 8; // Ukuran font kecil untuk footer

// Warna Teks dalam format RGB (r, g, b) -> 0.5 = Abu-abu
$color = array(0.5, 0.5, 0.5);

// Tuliskan teks di setiap halaman (Posisi: Kiri bawah)
// Parameter: page_text($x, $y, $text, $font, $size, $color)
$canvas->page_text(30, $h - 20, $teks_watermark, $font, $size, $color);
// =========================================================================

// Tampilkan PDF ke browser (Attachment => 0 berarti preview di browser, 1 untuk langsung download)
$dompdf->stream("Export_Data_Pengunjung.pdf", array("Attachment"=>0));

?>