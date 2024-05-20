<?php
header('Content-Type: application/json; charset=utf-8');
include __DIR__ . '/pedidos.class.php';
$id_venta = (isset($_GET['id_venta'])) ? $_GET['id_venta'] : null;
$action = (isset($_GET['action'])) ? $_GET['action'] : null;

class Api extends Pedidos
{
public function read()
{
$datos = $this->getAll();
$datos = json_encode($datos);
print($datos);
}


public function readOne($id_venta){
    $datos = $this->getOne($id_venta);
    if(isset($datos[$id_venta])){
        $datos = json_encode($datos);
        print($datos);
    }else{
        $datos['mensaje']='No se encontró el pedido';
        $datos = json_encode($datos);
        print($datos);
    }
}
public function deleteOne(){
    $filas=$this->delete($id_venta);
    if($filas){
        $datos['mensaje']='El pedido se ha eliminado';
    }else{
        $datos['mensaje']='No se pudo eliminar el pedido';
    }
}
}

$app = new Api();
switch ($action){
    case 'POST':
        break;
    case 'DELETE':
        break;
    case 'GET':
    default:
        if(isset($_GET['id_venta'])){
            $app->readOne($id_venta);
        }else{
            $app->read();
        }
        break;
}
$app->read();

?>