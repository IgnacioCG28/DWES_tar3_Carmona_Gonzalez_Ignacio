<?php
$conexion = new mysqli("127.0.0.1", "root", "", "db_tar3");
if ($conexion->connect_error) {
    die("Fail to connect DB buddy..." . $conexion->connect_error);
}
$conexion->set_charset("utf8");

if (isset($_POST["submitBtn"])) {
    if (empty($_POST["user"]) and empty($_POST["pass"])) {
        echo '<div class="btn btn-danger">CAMPOS VACÍOS</div>';
    } else {
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $db = $conexion->query("SELECT * FROM usuarios WHERE nombre='$user' and pass='$pass' ");
        if ($datos = $db->fetch_object()) {
            echo '<div class="loginSuccess">Buenos días ' . $user . '</div>';
        } else {
            echo '<div class="btn btn-warning">CUENTA NO EXISTE</div>';
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        html {
            font-size: 62.5%;
            box-sizing: border-box;
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
            font-size: 1.5rem;
        }

        form {
            display: flex;
            font-size: 1.5rem;
            flex-direction: column;
            align-items: flex-end;
            width: 300px;
            height: auto;
        }

        .form-control{
            font-size: 1.5rem;
        }

        .btn{
            font-size: 1.5rem;
        }

        .loginSuccess {
            background-color: blue;
            color: white;
            border-radius: 5px;
            position: absolute;
            right: 10px;
        }
    </style>
</head>

<body>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-style">
        <input type="text" name="user" id="user" placeholder="Nombre" class="form-control">
        <input type="password" name="pass" id="pass" placeholder="Contraseña" class="form-control">
        <input type="submit" value="Enviar" name="submitBtn" class="btn btn-primary">
    </form>
    <button id="createUser" class="btn-style">New User</button>
    <button id="logOut" class="btn-style">Log Out</button>
</body>

</html>