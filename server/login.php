<?php header("Access-Control-Allow-Origin: *"); ?>
<?php 
    include "./connection.php";

    // Create connection object
    $mysqli = new mysqli($server, $id, $pw, $db);

    // Check for errors
    if ($mysqli->connect_errno) {
        echo "Gagal terhubung ke database MySQL: " . $mysqli->connect_error;
    }

    // Get data
    $username = addslashes(htmlentities($_POST['username']));
    $password = addslashes(htmlentities($_POST['password']));

    $error = ""; // Error message

    // No null values
    if(empty($username) || empty($password)) {
        $error .= "Tolong Isi Semua Data Yang Diminta.";
    }
    else {
        $stmt = $mysqli->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $res = $stmt->get_result();
        
        // Jika login benar
        $row = $res->fetch_assoc();

        if($row) {
            // re-create final password from salt & typed password from user
            $md5_pass = md5($password);
            $combination = $md5_pass . $row["salt"];
            $final_password = md5($combination);

            // Jika hasil enkripsi password berbeda dengan yg ada di database
            if($final_password == $row["password"]) {
                echo "SUCCESS";
            }
            else {
                $error .= "Password salah. Silahkan coba lagi.";
            }
        }
        else {
            $error .= "Username tidak ditemukan. Silahkan coba lagi.";
        }
        $stmt->close();
    }

    echo $error;

    // Close connection
    $mysqli->close();
?>
