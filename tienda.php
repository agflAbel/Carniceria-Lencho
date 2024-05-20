<?php
    /*print_r($_GET);
    print_r($_POST);
    die;*/
    include(__DIR__.'/tienda.class.php');
    $app=new Tienda;
    // $app->checkRol('Administrador',true);
    $app->checkPrivilegio('Tienda',true);
    include(__DIR__.'/views/header.php');
    $action=(isset($_GET['action']))?$_GET['action']:null;
    $id_tienda=(isset($_GET['id_tienda']))?$_GET['id_tienda']:null;
    $dato=array();
    $alerta=array();
    switch ($action){
        case 'delete':
            $fila=$app->delete($id_tienda);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Tienda eliminade Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo eliminar la tienda";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include(__DIR__.'/views/tienda/index.php');
            break;
        case 'create':
            include(__DIR__.'/views/tienda/form.php');
            break;
        case 'save':
            $dato=$_POST;
            // echo "<pre>";
            // print_r($_POST);
            // print_r($_GET);
            // print_r($_FILES);
            // die;
            $dato['fotografia']=$_FILES['fotografia']['name'];
            $fila=$app->insert($dato);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Tienda agregada Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo agregar la tienda";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include(__DIR__.'/views/tienda/index.php');
            break;
        case 'update':
            $dato=$app->getOne($id_tienda);
            if(isset($dato['id_tienda'])){
                include(__DIR__.'/views/tienda/form.php');
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se encontró la Tienda";
                $dato=$app->getAll();
                include(__DIR__.'/views/alert.php');
                include(__DIR__.'/views/tienda/index.php');
            }
            break;
        case 'change':
            // echo '<pre>';
            // print_r($_POST);
            // print_r($_GET);
            // print_r($_FILES);
            // die;
            $dato=$_POST;
            $fila=$app->update($id_tienda,$dato);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Tienda modificada Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo modificar la Tienda";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include(__DIR__.'/views/tienda/index.php');
            break;
        default:
            $dato=$app->getAll(); 
            include(__DIR__.'/views/tienda/index.php');       
    }
    
    
    include(__DIR__.'/views/footer.php');
?>