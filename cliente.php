<?php
    /*print_r($_GET);
    print_r($_POST);
    die;*/
    include (__DIR__.'/cliente.class.php');
    $app=new Cliente;
    $app->checkRol('Administrador',true);
    include (__DIR__.'/views/header.php');
    $action=(isset($_GET['action']))?$_GET['action']:null;
    $id_cliente=(isset($_GET['id_cliente']))?$_GET['id_cliente']:null;
    $dato=array();
    $alerta=array();
    switch ($action){
        case 'delete':
            $fila=$app->delete($id_cliente);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Cliente eliminado Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo eliminar el Cliente";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include (__DIR__.'/views/cliente/index.php');
            break;
        case 'create':
            include(__DIR__.'/views/cliente/form.php');
            break;
        case 'save':
            // echo "<pre>";
            // print_r($_POST);
            // print_r($_GET);
            // die;
            $dato=$_POST;
            // print_r($dato);
            $fila=$app->insert($dato);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Cliente agregado Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo agregar el Cliente";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include(__DIR__.'/views/cliente/index.php');
            break;
        case 'update':
            $dato=$app->getOne($id_cliente);
            if(isset($dato['id_cliente'])){
                include(__DIR__.'/views/cliente/form.php');
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se encontró el Cliente";
                $dato=$app->getAll();
                include(__DIR__.'/views/alert.php');
                include(__DIR__.'/views/cliente/index.php');
            }
            break;
        case 'change':
            /*print_r($_POST);
            print_r($_GET);
            die;*/
            $dato=$_POST;
            $fila=$app->update($id_cliente,$dato);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Cliente modificado Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo modificar el Cliente";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include (__DIR__.'/views/cliente/index.php');
            break;
        default:
            $dato=$app->getAll(); 
            include (__DIR__.'/views/cliente/index.php');       
    }
    
    
    include (__DIR__.'/views/footer.php');
?>