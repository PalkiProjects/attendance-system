<?php
include "config.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$date = isset($_GET['date']) ? $_GET['date'] : "";

if ($date != "") {
    $sql = "SELECT * FROM attendance WHERE date='$date' ORDER BY time_in DESC";
} else {
    $sql = "SELECT * FROM attendance ORDER BY date DESC, time_in DESC";
}

$result = $conn->query($sql);
?>
<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
$conn = new mysqli("localhost", "root", "", "attendance_system");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM attendance ORDER BY date DESC, time_in DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Smart Attendance Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            text-align: center;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        table {
            margin: auto;
            border-collapse: collapse;
            width: 85%;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

    <h2>Smart Attendance System Dashboard</h2>
<form method="GET">
    <input type="date" name="date" value="<?php echo $date; ?>">
    <button type="submit">Filter</button>

    <a href="index.php">
        <button type="button">Reset</button>
    </a>
</form>

<br>
    <table>
        <tr>
            <th>ID</th>
            <th>Student ID</th>
            <th>Name</th>
            <th>Date</th>
            <th>Time In</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row["id"]."</td>
                        <td>".$row["student_id"]."</td>
                        <td>".$row["name"]."</td>
                        <td>".$row["date"]."</td>
                        <td>".$row["time_in"]."</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No Attendance Records Found</td></tr>";
        }

        $conn->close();
        ?>

    </table>

</body>
</html>