<?php header("Access-Control-Allow-Origin: *"); ?>
<?php 
    include "./connection.php";

    // Create connection object
    $mysqli = new mysqli($server, $id, $pw, $db);

    // Check for errors
    if ($mysqli->connect_errno) {
        echo "Gagal terhubung ke database MySQL: " . $mysqli->connect_error;
    }

    $kode_kab = addslashes(htmlentities($_GET['kode_kab']));

    $stmt = $mysqli->prepare("SELECT COUNT(*) AS jumlah_pasien FROM pasien WHERE id_kabupaten_kota_karantina = ?");
    $stmt->bind_param('i', $kode_kab);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
      
    echo $row['jumlah_pasien'];

    $stmt->close();

    // Close connection
    $mysqli->close();
?>
