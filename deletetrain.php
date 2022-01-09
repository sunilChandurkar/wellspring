<?php
    require_once("connection.php");
    if(isset($_GET["id"]) && $_GET["id"]){

    }
    $sql = "Delete from trains where id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_GET["id"]);
    $stmt->execute();
    $conn->close();
    header("Location: /wellspring/index.php");
    die();
