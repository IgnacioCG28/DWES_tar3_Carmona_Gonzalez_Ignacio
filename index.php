<?php
include("DB_connect.php");
$form = true;

if (isset($_POST["submitBtn"])) {
    if (empty($_POST["user"]) || empty($_POST["pass"])) {
        echo '<div class="warning-style">CAMPOS VACÍOS</div>';
    } else {
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $db = $conexion->query("SELECT * FROM usuarios WHERE nombre='$user' and pass='$pass'");
        $datos = $db->fetch_object();
        $rol = $datos->rol;
        if ($datos && $rol == 1) {
            $form = false;
            echo'<div class="loginSuccess"><h2>Buenos días ' . $user . '</h2></div>';
        }
        if ($datos && $rol == 0) {
            header('Location:zona_admin.php');
        } if (!$datos) {
            echo '<div class="warning-style">CUENTA NO EXISTE</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <style>
        html {
            font-size: 62.5%;
            box-sizing: border-box;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        *,
        *::before,
        *::after {
            box-sizing: inherit;
        }

        body {
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;

        }

        form {
            display: flex;
            flex-direction: column;
            /* O elige row según tu diseño */
            align-items: flex-start;
            /* Alinea los elementos a la izquierda */
        }

        form input[type="submit"] {
            margin-left: auto;
            /* Empuja el botón hacia la derecha */
        }


        h2 {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            padding-right: 5px;
            padding-left: 5px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .warning-style{
            background-color: yellow;
            border: 1px solid black;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 150px;
            height: 50px;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .form-control {
            display: flex;
            font-size: 1.5rem;
        }

        .btn-style {
            color: white;
            background-color: blue;
            border: 5px;
            border-color: none;

        }
    </style>
</head>

<body>
    <?php if ($form) : ?>
        <div class="container">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-style">
                <input type="text" name="user" id="user" placeholder="Nombre" class="form-control">
                <input type="password" name="pass" id="pass" placeholder="Contraseña" class="form-control">
                <input type="submit" value="Enviar" name="submitBtn" class="btn-style">
            </form>
        </div>
        <button id="createUser" class="btn-style">New User</button>
    <?php endif; ?>
    <?php if (!$form) : ?>
        <button id="logOut" class="btn-style">Log Out</button>
    <?php endif; ?>
</body>

</html>