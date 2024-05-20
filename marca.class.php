<?php
    require_once(__DIR__.'/sistema.class.php');
    class Marca extends Sistema{
        function getAll(){
            $sql = "SELECT * FROM marca";
            $this->conect();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $datos = $stmt->fetchAll();
            $this->SetCount(count($datos));
            return $datos;
        }
        function getOne($id_marca){
            $this->conect();
            $stmt = $this->conn->prepare("SELECT * FROM marca 
            where id_marca=:id_marca;");
            $stmt->bindParam(':id_marca', $id_marca,PDO::PARAM_INT);
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
            $nombre_archivo = $this->upload('marcas');
            if($nombre_archivo){
                if($this->validateMarca($dato)){
                    $stmt = $this->conn->prepare("INSERT INTO marca (marca,fotografia)
                    VALUES (:marca,:fotografia);");
                    $stmt->bindParam(':marca', $dato['marca'],PDO::PARAM_STR);
                    $stmt->bindParam(':fotografia', $nombre_archivo,PDO::PARAM_STR);
                    $stmt->execute();
                    return $stmt->rowCount();
                }
            }
            return 0;
        }
        function delete($id_marca){
            $this->conect();
            $stmt = $this->conn->prepare("DELETE FROM marca 
            where id_marca=:id_marca;");
            $stmt->bindParam(':id_marca', $id_marca,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        }
        
        function update($id_marca,$datos){
            $this->conect();
            $nombre_archivo = $this->upload('marcas');
            if($nombre_archivo){
                $stmt = $this->conn->prepare("UPDATE marca SET marca=:marca,
                fotografia=:fotografia
                WHERE id_marca=:id_marca;");
                $stmt->bindParam(':fotografia', $nombre_archivo,PDO::PARAM_STR);
            }else{
                $stmt = $this->conn->prepare("UPDATE marca SET marca=:marca
                WHERE id_marca=:id_marca;");
            }
            $stmt->bindParam(':id_marca', $id_marca,PDO::PARAM_INT);            
            $stmt->bindParam(':marca', $datos['marca'],PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount();
        }
        function validateMarca($dato){
            if(empty($dato['marca'])){
                return false;
            }
            return true;
        }
    }
?>