<?php
    function getmicrotime() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $server = "mysql-pkuznetsov.alwaysdata.net";
    $username = "388087_admin";
    $password = "Vaterloo2016";
    $database = "pkuznetsov_absences_empty";

    try {
        $conn = new mysqli($server, $username, $password, $database);

        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        if (!$conn->set_charset("utf8")) {
            throw new Exception("Error setting charset: " . $conn->error);
        }

        $sql = "DELETE FROM customers";

        if ($conn->query($sql) === TRUE) {
            echo "All rows from previous table were deleted successfully";
            echo "<br>";
        } else {
            throw new Exception("Error deleting rows: " . $conn->error);
        }

        echo "Starting script execution";
        $start = getmicrotime();

        $handle = fopen("./MOCK_DATA_generator_customers_withSemicolonForImportOrPDOinsert.csv", "r");

        $header = fgetcsv($handle, 1000, ";");

        $stmt = $conn->prepare("INSERT INTO customers (`customer_id`, `customerTitle`, `customerLastname`, `customerFirstname`, `customerStreetAddress`, `customerStreetAddress2`, `customerZipCode`, `customerCity`, `customerPhone`, `customerEmail`, `customerRegisterDate`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("issssssssss", $customer_id, $customerTitle, $customerLastname, $customerFirstname, $customerStreetAddress, $customerStreetAddress2, $customerZipCode, $customerCity, $customerPhone, $customerEmail, $customerRegisterDate);
        while ($row = fgetcsv($handle,1000,";")) {
            list($customer_id, $customerTitle, $customerLastname, $customerFirstname, $customerStreetAddress, $customerStreetAddress2, $customerZipCode, $customerCity, $customerPhone, $customerEmail, $customerRegisterDate) = $row;
            $stmt->execute($row);
        }

        fclose($handle);

        $stmt->close();
    } catch (Exception $e) {
        echo "<tr><td colspan='11'>" . htmlspecialchars($e->getMessage()) . "</td></tr>";
    } finally {
        if (isset($conn) && $conn->ping()) {
            $conn->close();
        }
        $end = getmicrotime();

        echo "<tr><td colspan='11'>Script executed in " . round($end - $start, 2) . " seconds.</td></tr>";
    }
?>