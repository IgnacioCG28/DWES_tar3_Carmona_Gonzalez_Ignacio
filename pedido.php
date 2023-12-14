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
$pizzas = $result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedPizzas = $_POST["pizzas"];
    $quantities = $_POST["quantities"];

    $totalPrice = 0.0;

    foreach ($selectedPizzas as $index => $id_pizza) {
        $quantity = $quantities[$index];

        $sql = "INSERT INTO pedidos (id_pizza, id_cliente, cantidad, coste, fecha_pedido) VALUES ('$id_pizza', 1, $quantity, 0.0, NOW())";
        if ($conn->query($sql) === TRUE) {
            $pizzaPrice = 0.0;

            $sql = "SELECT precio FROM pizzas WHERE id_pizza = '$id_pizza'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $pizzaPrice = $row['precio'];
            }

            $totalPrice += $pizzaPrice * $quantity;


            header("Location: gracias.php");
            exit;
        } else {
            echo "Error adding pizza to order: " . $conn->error;
        }
    }

    echo "Total Price: $" . $totalPrice;
    echo "<br>";
}
?>
<html>

<head>
    <link rel="stylesheet" href="styles.css">
</head>

<body>


    <form method="POST" action="">
        <label for="pizzas">Select Pizzas:</label>
        <select name="pizzas[]" multiple>
            <?php foreach ($pizzas as $pizza) { ?>
                <option value="<?php echo $pizza['id_pizza']; ?>"><?php echo $pizza['nombre']; ?></option>
            <?php } ?>
        </select>
        <br>
        <label for="quantities">Select Quantity:</label>
        <input type="number" name="quantities[]" min="1" value="1">
        <br>
        <input type="submit" value="Add to Order">
    </form>
    <a href="/index.php">Index</a><br><br><br>
</body>

</html>
<?php
$sql = "SELECT * FROM pizzas";
$result = $conn->query($sql);
$pizzas = $result->fetch_all(MYSQLI_ASSOC);

echo "Menu:<br>";
foreach ($pizzas as $pizza) {
    echo $pizza['nombre'] . " - $" . $pizza['precio'] . "<br>";
}

$conn->close();
?>