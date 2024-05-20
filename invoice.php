<?php
include __DIR__.'/admin/sistema.class.php';
$datos=$_POST;
$app=new Sistema;
$app->checkRol('CLiente');
try{
    #Conectamos a la base de datos
    $app->conect();
    #Iniciamos la transaccion
    $app->conn->beginTransaction();
    #Preguntar si esta puesto el carrito
    if(isset($_SESSION['cart'])){
        $correo=$_SESSION['correo'];
        $sql="SELECT id_cliente from cliente c join usuario u on c.id_usuario=u.id_usuario where correo = :correo;";
        $stmt=$app->conn->prepare($sql);
        $stmt->bindParam(':correo',$correo,PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $cliente=$stmt->fetchAll();
        if(isset($cliente[0])){
            $id_cliente=$cliente[0]['id_cliente'];
            $id_empleado=1;
            $id_tienda=1;
            $sql="INSERT INTO venta(id_tienda, id_empleado, id_cliente, fecha) VALUE (:id_tienda,:id_empleado,:id_cliente,now());";
            $stmt=$app->conn->prepare($sql);
            $stmt->bindParam(':id_tienda',$id_tienda,PDO::PARAM_INT);
            $stmt->bindParam(':id_empleado',$id_empleado,PDO::PARAM_INT);
            $stmt->bindParam(':id_cliente',$id_cliente,PDO::PARAM_INT);
            $stmt->execute();
            $filas=$stmt->rowCount();
            if($filas){
                $sql="SELECT v.id_venta from venta v WHERE v.id_cliente = :id_cliente order by 1 desc limit 1;";
                $stmt=$app->conn->prepare($sql);
                $stmt->bindParam(':id_cliente',$id_cliente,PDO::PARAM_INT);
                $stmt->execute();
                $venta=$stmt->fetchAll();
                if(isset($venta[0])){
                    $id_venta=$venta[0]['id_venta'];
                    $carrito = $_SESSION['cart'];
                    $filas=0;
                    foreach($carrito as $key=>$value){
                        $id_producto=$key;
                        $cantidad=$value;
                        $sql="INSERT INTO detalle_venta(id_venta, id_producto, cantidad) VALUE (:id_venta,:id_producto,:cantidad);";
                        $stmt=$app->conn->prepare($sql);
                        $stmt->bindParam(':id_venta',$id_venta,PDO::PARAM_INT);
                        $stmt->bindParam(':id_producto',$id_producto,PDO::PARAM_INT);
                        $stmt->bindParam(':cantidad',$cantidad,PDO::PARAM_INT);
                        $stmt->execute();
                        $filas+=$stmt->rowCount();
                    }
                    if($filas){
                        $app->conn->commit();
                        $app->alert('success','Venta realizada');

                    }
                }else{
                    $app->conn->rollBack();
                }
            }else{
                $app->conn->rollBack();
            }
        }
    }else{
        $app->conn->rollBack();
    }
}catch(Exception $e){
    echo $e->getMessage();
    $app->conn->rollBack();
}
?>