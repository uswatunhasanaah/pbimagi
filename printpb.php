<?php
include 'config/koneksi.php';
date_default_timezone_set("Asia/Makassar");
$date = date('d/m/Y G:i:s');
$datem = date('M/Y');

$idpb = $_GET['id'];
$datapb = mysqli_query($koneksi,"SELECT permohonanbiaya.*, user.* FROM permohonanbiaya JOIN user ON permohonanbiaya.id_user=user.id where permohonanbiaya.id='$idpb'");
$hdatapb = mysqli_fetch_row($datapb);

$q2 = mysqli_query($koneksi, "SELECT * FROM permohonan_detail WHERE permohonan_id = '$idpb' ORDER BY kategori");
$idkeu = mysqli_query($koneksi, "SELECT * FROM user WHERE id = '$hdatapb[13]'");
$hidkeu = mysqli_fetch_array($idkeu);
$iddirektur = mysqli_query($koneksi, "SELECT * FROM user WHERE id = '$hdatapb[14]'");
$hiddirektur = mysqli_fetch_array($iddirektur);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print PB</title>
    <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>
<body onload="window.print()">
    <div class="row d-flex align-items-center">
        <div class="col-4">
            <p>No : <?=$hdatapb[1]?></p>
        </div>
        <div class="col-4 text-center">
            <h4><b>FORM</b></h4>
            <h4><b>PERMOHONAN BIAYA</b></h4>
        </div>
        <div class="col-4 text-end">
            <img src="assets/images/logos/iac.png" width="100px" alt="">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-1">
            <h6>PROJECT</h6>
            <h6>PERIHAL</h6>
        </div>
        <div class="col-9">
            <h6>: <?=$hdatapb[2]?></h6>
            <h6>: <?=$hdatapb[3]?></h6>
        </div>
    </div>
    <hr>
    <?php
    $kategori_terakhir = "";
    while ($row = mysqli_fetch_assoc($q2)) {
        
        // Cek apakah ini kategori baru
        if ($kategori_terakhir != $row['kategori']) {
            if ($kategori_terakhir != "") {
                echo "<tr><td colspan='4' align='right'><strong>Total Kategori : </strong></td>
                    <td class='text-end'><strong>Rp " . number_format($subtotal, 0, ',', '.') . "</strong></td></tr>";
                echo "</tbody></table>";
            }
    
            echo "<label><b>Kategori: " . $row['kategori'] . "</b></label>";
            echo "<table class='table table-bordered table-sm'>";
            echo "<thead><tr class='text-center'><th width='400px'>Item</th><th width='100px'>Vol</th><th width='100px'>Satuan</th><th width='200px'>Harga</th><th width='200px'>Jumlah</th></tr></thead><tbody>";
            $kategori_terakhir = $row['kategori'];
            $subtotal = 0;
        }
        $total_keseluruhan = 0;
        $jumlah = $row['volume'] * $row['harga'];
        $subtotal += $jumlah;
        $total_keseluruhan += $jumlah;
    
        echo "<tr>
                <td>{$row['nama_item']}</td>
                <td class='text-center'>{$row['volume']}</td>
                <td class='text-center'>{$row['satuan']}</td>
                <td class='text-end'>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
                <td class='text-end'>Rp " . number_format($jumlah, 0, ',', '.') . "</td>
            </tr>";
    }
    
    // Tampilkan sisa total kategori terakhir
    echo "<tr><td colspan='4' align='right'><strong>Total Kategori : </strong></td>
        <td class='text-end'><strong>Rp " . number_format($subtotal, 0, ',', '.') . "</strong></td></tr>";
    echo "</tbody></table>";
    
    // Total keseluruhan
    echo "<hr><h6 class='text-end'><b>Grand Total : Rp " . number_format($total_keseluruhan, 0, ',', '.') . "<b></h6><hr>";
    ?>
    
    <label for="exampleInputEmail1" class="form-label">Catatan : </label>
    <p><?=$hdatapb[6];?></p>
    <p class="text-end"><?=$hdatapb[7]?></p>

    <div class="row d-flex align-items-center">
        <div class="col-4 text-center">
            <label for="">Dibuat Oleh,</label><br>
            <img src="<?=$hdatapb[8]?>" alt=""><br>
            <label for=""><b>( <?=$hdatapb[18]?> )</b></label><br>
            <label for=""><?=$hdatapb[21]?></label>
        </div>
        <div class="col-4 text-center">
            <label for="">Diketahui Oleh,</label><br>
            <img src="<?=$hdatapb[9]?>" alt=""><br>
            <label for=""><b>( <?=$hidkeu[1]?> )</b></label><br>
            <label for=""><?=$hidkeu[4]?></label>
        </div>
        <div class="col-4 text-center">
            <label for="">Disetujui Oleh,</label><br>
            <img src="<?=$hdatapb[10]?>" alt=""><br>
            <label for=""><b>( <?=$hiddirektur[1]?> )</b></label><br>
            <label for=""><?=$hiddirektur[4]?></label>
        </div>
    </div>
</body>
</html>