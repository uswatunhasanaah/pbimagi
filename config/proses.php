<?php
include('koneksi.php');
date_default_timezone_set("Asia/Makassar");

if(isset($_POST['submitpbn'])){

    // print_r($_POST);
    // exit();

    $nopb = $_POST['no'];
    $project = $_POST['project'];
    $perihal = $_POST['perihal'];
    $catatan = $_POST['catatan'];
    // $dibuat = ;
    $tglbuat = $_POST['dibuat'].' '.date('Y-m-d G:i:s');
    $total = $_POST['gtotal'];
    $iduser = $_POST['iduser'];
    
    // Ambil tanda tangan user dari DB
    $cek_ttd = mysqli_query($koneksi, "SELECT tanda_tangan FROM user WHERE id = $iduser");
    $data_ttd = mysqli_fetch_assoc($cek_ttd);
    $tanda_tangan_user = $data_ttd['tanda_tangan'];

    // Jika user belum punya tanda tangan
    if (empty($tanda_tangan_user)) {
        if (empty($_POST['signed1'])) {
            echo "<script>alert('Tanda tangan belum diisi.');history.back();</script>";
            exit();
        } else {
            $folderPath = "upload_ttd/";
            $image_parts = explode(";base64,", $_POST['signed1']); 
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = $folderPath . "db-".uniqid() . '.' . $image_type;
            file_put_contents($file, $image_base64);

            // Simpan tanda tangan ke tabel user
            $base64 = $_POST['signed1'];
            mysqli_query($koneksi, "UPDATE user SET tanda_tangan = '$base64' WHERE id = $iduser");
            $file = $base64;
        }
    } else {
        // Jika sudah ada tanda tangan, cek apakah checkbox "pakai_ttd" dicentang
        if (!isset($_POST['pakai_ttd'])) {
            echo "<script>alert('Silakan centang checkbox untuk menggunakan tanda tangan.');history.back();</script>";
            exit();
        }
        $get_ttd = mysqli_query($koneksi, "SELECT tanda_tangan FROM user WHERE id = $iduser");
        $data_ttd = mysqli_fetch_assoc($get_ttd);
        $file = $data_ttd['tanda_tangan'];
    }

    // ===== Upload File PDF Lampiran =====
    $folder = "lampiran_pdf/";
    $file_name = $_FILES['file_pdf']['name'];
    $file_tmp = $_FILES['file_pdf']['tmp_name'];
    $file_type = $_FILES['file_pdf']['type'];
    $file_size = $_FILES['file_pdf']['size'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!empty($file_name)) {
        if ($file_ext !== 'pdf' || $file_type !== 'application/pdf') {
            echo "<script> alert('Hanya file PDF yang diperbolehkan.');
                document.location='../index.php?page=pbn';</script>";
            exit();
        }

        if ($file_size > 3 * 1024 * 1024) {
            echo "<script> alert('Ukuran file melebihi batas maksimal 3MB.');
                document.location='../index.php?page=pbn';</script>";
            exit();
        }
    }

    $new_name = "lampiran_".uniqid() . ".pdf";
    $target_file = $folder . $new_name;
    move_uploaded_file($file_tmp, $target_file);    

    // ===== Simpan Data Permohonan Biaya =====
    $query = mysqli_query($koneksi, "INSERT INTO permohonanbiaya 
        VALUES (null, '$nopb', '$project', '$perihal', '$new_name', '$total', '$catatan', '$tglbuat', '$file', '', '', '', '$iduser','','','','', '')");

    $permohonan_id = mysqli_insert_id($koneksi);

    if ($query) {
        if (!empty($_POST['nama'])) {
            foreach ($_POST['nama'] as $i => $nama_item) {
                $kategori = $_POST['kategori'][$i];
                $volume   = $_POST['volume'][$i];
                $satuan   = $_POST['satuan'][$i];
                $harga_raw = str_replace(['Rp', '.', ',', ' '], '', $_POST['harga'][$i]);
                $harga     = (int)$harga_raw;
                $jumlah = $volume * $harga;

                $sql_detail = mysqli_query($koneksi, "INSERT INTO permohonan_detail 
                    VALUES (null, '$permohonan_id', '$kategori', '$nama_item', '$volume', '$satuan', '$harga','$jumlah')");
            }
        }
        echo "<script> alert('Simpan Data Berhasil!');
            document.location='../index.php?page=pbn';</script>";
    } else {
        echo "ERROR, data gagal diinput";
    }

} elseif(isset($_POST['submitpbap'])){

    // print_r($_POST);
    // exit();

    $id_user = $_POST['id_user'];
    $id_permohonan = $_POST['id_permohonan'];
    $kategori = $_POST['kategori'];
    $urgensi = $_POST['urgensi'];
    $biaya = $_POST['biaya'];
    $relevansi = $_POST['relevansi'];
    $nilai_akhir = $_POST['nilai_akhir'];
    $status = $_POST['status'];
    $ranking = $_POST['ranking'];
    $keterangan = $_POST['keterangan'] ?? [];

    // Ambil tanda tangan dari user
    $cek_ttd = mysqli_query($koneksi, "SELECT tanda_tangan FROM user WHERE id = $id_user");
    $data_ttd = mysqli_fetch_assoc($cek_ttd);
    $tanda_tangan_user = $data_ttd['tanda_tangan'] ?? null;

    $folderPath = "upload_ttd/";

    if (empty($tanda_tangan_user)) {
        // Jika belum ada tanda tangan di user, ambil dari form
        if (empty($_POST['signed1'])) {
            echo "Kosong";
            exit();
        } else {
            // Simpan file tanda tangan ke server
            $image_parts = explode(";base64,", $_POST['signed1']); 
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = $folderPath . "db-" . uniqid() . '.' . $image_type;
            file_put_contents($file, $image_base64);

            // Simpan base64 ke tabel user
            $base64_string = $_POST['signed1'];
            mysqli_query($koneksi, "UPDATE user SET tanda_tangan = '$base64_string' WHERE id = $id_user");

            $file = $base64_string;
        }
    } else {
        // Jika sudah ada tanda tangan di tabel user, gunakan langsung base64-nya
        $file = $tanda_tangan_user;
    }

    // Update keuangan di tabel permohonanbiaya
    $query = mysqli_query($koneksi, "UPDATE `permohonanbiaya` 
        SET `keuangan` = '$file', `idkeuangan` = '$id_user' 
        WHERE id = '$id_permohonan'");

    if($query){
        for ($i = 0; $i < count($kategori); $i++) {
            $kat = $kategori[$i];
            $urg = $urgensi[$i];
            $bio = $biaya[$i];
            $rel = $relevansi[$i];
            $nilai = $nilai_akhir[$i];
            $stat = $status[$i];
            $rank = $ranking[$i];
            $ket = isset($keterangan[$i]) ? $keterangan[$i] : null;
            
            // Simpan ke penilaian_kategori
            $sql1 = "INSERT INTO penilaian_kategori (id_permohonan, kategori, nilai_akhir, status, ranking, keterangan)
                    VALUES ('$id_permohonan', '$kat', '$nilai', '$stat', '$rank', '$ket')";
            mysqli_query($koneksi, $sql1);

            // Simpan ke penilaian_keuangan
            $sql2 = "INSERT INTO penilaian_keuangan (id_permohonan, kategori, urgensi, biaya, relevansi)
                    VALUES ('$id_permohonan', '$kat', '$urg', '$bio', '$rel')";
            mysqli_query($koneksi, $sql2);
        }
        echo "<script> alert('Simpan Data Berhasil!');
                document.location='../index.php?page=detailspbap&id=$id_permohonan';
                </script>";
    } else {
        echo "<script> alert('Data Gagal tersimpan!');
                document.location='../index.php?page=detailspbap&id=$id_permohonan';
                </script>";
    }
} elseif(isset($_POST['submitpbapd'])){
    
    // print_r($_POST);
    // exit();

    $id_user = $_POST['id_user'];
    $id_permohonan = $_POST['id_permohonan'];
    $revisi = $_POST['revisi'];
    $pakai_ttd = $_POST['pakai_ttd'] ?? 0;

    // Ambil tanda tangan dari user
    $cek_ttd = mysqli_query($koneksi, "SELECT tanda_tangan FROM user WHERE id = $id_user");
    $data_ttd = mysqli_fetch_assoc($cek_ttd);
    $tanda_tangan_user = $data_ttd['tanda_tangan'] ?? null;

    $folderPath = "upload_ttd/";

    // === ✅ KASUS 1: Jika pakai_ttd dicentang (pakai tanda tangan) ===
    if ($pakai_ttd == '1') {
        // Jika belum ada ttd, ambil dari form dan simpan
        if (empty($tanda_tangan_user) && !empty($_POST['signed1'])) {
            $image_parts = explode(";base64,", $_POST['signed1']); 
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = $folderPath . "db-" . uniqid() . '.' . $image_type;
            file_put_contents($file, $image_base64);

            // Simpan base64 ke tabel user
            $base64_string = $_POST['signed1'];
            mysqli_query($koneksi, "UPDATE user SET tanda_tangan = '$base64_string' WHERE id = $id_user");

            $file = $base64_string;
        } else {
            // Pakai tanda tangan yang sudah ada
            $file = $tanda_tangan_user;
        }

        // Update permohonanbiaya → simpan tanda tangan ke kolom direktur
        $query = mysqli_query($koneksi, "UPDATE permohonanbiaya 
            SET direktur = '$file', iddirektur = '$id_user' 
            WHERE id = '$id_permohonan'");

    // === ✅ KASUS 2: Jika tidak pakai ttd, tapi ada revisi ===
    } elseif (!empty($revisi)) {
        $query = mysqli_query($koneksi, "UPDATE permohonanbiaya 
            SET revisi = '$revisi', status = 'revisi' 
            WHERE id = '$id_permohonan'");
    }

    if($query){
        echo "<script> alert('Simpan Data Berhasil!');
                document.location='../index.php?page=detailspbap&id=$id_permohonan';
                </script>";
    } else {
        echo "<script> alert('Data Gagal tersimpan!');
                document.location='../index.php?page=detailspbap&id=$id_permohonan';
                </script>";
    }
} elseif(isset($_POST['revisipb'])){
    // print_r($_POST);
    // exit();
    $id_permohonan = $_POST['id_permohonan'];
    $project = $_POST['project'];
    $perihal = $_POST['perihal'];
    $catatan = $_POST['catatan'];
    $gtotal = $_POST['gtotal'];

    $id_detail = $_POST['id_detail'];
    $nama_item = $_POST['nama_item'];
    $volume = $_POST['volume'];
    $satuan = $_POST['satuan'];
    $harga = $_POST['harga'];

    $query = mysqli_query($koneksi, "UPDATE `permohonanbiaya` SET `project`='$project', `perihal`='$perihal', `total`='$gtotal', `keterangan`='$catatan',
    `status`='update' WHERE id='$id_permohonan'");

    if($query){
        // Validasi panjang array konsisten
        $count = count($id_detail);
        if ($count == count($nama_item) && $count == count($volume) && $count == count($satuan) && $count == count($harga)) {
            for ($i = 0; $i < $count; $i++) {
                $id = intval($id_detail[$i]);
                $nama = mysqli_real_escape_string($koneksi, $nama_item[$i]);
                $vol = floatval($volume[$i]);
                $sat = mysqli_real_escape_string($koneksi, $satuan[$i]);

                // Hapus format "Rp" dan titik pada harga
                $harga_clean = preg_replace('/[^0-9]/', '', $harga[$i]);
                $hrg = intval($harga_clean);

                $jumlah = $vol * $hrg;

                // Update query
                $query = "UPDATE permohonan_detail 
                        SET nama_item = '$nama',
                            volume = '$vol',
                            satuan = '$sat',
                            harga = '$hrg',
                            jumlah = '$jumlah'
                        WHERE id = '$id' AND permohonan_id = '$id_permohonan'";

                mysqli_query($koneksi, $query);
            }

            echo "<script> alert('Simpan Data Berhasil!');
                    document.location='../index.php?page=detailspb&id=$id_permohonan';
                    </script>";
        } else {
            echo "<script> alert('Data Gagal tersimpan!');
                    document.location='../index.php?page=detailspb&id=$id_permohonan';
                    </script>";
        }
    }
} elseif(isset($_POST['simpan_status'])){
    // print_r($_POST);
    // exit();
    $id_pb = mysqli_real_escape_string($koneksi, $_POST['id_pb']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status_proses']);

    // Simpan ke database (misalnya ke kolom `status_proses`)
    $update = mysqli_query($koneksi, "UPDATE permohonanbiaya SET dana='$status' WHERE id='$id_pb'");

    if ($update) {
        echo "<script> alert('Simpan Data Berhasil!');
                document.location='../index.php?page=historypbadm';
                </script>";
    } else {
        
        echo "<script> alert('Gagal Simpan Data');
                document.location='../index.php?page=historypbadm';
                </script>";
    }
}
?>