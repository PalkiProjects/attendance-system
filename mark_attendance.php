<?php
$conn = new mysqli("localhost", "root", "", "attendance_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if (isset($_POST['submit'])) {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];

    
    $date = date("Y-m-d");
    $time_in = date("H:i:s");
$check = "SELECT * FROM attendance 
          WHERE student_id='$student_id' 
          AND date=CURDATE()";

$result = $conn->query($check);

if ($result->num_rows > 0) {
    $message = "Already marked today ❌";
} else {
    $sql = "INSERT INTO attendance (student_id, name, date, time_in)
            VALUES ('$student_id', '$name', '$date', '$time_in')";
}
    if ($conn->query($sql) === TRUE) {
        $message = "Attendance Marked Successfully ✔️";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mark Attendance</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f8;
            text-align: center;
            padding: 30px;
        }

        form {
            background: white;
            padding: 20px;
            display: inline-block;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        input {
            padding: 10px;
            margin: 10px;
            width: 250px;
        }

        button {
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        h2 {
            color: #333;
        }

        .msg {
            margin-top: 15px;
            color: green;
        }
    </style>
</head>
<body>

<h2>Mark Attendance</h2>

<form method="POST">
    <input type="text" name="student_id" placeholder="Enter Student ID" required><br>
    <input type="text" name="name" placeholder="Enter Name" required><br>
    <button type="submit" name="submit">Mark Attendance</button>
</form>

<div class="msg">
    <?php echo $message; ?>
</div>

<br><br>
<a href="index.php">Go to Dashboard</a>

</body>
</html>