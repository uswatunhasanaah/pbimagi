<?php
include 'config/koneksi.php';

$iduser = $_SESSION['id'];
$tahun = date('Y');

// Statistik untuk STAFF (data sendiri)
$query = mysqli_query($koneksi, "SELECT 
        COUNT(*) AS total_permohonan,
        COUNT(CASE WHEN iddirektur = 0 THEN 1 END) AS total_diproses,
        COUNT(CASE WHEN iddirektur != 0 THEN 1 END) AS total_disetujui,
        CONCAT('Rp ', FORMAT(
            SUM(
                CASE 
                    WHEN iddirektur != 0 THEN 
                        CAST(REPLACE(REPLACE(REPLACE(total, 'Rp', ''), '.', ''), ',', '.') AS UNSIGNED)
                    ELSE 0 
                END
            ), 0)
        ) AS total_dana_disetujui
    FROM permohonanbiaya
    WHERE 
        id_user = $iduser
        AND YEAR(STR_TO_DATE(SUBSTRING_INDEX(tanggal, ' ', -2), '%Y-%m-%d')) = YEAR(CURDATE())");
$hasil = mysqli_fetch_row($query);

// Statistik untuk level lain (DIREKTUR atau KEUANGAN)
if ($level == 'Direktur') {
  $query2 = mysqli_query($koneksi, "SELECT 
          COUNT(*) AS total_permohonan,
          COUNT(CASE WHEN iddirektur = 0 THEN 1 END) AS total_diproses,
          COUNT(CASE WHEN iddirektur != 0 THEN 1 END) AS total_disetujui,
          CONCAT('Rp ', FORMAT(
              SUM(
                  CASE 
                      WHEN iddirektur != 0 THEN 
                          CAST(REPLACE(REPLACE(REPLACE(total, 'Rp', ''), '.', ''), ',', '.') AS UNSIGNED)
                      ELSE 0 
                  END
              ), 0)
          ) AS total_dana_disetujui
      FROM permohonanbiaya
      WHERE idkeuangan != 0 
        AND YEAR(STR_TO_DATE(SUBSTRING_INDEX(tanggal, ' ', -2), '%Y-%m-%d')) = YEAR(CURDATE())");
} else {
  $query2 = mysqli_query($koneksi, "SELECT 
          COUNT(*) AS total_permohonan,
          COUNT(CASE WHEN iddirektur = 0 THEN 1 END) AS total_diproses,
          COUNT(CASE WHEN iddirektur != 0 THEN 1 END) AS total_disetujui,
          CONCAT('Rp ', FORMAT(
              SUM(
                  CASE 
                      WHEN iddirektur != 0 THEN 
                          CAST(REPLACE(REPLACE(REPLACE(total, 'Rp', ''), '.', ''), ',', '.') AS UNSIGNED)
                      ELSE 0 
                  END
              ), 0)
          ) AS total_dana_disetujui
      FROM permohonanbiaya
      WHERE YEAR(STR_TO_DATE(SUBSTRING_INDEX(tanggal, ' ', -2), '%Y-%m-%d')) = YEAR(CURDATE())");
}
$hasil2 = mysqli_fetch_row($query2);

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin ImagiCreative</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/iac.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
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
        <!--  Row 1 -->
        <div class="row">
          <div class="col-lg-4">
            <div class="card overflow-hidden bg-primary">
              <div class="card-body p-4">
                <h5 class="card-title mb-9 fw-semibold">Jumlah Pengajuan Anggaran</h5>
                <div class="row align-items-center">
                  <div class="col-8">
                    <h2 class="fw-semibold mb-3"><?php if($level == 'Staff') { echo $hasil[0]; } else { echo $hasil2[0]; } ?></h2>
                    <div class="d-flex align-items-center mb-3">
                      <span
                        class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                        <i class="ti ti-arrow-up-left text-success"></i>
                      </span>
                      <p class="text-dark me-1 fs-3 mb-0">Tahun <?=$tahun?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card overflow-hidden bg-warning">
              <div class="card-body p-4">
                <h5 class="card-title mb-9 fw-semibold">Proses Pengajuan Anggaran</h5>
                <div class="row align-items-center">
                  <div class="col-8">
                    <h2 class="fw-semibold mb-3"><?php if($level == 'Staff') { echo $hasil[1]; } else { echo $hasil2[1]; } ?></h2>
                    <div class="d-flex align-items-center mb-3">
                      <span
                        class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                        <i class="ti ti-arrow-up-left text-success"></i>
                      </span>
                      <p class="text-dark me-1 fs-3 mb-0">Tahun <?=$tahun?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card overflow-hidden bg-success">
              <div class="card-body p-4">
                <h5 class="card-title mb-9 fw-semibold">Anggaran Disetujui</h5>
                <div class="row align-items-center">
                  <div class="col-8">
                    <h2 class="fw-semibold mb-3"><?php if($level == 'Staff') { echo $hasil[2]; } else { echo $hasil2[2]; } ?></h2>
                    <div class="d-flex align-items-center mb-3">
                      <span
                        class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                        <i class="ti ti-arrow-up-left text-success"></i>
                      </span>
                      <p class="text-dark me-1 fs-3 mb-0">Tahun <?=$tahun?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="card overflow-hidden">
              <div class="card-body p-4 text-center">
                <h5 class="card-title mb-9 fw-semibold">Total Dana Pengajuan Anggaran Disetujui</h5>
                <div class="row align-items-center">
                  <div class="col-12">
                    <h2 class="fw-semibold mb-3"><?php if($level == 'Staff') { echo $hasil[3]; } else { echo $hasil2[3]; } ?></h2>
                    <div class="d-flex align-items-center justify-content-center mb-3">
                      <span
                        class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                        <i class="ti ti-arrow-up-left text-success"></i>
                      </span>
                      <p class="text-dark me-1 fs-3 mb-0">Tahun <?=$tahun?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4">List Terkini Permohonan Biaya</h5>
                <div class="table-responsive">
                  <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                      <tr>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">No</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Tanggal</h6>
                        </th>
                        <?php if($level != 'Staff'){ ?>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Diajukan Oleh</h6>
                        </th>
                        <?php } ?>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Project</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Perihal</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Status Pengajuan</h6>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($level == 'Staff'){
                        $nobaris = 0;
                        $data = mysqli_query($koneksi, "SELECT permohonanbiaya.*, user.nama FROM permohonanbiaya JOIN user ON permohonanbiaya.id_user=user.id WHERE id_user='$iduser' ORDER BY id DESC LIMIT 5");
                        while($hdata = mysqli_fetch_array($data)){
                          $nobaris++;
                        ?>
                        <tr>
                          <td><?=$nobaris?></td>
                          <td><?=$hdata[7]?></td>
                          <td><?=$hdata[2]?></td>
                          <td><?=$hdata[3]?></td>
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
                            <?php } elseif($hdata[16]=='update' && $hdata[16]=='') { ?>
                              <span class="badge bg-secondary">Direktur</span>
                            <?php } else { ?>
                              <span class="badge bg-danger">Direktur</span>
                            <?php } ?>
                          </td>
                        </tr>
                        <?php } } else { 
                        $nobaris = 0;
                        $data = mysqli_query($koneksi, "SELECT permohonanbiaya.*, user.nama FROM permohonanbiaya JOIN user ON permohonanbiaya.id_user=user.id ORDER BY id DESC LIMIT 5");
                        while($hdata = mysqli_fetch_array($data)){
                          $nobaris++; ?>
                          <tr>
                          <td><?=$nobaris?></td>
                          <td><?=$hdata[7]?></td>
                          <td><?=$hdata[18]?></td>
                          <td><?=$hdata[2]?></td>
                          <td><?=$hdata[3]?></td>
                          <td class="text-center">
                            <?php if($hdata[13]!=0){ ?>
                              <span class="badge bg-success">Keuangan</span>
                            <?php } else { ?>
                              <span class="badge bg-danger">Keuangan</span>
                            <?php } ?>
                            <br>
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
                            <?php } elseif($hdata[16]=='update' && $hdata[16]=='') { ?>
                              <span class="badge bg-secondary">Direktur</span>
                            <?php } else { ?>
                              <span class="badge bg-danger">Direktur</span>
                            <?php } ?>
                          </td>
                        </tr>
                        <?php } } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/sidebarmenu.js"></script>
  <script src="assets/js/app.min.js"></script>
  <script src="assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="assets/js/dashboard.js"></script>
</body>

</html>