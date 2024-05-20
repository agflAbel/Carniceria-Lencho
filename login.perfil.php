<?php   
include __DIR__.'/admin/sistema.class.php';
$datos=$_POST;
$app=new Sistema;
// echo "<pre>";
// print_r($datos);
// print_r($_SESSION);
// print_r($_POST);
// die;
if($app->validateEmail($datos['email'])){
    
    if($app->login($datos['email'],$datos['contrasena'])){
        print_r($_SESSION);
        header('Location: checkout.php');
    }else{
    }
}else{
header('Location: login.php');
}
?>
