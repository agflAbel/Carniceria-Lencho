<?php
    /*print_r($_GET);
    print_r($_POST);
    die;*/
    include (__DIR__.'/marca.class.php');
    $app=new Marca;
    $app->checkRol('Administrador',true);
    include (__DIR__.'/views/header.php');
    $action=(isset($_GET['action']))?$_GET['action']:null;
    $id_marca=(isset($_GET['id_marca']))?$_GET['id_marca']:null;
    $dato=array();
    $alerta=array();
    switch ($action){
        case 'delete':
            $fila=$app->delete($id_marca);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Marca eliminada Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo eliminar la marca";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include (__DIR__.'/views/marca/index.php');
            break;
        case 'create':
            include(__DIR__.'/views/marca/form.php');
            break;
        case 'save':
            // echo "<pre>";
            // print_r($_POST);
            // print_r($_GET);
            // print "$ _FILES: "; print_r($_FILES);
            // die;
            $dato=$_POST;
            $dato['fotografia']=$_FILES['fotografia']['name'];
            // print_r($dato);
            // print_r($_FILES);
            $fila=$app->insert($dato);
            
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Marca agregada Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo agregar la marca";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include(__DIR__.'/views/marca/index.php');
            break;
        case 'update':
            $dato=$app->getOne($id_marca);
            if(isset($dato['id_marca'])){
                include(__DIR__.'/views/marca/form.php');
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se encontró la marca";
                $dato=$app->getAll();
                include(__DIR__.'/views/alert.php');
                include(__DIR__.'/views/marca/index.php');
            }
            break;
        case 'change':
            /*print_r($_POST);
            print_r($_GET);
            die;*/
            $dato=$_POST;
            $fila=$app->update($id_marca,$dato);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Marca modificada Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo modificar la marca";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include (__DIR__.'/views/marca/index.php');
            break;
        default:
            $dato=$app->getAll(); 
            include (__DIR__.'/views/marca/index.php');       
    }
    
    
    include (__DIR__.'/views/footer.php');
?>