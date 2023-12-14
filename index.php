<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_tar3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
session_start();
$loggedIn = false;
if (isset($_SESSION["username"])) {
    $loggedIn = true;
    $username = $_SESSION["username"];
}

// Logout functionality
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM usuarios WHERE nombre = '$username' AND pass = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Successful login
        $row = $result->fetch_assoc();
        $_SESSION["username"] = $row["nombre"];
        $loggedIn = true;
        header("Location: index.php");
        exit;
    } else {
        // Invalid credentials
        echo "Invalid username or password.";
    }
}

$conn->close();
?>

<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <?php if ($loggedIn) { ?>
        <h2>Welcome, <?php echo $username; ?>!</h2>
        <a href="index.php?logout=true">Logout</a>
    <?php } else { ?>
        <h2>Login</h2>
        <form action="index.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="new_user.php">Create one</a></p>
    <?php } ?>

    <h2>Menu</h2>
    <table>
        <tr>
            <th>Pizza</th>
            <th>Ingredients</th>
            <th>Price</th>
        </tr>
        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "db_tar3";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch pizza data from database
        $sql = "SELECT * FROM pizzas";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td>" . $row["ingredientes"] . "</td>";
                echo "<td>$" . $row["precio"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "No pizzas found.";
        }

        $conn->close();
        ?>
        <!-- Add more pizzas here -->
    </table>

    <?php if ($loggedIn) { ?>
        <form action="place_order.php" method="POST">
            <input type="submit" value="Place Order">
        </form>
    <?php } ?>
</body>
</html>
