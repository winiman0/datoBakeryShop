<?php
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'datosbakery4';

    $dbconn = mysqli_connect($host, $user, $password, $database)
    or die ("Failed to Connected");
    #echo ("Connected");
?>