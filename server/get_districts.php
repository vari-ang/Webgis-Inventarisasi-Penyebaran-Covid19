<?php header("Access-Control-Allow-Origin: *"); ?>
<?php 
    include "./connection.php";

    // Create connection object
    $mysqli = new mysqli($server, $id, $pw, $db);

    // Check for errors
    if ($mysqli->connect_errno) {
        echo "Gagal terhubung ke database MySQL: " . $mysqli->connect_error;
    }

    $id_propinsi = addslashes(htmlentities($_POST['provinceId']));

    $stmt = $mysqli->prepare("SELECT * FROM kabupaten_kota WHERE id_propinsi = ?");
    $stmt->bind_param('i', $id_propinsi);
    $stmt->execute();
    $res = $stmt->get_result();

    $districts = [];
    while($row = $res->fetch_assoc()) {
        $district = [];
        $district['id'] = $row['id'];
        $district['nama'] = $row['nama'];
        $districts[] = $district;
    }

    echo json_encode($districts);

    $stmt->close();

    // Close connection
    $mysqli->close();
?>
