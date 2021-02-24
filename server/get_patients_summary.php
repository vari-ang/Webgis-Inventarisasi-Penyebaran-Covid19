<?php header("Access-Control-Allow-Origin: *"); ?>
<?php 
    include "./connection.php";

    // Create connection object
    $mysqli = new mysqli($server, $id, $pw, $db);

    // Check for errors
    if ($mysqli->connect_errno) {
        echo "Gagal terhubung ke database MySQL: " . $mysqli->connect_error;
    }

    $results = [];

    $stmt = $mysqli->prepare("SELECT COUNT(*) AS total_penderita FROM pasien WHERE jenis='penderita'");
    $stmt->bind_param();
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $results['total_penderita'] = $row['total_penderita'];

    $stmt2 = $mysqli->prepare("SELECT COUNT(*) AS total_suspect FROM pasien WHERE jenis='suspect'");
    $stmt2->bind_param();
    $stmt2->execute();
    $res2 = $stmt2->get_result();
    $row2 = $res2->fetch_assoc();
    $results['total_suspect'] = $row2['total_suspect'];

    $datediff = round((time() - strtotime("2020-02-28")) / (60 * 60 * 24));
    $results['rata_penderita_per_hari'] = number_format((float)($row['total_penderita'] / $datediff), 3, '.', '');
    $results['rata_suspect_per_hari'] = number_format((float)($row2['total_suspect'] / $datediff), 3, '.', '');

    echo json_encode($results);

    $stmt->close();
    $stmt2->close();

    // Close connection
    $mysqli->close();
?>
