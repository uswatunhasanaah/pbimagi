<?php
date_default_timezone_set("Asia/Makassar");
$date = date('d/m/Y G:i:s');
$datem = date('M/Y');

$idpb = $_GET['id'];

$nama = $_SESSION['nama'] ?? null;
$username = $_SESSION['username'] ?? null;
$level = $_SESSION['level'] ?? null;
$id = $_SESSION['id'] ?? null;

$datapb = mysqli_query($koneksi,"SELECT permohonanbiaya.*, user.* FROM permohonanbiaya JOIN user ON permohonanbiaya.id_user=user.id where permohonanbiaya.id='$idpb'");
$hdatapb = mysqli_fetch_row($datapb);

$keuangan = mysqli_query($koneksi, "SELECT * FROM user WHERE id='$hdatapb[13]'");
$hkeuangan = mysqli_fetch_row($keuangan);
$direktur = mysqli_query($koneksi, "SELECT * FROM user WHERE id='$hdatapb[14]'");
$hdirektur = mysqli_fetch_row($direktur);

$q2 = mysqli_query($koneksi, "SELECT * FROM permohonan_detail WHERE permohonan_id = '$idpb' ORDER BY kategori");
$kategori_terakhir = "";
$subtotal = 0;
$total_keseluruhan = 0;
$i = 0;
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin ImagiCreative</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/iac.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />

  <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css"> -->
  
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
  <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  
  <script type="text/javascript" src="js/jquery.signature.min.js"></script>
  <script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/jquery.signature.css">
  
  <style>
      .kbw-signature { width: 100%; height: 150px;}
      #sig canvas{
          width: 100% !important;
          height: auto;
      }
  </style>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <?php include 'aside.php' ?>
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <?php include 'header.php' ?>
      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h1 class="text-center"><b>DETAIL</b></h1>
            <h2 class="text-center"><b>PERMOHONAN BIAYA</b></h2><br><br>
            <form action="config/proses.php" method="post" enctype="multipart/form-data">
              <div class="card">
                <div class="card-body">
                  <div class='row'>
                    <div class="col-2">
                      <label for="exampleInputEmail1" class="form-label">No</label>
                    </div>
                    <div class="col-10">
                      <input type="text" name="no" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?=$hdatapb[1]?>" readonly Required>
                    </div>
                  </div>
                  <div class='row mt-2'>
                    <div class="col-2">
                      <label for="exampleInputPassword1" class="form-label">Project</label>
                    </div>
                    <div class="col-10">
                      <input type="text" name="project" class="form-control" id="exampleInputPassword1" value="<?=$hdatapb[2];?>">
                    </div>
                  </div>
                  <div class='row mt-2'>
                    <div class="col-2">
                      <label for="exampleInputPassword1" class="form-label">Perihal</label>
                    </div>
                    <div class="col-10">
                      <input type="text" name="perihal" class="form-control" id="exampleInputPassword1" value="<?=$hdatapb[3];?>">
                    </div>
                  </div>
                </div>
              </div>
                
              <?php if(!empty($hdatapb[15])){ ?>
                <hr>
                <label><b>Informasi Revisi</b></label>
                <h4 class="text-warning"><?=$hdatapb[15]?></h4><hr>
              <?php } ?>
                <h5 class="card-title fw-semibold mb-4">Data Table</h5>
                <div class="card mb-0">
                  <div class="card-body">
                  <input type="hidden" name="id_permohonan" value="<?= $hdatapb[0] ?>">
                      <?php
                      while ($row = mysqli_fetch_assoc($q2)) {
                        if ($kategori_terakhir != $row['kategori']) {
                            if ($kategori_terakhir != "") {
                                echo "<tr class='subtotal-row'><td colspan='4' align='right'><strong>Total Kategori</strong></td>
                                      <td class='text-end'><strong class='subtotal-kategori'>Rp " . number_format($subtotal, 0, ',', '.') . "</strong></td></tr>";
                                echo "</tbody></table>";
                            }
                    
                            echo "<label><b>Kategori: " . $row['kategori'] . "</b></label>";
                            echo "<div class='table-responsive'><table class='table table-bordered table-sm kategori-table'>";
                            echo "<thead><tr class='text-center'><th>Item</th><th width='150px'>Volume</th><th width='150px'>Satuan</th><th width='200px'>Harga</th><th>Jumlah</th></tr></thead><tbody>";
                            $kategori_terakhir = $row['kategori'];
                            $subtotal = 0;
                        }
                    
                        $jumlah = $row['volume'] * $row['harga'];
                        $subtotal += $jumlah;
                        $total_keseluruhan += $jumlah;
                    
                        echo "<tr>
                                <input type='hidden' name='id_detail[]' value='{$row['id']}'>
                                <td><input type='text' name='nama_item[]' value='{$row['nama_item']}' class='form-control'></td>
                                <td><input type='number' name='volume[]' value='{$row['volume']}' class='form-control volume' oninput='updateTotal(this)'></td>
                                <td><input type='text' name='satuan[]' value='{$row['satuan']}' class='form-control'></td>
                                <td><input type='text' name='harga[]' value='" . number_format($row['harga'], 0, ',', '.') . "' class='form-control harga' oninput='updateTotal(this)'></td>
                                <td class='text-end'><span class='jumlah'>Rp " . number_format($jumlah, 0, ',', '.') . "</span></td>
                              </tr>";
                    }
                    
                    // Total kategori terakhir
                    echo "<tr class='subtotal-row'>
                        <td colspan='4' align='right'><strong>Total Kategori</strong></td>
                        <td class='text-end'><strong class='subtotal-kategori'>Rp " . number_format($subtotal, 0, ',', '.') . "</strong></td>
                      </tr>";
                    echo "</tbody></table></div>";
                    
                    // Grand Total
                    echo "<hr><h4 class='text-end'>
                            <input type='hidden' name='gtotal' id='grand-totall' value='$hdatapb[5]'>
                            <b>Total Keseluruhan: <span id='grand-total'>Rp " . number_format($total_keseluruhan, 0, ',', '.') . "</span></b>
                          </h4><hr>";
                      ?>
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Lampiran Dokumen : </label>
                      <a href="https://pb.imagicreative.com/config/lampiran_pdf/<?=$hdatapb[4]?>" target="_BLANK">Lampiran Dokumen</a>
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Catatan : </label>
                      <textarea name="catatan" class="form-control" rows="3"><?=$hdatapb[6];?></textarea>
                    </div>
                    <div class="mb-3">
                      <p for="exampleInputEmail1" class="form-label text-end">Dibuat di : <?=$hdatapb[7]?></p>
                    </div>
                    <div class="row text-center">
                      <div class="col-md-4"><br>
                        <label for="">Dibuat Oleh,</label><br>
                        <img src="<?= $hdatapb[8] ?>" alt="Tanda Tangan">
                        <label for=""><b>( <?=$hdatapb[19]?> )</b></label><br>
                        <label for=""><b>( <?=$hdatapb[22]?> )</b></label>
                      </div>
                      <div class="col-md-4"><br>
                        <label for="">Diketahui Oleh,</label><br>
                        <?php if(!empty($hdatapb[9])){ ?>
                          <img src="<?=$hdatapb[9]?>" alt="">
                          <label for=""><b>( <?=$hkeuangan[1]?> )</b></label><br>
                          <label for=""><b>( <?=$hkeuangan[4]?> )</b></label>
                        <?php } else {echo "<br><br><br><br><br>"; echo "<label><b>( ________ )</b></label><br>
                        <label>Direktur</label>"; } ?>
                      </div>
                      <div class="col-md-4"><br>
                        <label for="">Diketahui Oleh,</label><br>
                        <?php if(!empty($hdatapb[10])){ ?>
                          <img src="<?=$hdatapb[10]?>" alt="">
                          <label for=""><b>( <?=$hdirektur[1]?> )</b></label><br>
                          <label for=""><b>( <?=$hdirektur[4]?> )</b></label>
                        <?php } else {echo "<br><br><br><br><br>"; echo "<label><b>( ________ )</b></label><br>
                        <label>Direktur</label>"; } ?>
                      </div>
                    </div>
                    <?php if($hdatapb[16] == 'revisi' || empty($hdatapb[9])){ ?>
                      <br>
                      <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" Required>
                        <label class="form-check-label" for="exampleCheck1">Pastikan Data sudah Benar.</label>
                      </div>
                      <button type="submit" class="btn btn-primary form-control" name="revisipb">Update Revisi Data</button>
                    <?php } ?>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    var sig = $('#sig').signature({syncField: '#signature64_1', syncFormat: 'PNG'});
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64_1").val('');
    });
  </script>
  <script>
    function unformatRupiah(rp) {
        return parseInt(rp.replace(/[^0-9]/g, '')) || 0;
    }

    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }

    function updateTotal(el) {
        const row = el.closest('tr');
        const table = el.closest('table');
        
        // Update jumlah per item
        const volume = parseFloat(row.querySelector('.volume').value) || 0;
        const harga = unformatRupiah(row.querySelector('.harga').value);
        const jumlah = volume * harga;
        row.querySelector('.jumlah').innerText = formatRupiah(jumlah);

        // Update total kategori
        let subtotal = 0;
        table.querySelectorAll('tbody tr').forEach(r => {
            if (r.querySelector('.volume') && r.querySelector('.harga')) {
                const vol = parseFloat(r.querySelector('.volume').value) || 0;
                const hrg = unformatRupiah(r.querySelector('.harga').value);
                subtotal += vol * hrg;
            }
        });
        const subtotalElem = table.querySelector('.subtotal-kategori');
        if (subtotalElem) {
            subtotalElem.innerText = formatRupiah(subtotal);
        }

        // Update grand total dari semua subtotal kategori
        let grandTotal = 0;
        document.querySelectorAll('.subtotal-kategori').forEach(el => {
            grandTotal += unformatRupiah(el.innerText);
        });
        document.getElementById('grand-total').innerText = formatRupiah(grandTotal);
        $('#grand-totall').val(formatRupiah(grandTotal));
    }
  </script>
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/sidebarmenu.js"></script>
  <script src="assets/js/app.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>