<?php
include __DIR__.'/admin/sistema.class.php';
$app=new Sistema();
$app->chackRol('Cliente',true);
$app-conect();
$id_usuario=$_SESSION['id_usuario'];
$id_venta=$_GET['id_venta'];
$sql="SELECT * FROM orders where id_usuario=:id_usuario";
$stmt=$app->conn->prepare($sql);
$stmt->bindParam(':id_usuario',$id_usuario,PDO::PARAM_INT);
$stmt->execute();
$sql=""
?>