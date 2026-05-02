<?php
session_start();
$conn = new mysqli("localhost", "root", "", "attendance_system");

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['admin'] = $username;
        header("Location: index.php");
    } else {
        echo "Wrong username or password";
    }
}
?>

<form method="POST">
    <h2>Login</h2>
    <input name="username" placeholder="Username"><br><br>
    <input name="password" type="password" placeholder="Password"><br><br>
    <button name="login">Login</button>
</form>