<?php
error_reporting(0);
session_start();
$id_producto=isset($_GET['id_producto']) ? $_GET['id_producto'] : die("Eroo: producto no encontrado");
$cantidad=isset($_GET['cantidad']) ? $_GET['cantidad'] : die("es necesaria la cantidad");
if(!isset($_SESSION['cart'])){
    $_SESSION['cart']=array();
}
$_SESSION['cart'][$id_producto]+=$cantidad;

?>