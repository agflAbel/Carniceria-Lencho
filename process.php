<?php
$datos=$_POST;
include __DIR__."/admin/sistema.class.php";
$app = new Sistema();
if($app->register($datos)){
    $tipo='success';
    $mensaje='Usuario registrado correctamente';
    $app->alert($tipo,$mensaje);
}else{
    $tipo='danger';
    $mensaje='No se pudo registrar el usuario';
    $app->alert($tipo,$mensaje);
}
?>