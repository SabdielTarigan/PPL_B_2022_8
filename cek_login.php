<?php

session_start();
include 'db_login.php';

// $email = $_POST['email'];
// $password = $_POST['password'];
// $query = mysqli_query($db, "SELECT * FROM user WHERE email='$email' AND password='$password'"); 
// $countdata = mysqli_num_rows($query);
//$data = mysqli_fetch_array($query);
?>

<?php
if(isset($_POST['loginbtn'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = mysqli_query($db, "SELECT * FROM user WHERE email='$email' AND password='$password'"); 
    $countdata = mysqli_num_rows($query);
    if($countdata > 0){ 
        $data = mysqli_fetch_assoc($query);
        //$_SESSION['email'] = $email;
        // $_SESSION['login'] = true;
        //echo '<script>window.location="../Mahasiswa/dash_mhs.php"</script>';      
        if($data['level']=="operator"){
            // buat session login dan email
            $_SESSION['email'] = $email;
            $_SESSION['level'] = "operator";
            // alihkan ke halaman dashboard operator
            header("location:../Operator/dash_operator.php");
    
        // cek jika user login sebagai pegawai
        }else if($data['level']=="mahasiswa"){
            // buat session login dan email
            $_SESSION['email'] = $email;
            $_SESSION['level'] = "mahasiswa";
            // alihkan ke halaman dashboard pegawai
            header("location:../Mahasiswa/dash_mhs.php");
    
        // cek jika user login sebagai doswal
        }else if($data['level']=="dosen"){
            // buat session login dan email
            $_SESSION['email'] = $email;
            $_SESSION['level'] = "dosen";
            // alihkan ke halaman dashboard doswal
            header("location:../Doswal/dash_doswal.php");
    
        }else if($data['level']=="departemen"){
            // buat session login dan email
            $_SESSION['email'] = $email;
            $_SESSION['level'] = "departemen";
            // alihkan ke halaman dashboard dept
            header("location:../Departemen/dash_dept.php");
        }
        }else{
            header("location:login.php?pesan=gagal");
            exit();
        }
    }else{
        header("location:login.php");
    }
?>




