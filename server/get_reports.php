<?php header("Access-Control-Allow-Origin: *"); ?>
<?php 
    include "./connection.php";

    // Create connection object
    $mysqli = new mysqli($server, $id, $pw, $db);

    // Check for errors
    if ($mysqli->connect_errno) {
        echo "Gagal terhubung ke database MySQL: " . $mysqli->connect_error;
    }

    $months = ["Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    $selected_months = [];
    $total_supect = [];
    $total_sufferer = [];
    $results = [];

    for($i = 2; $i <= date('m'); $i++) {
        $stmt = $mysqli->prepare("SELECT COUNT(*) AS total_suspect FROM pasien WHERE jenis = ? AND MONTH(tanggal) = ?");
        $type = 'suspect';
        $stmt->bind_param('si', $type, $i);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();

        $stmt2 = $mysqli->prepare("SELECT COUNT(*) AS total_penderita FROM pasien WHERE jenis = ? AND MONTH(tanggal) = ?");
        $type = 'penderita';
        $stmt2->bind_param('si', $type, $i);
        $stmt2->execute();
        $res2 = $stmt2->get_result();
        $row2 = $res2->fetch_assoc();

        $selected_months[] = $months[$i-2];
        $total_supect[] = $row['total_suspect'];
        $total_sufferer[] = $row2['total_penderita'];
    }

    $results['label_bulan'] = $selected_months;
    $results['label_total_suspect'] = $total_supect;
    $results['label_total_penderita'] = $total_sufferer;

    echo json_encode($results);

    // Close connection
    $mysqli->close();
?>
