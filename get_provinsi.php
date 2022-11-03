<?php
require_once 'db_login.php';

// Get all provinsi from table provinsi and echo the result
$query = "SELECT * FROM provinsi";
$result = $db->query($query);
if (!$result) {
  die("Could not query the database: <br/>" . $db->error);
} else {
  echo "<option disabled selected value=''>Pilih Provinsi</option>";
  while ($row = $result->fetch_object()) {
    echo "<option value='" . $row->id . "'>" . $row->nama . "</option>";
  }
}
