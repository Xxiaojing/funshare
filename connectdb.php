<?php

    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'funshare';

    $con = new mysqli($servername, $username, $password, $dbname);

    if($con->connect_error) {
        die("Conncection failed: " . $con->connect_error);
    }
    echo "Connected successfully.";
?>
