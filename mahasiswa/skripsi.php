<?php
session_start(); //inisialisasi session
require_once 'db_login.php';
$nim = $_SESSION['username']; 

if (isset($_POST['submit'])) {
    $submit = true;
    // Check if id_status is empty
    if (empty($_POST['id_status'])) {
      $error_id_status = "Semester tidak boleh kosong";
      $submit = false;
    } else {
      $id_status = $db->real_escape_string(trim($_POST['id_status']));
    }
  
    // Check if nilai is empty
    if (empty($_POST['nilai'])) {
      $error_nilai = "nilai tidak boleh kosong";
      $submit = false;
    } else {
      $nilai = $db->real_escape_string(trim($_POST['nilai']));
    }
  
    // If submit is true, insert the data
    if ($submit) {
  
      // Membuat data mahasiswa yang sudah tersambung ke user_id
      $query = "INSERT INTO skripsi (nim, id_status, nilai) VALUES ('$nim', '$id_status', '$nilai')";
  
      $result = $db->query($query);
  
      if (!$result) {
        $success = false;
        $error_message = "Gagal menyimpan!";
      } else {
        $success = true;
        // Clear all the input
        $id_status = "";
        $nilai = "";
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
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <!-- script icon -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</head>

<body id="page-top">

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
                <a class="nav-link" href="index.php">
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

                    <div class="card-header">Masukkan Data Skripsi</div>
                    <div class="card-body">
                    <!-- /* TODO definisikan method dan actions */ -->
                    <form name="daftar" method="POST" action="">
                        
                    <div class="row mb-3">
                    <label for="inputJalur" class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="id_status" name="id_status">
                            <option value="" selected>Pilih Status</option>
                            <option value="1">Belum Ambil</option>
                            <option value="2">Sedang Ambil</option>
                            <option value="3">Lulus</option>
                        </select>
                    </div>
                    </div>             
                    <div class="row mb-3">
                    <label for="inputJalur" class="col-sm-2 col-form-label">Nilai Skripsi</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="nilai" name="nilai">
                            <option value="">Pilih Nilai</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                        </select>
                    </div>
                    </div>
                    <div class="row mb-3">
                    <label for="inputNumber" class="col-sm-2 col-form-label">Scan Berita Acara</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="file" id="scan" name="scan">
                    </div>
                    </div>

                    <br>
                    <button type="submit" name="submit" id="submit" value="submit" class="btn btn-primary container-fluid">Simpan</button>
                  </form>
                </div>
              </div>

                    

                    <!-- Page Heading -->
              <!-- General Form Elements -->
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
                        <span aria-hidden="true">??</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="index.php">Logout</a>
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