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
        $provinces[] = $province;
    }

    echo json_encode($provinces);

    $stmt->close();

    // Close connection
    $mysqli->close();
?>
