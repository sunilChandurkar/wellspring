<!DOCTYPE html>
<html>
<head>
    <title>Edit Train</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<?php
require_once("navbar.php");
?>
<div class="container">

<?php
    require_once("connection.php");
    //Validate data.
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
        $id = $_POST["id"];

        //Update the Row.
        $sql = "UPDATE trains SET train_line=?, route_name=?, run_number=?, operator_id=? where id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $train_line, $route_name, $run_number, $operator_id, $id);
        $stmt->execute();
        $conn->close();
        header("Location: /wellspring/index.php");
        die();
    }else{
        $id = $_GET["id"];
        $sql = "Select train_line, route_name, run_number, operator_id from trains where id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result(); // get the mysqli result
        $row = $result->fetch_assoc();
        ?>
        <h4 style="margin-top: 50px;">Edit a Train</h4>
        <form method="post" id="editForm" onsubmit="return validateForm()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="row">
                <div class="col-md-2">
                    Train Line:
                </div>
                <div class="col-md-2">
                    <input type="text" name="train-line" maxlength="20" value="<?php echo $row['train_line']; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                Route Name:
                </div>
                <div class="col-md-2">
                    <input type="text" name="route-name" maxlength="20" value="<?php echo $row['route_name']; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    Run Number:
                </div>
                <div class="col-md-2">
                    <input type="text" name="run-number" maxlength="20" value="<?php echo $row['run_number']; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                Operator ID:
                </div>
                <div class="col-md-2">
                    <input type="text" name="operator-id" maxlength="20" value="<?php echo $row['operator_id']; ?>" required>
                </div>
            </div>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input class="btn btn-primary" type="submit">
        </form>
        <?php
        }
        ?>
</div>
<script>
    function validateForm() {
        let trainLine = document.forms["editForm"]["train-line"].value;
        if (trainLine == "") {
            alert("Train Line must be filled out");
            return false;
        }

        let routeName = document.forms["editForm"]["route-name"].value;
        if (routeName == "") {
            alert("Route Name must be filled out");
            return false;
        }

        let runNumber = document.forms["editForm"]["run-number"].value;
        if (runNumber == "") {
            alert("Run Number must be filled out");
            return false;
        }

        let operatorId = document.forms["editForm"]["operator-id"].value;
        if (operatorId == "") {
            alert("Operator Id must be filled out");
            return false;
        }
    }
</script>

</body>
</html>
