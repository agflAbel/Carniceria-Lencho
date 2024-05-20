<?php
    /*print_r($_GET);
    print_r($_POST);
    die;*/
    include (__DIR__.'/privilegio.class.php');
    $app=new Privilegio;
    $app->checkRol('Administrador',true);
    include (__DIR__.'/views/header.php');
    $action=(isset($_GET['action']))?$_GET['action']:null;
    $id_privilegio=(isset($_GET['id_privilegio']))?$_GET['id_privilegio']:null;
    $dato=array();
    $alerta=array();
    switch ($action){
        case 'delete':
            $fila=$app->delete($id_privilegio);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Privilegio eliminado Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo eliminar el Privilegio";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include (__DIR__.'/views/privilegio/index.php');
            break;
        case 'create':
            include(__DIR__.'/views/privilegio/form.php');
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
                $alerta['mensaje']="Privilegio agregado Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo agregar el Privilegio";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include(__DIR__.'/views/privilegio/index.php');
            break;
        case 'update':
            $dato=$app->getOne($id_privilegio);
            if(isset($dato['id_privilegio'])){
                include(__DIR__.'/views/privilegio/form.php');
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se encontró el privilegio";
                $dato=$app->getAll();
                include(__DIR__.'/views/alert.php');
                include(__DIR__.'/views/privilegio/index.php');
            }
            break;
        case 'change':
            /*print_r($_POST);
            print_r($_GET);
            die;*/
            $dato=$_POST;
            $fila=$app->update($id_privilegio,$dato);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Privilegio modificado Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo modificar el Privilegio";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include (__DIR__.'/views/privilegio/index.php');
            break;
        default:
            $dato=$app->getAll(); 
            include (__DIR__.'/views/privilegio/index.php');       
    }
    
    
    include (__DIR__.'/views/footer.php');
?>