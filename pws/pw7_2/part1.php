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
    $dsn = "mysql:host=$server;dbname=$database;charset=utf8";
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "DELETE FROM customers";
    $conn->exec($sql);

    echo "All rows from previous table were deleted successfully";
    echo "<br>";
    echo "Starting script execution";
    echo "<br>";
    $start = getmicrotime();

    // Open the CSV file
    $handle = fopen("./MOCK_DATA_generator_customers_withSemicolonForImportOrPDOinsert.csv", "r");

    if ($handle === false) {
        throw new Exception("Unable to open the CSV file.");
    }

    // Skip the header row
    $header = fgetcsv($handle, 1000, ";");

    $stmt = $conn->prepare("INSERT INTO customers (
        `customer_id`, `customerTitle`, `customerLastname`, `customerFirstname`, 
        `customerStreetAddress`, `customerStreetAddress2`, `customerZipCode`, 
        `customerCity`, `customerPhone`, `customerEmail`, `customerRegisterDate`
    ) VALUES (
        :customer_id, :customerTitle, :customerLastname, :customerFirstname, 
        :customerStreetAddress, :customerStreetAddress2, :customerZipCode, 
        :customerCity, :customerPhone, :customerEmail, :customerRegisterDate
    )");

    while ($row = fgetcsv($handle, 1000, ";")) {
        list(
            $customer_id, $customerTitle, $customerLastname, $customerFirstname,
            $customerStreetAddress, $customerStreetAddress2, $customerZipCode,
            $customerCity, $customerPhone, $customerEmail, $customerRegisterDate
        ) = $row;

        $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->bindParam(':customerTitle', $customerTitle, PDO::PARAM_STR);
        $stmt->bindParam(':customerLastname', $customerLastname, PDO::PARAM_STR);
        $stmt->bindParam(':customerFirstname', $customerFirstname, PDO::PARAM_STR);
        $stmt->bindParam(':customerStreetAddress', $customerStreetAddress, PDO::PARAM_STR);
        $stmt->bindParam(':customerStreetAddress2', $customerStreetAddress2, PDO::PARAM_STR);
        $stmt->bindParam(':customerZipCode', $customerZipCode, PDO::PARAM_STR);
        $stmt->bindParam(':customerCity', $customerCity, PDO::PARAM_STR);
        $stmt->bindParam(':customerPhone', $customerPhone, PDO::PARAM_STR);
        $stmt->bindParam(':customerEmail', $customerEmail, PDO::PARAM_STR);
        $stmt->bindParam(':customerRegisterDate', $customerRegisterDate, PDO::PARAM_STR);

        $stmt->execute();
    }

    fclose($handle);

} catch (Exception $e) {
    echo "<tr><td colspan='11'>" . htmlspecialchars($e->getMessage()) . "</td></tr>";
} finally {
    $end = getmicrotime();
    echo "<tr><td colspan='11'>Script executed in " . round($end - $start, 2) . " seconds.</td></tr>";
}
?>
/