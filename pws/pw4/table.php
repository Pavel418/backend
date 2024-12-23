<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Timetable</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        table th {
            background-color: #f2f2f2;
            color: #333;
        }
        .dataTables_wrapper {
            margin-top: 20px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#timetable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthMenu: [5, 10, 25, 50],
                columnDefs: [
                    { orderable: true, targets: '_all' },
                ],
                language: {
                    search: "Search by any field:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries"
                }
            });
        });
    </script>
</head>
<body>
    <h1>Student Timetable</h1>
    <table id="timetable" class="display">
        <thead>
            <tr>
                <th>Date of Lesson</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Duration</th>
                <th>Class Name</th>
                <th>Subject</th>
                <th>Professor Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

            $server = "mysql-pkuznetsov.alwaysdata.net";
            $username = "388087_admin";
            $password = "Vaterloo2016";
            $database = "pkuznetsov_absences_";

            try {
                $conn = new mysqli($server, $username, $password, $database);

                if ($conn->connect_error) {
                    throw new Exception("Connection failed: " . $conn->connect_error);
                }

                if (!$conn->set_charset("utf8")) {
                    throw new Exception("Error setting charset: " . $conn->error);
                }

                $query = "
                    SELECT 
                        lessons.course_date AS course_date,
                        lessons.start_time AS course_start_time,
                        lessons.end_time AS course_end_time,
                        lessons.course_duration AS duration,
                        classes.class_full_name AS full_class_name,
                        subjects.subject AS subject_name,
                        CONCAT(professors.first_name, ' ', professors.last_name) AS professor_name
                    FROM 
                        lessons
                    JOIN 
                        classes ON lessons.class_id = classes.class_id
                    JOIN 
                        subjects ON lessons.subject_id = subjects.subject_id
                    JOIN 
                        professors ON lessons.professor_id = professors.professor_id;
                ";

                $result = $conn->query($query);

                if (!$result) {
                    throw new Exception("Query failed: " . $conn->error);
                }

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['course_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['course_start_time']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['course_end_time']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['duration']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['full_class_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['subject_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['professor_name']) . "</td>";
                    echo "</tr>";
                }

            } catch (Exception $e) {
                echo "<tr><td colspan='7'>" . htmlspecialchars($e->getMessage()) . "</td></tr>";
            } finally {
                if (isset($conn) && $conn->ping()) {
                    $conn->close();
                }
            }
            ?>
        </tbody>
    </table>
</body>
</html>
