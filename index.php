<?php
  include 'config/koneksi.php';
  
  session_start();

  $nama = $_SESSION['nama'] ?? null;
  $username = $_SESSION['username'] ?? null;
  $level = $_SESSION['level'] ?? null;
  $id = $_SESSION['id'] ?? null;
  $page = (isset($_GET['page'])) ? $_GET['page'] : '';

  $request = $_SERVER['REQUEST_URI'];
//   echo $username;
  if(empty($_SESSION['nama'])){
    include 'login.php';
  } else {
    switch ($page) {
      case 'home':
        include 'home.php';
        break;
      case 'pbn':
        include 'formpbn.php';
        break;
      case 'appb':
        include 'approvalpb.php';
        break;
      case 'detailspb':
        include 'detailspb.php';
        break;
      case 'detailspbap':
        include 'detailspbap.php';
        break;
      case 'historypb':
        include 'history_pb.php';
        break;
      case 'statuspb':
        include 'statuspb.php';
        break;
      case 'historypbadm':
        include 'historypbadm.php';
        break;
      }
  }
?>