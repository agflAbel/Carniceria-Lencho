<?php
include __DIR__.'/sistema.class.php';
class Pedidos extends Sistema{
    public function getALl(){
        $sql = "SELECT * FROM pedido";
        $this->conect();
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->SetCount(count($datos));
        return $datos;
    }
}
?>