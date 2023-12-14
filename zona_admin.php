<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'db_connection.php';

function getMostSoldPizzas() {
    global $conn;
    
    $query = "SELECT p.nombre, COUNT(*) as total_sales
              FROM pizzas p
              INNER JOIN pedidos pe ON p.id_pizza = pe.id_pizza
              GROUP BY p.id_pizza
              ORDER BY total_sales DESC";
    
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $pizzas;
    } else {
        return [];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['coste']) && isset($_POST['ingredientes'])) {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $coste = $_POST['coste'];
    $ingredientes = $_POST['ingredientes'];

    if (!empty($nombre) && !empty($precio) && !empty($coste) && !empty($ingredientes)) {
        $query = "INSERT INTO pizzas (nombre, precio, coste, ingredientes)
                  VALUES ('$nombre', '$precio', '$coste', '$ingredientes')";

        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Pizza created successfully.";
        } else {
            echo "Error creating pizza: " . mysqli_error($conn);
        }
    } else {
        echo "Please fill in all the fields.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_pizza_id'])) {
    $pizzaId = $_POST['delete_pizza_id'];
    
    // Check if there is a pedido for the pizza
    $pedidoQuery = "SELECT * FROM pedidos WHERE id_pizza = '$pizzaId'";
    $pedidoResult = mysqli_query($conn, $pedidoQuery);
    
    if ($pedidoResult && mysqli_num_rows($pedidoResult) > 0) {
        echo "Cannot delete pizza because there is a sale.";
    } else {
        $query = "DELETE FROM pizzas WHERE id_pizza = '$pizzaId'";
    
        $result = mysqli_query($conn, $query);
    
        if ($result) {
            echo "Pizza deleted successfully.";
        } else {
            echo "Error deleting pizza: " . mysqli_error($conn);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_start();
    session_destroy();
    header("Location: index.php");
    exit;
}
?>

<form method="POST" action="">
    <h2>Modify/Create Pizza</h2>
    <input type="hidden" name="id_pizza" value="">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" required>
    <label for="precio">Precio:</label>
    <input type="number" name="precio" step="0.01" required>
    <label for="coste">Coste:</label>
    <input type="number" name="coste" step="0.01" required>
    <label for="ingredientes">Ingredientes:</label>
    <input type="text" name="ingredientes" required>
    <button type="submit">Save Pizza</button>
</form>

<form method="POST" action="">
    <h2>Delete Pizza</h2>
    <label for="delete_pizza_id">Select Pizza:</label>
    <select name="delete_pizza_id" required>
        <?php
        $query = "SELECT * FROM pizzas";
        $result = mysqli_query($conn, $query);
        
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['id_pizza'] . "'>" . $row['nombre'] . "</option>";
            }
        }
        ?>
    </select>
    <button type="submit">Delete Pizza</button>
</form>

<h2>Most Sold Pizzas</h2>
<?php
$pizzas = getMostSoldPizzas();

if (!empty($pizzas)) {
    foreach ($pizzas as $pizza) {
        echo "<p>" . $pizza['nombre'] . " - Total Sales: " . $pizza['total_sales'] . "</p>";
    }
} else {
    echo "<p>No pizzas found.</p>";
}
?>

<form method="POST" action="">
    <button type="submit" name="logout">Logout</button>
</form>
