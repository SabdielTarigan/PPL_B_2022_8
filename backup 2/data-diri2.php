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
      $status_mhs = "";
      $nip = "";
      $hp = "";
      $email = "";
      $alamat = "";
      $provinsi = "";
      $kabupaten = "";
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
    <script type="text/javascript" src="ajax.js"></script>

</head>

<body id="page-top" onload="getProvinsi()">
    
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SIAP<sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="data-diri.php">
                    <span class="icon">
                        <ion-icon name="person"></ion-icon>
                    </span>
                    <span class="tittle">Data Diri</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="irs.php">
                    <span class="icon">
                        <ion-icon name="create"></ion-icon>
                    </span>
                    <span class="tittle">IRS</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="khs.php">
                    <span class="icon">
                        <ion-icon name="albums"></ion-icon>
                    </span>
                    <span class="tittle">KHS</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="pkl.php">
                    <span class="icon">
                        <ion-icon name="document-text"></ion-icon>
                    </span>
                    <span class="tittle">PKL</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="skripsi.php">
                    <span class="icon">
                        <ion-icon name="school"></ion-icon>
                    </span>
                    <span class="tittle">Skripsi</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item active">
                <a class="nav-link" href="logout.php">
                    <span class="tittle">Logout</span>
                </a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>



        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include('header.html'); ?>

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
                    <div class="row mb-3" action="upload.php" method="post" enctype="multipart/form-data">
                      <label for="inputNumber" class="col-sm-2 col-form-label">Upload Foto</label>
                      <div class="col-sm-10">
                        <input class="form-control" type="file" id="formFile">
                      </div>
                    </div>
                    
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
                        <input type="text" name="nim" id="nim" class="form-control" value="<?php if (isset($nim)) echo $nim; ?>" readonly>
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
                    
                    <!-- get status -->
                    <div class="row mb-3">
                      <label for="status_mhs" class="col-sm-2 col-form-label">Status Mahasiswa</label>
                      <div class="col-sm-10">  
                        <select name="status_mhs" id="status_mhs" class="form-control">
                          <option value="">Pilih Status</option>
                          <?php 
                          $query = "SELECT * FROM status_mhs";
                          $result = $db->query($query);
                          while ($row = $result->fetch_object()) {
                            echo "<option value='" . $row->id . "'>" . $row->status . "</option>";
                          }
                          ?>
                        </select>
                        <div id="error_status_mhs" style="color: red;">
                          <?php if (isset($error_status_mhs))  echo $error_status_mhs ?>
                        </div>
                      </div>
                    </div>

                    <!-- get dosen -->
                    <div class="row mb-3">
                      <label for="nip" class="col-sm-2 col-form-label">Dosen Wali</label>
                      <div class="col-sm-10">  
                        <select name="nip" id="nip" class="form-control">
                          <option value="">Pilih Dosen Wali</option>
                          <?php 
                          $query = "SELECT * FROM dosen";
                          $result = $db->query($query);
                          while ($row = $result->fetch_object()) {
                            echo "<option value='" . $row->nip . "'>" . $row->nama . "</option>";
                          }
                          ?>
                        </select>
                        <div id="error_nip" style="color: red;">
                          <?php if (isset($error_nip))  echo $error_nip ?>
                        </div>
                      </div>
                    </div>
                      
                      <div class="row mb-3">
                        <label for="hp" class="col-sm-2 col-form-label">Nomor HP</label>
                        <div class="col-sm-10">    
                          <input type="text" name="hp" id="hp" class="form-control" value="<?php if (isset($hp)) echo $hp; ?>">
                          <div id="error_name" style="color: red;">
                            <?php if (isset($error_hp))  echo $error_hp ?>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">    
                          <!-- /* TODO buat cek email menggunakan ajax */ -->
                          <input type="email" name="email" id="email" class="form-control" value="<?php if (isset($email)) echo $email; ?>">
                          <div id="error_email" style="color: red;">
                            <?php if (isset($error_email))  echo $error_email ?>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">    
                          <textarea name="alamat" id="alamat" rows="3" class="form-control"><?php if (isset($alamat)) echo $alamat; ?></textarea>
                          <div id="error_alamat" style="color: red;">
                            <?php if (isset($error_alamat))  echo $error_alamat ?>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="provinsi" class="col-sm-2 col-form-label">Provinsi</label>
                        <div class="col-sm-10">    
                          <select onchange="getKabupaten()" name="provinsi" id="provinsi" class="form-control">
                            <option value="">Pilih Provinsi</option>
                            <!-- /* TODO tampilkan daftar provinsi menggunakan ajax */ -->
                            <!-- DONE: Ditaruh di body onload -->
                          </select>
                          <div id="error_provinsi" style="color: red;">
                            <?php if (isset($error_provinsi))  echo $error_provinsi ?>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="kabupaten" class="col-sm-2 col-form-label">Kota/Kabupaten</label>
                        <div class="col-sm-10">    
                          <select name="kabupaten" id="kabupaten" class="form-control">
                          <option value="">Pilih Kota/Kabupaten</option>
                          <!-- /* TODO tampilkan daftar kabupaten berdasarkan pilihan provinsi sebelumnya, menggunakan ajax*/ -->
                          <!-- DONE: onchange bagian provinsi -->
                          </select>
                          <div id="error_kabupaten" style="color: red;">
                            <?php if (isset($error_kabupaten))  echo $error_kabupaten ?>
                          </div>
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

</html>