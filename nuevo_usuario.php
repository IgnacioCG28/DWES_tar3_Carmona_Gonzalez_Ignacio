<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (usernameExists($username)) {
        echo "Username already exists. Please choose another one.";
    } else {
        createUser($username, $password, $email);
        echo "User created successfully!";
        header("Location: index.php");
        exit();
    }
}

function usernameExists($username) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE nombre = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    $conn->close();

    return $count > 0;
}

function createUser($username, $password, $email) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, pass, correo, rol) VALUES (?, ?, ?, ?)");
    $rol = 1;
    $stmt->bind_param("sssi", $username, $password, $email, $rol);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function connectToDatabase() {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'db_tar3';

    $mysqli = new mysqli($host, $username, $password, $database);

    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }

    return $mysqli;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>New User Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Create a New User</h1>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <input type="submit" value="Create User">
    </form>
    <button><a href="index.php">Exit</a></button>
</body>
</html>
