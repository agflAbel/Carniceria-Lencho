<?php
    /*print_r($_GET);
    print_r($_POST);
    die;*/
    include (__DIR__.'/rol.class.php');
    include (__DIR__.'/privilegio.class.php');
    $app=new Rol;
    $appPrivilegios = new Privilegio;
    // $app->checkRol('Administrador',true);
    include (__DIR__.'/views/header.php');
    $action=(isset($_GET['action']))?$_GET['action']:null;
    $id_rol=(isset($_GET['id_rol']))?$_GET['id_rol']:null;
    $dato=array();
    $alerta=array();
    switch ($action){
        case 'delete':
            $fila=$app->delete($id_rol);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Rol eliminado Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo eliminar el Rol";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include (__DIR__.'/views/rol/index.php');
            break;
        case 'create':
            $privilegios=$appPrivilegios->getAll();
            include(__DIR__.'/views/rol/form.php');
            break;
        case 'save':
            $privilegios=$appPrivilegios->getAll();
            // echo "<pre>";
            // print_r($_POST);
            // print_r($_GET);
            // die;
            $dato=$_POST;
            // print_r($dato);
            // print_r($privilegios);
            // die;
            $fila=$app->insert($dato,$privilegios);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Rol agregado Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo agregar el Rol";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include(__DIR__.'/views/rol/index.php');
            break;
        case 'update':
            $privilegios=$appPrivilegios->getAll();
            $dato=$app->getOne($id_rol);
            if(isset($dato['id_rol'])){
                include(__DIR__.'/views/rol/form.php');
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se encontró el Rol";
                $dato=$app->getAll();
                include(__DIR__.'/views/alert.php');
                include(__DIR__.'/views/rol/index.php');
            }
            break;
        case 'change':
            /*print_r($_POST);
            print_r($_GET);
            die;*/
            $dato=$_POST;
            $fila=$app->update($id_rol,$dato);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Rol modificado Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo modificar el Rol";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include (__DIR__.'/views/rol/index.php');
            break;
        default:
            $dato=$app->getAll(); 
            include (__DIR__.'/views/rol/index.php');       
    }
    
    
    include (__DIR__.'/views/footer.php');
?>