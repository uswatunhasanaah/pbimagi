<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin ImagiCreative</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/iac.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">
   
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
    <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
   
    <script type="text/javascript" src="js/jquery.signature.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.signature.css">
   
    <style>
        .kbw-signature { width: 200px; height: 200px;}
        #sig canvas{
            width: 100% !important;
            height: auto;
        }
    </style>
   
</head>
<body>
   
<div class="container">
   
    <form method="POST" action="simpan_ttd.php">
   
        <h1>Tanda Tangan Touch Screen HTML</h1>
   
        <div class="col-md-12">
            <label class="" for="">Tanda Tangan:</label>
            <br/>
            <div id="sig" ></div>
            <br/>
            <button id="clear">Hapus Tanda Tangan</button>
            <textarea id="signature64" name="signed" style="display: none"></textarea>
        </div>
   
        <br/>
        <button class="btn btn-success">Submit</button>
    </form>
   
</div>
   
<script type="text/javascript">
    var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });
</script>
</body>
</html>