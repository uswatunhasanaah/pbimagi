<?php

include "koneksi.php";
session_start();

// print_r($_POST); exit();

$username = $_POST['username'];
$password = $_POST['password'];

$login1 = mysqli_query($koneksi,"SELECT * FROM user
WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($login1);

// cek apakah username dan password di temukan pada database
if($cek > 0){

   $data = mysqli_fetch_assoc($login1);
   $nama = $data['nama'];
   $username = $data['username'];
   $level = $data['level'];
   $id = $data['id'];

   // cek jika user login
   if($data['level'] == 'Staff'){
    // buat session login dan username
      $_SESSION['username'] = $username;
      $_SESSION['nama'] = $nama;
      $_SESSION['level'] = $level;
      $_SESSION['id'] = $id;
      
      header('location:../index.php?page=home');
   } elseif($data['level'] == 'Manager Keuangan'){
      // buat session login dan username
      $_SESSION['username'] = $username;
      $_SESSION['nama'] = $nama;
      $_SESSION['level'] = $level;
      $_SESSION['id'] = $id;
      
      header('location:../index.php?page=home');
   } elseif($data['level'] == 'Direktur'){
      // buat session login dan username
      $_SESSION['username'] = $username;
      $_SESSION['nama'] = $nama;
      $_SESSION['level'] = $level;
      $_SESSION['id'] = $id;
      
      header('location:../index.php?page=home');
   } else{
      header("Location:../index.php?page=home?error=Data Tidak Ditemukan");
   } 
}else{
      header("Location:../login.php?error=Data Tidak Ditemukan");
}
?>