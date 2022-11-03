<?php include('header.html') ?>

<?php
/*TODO: buat 
1. server side validation
2. insert new user
3. tampilkan hasilnya error/berhasil */

require_once 'db_login.php';

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
    // Untuk membuat password dari nama depan
    // Pertama diambil kata pertama menggunakan fungsi explode, kemudian dijadikan huruf lowercase
    // Terakhir dilakukan hash untuk mengubah agar tidak eksplisit
    $password = hash('ripemd160', strtolower( explode(' ', $nama)[0] ) );

    // Melakukan query ke database untuk membuat user
    $query = "INSERT INTO user (username, password, role_id) VALUES ('$nim', '$password', '1')";

    // Mendapatkan id user yang baru saja diinsert
    if ($db->query($query) === TRUE) {
      $user_id = $db->insert_id;
    }

    // Membuat data mahasiswa yang sudah tersambung ke user_id
    $query = "INSERT INTO mhs (nama, nim, angkatan, id_status_mhs, hp, email, alamat, id_provinsi, id_kabupaten, user_id) VALUES ('$nama', '$nim', '$angkatan', '$status_mhs', '$hp', '$email', '$alamat', $provinsi, $kabupaten, $user_id)";

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

  <div class="card-header">Form Input Pendaftaran</div>
  <div class="card-body">
    <!-- /* TODO definisikan method dan actions */ -->
    <form name="daftar" method="POST" action="">
      <div class="form-group">
        <label for="name">Nama Lengkap</label>
        <input type="text" name="nama" id="nama" class="form-control" value="<?php if (isset($nama)) echo $nama; ?>">
        <div id="error_name" style="color: red;">
          <?php if (isset($error_nama))  echo $error_nama ?>
        </div>
      </div>
      <div class="form-group">
        <label for="nim">NIM</label>
        <input type="text" name="nim" id="nim" class="form-control" value="<?php if (isset($nim)) echo $nim; ?>">
        <div id="error_name" style="color: red;">
          <?php if (isset($error_nim))  echo $error_nim ?>
        </div>
      </div>
      <div class="form-group">
        <label for="angkatan">Angkatan</label>
        <input type="text" name="angkatan" id="angkatan" class="form-control" value="<?php if (isset($angkatan)) echo $angkatan; ?>">
        <div id="error_name" style="color: red;">
          <?php if (isset($error_angkatan))  echo $error_angkatan ?>
        </div>
      </div>
      
      <!-- get status -->
      <div class="form-group">
        <label for="status_mhs">Status Mahasiswa</label>
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
      
      <div class="form-group">
        <label for="hp">Nomor HP</label>
        <input type="text" name="hp" id="hp" class="form-control" value="<?php if (isset($hp)) echo $hp; ?>">
        <div id="error_name" style="color: red;">
          <?php if (isset($error_hp))  echo $error_hp ?>
        </div>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <!-- /* TODO buat cek email menggunakan ajax */ -->
        <input type="email" name="email" id="email" class="form-control" oninput="getUser()" value="<?php if (isset($email)) echo $email; ?>">
        <div id="error_email" style="color: red;">
          <?php if (isset($error_email))  echo $error_email ?>
        </div>
      </div>
      <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea name="alamat" id="alamat" rows="3" class="form-control"><?php if (isset($alamat)) echo $alamat; ?></textarea>
        <div id="error_alamat" style="color: red;">
          <?php if (isset($error_alamat))  echo $error_alamat ?>
        </div>
      </div>
      <div class="form-group">
        <label for="provinsi">Provinsi</label>
        <select onchange="getKabupaten()" name="provinsi" id="provinsi" class="form-control">
          <option value="">Pilih Provinsi</option>
          <!-- /* TODO tampilkan daftar provinsi menggunakan ajax */ -->
          <!-- DONE: Ditaruh di body onload -->
        </select>
        <div id="error_provinsi" style="color: red;">
          <?php if (isset($error_provinsi))  echo $error_provinsi ?>
        </div>
      </div>
      <div class="form-group">
        <label for="kabupaten">Kota/Kabupaten</label>
        <select name="kabupaten" id="kabupaten" class="form-control">
          <option value="">Pilih Kota/Kabupaten</option>
          <!-- /* TODO tampilkan daftar kabupaten berdasarkan pilihan provinsi sebelumnya, menggunakan ajax*/ -->
          <!-- DONE: onchange bagian provinsi -->
        </select>
        <div id="error_kabupaten" style="color: red;">
          <?php if (isset($error_kabupaten))  echo $error_kabupaten ?>
        </div>
      </div>
      <br>
      <button type="submit" name="submit" id="submit" value="submit" class="btn btn-primary container-fluid">Daftar</button>
    </form>
  </div>
</div>