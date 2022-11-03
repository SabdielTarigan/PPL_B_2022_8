<?php include('header.html') ?>

<?php
session_start(); //inisialisasi session
require_once 'db_login.php';
$nim = $_SESSION['username']; 

// Check if already submit the form
if (isset($_POST['submit'])) {
  $submit = true;
  // Check if nama is empty
  if (empty($_POST['nama'])) {
    $error_nama = "Nama tidak boleh kosong";
    $submit = false;
  } else {
    $nama = $db->real_escape_string(trim($_POST['nama']));
  }

  // Check if nim is empty
  if (empty($_POST['nim'])) {
    $error_nim = "NIM tidak boleh kosong";
    $submit = false;
  } else {
    $nim = $db->real_escape_string(trim($_POST['nim']));
  }

  // Check if angkatan is empty
  if (empty($_POST['angkatan'])) {
    $error_angkatan = "Tahun Angkatan tidak boleh kosong";
    $submit = false;
  } else {
    $angkatan = $db->real_escape_string(trim($_POST['angkatan']));
  }
  // Check if status_mhs is empty
  if (empty($_POST['status_mhs'])) {
    $error_status_mhs = "Wajib isi, tidak boleh kosong";
    $submit = false;
  } else {
    $status_mhs = $db->real_escape_string(trim($_POST['status_mhs']));
  }

  // Check if nip is empty
  if (empty($_POST['nip'])) {
    $error_nip = "Dosen Wali tidak boleh kosong";
    $submit = false;
  } else {
    $nip = $db->real_escape_string(trim($_POST['nip']));
  }

    // Check if hp is empty
    if (empty($_POST['hp'])) {
      $error_hp = "Nomor HP tidak boleh kosong";
      $submit = false;
    } else {
      $hp = $db->real_escape_string(trim($_POST['hp']));
    }

  // Check if email is empty
  if (empty($_POST['email'])) {
    $error_email = "Email tidak boleh kosong";
    $submit = false;
  } else {
    // Check email is valid
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $error_email = "Email tidak valid";
      $submit = false;
    } else {
      $email = $db->real_escape_string(trim($_POST['email']));
      // Check if email is already registered
      $query = "SELECT * FROM mhs WHERE email = '$email'";
      $result = $db->query($query);
      if ($result->num_rows > 0) {
        $error_email = "Email sudah terdaftar";
        $submit = false;
      }
    }
  }

  // Check if alamat is empty
  if (empty($_POST['alamat'])) {
    $error_alamat = "Alamat tidak boleh kosong";
    $submit = false;
  } else {
    $alamat = $db->real_escape_string(trim($_POST['alamat']));
  }

  // Check if provinsi is empty
  if (empty($_POST['provinsi'])) {
    $error_provinsi = "Provinsi tidak boleh kosong";
    $submit = false;
  } else {
    $provinsi = $db->real_escape_string(trim($_POST['provinsi']));
  }

  // Check if kabupaten is empty
  if (empty($_POST['kabupaten'])) {
    $error_kabupaten = "Kabupaten tidak boleh kosong";
    $submit = false;
  } else {
    $kabupaten = $db->real_escape_string(trim($_POST['kabupaten']));
  }

  // If submit is true, insert the data
  if ($submit) {

    // Membuat data mahasiswa yang sudah tersambung ke user_id
    $query = "INSERT INTO mhs (foto, nama, nim, angkatan, id_status_mhs, nip, hp, email, alamat, id_provinsi, id_kabupaten) VALUES ('$namefile', '$nama', '$nim', '$angkatan', '$status_mhs', '$nip', '$hp', '$email', '$alamat', $provinsi, $kabupaten)";
    
    $result = $db->query($query);

    if (!$result) {
      $success = false;
      $error_message = "Gagal menyimpan!";
    } else {
      $success = true;
      // Clear all the input
      $nama = "";
      $nim = "";
      $angkatan = "";
    }

    $db->close();
  }
}


?>

<body id="page-top" onload="getProvinsi()">
    
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
              <!-- General Form Elements -->
              <!-- General Form Elements -->
              <div class="card">
                <!-- If there is success variable, show message -->
                <?php if (isset($success)) : ?>
                  <?php if ($success) : ?>
                    <div class="alert alert-success" role="alert">
                      Berhasil mendaftar
                    </div>
                  <?php else : ?>
                    <div class="alert alert-danger" role="alert">
                      <?php echo $error_message ?>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>

                <div class="card-header">Masukkan Data Diri</div>
                <div class="card-body">
                  <!-- /* TODO definisikan method dan actions */ -->
                  <form name="daftar" method="POST" action="">
                    
                    <div class="row mb-3">
                      <label for="name" class="col-sm-2 col-form-label">Nama Lengkap</label>
                      <div class="col-sm-10">                        
                        <input type="text" name="nama" id="nama" class="form-control" value="<?php if (isset($nama)) echo $nama; ?>">
                        <div id="error_name" style="color: red;">
                          <?php if (isset($error_nama))  echo $error_nama ?>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                      <div class="col-sm-10">                        
                        <input type="text" name="nim" id="nim" class="form-control" value="<?php if (isset($nim)) echo $nim; ?>">
                        <!-- <div id="error_name" style="color: red;">
                          <?php if (isset($error_nim))  echo $error_nim ?>
                        </div> -->
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="angkatan" class="col-sm-2 col-form-label">Angkatan</label>
                      <div class="col-sm-10">  
                        <input type="text" name="angkatan" id="angkatan" class="form-control" value="<?php if (isset($angkatan)) echo $angkatan; ?>">
                        <div id="error_name" style="color: red;">
                          <?php if (isset($error_angkatan))  echo $error_angkatan ?>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="angkatan" class="col-sm-2 col-form-label">Angkatan</label>
                      <div class="col-sm-10">  
                        <input type="text" name="angkatan" id="angkatan" class="form-control" value="<?php if (isset($angkatan)) echo $angkatan; ?>">
                        <div id="error_name" style="color: red;">
                          <?php if (isset($error_angkatan))  echo $error_angkatan ?>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="angkatan" class="col-sm-2 col-form-label">Angkatan</label>
                      <div class="col-sm-10">  
                        <input type="text" name="angkatan" id="angkatan" class="form-control" value="<?php if (isset($angkatan)) echo $angkatan; ?>">
                        <div id="error_name" style="color: red;">
                          <?php if (isset($error_angkatan))  echo $error_angkatan ?>
                        </div>
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
                    <a class="btn btn-primary" href="logout.php">Logout</a>
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