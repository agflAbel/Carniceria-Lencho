<?php
    require_once(__DIR__.'/sistema.class.php');
    class Privilegio extends Sistema{
        function getAll(){
            $sql = "SELECT * FROM privilegio";
            $this->conect();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $datos = $stmt->fetchAll();
            $this->SetCount(count($datos));
            return $datos;
        }
        function getOne($id_privilegio){
            $this->conect();
            $stmt = $this->conn->prepare("SELECT * FROM privilegio 
            where id_privilegio=:id_privilegio;");
            $stmt->bindParam(':id_privilegio', $id_privilegio,PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $datos=array();
            $datos = $stmt->fetchAll();
            if(isset($datos[0])){
                $this->SetCount(count($datos));
                return $datos[0];
            }
            return array();
        }
        function insert($dato){
            $this->conect();
            $stmt = $this->conn->prepare("INSERT INTO privilegio (privilegio)
            VALUES (:privilegio);");
            $stmt->bindParam(':privilegio', $dato['privilegio'],PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount();
            return 0;
        }
        function delete($id_privilegio){
            $this->conect();
            $stmt = $this->conn->prepare("DELETE FROM privilegio 
            where id_privilegio=:id_privilegio;");
            $stmt->bindParam(':id_privilegio', $id_privilegio,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        }
        
        function update($id_privilegio,$datos){
            $this->conect();
            $stmt = $this->conn->prepare("UPDATE privilegio SET privilegio=:privilegio
            WHERE id_privilegio=:id_privilegio;");
            $stmt->bindParam(':privilegio', $datos['privilegio'],PDO::PARAM_STR);
            $stmt->bindParam(':id_privilegio', $id_privilegio,PDO::PARAM_INT);   
            $stmt->execute();
            return $stmt->rowCount();
        }
    }
?>