<?php header("Access-Control-Allow-Origin: *"); ?>
<?php
    // Get input
    $patientId = addslashes(htmlentities($_POST['patient_id']));
    
    include "./connection.php";

    $is_error = false;

    // Create connection object
    $mysqli = new mysqli($server, $id, $pw, $db);

    // Check for connection error
    if ($mysqli->connect_errno) {
        $is_error = true;
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    }    

    $stmt = $mysqli->prepare("DELETE FROM pasien WHERE id=?");
    $stmt->bind_param('i', $patientId);

    if(!$stmt->execute()) {
        $is_error = true;
        echo "Terjadi kendala menghapus data";
    }
    $stmt->close();
    
    if(!$is_error) {
        echo "SUCCESS";
    }

    /* close connection */
    $mysqli->close();
?>