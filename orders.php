<?php
include __DIR__.'/admin/sistema.class.php';
$app=new Sistema();
if(!$app->checkRol("CLiente")){
    header("Location: login.php");
}
include __DIR__.'/header.php';
$app->connect();
$sql="SELECT * FROM orders WHERE id_usuario = :id_usuario";
$stmt=$app->prepare($sql);
$id_usuario = $_SESSION['id_usuario'];
$stmt->bindParam(':id_usuario',$id_usuario,PDO::PARAM_INT);
$stmt->execute();
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
include __DIR__.'views/pedidos/index.php';
include __DIR__.'/footer.php';
?>