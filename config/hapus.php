<?php
include('koneksi.php');

if(!empty($_GET['idpb'])){ 

    $idpd   = $_GET['idpb'];

    $query = mysqli_query($koneksi, "DELETE from permohonanbiaya where id='$idpd'");

    if($query) {
        $query1 = mysqli_query($koneksi, "DELETE from permohonan_detail where permohonan_id='$idpd'");
        if($query1){
            $query2 = mysqli_query($koneksi, "DELETE from penilaian_keuangan where id_permohonan='$idpd'");
            if($query2){
                echo "<script> alert('Hapus Data Berhasil!');
                document.location='../index.php?page=statuspb';
                </script>";
            }
        }
    } else {
        echo
        "ERROR, data gagal dihapus" . mysqli_error($koneksi);
    }
}
?>