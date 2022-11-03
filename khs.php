<?php
session_start(); //inisialisasi session
require_once 'db_login.php';
$nim = $_SESSION['username']; 

// Check if already submit the form
if (isset($_POST['submit'])) {
  $submit = true;
  // Check if smt is empty
  if (empty($_POST['smt'])) {
    $error_smt = "Semester tidak boleh kosong";
    $submit = false;
  } else {
    $smt = $db->real_escape_string(trim($_POST['smt']));
  }

  // Check if sks is empty
  if (empty($_POST['sks'])) {
    $error_sks = "SKS tidak boleh kosong";
    $submit = false;
  } else {
    $sks = $db->real_escape_string(trim($_POST['sks']));
  }

  // Check if sks_kumulatif is empty
  if (empty($_POST['sks_kumulatif'])) {
    $error_sks_kumulatif = "SKS Kumulatif tidak boleh kosong";
    $submit = false;
  } else {
    $sks_kumulatif = $db->real_escape_string(trim($_POST['sks_kumulatif']));
  }

  // Check if ip is empty
  if (empty($_POST['ip'])) {
    $error_ip = "IP tidak boleh kosong";
    $submit = false;
  } else {
    $ip = $db->real_escape_string(trim($_POST['ip']));
  }
  // Check if ipk is empty
  if (empty($_POST['ipk'])) {
    $error_ipk = "ipk tidak boleh kosong";
    $submit = false;
  } else {
    $ipk = $db->real_escape_string(trim($_POST['ipk']));
  }

  // If submit is true, insert the data
  if ($submit) {

    // Membuat data mahasiswa yang sudah tersambung ke user_id
    $query = "INSERT INTO khs (nim, smt, sks, sks_kumulatif, ip, ipk) VALUES ('$nim', '$smt', '$sks','$sks_kumulatif', '$ip', '$ipk')";

    $result = $db->query($query);

    if (!$result) {
      $success = false;
      $error_message = "Gagal menyimpan!";
    } else {
      $success = true;
      // Clear all the input
      $smt = "";
      $sks = "";
      $sks_kumulatif = "";
      $ip = "";
      $ipk = "";

    }

    $db->close();
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SIAP-SIAP</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <!-- script icon -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include('nav.html'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include('header.html'); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
              <!-- General Form Elements -->
                <div class="card">
                  <!-- If there is success variable, show message -->
                  <?php if (isset($success)) : ?>
                    <?php if ($success) : ?>
                      <div class="alert alert-success" role="alert">
                        Berhasil Menambahkan
                      </div>
                    <?php else : ?>
                      <div class="alert alert-danger" role="alert">
                        <?php echo $error_message ?>
                      </div>
                    <?php endif; ?>
                  <?php endif; ?>

                  <div class="card-header">Masukkan Data KHS</div>
                  <div class="card-body">
                    <!-- /* TODO definisikan method dan actions */ -->
                    <form name="daftar" method="POST" action="">
                        
                      <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Semester</label>
                            <div class="col-sm-10">                        
                                <input type="text" name="smt" id="smt" class="form-control" value="<?php if (isset($smt)) echo $smt; ?>">
                                <div id="error_name" style="color: red;">
                                  <php if (isset($error_smt))  echo $error_smt ?>  
                              </div>
                          </div>
                      </div>
                      <div class="row mb-3">
                        <label for="sks" class="col-sm-2 col-form-label">SKS Semester</label>
                        <div class="col-sm-10">                        
                            <input type="text" name="sks" id="sks" class="form-control" value="<?php if (isset($sks)); ?>">
                            <!-- <div id="error_name" style="color: red;">
                                <?php if (isset($error_sks))  echo $error_sks ?>
                              </div> -->
                          </div>
                      </div>

                      <div class="row mb-3">
                          <label for="name" class="col-sm-2 col-form-label">SKS Kumulatif</label>
                          <div class="col-sm-10">                        
                                <input type="text" name="sks_kumulatif" id="sks_kumulatif" class="form-control" value="<?php if (isset($sks_kumulatif)) echo $sks_kumulatif; ?>">
                                <div id="error_name" style="color: red;">
                                  <php if (isset($error_sks_kumulatif))  echo $error_sks_kumulatif ?>  
                          </div>
                          </div>
                      </div>
                      <div class="row mb-3">
                        <label for="ip" class="col-sm-2 col-form-label">IP Semester</label>
                        <div class="col-sm-10">                        
                            <input type="text" name="ip" id="ip" class="form-control" value="<?php if (isset($ip)); ?>">
                            <!-- <div id="error_name" style="color: red;">
                                <?php if (isset($error_ip))  echo $error_ip ?>
                              </div> -->
                      </div>
                      </div>
                      <div class="row mb-3">
                        <label for="ipk" class="col-sm-2 col-form-label">IP Kumulatif</label>
                        <div class="col-sm-10">                        
                            <input type="text" name="ipk" id="ipk" class="form-control" value="<?php if (isset($ipk)); ?>">
                            <!-- <div id="error_name" style="color: red;">
                                <?php if (isset($error_ipk))  echo $error_ipk ?>
                              </div> -->
                          </div>
                      </div>


                      <div class="row mb-3" action="upload.php" method="post" enctype="multipart/form-data">
                        <label for="inputNumber" class="col-sm-2 col-form-label">Upload Foto</label>
                        <div class="col-sm-10">
                          <input class="form-control" type="file" id="formFile">
                        </div>
                      </div>

                      
                      <br>
                      <button type="submit" name="submit" id="submit" value="submit" class="btn btn-primary container-fluid">Simpan</button>
                    </form>
                  </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>