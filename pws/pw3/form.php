<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $server = "mysql-pkuznetsov.alwaysdata.net";
    $username = "388087_admin";
    $password = "Vaterloo2016";
    $database = "pkuznetsov_customers";

    try {
        $conn = new mysqli($server, $username, $password, $database);

        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        if (!$conn->set_charset("utf8")) {
            throw new Exception("Error setting charset: " . $conn->error);
        }

        $query = "
        ";

        $result = $conn->query($query);

        if (!$result) {
            throw new Exception("Query failed: " . $conn->error);
        }
    } catch (Exception $e) {
        
    } finally {
        if (isset($conn) && $conn->ping()) {
            $conn->close();
        }
    }
?>