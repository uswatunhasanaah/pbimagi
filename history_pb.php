<?php
include 'config/koneksi.php';
date_default_timezone_set("Asia/Makassar");
$date = date('d/m/Y G:i:s');
$datem = date('M/Y');

$iduser = $_SESSION['id'];
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
  
  <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
  <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
  <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>-->
  
  <script type="text/javascript" src="js/jquery.signature.min.js"></script>
  <script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/jquery.signature.css">
  
  <style>
      .kbw-signature { width: 100%; height: 150px;}
      #sig canvas{
          width: 100% !important;
          height: auto;
      }
  </style><!-- jQuery (required by DataTables) --><!-- jQuery (wajib) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables (CSS & JS) -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

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
            <h1 class="text-center"><b>HISTORY</b></h1>
            <h2 class="text-center"><b>PERMOHONAN BIAYA</b></h2><br><br>
              <div class="card mb-0">
                <div class="card-body">
                  <label for="">Keterangan Status Dana : 
                              <span class="badge bg-success">Sudah Diproses</span>
                              <span class="badge bg-warning">On Proses</span><br><br>
                    <div class="table table-responsive">
                    <table class="table table-bordered" id="datatablee">
                      <thead class="text-center">
                        <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Project</th>
                          <th>Perihal</th>
                          <th>Jumlah</th>
                          <th>Status Pengajuan</th>
                          <th>Proses Dana</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $nobaris = 0;
                        $data = mysqli_query($koneksi, "SELECT permohonanbiaya.*, user.nama FROM permohonanbiaya JOIN user ON permohonanbiaya.id_user=user.id
                        WHERE id_user='$iduser' and direktur != ''
                        ORDER BY id DESC");
                        while($hdata = mysqli_fetch_array($data)){
                          $nobaris++;
                        ?>
                        <tr>
                          <td><?=$nobaris?></td>
                          <td><?=$hdata[7]?></td>
                          <td><?=$hdata[2]?></td>
                          <td><?=$hdata[3]?></td>
                          <td><?=$hdata[5]?></td>
                          <td class="text-center">
                            <?php if($hdata[13]!=0){ ?>
                              <span class="badge bg-success">Keuangan</span>
                            <?php } else { ?>
                              <span class="badge bg-danger">Keuangan</span>
                            <?php } ?>
                            
                            <?php if($hdata[14]!=0){ ?>
                              <span class="badge bg-success">Direktur</span>
                            <?php } elseif($hdata[16]=='revisi'){ ?>
                              <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><span class="badge bg-warning">Direktur</span></a>
                              <!-- Modal -->
                              <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLongTitle">Informasi Revisi</h5>
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <p><?=$hdata[15]?></p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <?php } elseif($hdata[16]=='update') { ?>
                              <span class="badge bg-secondary">Direktur</span>
                            <?php } else { ?>
                              <span class="badge bg-danger">Direktur</span>
                            <?php } ?>
                          </td>
                          <td>
                          <?php if(empty($hdata[17])){ ?> <span class="badge bg-warning">On Proses</span> <?php } else { ?> <span class="badge bg-success">Sudah Diproses</span> <?php } ?>
                          </td>
                          <td class="text-center">
                            <a href="index.php?page=detailspb&id=<?=$hdata[0]?>"><span class="badge bg-info">Details</span></a><br>
                            <?php if($hdata[14]!=0){ ?>
                            <a href="printpb.php?id=<?=$hdata[0]?>"><span class="badge bg-secondary">Print</span></a> <?php } else { ?>
                            <a href="config/hapus.php?idpb=<?=$hdata[0]?>" onclick="return confirm('Anda ingin Hapus?')"><span class="badge bg-danger">Hapus</span></a><br>
                            <?php } ?>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                  <br><br>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--<script src="assets/libs/jquery/dist/jquery.min.js"></script>-->
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/sidebarmenu.js"></script>
  <script src="assets/js/app.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.js"></script>
  <script>
      $(document).ready(function () {
        $('#datatablee').DataTable({
          responsive: true
        });
      });
    </script>
</body>

</html>