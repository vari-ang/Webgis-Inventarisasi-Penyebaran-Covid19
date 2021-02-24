<?php header("Access-Control-Allow-Origin: *"); ?>
<?php
    // Get input
    $patientType = addslashes(htmlentities($_POST['input-patient-type']));
    $name = addslashes(htmlentities($_POST['input-name'])); 
    $ktp = addslashes(htmlentities($_POST['input-ktp']));
    $address = addslashes(htmlentities($_POST['input-address']));
    $files = $_FILES["input-photo"];
    $sickComplaint = addslashes(htmlentities($_POST['input-sick-complaint']));
    $travelHistory = addslashes(htmlentities($_POST['input-travel-history']));
    $quarantineProvinceId = addslashes(htmlentities($_POST['input-quarantine-provinces']));
    $quarantineDistrictId = addslashes(htmlentities($_POST['input-quarantine-districts']));
    $geom = addslashes(htmlentities($_POST['geom']));
    
    // Check for empty values
    if(empty($files['name'][0]) || empty($patientType) || empty($name) || empty($ktp) || empty($address) || empty($sickComplaint) || empty($travelHistory) || empty($quarantineProvinceId) || empty($quarantineDistrictId)) {
        // Show error message
        echo "Tolong Isi Semua Data Yang Diminta.";
    }
    else {
        include "./connection.php";

        $is_error = false;

        // Create connection object
        $mysqli = new mysqli($server, $id, $pw, $db);

        // Check for connection error
        if ($mysqli->connect_errno) {
            $is_error = true;
            echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        }

        // Loop gambar yang diinputkan
        foreach($files['name'] as $key => $photo_name) {
            // Jika tidak ada error
            if($files['error'][$key] == 0) {
                $file_info = getimagesize($files['tmp_name'][$key]);
                if(!empty($file_info)) {
                    $ext = substr($photo_name, strrpos($photo_name, '.') + 1);
                    $filename = strtotime("now") . '.' . $ext;

                    $stmt = $mysqli->prepare("INSERT INTO pasien(nama, no_ktp, alamat, foto, jenis, keluhan_sakit, riwayat_perjalanan, geom, id_propinsi_karantina, id_kabupaten_kota_karantina) 
                                                VALUES (?,?,?,?,?,?,?,?,?,?)");
                    $stmt->bind_param('ssssssssss', $name, $ktp , $address, $filename, $patientType, $sickComplaint, $travelHistory, $geom, $quarantineProvinceId, $quarantineDistrictId);
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

        if(!$is_error) {
            echo "SUCCESS";
        }

        /* close connection */
        $mysqli->close();
    }
?>