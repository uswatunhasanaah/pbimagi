<?php
date_default_timezone_set("Asia/Makassar");
$date = date('d/m/Y G:i:s');

$idpb = $_GET['id'];

$nama = $_SESSION['nama'] ?? null;
$username = $_SESSION['username'] ?? null;
$level = $_SESSION['level'] ?? null;
$id = $_SESSION['id'] ?? null;

$datapb = mysqli_query($koneksi,"SELECT permohonanbiaya.*, user.* FROM permohonanbiaya JOIN user ON permohonanbiaya.id_user=user.id where permohonanbiaya.id='$idpb'");
$hdatapb = mysqli_fetch_row($datapb);

$q2 = mysqli_query($koneksi, "SELECT * FROM permohonan_detail WHERE permohonan_id = '$idpb' ORDER BY kategori");

$idkeu = mysqli_query($koneksi, "SELECT * FROM user WHERE id = '$hdatapb[13]'");
$hidkeu = mysqli_fetch_array($idkeu);
$iddirektur = mysqli_query($koneksi, "SELECT * FROM user WHERE id = '$hdatapb[14]'");
$hiddirektur = mysqli_fetch_array($iddirektur);

$kategoriData = [];
while ($row = mysqli_fetch_assoc($q2)) {
  $kategoriData[$row['kategori']][] = $row;
}
function formatRupiah($angka) {
  return 'Rp ' . number_format($angka, 0, ',', '.');
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin ImagiCreative</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/iac.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
  
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
              <h1 class="text-center"><b>APPROVAL</b></h1>
              <h2 class="text-center"><b>PERMOHONAN BIAYA</b></h2><br>
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-2">
                        <label for="exampleInputEmail1" class="form-label">No</label><br>
                        <label for="exampleInputPassword1" class="form-label">Project</label><br>
                        <label for="exampleInputPassword1" class="form-label">Perihal</label>
                      </div>
                      <div class="col-md-10">
                        <label for="exampleInputEmail1" class="form-label">: <?=$hdatapb[1]?></label><br>
                        <label for="exampleInputEmail1" class="form-label">: <?=$hdatapb[2]?></label><br>
                        <label for="exampleInputEmail1" class="form-label">: <?=$hdatapb[3]?></label>
                      </div>
                    </div>
                  </div>
                </div>
                <form action="config/proses.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_permohonan" value="<?= $hdatapb[0] ?>">
                <input type="hidden" name="id_user" value="<?= $id ?>">
                <h5 class="card-title fw-semibold mb-4">Data Table</h5>
                <div class="card mb-0">
                  <div class="card-body">
                    <form id="form-penilaian">
                    <?php foreach ($kategoriData as $kategori => $items): ?>
                      <div class="kategori-block" data-kategori="<?= $kategori ?>">
                        <div class="row">
                          <div class="col-6">
                            <h5><b>Kategori: <?= $kategori ?></b></h5>
                          </div>
                          <div class="col-6">
                            <?php if(empty($hdatapb[9])){ ?>
                              <p class="text-end"><span class="status-text"></span></p>
                            <?php } else {
                                  $query = mysqli_query($koneksi, "SELECT * FROM penilaian_kategori WHERE id_permohonan = '$idpb' and kategori='$kategori'");
                                  $hnilai = mysqli_fetch_row($query);
                                  if($hnilai[4]=='Perlu Revisi'){
                            ?>
                              <p class="text-end text-white">
                                <span class="bg-warning">Ranking <?=$hnilai[5]?> | Nilai : <?=$hnilai[3]?> | <?=$hnilai[4]?><br><?=$hnilai[6]?></span>
                              </p>
                            <?php } else { ?>
                              <p class="text-end text-white">
                                <span class="bg-success"><b>Ranking <?=$hnilai[5]?> | Nilai : <?=$hnilai[3]?> | <?=$hnilai[4]?><br><?=$hnilai[6]?></b></span>
                              </p>
                            <?php }} ?>
                          </div>
                        </div>
                          <div class="table-responsive">
                              <table class="table table-bordered table-sm">
                                  <thead>
                                      <tr class="text-center">
                                          <th>Item</th>
                                          <th>Volume</th>
                                          <th>Satuan</th>
                                          <th>Harga</th>
                                          <th>Jumlah</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php $totalKategori = 0; foreach ($items as $item):
                                          $jumlah = $item['volume'] * $item['harga'];
                                          $totalKategori += $jumlah;
                                      ?>
                                          <tr>
                                              <td><?= $item['nama_item'] ?></td>
                                              <td class="text-center"><?= $item['volume'] ?></td>
                                              <td class="text-center"><?= $item['satuan'] ?></td>
                                              <td class="text-end">Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                                              <td class="text-end">Rp <?= number_format($jumlah, 0, ',', '.') ?></td>
                                          </tr>
                                      <?php endforeach; ?>
                                  </tbody>
                                  <tfoot>
                                      <tr>
                                          <td colspan="4" class="text-end"><strong>Total Kategori</strong></td>
                                          <td class="text-end"><strong>Rp <?= number_format($totalKategori, 0, ',', '.') ?></strong></td>
                                      </tr>
                                  </tfoot>
                              </table>
                          </div>
                          <?php if(empty($hdatapb[9])){ ?>
                          <input type="hidden" name="kategori[]" value="<?= $kategori ?>">
                          <div class="row">
                              <div class="col-md-4">
                                  <label class="form-control">Urgensi:
                                      <select class="form-control urgensi" name="urgensi[]" required>
                                          <option value="">Pilih</option>
                                          <option value="5">Sangat Penting</option>
                                          <option value="4">Penting</option>
                                          <option value="3">Cukup Penting</option>
                                          <option value="2">Kurang Penting</option>
                                          <option value="1">Tidak Penting</option>
                                      </select>
                                  </label>
                              </div>
                              <div class="col-md-4">
                                  <label class="form-control">Biaya:
                                      <select class="form-control biaya" name="biaya[]" required>
                                          <option value="">Pilih</option>
                                          <option value="1">Sangat Baik</option>
                                          <option value="2">Baik</option>
                                          <option value="3">Cukup Baik</option>
                                          <option value="4">Tidak Baik</option>
                                          <option value="5">Sangat Tidak Baik</option>
                                      </select>
                                  </label>
                              </div>
                              <div class="col-md-4">
                                  <label class="form-control">Relevansi:
                                      <select class="form-control relevansi" name="relevansi[]" required>
                                          <option value="">Pilih</option>
                                          <option value="5">Sangat Relevan</option>
                                          <option value="4">Relevan</option>
                                          <option value="3">Cukup Relevan</option>
                                          <option value="2">Kurang Relevan</option>
                                          <option value="1">Tidak Relevan</option>
                                      </select>
                                  </label>
                              </div>
                          </div>
                          <?php } else {
                            $penilaianitem = mysqli_query($koneksi, "SELECT * FROM penilaian_keuangan WHERE id_permohonan='$idpb' and kategori='$kategori'");
                            $hpenilaian = mysqli_fetch_row($penilaianitem);
                          ?>
                            <div class="row">
                              <div class="col-md-4">
                                <label class="form-control">Urgensi : 
                                  <?php
                                  if($hpenilaian[3]==5){ echo "Sangat Penting";
                                  } elseif($hpenilaian[3]==4){ echo "Penting";
                                  } elseif($hpenilaian[3]==3){ echo "Cukup Penting";
                                  } elseif($hpenilaian[3]==2){ echo "Kurang Penting";
                                  } elseif($hpenilaian[3]==1){ echo "Tidak Penting";}
                                  ?>
                                </label>
                              </div>
                              <div class="col-md-4">
                                <label class="form-control">Biaya : 
                                  <?php
                                  if($hpenilaian[4]==1){ echo "Sangat Baik";
                                  } elseif($hpenilaian[4]==2){ echo "Baik";
                                  } elseif($hpenilaian[4]==3){ echo "Cukup Baik";
                                  } elseif($hpenilaian[4]==4){ echo "Kurang Baik";
                                  } elseif($hpenilaian[4]==5){ echo "Tidak Baik";}
                                  ?>
                                </label>
                              </div>
                              <div class="col-md-4">
                                <label class="form-control">Relevansi : 
                                  <?php
                                  if($hpenilaian[5]==5){ echo "Sangat Relevan";
                                  } elseif($hpenilaian[5]==4){ echo "Relevan";
                                  } elseif($hpenilaian[5]==3){ echo "Cukup Relevan";
                                  } elseif($hpenilaian[5]==2){ echo "Kurang Relevan";
                                  } elseif($hpenilaian[5]==1){ echo "Tidak Relevan";}
                                  ?>
                                </label>
                              </div>
                            </div>
                          <?php } ?>

                          <div class="row mt-2">
                              <div class="col-md-12 keterangan-wrap" style="display:none;">
                                  <label class="form-control">Keterangan:
                                      <textarea class="form-control keterangan" name="keterangan[]" rows="2" placeholder="Masukkan keterangan jika perlu revisi..."></textarea>
                                  </label>
                              </div>
                          </div>
                          <!--<input type="text" name="nilai_akhir[]">-->
                          <!--<input type="text" name="status[]">-->
                          <!--<input type="text" name="ranking[]">-->
                          <input type="hidden" name="nilai_akhir[]" class="nilai-akhir">
                          <input type="hidden" name="status[]" class="status-input">
                          <input type="hidden" name="ranking[]" class="ranking-input">
                          
                          <hr>
                      </div>
                  <?php endforeach; ?>
                <!-- <hr> -->
                <h3 class="text-end"><b>Grand Total: <span><?=$hdatapb[5]?></span></b></h3><hr>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Catatan : <br> <?=$hdatapb[6];?></label>
                </div>
                <!-- <hr> -->
                <!-- <div id="hasil-ranking"></div> -->

                <?php if(!empty($hdatapb[15])){ ?>
                  <hr>
                  <label><b>Informasi Revisi</b></label>
                  <h4 class="text-warning"><?=$hdatapb[15]?></h4>
                <?php } ?>
                <hr>
                <p for="exampleInputEmail1" class="form-label text-end"><?=$hdatapb[7]?></p>
                    <div class="row text-center">
                      <div class="col-md-4"><br>
                        <label for="">Dibuat Oleh,</label><br>
                        <img src="<?=$hdatapb[8]?>" alt="">
                        <label for=""><b>( <?=$hdatapb[19]?> )</b></label><br>
                        <label for=""><?=$hdatapb[22]?></label>
                      </div>
                      <div class="col-md-4"><br>
                        <label for="">Diketahui Oleh,</label><br>
                        <?php if(empty($hdatapb[9])){
                          if($level == "Manager Keuangan"){
                          $sql = "SELECT tanda_tangan FROM user WHERE id = $id";
                          $result = mysqli_query($koneksi, $sql);

                          if (mysqli_num_rows($result) > 0) {
                              $row = mysqli_fetch_assoc($result);
                              $ttd = $row['tanda_tangan'];

                              if ($ttd == null || $ttd == '') {  ?>
                                <div id="sig" ></div>
                                <br/>
                                <button id="clear" class="btn btn-warning">Hapus Tanda Tangan</button>
                                <textarea id="signature64_1" name="signed1" style="display: none"></textarea><br><br>
                                <label for=""><b>( <?=$nama?> )</b></label><br>
                                <label for=""><?=$level?></label>
                                <?php } else { ?> 
                                  <br><br>
                                  <img src="<?=$ttd?>" alt="Tanda Tangan">
                                  <div class="form-check">
                                      <input class="form-check-input" type="checkbox" name="pakai_ttd" value="1" id="pakaiTTD" required>
                                      <label class="form-check-label" for="pakaiTTD">
                                          Gunakan tanda tangan yang sudah ada
                                      </label>
                                  </div>
                                <?php } ?>
                          <?php } } else { ?>
                              <br><br><br><br><br>";
                              <br>
                              <label><b>( ________ )</b></label><br>
                              <label>Manager Keuangan</label>";
                            <?php } } else { ?>
                              <img src="<?=$hdatapb[9]?>" alt="">
                              <label for=""><b>( <?=$hidkeu[1]?> )</b></label><br>
                              <label for=""><?=$hidkeu[4]?></label>
                            <?php } ?>
                      </div>
                      <div class="col-md-4"><br>
                        <label for="">Disetujui Oleh,</label><br>
                        <?php if(empty($hdatapb[10])){
                          if($level == "Direktur"){ 
                          $sql = "SELECT tanda_tangan FROM user WHERE id = $id";
                          $result = mysqli_query($koneksi, $sql);

                          if (mysqli_num_rows($result) > 0) {
                              $row = mysqli_fetch_assoc($result);
                              $ttd = $row['tanda_tangan'];

                              if ($ttd == null || $ttd == '') {  ?>
                                  <div id="sig" ></div>
                                  <br/>
                                  <p class="text-danger"><i>Jika perlu revisi dulu, Bagian TTD tidak perlu diisi</i></p>
                                  <button id="clear" class="btn btn-warning">Hapus Tanda Tangan</button>
                                  <textarea id="signature64_1" name="signed1" style="display: none"></textarea><br><br>
                                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Revisi Dulu</button>
                                  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLongTitle" >Keterangan Revisi</h5>
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                        <div class="mb-3">
                                          <textarea class="form-control" id="exampleFormControlTextarea1" name="revisi" rows="5"></textarea>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Save</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div><br><br>
                                <label for=""><b>( <?=$nama?> )</b></label><br>
                                <label for=""><?=$level?></label>
                              <?php } else { ?> 
                                  <br><br>
                                  <img src="<?=$ttd?>" alt="Tanda Tangan"><br><br>
                                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Revisi Dulu</button>
                                  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLongTitle" >Keterangan Revisi</h5>
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                        <div class="mb-3">
                                          <textarea class="form-control" id="exampleFormControlTextarea1" name="revisi" rows="5"></textarea>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Save</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div><br><br>
                                  <div class="form-check">
                                      <input class="form-check-input" type="checkbox" name="pakai_ttd" value="1" id="pakaiTTD">
                                      <label class="form-check-label" for="pakaiTTD">
                                          Gunakan tanda tangan yang sudah ada
                                      </label>
                                  </div>
                              <?php } ?>
                                
                        <?php } } else {echo "<br><br><br><br><br>"; echo "<br>
                        <label><b>( ________ )</b></label><br>
                        <label>Direktur</label>"; } } else { ?>
                            <img src="<?=$hdatapb[10]?>" alt="">
                            <label for=""><b>( <?=$hiddirektur[1]?> )</b></label><br>
                            <label for=""><?=$hiddirektur[4]?></label>
                        <?php } ?>
                      </div>
                    </div>
                    <?php if(empty($hdatapb[9])){
                      if($level == "Manager Keuangan"){ ?>
                        <br><br>
                        <div class="mb-3 form-check">
                          <input type="checkbox" class="form-check-input" id="exampleCheck1" Required>
                          <label class="form-check-label" for="exampleCheck1">Pastikan Data sudah Benar.</label>
                        </div>
                        <button type="submit" class="btn btn-info form-control" name="submitpbap">Submit Data</button>
                    <?php } } elseif(empty($hdatapb[10])){
                          if($level == "Direktur"){ ?>
                        <br><br>
                        <div class="mb-3 form-check">
                          <input type="checkbox" class="form-check-input" id="exampleCheck1" Required>
                          <label class="form-check-label" for="exampleCheck1">Pastikan Data sudah Benar.</label>
                        </div>
                        <button type="submit" class="btn btn-info form-control" name="submitpbapd">Submit Data</button>
                      <?php } } ?>
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
    document.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', hitungSemua);
    });
    
    function hitungSemua() {
        let kategoriBlocks = document.querySelectorAll('.kategori-block');
        let data = [], urgensiVals = [], biayaVals = [], relevansiVals = [];
    
        kategoriBlocks.forEach(block => {
            let urg = parseInt(block.querySelector('.urgensi').value) || 0;
            let biaya = parseInt(block.querySelector('.biaya').value) || 0;
            let relev = parseInt(block.querySelector('.relevansi').value) || 0;
    
            urgensiVals.push(urg);
            biayaVals.push(biaya);
            relevansiVals.push(relev);
    
            data.push({kategori: block.dataset.kategori, urgensi: urg, biaya: biaya, relevansi: relev, block});
        });
    
        let minUrg = Math.min(...urgensiVals), maxUrg = Math.max(...urgensiVals);
        let minBiaya = Math.min(...biayaVals), maxBiaya = Math.max(...biayaVals);
        let minRelev = Math.min(...relevansiVals), maxRelev = Math.max(...relevansiVals);
    
        let bobot = { urgensi: 5, biaya: 4, relevansi: 3 };
    
        let hasil = data.map(item => {
            // let normUrg = (item.urgensi - minUrg) / (maxUrg - minUrg || 1);
            let normUrg = maxUrg === minUrg ? 1 : (item.urgensi - minUrg) / (maxUrg - minUrg);
            // let normBiaya = (maxBiaya - item.biaya) / (maxBiaya - minBiaya || 1); // Cost
            let normBiaya = maxBiaya === minBiaya ? 1 : (maxBiaya - item.biaya) / (maxBiaya - minBiaya);
            // let normRelev = (item.relevansi - minRelev) / (maxRelev - minRelev || 1);
            let normRelev = maxRelev === minRelev ? 1 : (item.relevansi - minRelev) / (maxRelev - minRelev);
    
            let total = (
                bobot.urgensi * normUrg +
                bobot.biaya * normBiaya +
                bobot.relevansi * normRelev
            );
    
            return {
                kategori: item.kategori,
                nilai: total.toFixed(2),
                status: total >= 6.5 ? 'Layak Disetujui' : 'Perlu Revisi',
                block: item.block
            };
        });
    
        hasil.sort((a, b) => b.nilai - a.nilai);
        hasil.forEach((h, i) => {
            h.ranking = i + 1;
            let statusText = `Nilai: ${h.nilai} | Ranking: ${h.ranking} | ${h.status}`;
            let span = h.block.querySelector('.status-text');
            span.innerText = statusText;
            span.style.color = h.status === 'Layak Disetujui' ? 'green' : 'orange';
              
            // Tampilkan atau sembunyikan textarea keterangan
            let keteranganWrap = h.block.querySelector('.keterangan-wrap');
            if (h.status === 'Perlu Revisi') {
                keteranganWrap.style.display = 'block';
            } else {
                keteranganWrap.style.display = 'none';
                h.block.querySelector('.keterangan').value = '';
            }
              // Set input nilai, status, dan ranking
              h.block.querySelector('.nilai-akhir').value = h.nilai;
              h.block.querySelector('.status-input').value = h.status;
              h.block.querySelector('.ranking-input').value = h.ranking;
        });
    
        let output = '<h5><b>Hasil Akhir Penilaian</b></h5><table class="table table-bordered">';
        output += '<thead><tr><th>Ranking</th><th>Kategori</th><th>Nilai Akhir</th><th>Status</th><th>Keterangan</th></tr></thead><tbody>';
        hasil.forEach(h => {
            let ket = h.block.querySelector('.keterangan').value || '-';
            output += `<tr><td>${h.ranking}</td><td>${h.kategori}</td><td>${h.nilai}</td><td>${h.status}</td><td>${ket}</td></tr>`;
        });
        output += '</tbody></table>';
    
        document.getElementById('hasil-ranking').innerHTML = output;
    }
    </script>

  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/sidebarmenu.js"></script>
  <script src="assets/js/app.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>