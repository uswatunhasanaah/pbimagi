<?php
date_default_timezone_set("Asia/Makassar");
$date = date('d/m/Y G:i:s');
$datem = date('M/Y');

$nopb = mysqli_query($koneksi,"SELECT 1000+COUNT(*)+1 FROM permohonanbiaya");
$hnopb = mysqli_fetch_row($nopb);

$npb = $hnopb[0]."/PB/IAC/".$datem;

$nama = $_SESSION['nama'] ?? null;
$username = $_SESSION['username'] ?? null;
$level = $_SESSION['level'] ?? null;
$id = $_SESSION['id'] ?? null;

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
        <div class="card">
          <div class="card-body">
            <h1 class="text-center"><b>FORM</b></h1>
            <h2 class="text-center"><b>PERMOHONAN BIAYA</b></h2><br><br>
            <form action="config/proses.php" method="post" enctype="multipart/form-data" onsubmit="return validateFile()">
              <div class="card">
                <div class="card-body">
                  <div class='row'>
                    <div class="col-2">
                      <label for="exampleInputEmail1" class="form-label">No</label>
                    </div>
                    <div class="col-10">
                      <input type="text" name="no" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?=$npb?>" readonly Required>
                    </div>
                  </div>
                  <div class='row mt-2'>
                    <div class="col-2">
                      <label for="exampleInputPassword1" class="form-label">Project*</label>
                    </div>
                    <div class="col-10">
                      <input type="text" name="project" class="form-control" id="exampleInputPassword1" Required>
                    </div>
                  </div>
                  <div class='row mt-2'>
                    <div class="col-2">
                      <label for="exampleInputPassword1" class="form-label">Perihal*</label>
                    </div>
                    <div class="col-10">
                      <input type="text" name="perihal" class="form-control" id="exampleInputPassword1" Required>
                    </div>
                  </div>
                </div>
              </div>
              <h5 class="card-title fw-semibold mb-4">Data Table</h5>
              <div class="card mb-0">
                <div class="card-body">
                  <button type="button" class="btn btn-info" onclick="addKategori()">Tambah Data/Kategori</button>
                  <br><br>
                  <div id="form-area"></div>
                    <datalist id="kategoriList">
                      <?php
                        $result = mysqli_query($koneksi, "SELECT DISTINCT nama_kategori FROM pilihan_kategori");
                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="'.htmlspecialchars($row['nama_kategori']).'"></option>';
                        }
                      ?>
                    </datalist>
                  <hr>
                  <h5 class="text-end"><b>Grand Total: <span id="grand-total">Rp 0</span></b></h5><hr>
                  <input type="hidden" name="gtotal" id="grand-totalinput">
                  <input type="hidden" name="iduser" value="<?=$id?>">

                  <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Lampiran Dokumen : </label> 
                      <input type="file" name="file_pdf" class="form-control" id="file_pdf" accept="application/pdf" aria-describedby="emailHelp" value="Makassar">
                      <p class="text-danger"><i>Hanya menerima dokumen PDF saja, MAX 3MB</i></p>
                  </div>

                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Catatan : </label>
                    <textarea name="catatan" id="" class="form-control" rows="3"></textarea>
                  </div>
                  <div class="row">
                      <div class="col mb-3">
                        <label for="exampleInputEmail1" class="form-label">Dibuat di : </label>
                        <input type="text" name="dibuat" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="Makassar" Required>
                      </div>
                      <div class="col mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tanggal & Waktu :</label>
                        <input type="text" name="tglbuat" class="form-control" id="exampleInputEmail1" value="<?=$date?>" readonly Required>
                      </div>
                  </div>
                  <div class="row text-center">
                    <div class="col-md-4">
                      <label for="">Dibuat Oleh,</label><br>
                      <?php
                        if ($level == "Staff") {
                          $sql = "SELECT tanda_tangan FROM user WHERE id = $id";
                          $result = mysqli_query($koneksi, $sql);

                          if (mysqli_num_rows($result) > 0) {
                              $row = mysqli_fetch_assoc($result);
                              $ttd = $row['tanda_tangan'];

                              if ($ttd == null || $ttd == '') {
                                  // Jika belum ada tanda tangan, tampilkan signature pad
                                  ?>
                                  <div id="sig"></div>
                                  <br/>
                                  <button id="clear" class="btn btn-danger">Ulangi</button>
                                  <textarea id="signature64_1" name="signed1" style="display: none"></textarea>
                                  <?php
                              } else {
                                  // Jika sudah ada tanda tangan, tampilkan checkbox dan preview
                                  ?><br><br>
                                  <img src="<?= $ttd ?>" alt="Tanda Tangan" style="border:1px solid #ccc; max-height:150px;">
                                  <div class="form-check">
                                      <input class="form-check-input" type="checkbox" name="pakai_ttd" value="1" id="pakaiTTD" required>
                                      <label class="form-check-label" for="pakaiTTD">
                                          Gunakan tanda tangan yang sudah ada
                                      </label>
                                  </div>
                                  <?php
                              }
                            }
                          }
                        ?>
                        <br>
                          <label for=""><b>( <?=$nama?> )</b></label><br>
                          <label for=""><b><?=$level?></b></label>
                        </div>
                    <div class="col-md-4">
                      <label for="">Diketahui Oleh,</label><br>
                      <br><br><br><br><br>
                      <label for=""><b>( ________ )</b></label><br>
                      <label for="">Keuangan</label>
                    </div>
                    <div class="col-md-4">
                      <label for="">Disetujui Oleh,</label><br>
                      <br><br><br><br><br>
                      <label for=""><b>( ________ )</b></label><br>
                      <label for="">Direktur</label>
                    </div>
                  </div><br><br>
                  <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" Required>
                    <label class="form-check-label" for="exampleCheck1">Pastikan Data sudah Benar.</label>
                  </div>
                  <button type="submit" class="btn btn-primary form-control" name="submitpbn">Submit Data</button>
                </div>
              </div>
            </form>
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
    let kategoriCount = 0;

    // Tambah Kategori
    function addKategori() {
      kategoriCount++;
      const kategoriId = kategoriCount;
      const kategoriHtml = `
        <div class="kategori mb-4" id="kategori_${kategoriId}">
          <label>
            <b>Kategori</b><br>
            <!-- Input text untuk user, suggestion pakai datalist -->
            <input type="text" name="kategori_nama" class="form-control mb-2" list="kategoriList" 
                   id="inputKategori_${kategoriId}" placeholder="Nama Kategori" 
                   oninput="updateKategoriHidden(${kategoriId})" required>
            <button class="btn btn-danger mt-2" onclick="removeKategori(${kategoriId})">Hapus Kategori</button>
          </label>
          <button class="btn btn-success mt-2" onclick="addItem(${kategoriId})">Tambah Item</button>
          <br><br>
          <div class="table-responsive">
            <table class="table table-bordered table-sm" id="table_${kategoriId}">
              <thead>
                <tr class='text-center'>
                  <th>Item</th>
                  <th width='150px'>Volume/Qty</th>
                  <th width='150px'>Satuan</th>
                  <th width='150px'>Harga</th>
                  <th width='180px'>Jumlah</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody></tbody>
              <tfoot>
                <tr>
                  <td colspan="4" align="right"><strong>Total:</strong></td>
                  <td class="rupiah total-kategori text-end" colspan="2">Rp 0</td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      `;
      $('#form-area').append(kategoriHtml);
      addItem(kategoriId); // Tambah 1 item otomatis
  }

  function updateKategoriHidden(id) {
      const inputVal = document.getElementById('inputKategori_' + id).value;
      document.getElementById('hiddenKategori_' + id).value = inputVal;
  }

  function removeKategori(id) {
      $('#kategori_' + id).remove();
  }

    // Tambah Item
    function addItem(kategoriId) {
      const kategoriInput = document.querySelector(`#kategori_${kategoriId} input[name="kategori_nama"]`);
      const kategoriValue = kategoriInput ? kategoriInput.value : '';

      const row = `
        <tr>
          <td>
            <input type="hidden" name="kategori[]" value="${kategoriValue}">
            <input type="text" class="form-control" name="nama[]" required>
          </td>
          <td><input type="number" class="form-control" name="volume[]" class="volume" min="0" value="0" onchange="updateJumlah(this)"></td>
          <td><input type="text" class="form-control" name="satuan[]" required></td>
          <td>
            <input type="text" class="form-control" name="harga[]" class="harga" value="" 
                  oninput="sanitizeHarga(this)" 
                  onblur="formatHarga(this)" 
                  onchange="updateJuml  ah(this)">
          </td>
          <td class="rupiah jumlah">Rp 0</td>
          <td><button class="btn btn-danger btn-sm" onclick="removeItem(this)">X</button></td>
        </tr>
      `;
      $(`#table_${kategoriId} tbody`).append(row);
      updateKategoriHidden(kategoriId);
    }

    // Update semua input kategori tersembunyi
    function updateKategoriHidden(kategoriId) {
      const kategoriInput = document.querySelector(`#kategori_${kategoriId} input[name="kategori_nama"]`);
      const kategoriValue = kategoriInput.value;
      const hiddenInputs = document.querySelectorAll(`#table_${kategoriId} input[name="kategori[]"]`);
      hiddenInputs.forEach(input => {
        input.value = kategoriValue;
      });
    }

    // Update jumlah dan total
    function updateJumlah(el) {
      const row = $(el).closest('tr');
      const volume = parseFloat(row.find('input[name="volume[]"]').val()) || 0;
      let harga = row.find('input[name="harga[]"]').val().replace(/[^\d]/g, '');
      harga = parseFloat(harga) || 0;
      const jumlah = volume * harga;

      row.find('.jumlah').text(formatRupiah(jumlah));
      updateTotalKategori($(el).closest('table'));
    }

    // Update total kategori dan grand total
    function updateTotalKategori(table) {
      let total = 0;
      table.find('tbody tr').each(function () {
        const volume = parseFloat($(this).find('input[name="volume[]"]').val()) || 0;
        let harga = $(this).find('input[name="harga[]"]').val().replace(/[^\d]/g, '');
        harga = parseFloat(harga) || 0;
        total += volume * harga;
      });
      table.find('.total-kategori').text(formatRupiah(total));
      updateGrandTotal();
    }

    // Grand Total
    function updateGrandTotal() {
      let grandTotal = 0;
      $('.total-kategori').each(function () {
        let val = $(this).text().replace(/[^\d]/g, '');
        grandTotal += parseFloat(val) || 0;
      });
      $('#grand-total').text(formatRupiah(grandTotal));
      $('#grand-totalinput').val(formatRupiah(grandTotal));
    }

    // Hapus Kategori
    function removeKategori(kategoriId) {
      $(`#kategori_${kategoriId}`).remove();
      updateGrandTotal();
    }

    // Hapus Item
    function removeItem(el) {
      const table = $(el).closest('table');
      $(el).closest('tr').remove();
      updateTotalKategori(table);
    }

    // Format Harga
    function sanitizeHarga(input) {
      input.value = input.value.replace(/[^\d]/g, '');
    }

    function formatHarga(input) {
      let value = input.value.replace(/[^\d]/g, '');
      input.value = formatRupiah(parseFloat(value));
      updateJumlah(input);
    }

    // Format Rupiah
    function formatRupiah(angka) {
      if (!angka || isNaN(angka)) return 'Rp 0';
      return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
  </script>

  <script>
    function validateFile() {
        const file = document.getElementById('file_pdf').files[0];
        if (file) {
            const maxSize = 3 * 1024 * 1024; // 3 MB
            if (file.size > maxSize) {
                alert("Ukuran file maksimal adalah 3MB!");
                return false;
            }
        }
        return true;
    }
  </script>

  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/sidebarmenu.js"></script>
  <script src="assets/js/app.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>