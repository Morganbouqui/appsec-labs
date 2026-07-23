<?php

$conn = new mysqli("localhost", "root", "", "appsec_lab");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

}

$sql = "SELECT * FROM users
        WHERE username = '$username'
        AND password = '$password'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Login Successful";
} else {
    echo "Invalid username or password";
}
