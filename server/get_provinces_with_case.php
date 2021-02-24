<?php header("Access-Control-Allow-Origin: *"); ?>
<?php 
    include "./connection.php";

    // Create connection object
    $mysqli = new mysqli($server, $id, $pw, $db);

    // Check for errors
    if ($mysqli->connect_errno) {
        echo "Gagal terhubung ke database MySQL: " . $mysqli->connect_error;
    }

    $stmt = $mysqli->prepare("SELECT * FROM propinsi");
    $stmt->bind_param();
    $stmt->execute();
    $res = $stmt->get_result();

    $provinces = [];
    while($row = $res->fetch_assoc()) {
        $province = [];
        $province['id'] = $row['id'];
        $province['nama'] = $row['nama'];
        $province['lat'] = $row['lat'];
        $province['long'] = $row['long'];

        $stmt2 = $mysqli->prepare("SELECT COUNT(*) AS jumlah_pasien FROM pasien WHERE id_propinsi_karantina=?");
        $stmt2->bind_param('i', $row['id']);
        $stmt2->execute();
        $res2 = $stmt2->get_result();
        $row2 = $res2->fetch_assoc();

        $stmt3 = $mysqli->prepare("SELECT COUNT(*) AS jumlah_suspect FROM pasien WHERE jenis=? AND id_propinsi_karantina=?");
        $type = 'suspect';
        $stmt3->bind_param('si', $type, $row['id']);
        $stmt3->execute();
        $res3 = $stmt3->get_result();
        $row3 = $res3->fetch_assoc();

        $stmt4 = $mysqli->prepare("SELECT COUNT(*) AS jumlah_penderita FROM pasien WHERE jenis=? AND id_propinsi_karantina=?");
        $type = 'penderita';
        $stmt4->bind_param('si', $type, $row['id']);
        $stmt4->execute();
        $res4 = $stmt4->get_result();
        $row4 = $res4->fetch_assoc();

        $province['jumlah_pasien'] = $row2['jumlah_pasien'];
        $province['jumlah_suspect'] = $row3['jumlah_suspect'];
        $province['jumlah_penderita'] = $row4['jumlah_penderita'];
        $provinces[] = $province;
    }

    echo json_encode($provinces);

    $stmt->close();

    // Close connection
    $mysqli->close();
?>
