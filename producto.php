<?php
    /*print_r($_GET);
    print_r($_POST);
    die;*/
    include (__DIR__.'/producto.class.php');
    include (__DIR__.'/marca.class.php');
    // print_r($_SESSION);
    $app=new Producto;
    $appmarca = new Marca;
    $app->checkRol('Administrador',true);
    include ('views/header.php');
    $action=(isset($_GET['action']))?$_GET['action']:null;
    $id_producto=(isset($_GET['id_producto']))?$_GET['id_producto']:null;
    $dato=array();
    $alerta=array();
    switch ($action){
        case 'delete':
            $fila=$app->delete($id_producto);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Producto eliminado Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo eliminar el producto";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include(__DIR__.'/views/producto/index.php');
            break;
        case 'create':
            $marcas = $appmarca->getAll();
            include(__DIR__.'/views/producto/form.php');
            break;
        case 'save':
            /*echo "<pre>";
            print_r($_POST);
            print_r($_GET);
            print_r($_FILES);
            die;*/
            $dato=$_POST;
            $dato['fotografia']=$_FILES['fotografia']['name'];
            $fila=$app->insert($dato);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Producto agregado Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo agregar el Producto";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include(__DIR__.'/views/producto/index.php');
            break;
        case 'update':
            $dato=$app->getOne($id_producto);
            $marcas = $appmarca->getAll();
            if(isset($dato['id_producto'])){
                include(__DIR__.'/views/producto/form.php');
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se encontró el Producto";
                $dato=$app->getAll();
                include(__DIR__.'/views/alert.php');
                include(__DIR__.'/views/producto/index.php');
            }
            break;
        case 'change':
            #print_r($_POST);
            #print_r($_GET);
            #die;
            $dato=$_POST;
            #print_r($_POST);
            $fila=$app->update($id_producto,$dato);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Producto modificado Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo modificar el producto";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include(__DIR__.'/views/producto/index.php');
            break;
        default:
            $dato=$app->getAll(); 
            include(__DIR__.'/views/producto/index.php');       
    }
    
    
    include(__DIR__.'/views/footer.php');
?>