<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance_system";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['uid'])) {

    $uid = $_POST['uid'];

   
    $checkQuery = "SELECT * FROM students WHERE rfid_uid='$uid'";
    $result = $conn->query($checkQuery);

    if($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        $student_id = $row['student_id'];
        $name = $row['name'];

        
        date_default_timezone_set("Asia/Kolkata");

        $date = date("Y-m-d");
        $time = date("H:i:s");

        
        $insertQuery = "INSERT INTO attendance (student_id, name, date, time_in)
                        VALUES ('$student_id', '$name', '$date', '$time')";

        if($conn->query($insertQuery) === TRUE) {
            echo "Attendance Marked Successfully for " . $name;
        } else {
            echo "Error: Attendance Not Marked";
        }

    } else {
        echo "Unauthorized RFID Card";
    }

} else {
    echo "No UID Received";
}


$conn->close();

?>