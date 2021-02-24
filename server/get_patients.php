<?php header("Access-Control-Allow-Origin: *"); ?>
<?php 
    include "./connection.php";

    // Create connection object
    $mysqli = new mysqli($server, $id, $pw, $db);

    // Check for errors
    if ($mysqli->connect_errno) {
        echo "Gagal terhubung ke database MySQL: " . $mysqli->connect_error;
    }

    $stmt = $mysqli->prepare("SELECT * FROM pasien");
    $stmt->bind_param();
    $stmt->execute();
    $res = $stmt->get_result();

    $patients = [];
    while($row = $res->fetch_assoc()) {
        $patient = [];
        $patient['id'] = $row['id'];
        $patient['nama'] = $row['nama'];
        $patient['no_ktp'] = $row['no_ktp'];
        $patient['alamat'] = $row['alamat'];
        $patient['foto'] = $row['foto'];
        $patient['jenis'] = $row['jenis'];
        $patient['keluhan_sakit'] = $row['keluhan_sakit'];
        $patient['riwayat_perjalanan'] = $row['riwayat_perjalanan'];
        $patient['geom'] = $row['geom'];
        $patient['id_propinsi_karantina'] = $row['id_propinsi_karantina'];
        $patient['id_kabupaten_kota_karantina'] = $row['id_kabupaten_kota_karantina'];

        // Get province
        $stmt2 = $mysqli->prepare("SELECT * FROM propinsi WHERE id=?");
        $stmt2->bind_param('i', $row['id_propinsi_karantina']);
        $stmt2->execute();
        $res2 = $stmt2->get_result();
        $row2 = $res2->fetch_assoc();
        $patient['nama_propinsi_karantina'] = $row2['nama'];

        // Get district
        $stmt3 = $mysqli->prepare("SELECT * FROM kabupaten_kota WHERE id=?");
        $stmt3->bind_param('i', $row['id_kabupaten_kota_karantina']);
        $stmt3->execute();
        $res3 = $stmt3->get_result();
        $row3 = $res3->fetch_assoc();
        $patient['nama_kabupaten_kota_karantina'] = $row3['nama'];

        $patient['tanggal'] = $row['tanggal'];
        $patients[] = $patient;
    }

    echo json_encode($patients);

    $stmt->close();

    // Close connection
    $mysqli->close();
?>
