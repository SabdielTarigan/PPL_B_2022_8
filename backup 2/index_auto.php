<?php
session_start(); //inisialisasi session
require_once('db_login.php');

//cek apakah user sudah submit form
if (isset($_POST["submit"])){
    $valid = TRUE; //flag validasi

    //cek validasi username
    $username = test_input($_POST['username']);
    if ($username == ''){
        $error_username = "username is required";
        $valid = FALSE;
    }

    //cek validasi password
    $password = test_input($_POST['password']);
    if ($password == ''){
        $error_password = "Password is required";
        $valid = FALSE;
    } else {
        $verify_pass = hash('ripemd160', $password);
    }
       

    //cek validasi
    if ($valid){
        //asign a query
        $query = mysqli_query($db, " SELECT * FROM user WHERE username='".$username."' AND password='".$verify_pass."' ");
        $countdata = mysqli_num_rows($query);
        
        //excute the query
        // $result = $db->query($query);
        if ($countdata > 0){
            die ("Could not query the database: <br />". $db->error);
        } else{
            $_SESSION['username'] = $username;
            // header('Location: data-diri.php');
            $data = mysqli_fetch_assoc($query);

            if($data['role_id'] === "1"){
                // buat session login dan id
                $_SESSION['id'] = $id;
                $_SESSION['role_id'] = "mahasiswa";
                // alihkan ke halaman dashboard pegawai
                header("location:../mahasiswa/data-diri.php");
            }
 

            exit;
        }
        //close db connection
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
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

		<!-- Custom styles for this template-->
		<link href="css/sb-admin-2.css" rel="stylesheet">

		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
		<title>Input Pendaftaran</title>
		<script type="text/javascript" src="ajax.js"></script>

		<body onload="getProvinsi()"></body>

	</head>

<body class="bg-gradient-primary sidebar-toggled">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Hai Siap2 Ya..</h1>
                                    <div id="error" class="text-danger">
                                        <?php if (isset($error)) echo $error; ?>
                                    </div>
                                    </div>
                                        <form method="POST" autocomplete="on" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="username" class="form-control" id="username" name="username" size="30" value="<?php if(isset($username)) echo $username;?>">
                                                <div class="text-danger"><?php if(isset($error_username)) echo $error_username;?></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" size="30" value="">
                                                <div class="text-danger"><?php if(isset($error_password)) echo $error_password;?></div>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-user btn-block" name="submit" value="submit">Login</button>
                                            <!-- <a class="btn btn-primary btn-user btn-block" type="submit" name="submit" value="submit">Login</a> -->
                                        </form>
                                    
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Lupa Sandi?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Buat Akun</a>
                                    </div>
                                </div>
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
    <script src="js/sb-admin-2.js"></script>









</body>

</html>