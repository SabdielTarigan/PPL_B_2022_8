<?php

use LDAP\Result;

 include('header.html') ?>

<?php
require_once('db_login.php');

//cek apakah user sudah submit form
if (isset($_POST['submit'])) {
    $submit = true;
    // Check if nama is empty
    if ($_POST['nama'] == '') {
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

    
  // If submit is true, insert the data
  if ($submit) {
    // Untuk membuat password dari nama depan
    // Pertama diambil kata pertama menggunakan fungsi explode, kemudian dijadikan huruf lowercase
    // Terakhir dilakukan hash untuk mengubah agar tidak eksplisit
    $password = hash('ripemd160', strtolower( explode(' ', $nama)[0] ) );

    // Melakukan query ke database untuk membuat user
    $query = "INSERT INTO user (username, password, role_id) VALUES ('$nim', '$password', '1')";
    
    $result = $db->query($query);
    if (!Result){
        die ("Could not query the database: <br />". $db->error);
    } else {
        if ($result->num_rows>0){ //login berhasil
            // Mendapatkan id user yang baru saja diinsert
            if ($db->query($query) === TRUE) {
              $user_id = $db->insert_id;
            }
            echo "Berhasil";
            header('Location: index.php');
        } else{ //login gagal
            echo '<span class="error">Combination of username and password are not correct.</span>';
        } 
    }

}

?>

<html>
<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Generate an Account!</h1>
                            </div>
                            <form class="user" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                <!-- <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="firstName"
                                            placeholder="Nama Awal">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="lastName"
                                            placeholder="Nama Akhir">
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <input type="nama" class="form-control form-control-user" id="nama"
                                    name="nama"
                                        placeholder="Nama Lengkap"
                                        value="<?php if(isset($nama)) echo $nama; ?>"
                                        >
                                        <div class="text-danger"> <?php if(isset($error_nama)) echo $error_nama;?></div>
                                </div>
                                <div class="form-group">
                                    <input type="nim" class="form-control form-control-user" id="nim" name="nim"
                                        placeholder="Masukkan NIM"
                                        value="<?php if(isset($username)) echo $username;?>"
                                        >
                                    <div class="text-danger"> <?php if(isset($error_nim)) echo $error_nim;?></div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block" name="submit" value="submit" id="submit">Generate Account</button>
                                <!-- <a href="index.php" class="btn btn-primary btn-user btn-block
                                type="submit" name="submit" value="submit"
                                >
                                    Generate Account
                                </a> -->
                                <hr>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="index.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
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