<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
</head>
<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include 'db_connection.php';

        $title = htmlspecialchars($_POST['title'] ?? '');
        $firstName = htmlspecialchars($_POST['first name'] ?? '');
        $lastName = htmlspecialchars($_POST['last name'] ?? '');
        $first_address = htmlspecialchars($_POST['first_address'] ?? '');
        $second_address = htmlspecialchars($_POST['second_address'] ?? '');
        $city = htmlspecialchars($_POST['city'] ?? '');
        $postal = htmlspecialchars($_POST['postal_code'] ?? '');
        $phone = htmlspecialchars($_POST['phone'] ?? '');
        $email = htmlspecialchars($_POST['email'] ?? '');

        try {
            $stmt = $pdo->prepare('INSERT INTO customers (`title`, `first name`, `last name`, `first adress`, `second adress`, `city`, `postal code`, `phone`, `email`) VALUES (:title, :first_name, :last_name, :first_address, :second_address, :city, :postal, :phone, :email)');$stmt->bindParam(':title', $title);
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':first_address', $first_address);
            $stmt->bindParam(':second_address', $second_address);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':postal', $postal);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            echo "<p>Form submitted successfully!</p>";
        } catch (Exception $e) {
            echo "<p>Error submitting form: " . $e->getMessage() . "</p>";
        }
    }
    ?>

    <form action="" method="post">
        <table>
            <tr>
                <td>Title:</td>
                <td>
                    <input type="radio" id="mr" name="title" value="Mr" required>
                    <label for="mr">Mr</label>
                    <input type="radio" id="mrs" name="title" value="Mrs">
                    <label for="mrs">Mrs</label>
                </td>
            </tr>
            <tr>
                <td>First Name:</td>
                <td><input type="text" name="first_name" required></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><input type="text" name="last_name" required></td>
            </tr>
            <tr>
                <td>First Address:</td>
                <td><input type="text" name="first_address" required></td>
            </tr>
            <tr>
                <td>Second Address:</td>
                <td><input type="text" name="second_address"></td>
            </tr>
            <tr>
                <td>City:</td>
                <td><input type="text" name="city" required></td>
            </tr>
            <tr>
                <td>Postal Code:</td>
                <td><input type="text" name="postal_code" required></td>
            </tr>
            <tr>
                <td>Phone:</td>
                <td><input type="text" name="phone" required></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="email" name="email" required></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Submit"></td>
            </tr>
        </table>
    </form>
</body>
</html>
