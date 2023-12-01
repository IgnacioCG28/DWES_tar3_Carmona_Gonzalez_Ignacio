<?php
$conexion = new mysqli("localhost", "root", "", "db_tar3");
if ($conexion->connect_error) {
    die("Fail to connect DB buddy..." . $conexion->connect_error);
}
$conexion->set_charset("utf8");

