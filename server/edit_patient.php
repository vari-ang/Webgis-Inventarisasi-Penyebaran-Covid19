<?php header("Access-Control-Allow-Origin: *"); ?>
<?php
    // Get input
    $patientId = addslashes(htmlentities($_POST['patient_id']));
    $patientType = addslashes(htmlentities($_POST['input-patient-type']));
    $name = addslashes(htmlentities($_POST['input-name'])); 
    $ktp = addslashes(htmlentities($_POST['input-ktp']));
    $address = addslashes(htmlentities($_POST['input-address']));
    $files = $_FILES["input-photo"];
    $sickComplaint = addslashes(htmlentities($_POST['input-sick-complaint']));
    $travelHistory = addslashes(htmlentities($_POST['input-travel-history']));
    $is_changedate = $_POST['is_changedate'];
    $tanggal = addslashes(htmlentities($_POST['datetime_added']));
    
    include "./connection.php";

    $is_error = false;

    // Create connection object
    $mysqli = new mysqli($server, $id, $pw, $db);

    // Check for connection error
    if ($mysqli->connect_errno) {
        $is_error = true;
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    }   

    if($is_changedate === "true") { $tanggal = date('Y-m-d H:i:s'); }

    // If photo is not change by admin
    if($files["size"][0] === 0) {
        $stmt = $mysqli->prepare("UPDATE pasien SET nama=?, no_ktp=?, alamat=?, jenis=?, keluhan_sakit=?, riwayat_perjalanan=?, tanggal=? WHERE id=?");
        $stmt->bind_param('ssssssss', $name, $ktp , $address, $patientType, $sickComplaint, $travelHistory, $tanggal, $patientId);

        if(!$stmt->execute()) {
            $is_error = true;
            echo "Terjadi kendala menyimpan perubahan data";
        }
        $stmt->close();
    }
    else {
        // Loop gambar yang diinputkan
        foreach($files['name'] as $key => $photo_name) {
            // Jika tidak ada error
            if($files['error'][$key] == 0) {
                $file_info = getimagesize($files['tmp_name'][$key]);
                if(!empty($file_info)) {
                    $ext = substr($photo_name, strrpos($photo_name, '.') + 1);
                    $filename = strtotime("now") . '.' . $ext;
                
                    $stmt = $mysqli->prepare("UPDATE pasien
                                            SET nama=?, no_ktp=?, alamat=?, foto=?, jenis=?, keluhan_sakit=?, riwayat_perjalanan=?, tanggal=?
                                            WHERE id=?");
                    $stmt->bind_param('sssssssss', $name, $ktp , $address, $filename, $patientType, $sickComplaint, $travelHistory, $tanggal, $patientId);
                    
                    if($stmt->execute()) {
                        $destination = "../resources/foto_pasien/" . $filename;

                        // Pindahkan gambar ke folder "posting/"
                        if(!move_uploaded_file($files['tmp_name'][$key], $destination)) {
                            $is_error = true;
                            echo "Aduh! Foto yang Anda kirim gagal diupload :(";
                        }
                    }
                    else {
                        $is_error = true;
                        echo "Terjadi kendala menyimpan data ke database";
                    }

                    $stmt->close();
                }
                else {
                    $is_error = true;
                    echo "Foto yang Anda upload nampaknya bukan sebuah gambar.";
                }
            }
            else {
                $is_error = true;
                echo "Oops! Terdapat error pada saat upload. Silahkan coba lagi.";
            }
        }
    }

    if(!$is_error) {
        echo "SUCCESS";
    }

    /* close connection */
    $mysqli->close();
?>