<?php
    /*print_r($_GET);
    print_r($_POST);
    die;*/
    include (__DIR__.'/usuario.class.php');
    include (__DIR__.'/rol.class.php');
    $app=new Usuario;
    $appRoles = new Rol;
    $app->checkRol('Administrador',true);
    include (__DIR__.'/views/header.php');
    $action=(isset($_GET['action']))?$_GET['action']:null;
    $id_usuario=(isset($_GET['id_usuario']))?$_GET['id_usuario']:null;
    $dato=array();
    $alerta=array();
    switch ($action){
        case 'delete':
            $fila=$app->delete($id_usuario);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Usuario eliminado Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo eliminar el Usuario";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include (__DIR__.'/views/usuario/index.php');
            break;
        case 'create':
            $roles=$appRoles->getAll();
            include(__DIR__.'/views/usuario/form.php');
            break;
        case 'save':
            $roles=$appRoles->getAll();
            $dato=$_POST;
            $fila=$app->insert($dato,$roles);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Usuario agregado Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo agregar el Usuario";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include(__DIR__.'/views/usuario/index.php');
            break;
        case 'update':
            $roles=$appRoles->getAll();
            $dato=$app->getOne($id_usuario);
            if(isset($dato['id_usuario'])){
                include(__DIR__.'/views/usuario/form.php');
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se encontró el Usuario";
                $dato=$app->getAll();
                include(__DIR__.'/views/alert.php');
                include(__DIR__.'/views/usuario/index.php');
            }
            break;
        case 'change':
            $dato=$_POST;
            $roles=$appRoles->getAll();
            // echo "<pre>";
            // print_r($dato);
            // print_r($roles);
            // print_r($id_usuario);
            // die;
            $fila=$app->update($id_usuario,$dato,$roles);
            if ($fila){
                $alerta['tipo']="success";
                $alerta['mensaje']="Usuario modificado Correctamente";
            }else{
                $alerta['tipo']="danger";
                $alerta['mensaje']="No se pudo modificar el Usuario";
            }
            $dato=$app->getAll();
            include(__DIR__.'/views/alert.php');
            include (__DIR__.'/views/usuario/index.php');
            break;
        default:
            $dato=$app->getAll(); 
            include (__DIR__.'/views/usuario/index.php');       
    }
    
    
    include (__DIR__.'/views/footer.php');
?>