<?php
    $servername = "localhost";
    $db_user = "group7";
    $db_pass = "KVSzuH";
    $db_name = "group7";
    $conn = mysqli_connect($servername, $db_user, $db_pass, $db_name);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>
