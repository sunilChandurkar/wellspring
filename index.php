<!DOCTYPE html>
<html>
<head>
    <title>Trains</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
    <style>
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        li {
            display: inline;
        }
    </style>
</head>
<body>
<?php
    require_once('navbar.php');
?>
<div class="container">


<h2 style="padding-top: 50px;">Trains</h2>
<table id="trains" class="display table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Train Line</th>
            <th>Route Name</th>
            <th>Run Number</th>
            <th>Operator ID</th>
            <th>Action</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
            require_once("connection.php");
            $sql = "Select id, train_line, route_name, run_number, operator_id from trains";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";

                    echo "<td>";
                    echo $row["train_line"];
                    echo "</td>";

                    echo "<td>";
                    echo $row["route_name"];
                    echo "</td>";

                    echo "<td>";
                    echo $row["run_number"];
                    echo "</td>";

                    echo "<td>";
                    echo $row["operator_id"];
                    echo "</td>";

                    echo "<td>";
                    echo '<a href="edittrain.php?id=' . $row["id"] . '">';
                    echo 'Edit</a>';
                    echo "</td>";

                    echo "<td>";
                    echo '<a class="del" href="deletetrain.php?id=' . $row["id"] . '" onclick="return confirm(\'Are you sure you want to delete this item?\');">';
                    echo 'Delete</a>';
                    echo "</td>";

                    echo "</tr>";
                }
            } else {
                echo "Data to be uploaded.";
            }
            $conn->close();
        ?>
    </tbody>
</table>

<h3 style="margin-top: 50px;">Upload CSV File</h3>
<form action="upload.php" method="post" enctype="multipart/form-data">
    Select CSV to upload:
    <input type="file" name="fileToUpload" id="fileToUpload" required>
    <input type="submit" value="Upload CSV" name="submit">
</form>

    <div style="margin-top: 50px;"></div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready( function () {
        $('#trains').DataTable(
            {
                "order": [[ 2, "asc" ]],
                "pageLength": 5
            }
        );
    } );


</script>
</body>
</html>
