<?php
    /*print_r($_GET);
    print_r($_POST);
    die;*/
    include (__DIR__.'/empleado.class.php');
    $app=new Empleado;
    $app->checkRol('Administrador',true);
    include (__DIR__.'/views/header.php');
    $action=(isset($_GET['action']))?$_GET['action']:null;
    $id_empleado=(isset($_GET['id_empleado']))?$_GET['id_empleado']:null;
    $dato=array();
    $alerta=array();
    switch ($action){
        case 'delete':
            $fila=$app->delete($id_empleado);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Empleado eliminado Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo eliminar el Empleado";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include (__DIR__.'/views/empleado/index.php');
            break;
        case 'create':
            include(__DIR__.'/views/empleado/form.php');
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
                $alerta['mensaje']="Empleado agregado Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo agregar el Empleado";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include(__DIR__.'/views/empleado/index.php');
            break;
        case 'update':
            $dato=$app->getOne($id_empleado);
            if(isset($dato['id_empleado'])){
                include(__DIR__.'/views/empleado/form.php');
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se encontró el Empleado";
                $dato=$app->getAll();
                include(__DIR__.'/views/alert.php');
                include(__DIR__.'/views/empleado/index.php');
            }
            break;
        case 'change':
            /*print_r($_POST);
            print_r($_GET);
            die;*/
            $dato=$_POST;
            $fila=$app->update($id_empleado,$dato);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Empleado modificado Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo modificar el Empleado";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include (__DIR__.'/views/empleado/index.php');
            break;
        default:
            $dato=$app->getAll(); 
            include (__DIR__.'/views/empleado/index.php');       
    }
    
    
    include (__DIR__.'/views/footer.php');
?>