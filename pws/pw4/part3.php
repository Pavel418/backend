<?php
    function getmicrotime() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

    $start = getmicrotime();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $server = "mysql-pkuznetsov.alwaysdata.net";
    $username = "388087_admin";
    $password = "Vaterloo2016";
    $database = "pkuznetsov_absences_empty";

    $conn = mysqli_connect($server, $username, $password, $database);
    
    if (!$conn) {
        die("<tr><td colspan='11'>Connection failed: " . mysqli_connect_error() . "</td></tr>");
    }
    
    if (!mysqli_set_charset($conn, "utf8")) {
        die("<tr><td colspan='11'>Error setting charset: " . mysqli_error($conn) . "</td></tr>");
    }
    
    $sql = "DELETE FROM customers";
    
    if (mysqli_query($conn, $sql)) {
        echo "All rows from previous table were deleted successfully";
        echo "<br>";
    } else {
        throw new Exception("Error deleting rows: " . mysqli_error($conn));
    }
    
    echo "Starting script execution";
    $start = getmicrotime();

    $handle = fopen("./MOCK_DATA_generator_customers_withSemicolonForImportOrPDOinsert.csv", "r");

    $header = fgetcsv($handle, 1000, ";");

    while ($row = fgetcsv($handle, 1000, ";")) {
        $customer_id = mysqli_real_escape_string($conn, $row[0]);
        $customerTitle = mysqli_real_escape_string($conn, $row[1]);
        $customerLastname = mysqli_real_escape_string($conn, $row[2]);
        $customerFirstname = mysqli_real_escape_string($conn, $row[3]);
        $customerStreetAddress = mysqli_real_escape_string($conn, $row[4]);
        $customerStreetAddress2 = mysqli_real_escape_string($conn, $row[5]);
        $customerZipCode = mysqli_real_escape_string($conn, $row[6]);
        $customerCity = mysqli_real_escape_string($conn, $row[7]);
        $customerPhone = mysqli_real_escape_string($conn, $row[8]);
        $customerEmail = mysqli_real_escape_string($conn, $row[9]);
        $customerRegisterDate = mysqli_real_escape_string($conn, $row[10]);
    
        $query = "INSERT INTO customers (`customer_id`, `customerTitle`, `customerLastname`, `customerFirstname`, `customerStreetAddress`, `customerStreetAddress2`, `customerZipCode`, `customerCity`, `customerPhone`, `customerEmail`, `customerRegisterDate`) VALUES ('$customer_id', '$customerTitle', '$customerLastname', '$customerFirstname', '$customerStreetAddress', '$customerStreetAddress2', '$customerZipCode', '$customerCity', '$customerPhone', '$customerEmail', '$customerRegisterDate')";
    
        mysqli_query($conn, $query);
    }

    fclose($handle);

    mysqli_close($conn);

    $end = getmicrotime();

    echo "<tr><td colspan='11'>Script executed in " . round($end - $start, 2) . " seconds.</td></tr>";
?>