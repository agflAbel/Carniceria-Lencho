<?php
    require_once(__DIR__.'/sistema.class.php');
    class Cliente extends Sistema{
        function getAll(){
            $sql = "SELECT id_cliente, CONCAT(primer_apellido,' ',segundo_apellido)apellidos,nombre,rfc FROM cliente";
            $this->conect();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $datos = $stmt->fetchAll();
            $this->SetCount(count($datos));
            return $datos;
        }
        function getOne($id_cliente){
            $this->conect();
            $stmt = $this->conn->prepare("SELECT * FROM cliente 
            where id_cliente=:id_cliente;");
            $stmt->bindParam(':id_cliente', $id_cliente,PDO::PARAM_INT);
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
            if($dato['rfc']==''){
                $stmt = $this->conn->prepare("INSERT INTO cliente (nombre,primer_apellido,segundo_apellido)
                VALUES (:nombre,:primer_apellido,:segundo_apellido);");
            }else{
                $stmt = $this->conn->prepare("INSERT INTO cliente (nombre,primer_apellido,segundo_apellido,rfc)
                VALUES (:nombre,:primer_apellido,:segundo_apellido,:rfc);");
                $stmt->bindParam(':rfc', $dato['rfc'],PDO::PARAM_STR); 
            }
            $stmt->bindParam(':nombre', $dato['nombre'],PDO::PARAM_STR);
            $stmt->bindParam(':primer_apellido', $dato['primer_apellido'],PDO::PARAM_STR);
            $stmt->bindParam(':segundo_apellido', $dato['segundo_apellido'],PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount();
            return 0;
        }
        function delete($id_cliente){
            $this->conect();
            $stmt = $this->conn->prepare("DELETE FROM cliente 
            where id_cliente=:id_cliente;");
            $stmt->bindParam(':id_cliente', $id_cliente,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        }
        
        function update($id_cliente,$datos){
            $this->conect();
            $stmt = $this->conn->prepare("UPDATE cliente SET nombre=:nombre,primer_apellido=:primer_apellido,segundo_apellido=:segundo_apellido,rfc=:rfc
            WHERE id_cliente=:id_cliente;");
            $stmt->bindParam(':primer_apellido', $datos['primer_apellido'],PDO::PARAM_STR);
            $stmt->bindParam(':segundo_apellido', $datos['segundo_apellido'],PDO::PARAM_STR);
            $stmt->bindParam(':rfc', $datos['rfc'],PDO::PARAM_STR);
            $stmt->bindParam(':id_cliente', $id_cliente,PDO::PARAM_INT);            
            $stmt->bindParam(':nombre', $datos['nombre'],PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount();
        }
    }
?>