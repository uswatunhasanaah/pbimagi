<?php
date_default_timezone_set("Asia/Makassar");
$date = date('d/m/Y G:i:s');
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin ImagiCreative</title>
  <!-- <script src="https://code.jquery.com/jquery-3.6.2.slim.js" integrity="sha256-OflJKW8Z8amEUuCaflBZJ4GOg4+JnNh9JdVfoV+6biw=" crossorigin="anonymous"></script> -->
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/iac.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">
  
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
  <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  
  <script type="text/javascript" src="js/jquery.signature.min.js"></script>
  <script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/jquery.signature.css">

  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->
  <style>
      .kbw-signature { width: 100%; height: 150px;}
      #sig canvas{
          width: 100% !important;
          height: auto;
      }
  </style>
  <!-- <script src="item.js"></script> -->
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <?php include 'aside.php'; ?>
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <?php include 'header.php'; ?>
      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h1 class="text-center"><b>FORM</b></h1>
              <h2 class="text-center"><b>PERMOHONAN BIAYA</b></h2>
              <div class="card">
                <div class="card-body">
                  <form action="" method="post">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">No</label>
                      <input type="text" name="no" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="001" readonly Required>
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Project</label>
                      <select id="projet" class="form-control" name="project" Required>
                        <option value="">Pilih...</option>
                        <option value="volvo">Volvo</option>
                        <option value="saab">Saab</option>
                        <option value="opel">Opel</option>
                        <option value="audi">Audi</option>
                      </select>
                      <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Perihal</label>
                      <input type="text" name="perihal" class="form-control" id="exampleInputPassword1" Required>
                    </div>
                    <button type="submit" class="btn btn-primary">Check Data</button>
                  </form>
                </div>
              </div>
              <form action="config/proses.php" method="post">
                <h5 class="card-title fw-semibold mb-4">Data Table</h5>
                <input type="text" class="form-control" id="exampleInputEmail1" value="<?=$_POST['no']?>" readonly Required name="nopb">
                <input type="text" class="form-control" id="exampleInputEmail1" value="<?=$_POST['project']?>" readonly Required name="project">
                <input type="text" class="form-control" id="exampleInputEmail1" value="<?=$_POST['perihal']?>" readonly Required name="perihal">
                <div class="card mb-0">
                  <div class="card-body">
                    <div class="table table-responsive">
                      <table class="table table-bordered">
                        <thead class="text-center">
                          <tr>
                            <th>Item</th>
                            <th>Volume</th>
                            <th>Satuan</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah</th>
                            <th><button type="button" class="btn btn-sm btn-success" onclick="BtnAdd()">+</button></th>
                          </tr>
                        </thead>
                        <tbody id="TBody">
                          <tr id="TRow" class="d-none">
                            <td style="width:25%"><input type="text" name="item" id="item" class="form-control" Required></td>
                            <td style="width:5%"><input type="number" name="vol" id="vol" class="form-control" onchange="Calc(this);" Required></td>
                            <td style="width:5%"><input type="text" name="satuan" id="satuan" class="form-control" Required></td>
                            <td style="width:15%"><input type="number" name="harga" id="harga" class="form-control" onchange="Calc(this);" Required></td>
                            <td style="width:15%">
                              <input type="number" name="jumlah" id="jumlah" class="form-control text-end" value="0" Required>
                              <input type="text" name="jumlahtext" id="jumlahtext" class="form-control text-end" value="0" readonly Required>
                            </td>
                            <td style="width:5%" class="text-center"><button type="button" class="btn btn-sm btn-danger" onclick="BtnDel(this)">X</button></td>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="4" class="text-center"><b>Total</b></td>
                            <td colspan="2">
                              <input type="number" class="form-control text-end" id="FTotal" name="FTotal" Required>
                              <input type="text" class="form-control text-end" id="FTotaltext" name="FTotaltext" readonly Required>
                            </td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Catatan : </label>
                      <textarea name="catatan" id="" class="form-control" rows="5"></textarea>
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
                    <br><br>
                    <div class="row text-center">
                      <div class="col-md-12">
                        <label for="">Dibuat Oleh,</label><br>
                        <?php
                        $ttd = "dibuat";
                        if($ttd == "dibuat"){
                        ?>
                          <div id="sig" ></div>
                          <br/>
                          <button id="clear" class="btn btn-danger">Hapus Tanda Tangan</button>
                          <textarea id="signature64_1" name="signed1" style="display: none"></textarea><br><br>
                          <input type="text" name="pinttd" class="form-control" id="exampleInputPassword1" placeholder="Masukan PIN TTD" Required>
                        <?php } else { echo "<br><br><br><br><br>"; } ?><br>
                        <label for="">(Nama)</label>
                      </div><hr>
                      <div class="col-md-12">
                        <label for="">Diketahui Oleh,</label><br>
                        <?php if($ttd == "diketahui"){ ?>
                          <div id="sig" ></div>
                          <br/>
                          <button id="clear" class="btn btn-danger">Hapus Tanda Tangan</button>
                          <textarea id="signature64_2" name="signed" style="display: none"></textarea>
                          <button class="btn btn-success">Submit</button>
                        <?php } else { echo "<br><br><br><br><br>"; } ?>
                        <label for="">(Nama)</label>
                      </div><hr>
                      <div class="col-md-12">
                        <label for="">Disetujui Oleh,</label><br>
                        <?php if($ttd == "disetujui"){ ?>
                          <div id="sig" ></div>
                          <br/>
                          <button id="clear" class="btn btn-danger">Hapus Tanda Tangan</button>
                          <textarea id="signature64_3" name="signed" style="display: none"></textarea>
                          <br/>
                        <button class="btn btn-success">Submit</button>
                        <?php } else { echo "<br><br><br><br><br>"; } ?>
                        <label for="">(Nama)</label>
                      </div>
                    </div>
                    <br><br><br>
                    <div class="mb-3 form-check">
                      <input type="checkbox" class="form-check-input" id="exampleCheck1" Required>
                      <label class="form-check-label" for="exampleCheck1">Pastikan Data sudah Benar.</label>
                    </div>
                    <button type="submit" class="btn btn-primary form-control" name="submitpb">Submit Data</button>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>