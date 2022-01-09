<!DOCTYPE html>
<html>
<head>
    <title>Upload</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>
<?php
require_once("navbar.php");
?>
<div class="container">

<?php
    require_once("connection.php");
    $target_dir = "uploads/";
    $target_file = $target_dir . time() . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;

    // Check if the file is a CSV file.
    $csv_mimetypes = array(
        'text/csv',
        'text/plain',
        'application/csv',
        'text/comma-separated-values',
        'application/excel',
        'application/vnd.ms-excel',
        'application/vnd.msexcel',
        'text/anytext',
        'application/octet-stream',
        'application/txt',
    );

    if(isset($_POST["submit"])) {
        // Check file size.
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Sorry, your file is too large.<br>";
            $uploadOk = 0;
        }
        //Check for CSV.
        if (in_array($_FILES['fileToUpload']['type'], $csv_mimetypes)) {
            echo "Uploaded File is CSV.<br>";
            $uploadOk = 1;
        }else{
            echo "Uploaded File is not CSV.<br>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.<br>";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file has been uploaded to " . $target_file . ".<br>";
            } else {
                echo "Sorry, there was an error uploading your file.<br>";
            }
        }


        $myFile = fopen($target_file, "r") or die("Unable to open file!");
        // Read each line.
        $lineCounter = 0;
        while(!feof($myFile)) {
            $line = fgets($myFile);
            if($lineCounter == 0){
                //Check the headers.
                if(trim($line) == "TRAIN_LINE,ROUTE_NAME,RUN_NUMBER,OPERATOR_ID"){
                    echo "Headers are Valid<br>";
                }else{
                    echo "File Headers should be TRAIN_LINE, ROUTE_NAME, RUN_NUMBER, OPERATOR_ID.<br>";
                    echo "File Headers are Invalid. File will be deleted.<br>";
                    //Clean Up
                    unlink($target_file);
                    die();
                }
            }

            if($lineCounter > 0 && $line){
                $lineArr = explode(",", $line);
                $train_line = $lineArr[0];
                $route_name = $lineArr[1];
                $run_number = $lineArr[2];
                $operator_id = $lineArr[3];
                if(trim($train_line) && trim($route_name) && trim($run_number) && trim($operator_id)){
                    //Check if a row exists.
                    $sql = "SELECT id FROM trains WHERE train_line=? AND route_name=? AND run_number=? AND operator_id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssss", $train_line, $route_name, $run_number, $operator_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    if($row){
                        echo "Row exists.<br>";
                    }else{
                        $sql = "INSERT INTO trains (train_line, route_name, run_number,operator_id) VALUES (?,?,?,?)";
                        $stmt= $conn->prepare($sql);
                        $stmt->bind_param("ssss", $train_line, $route_name, $run_number, $operator_id);
                        $stmt->execute();
                    }
                }
            }
            $lineCounter += 1;
        }
        fclose($myFile);
        $conn->close();
    }

/**
 * @param String $header_line
 * @return bool
 * Function returns true if all headers are present.
 */
    function validate_headers($header_line){
        if(strpos($header_line, "TRAIN_LINE") === false){
            return false;
        }
        if(strpos($header_line, "ROUTE_NAME") === false){
            return false;
        }
        if(strpos($header_line, "RUN_NUMBER") === false){
            return false;
        }
        if(strpos($header_line, "OPERATOR_ID") === false){
            return false;
        }
        return true;
    }
?>
</div>
</body>
</html>
