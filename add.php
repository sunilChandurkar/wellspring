<!DOCTYPE html>
<html>
<head>
    <title>Add Train</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<?php
    require_once("navbar.php");
?>
<div class="container">

<?php
require_once("connection.php");
/*
 * @param String $data
 * @return String $data
 */
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $train_line = test_input($_POST["train-line"]);
    $route_name = test_input($_POST["route-name"]);
    $run_number = test_input($_POST["run-number"]);
    $operator_id = test_input($_POST["operator-id"]);

    //Check if Row exists.
    $sql = "SELECT id FROM trains WHERE train_line=? AND route_name=? AND run_number=? AND operator_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $train_line, $route_name, $run_number, $operator_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if($row){
        echo "Row exists.<br>";
    }else{
        echo "Do an insert.<br>";
        $sql = "INSERT INTO trains (train_line, route_name, run_number,operator_id) VALUES (?,?,?,?)";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("ssss", $train_line, $route_name, $run_number, $operator_id);
        $stmt->execute();
        $conn->close();
        header("Location: /wellspring/index.php");
        die();
    }

}else{
    ?>
    <h4 style="margin-top: 50px;">Add a Train</h4>

    <form method="post" id="addForm" onsubmit="return validateForm()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="row">
            <div class="col-md-2">
                Train Line:
            </div>
            <div class="col-md-2">
                <input type="text" name="train-line" maxlength="20" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                Route Name:
            </div>
            <div class="col-md-2">
                <input type="text" name="route-name" maxlength="20" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                Run Number:
            </div>
            <div class="col-md-2">
                <input type="text" name="run-number" maxlength="20" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                Operator ID:
            </div>
            <div class="col-md-2">
                <input type="text" name="operator-id" maxlength="20" required>
            </div>
        </div>
        <input class="btn btn-primary" type="submit">
    </form>
    <?php
    }
    ?>
<script>
    /*
     * Function returns false if any filed is empty.
     */
    function validateForm() {
        let trainLine = document.forms["addForm"]["train-line"].value;
        if (trainLine == "") {
            alert("Train Line must be filled out");
            return false;
        }

        let routeName = document.forms["addForm"]["route-name"].value;
        if (routeName == "") {
            alert("Route Name must be filled out");
            return false;
        }

        let runNumber = document.forms["addForm"]["run-number"].value;
        if (runNumber == "") {
            alert("Run Number must be filled out");
            return false;
        }

        let operatorId = document.forms["addForm"]["operator-id"].value;
        if (operatorId == "") {
            alert("Operator Id must be filled out");
            return false;
        }
    }
</script>
</div>
</body>
</html>

