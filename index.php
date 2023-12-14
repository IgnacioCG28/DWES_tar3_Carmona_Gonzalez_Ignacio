<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_tar3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$loggedIn = false;
if (isset($_SESSION["username"])) {
    $loggedIn = true;
    $username = $_SESSION["username"];
}

if ($loggedIn && $username == "admin") {
    header("Location: zona_admin.php");
    exit;
}

if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM usuarios WHERE nombre = '$username' AND pass = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["username"] = $row["nombre"];
        $loggedIn = true;
        header("Location: index.php");
        exit;
    } else {
        echo "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
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
        <p>Don't have an account? <a href="nuevo_usuario.php">Create one</a></p>
    <?php } ?>

    <h2>Menu</h2>
    <table style="border: 1px solid black;">
        <tr>
            <th>Pizza</th>
            <th>Ingredients</th>
            <th>Price</th>
        </tr>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "db_tar3";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

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
        ?>
    </table>

    <?php if ($loggedIn) { ?>
        <form action="pedido.php" method="POST">
            <input type="submit" value="Place Order">
        </form>
    <?php } ?>
</body>
</html>
