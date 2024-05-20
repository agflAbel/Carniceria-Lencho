<?php
include __DIR__.'/admin/sistema.class.php';
$app=new Sistema();
if(!$app->checkRol("CLiente")){
    header("Location: login.php");
}

include __DIR__.'/views/header.php';
$app->connect();
$sql="SELECT nombre, primer_apellido, segundo_apellido, segundo_apellido FROM cliente c join usuario u using (id_usuario) where c.id_usuario=:id_usuario";
$stmt=$app->conn->prepare($sql);
$id_usuario=$_SESSION["id_usuario"];
$stmt->bindParam(':id_usuario',$id_usuario,PDO::PARAM_INT);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$cliente=$stmt->fetchAll();
echo "<h1>Bienvenido ". $cliente[0]["nombre"];
include __DIR__.'/views/footer.php';
?>