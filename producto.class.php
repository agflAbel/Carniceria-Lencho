<?php
    require_once (__DIR__.'/sistema.class.php');
    class Producto extends Sistema{
        function getAll(){
            $sql = "SELECT id_producto,producto,marca,precio,pr.fotografia,m.fotografia fotomarca
                FROM producto pr INNER JOIN marca m on pr.id_marca=m.id_marca";
            $this->conect();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $datos = $stmt->fetchAll();
            $this->SetCount(count($datos));
            return $datos;
        }
        function getOne($id_producto){
            $this->conect();
            $stmt = $this->conn->prepare("SELECT id_producto,producto,marca,m.id_marca,precio,pr.fotografia,m.fotografia fotomarca FROM producto pr INNER JOIN marca m on pr.id_marca=m.id_marca
            where id_producto=:id_producto;");
            $stmt->bindParam(':id_producto', $id_producto,PDO::PARAM_INT);
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
            $nombre_archivo = $this->upload('productos');
            if($nombre_archivo){
                $stmt = $this->conn->prepare("INSERT INTO producto (producto,precio,id_marca,fotografia)
                VALUES (:producto,:precio,:id_marca,:fotografia);");
                $stmt->bindParam(':fotografia', $nombre_archivo,PDO::PARAM_STR);
            }else{
                $stmt = $this->conn->prepare("INSERT INTO producto (producto,precio,id_marca)
                VALUES (:producto,:precio,:id_marca);");
            }
            if($nombre_archivo){
                if($this->validateMarca($dato)){
                    
                    $stmt->bindParam(':producto', $dato['producto'],PDO::PARAM_STR);
                    $stmt->bindParam(':precio', $dato['precio'],PDO::PARAM_STR);
                    $stmt->bindParam(':id_marca', $dato['marca'],PDO::PARAM_STR);
                    $stmt->execute();
                    return $stmt->rowCount();
                }
            }
            return 0;
        }
        function delete($id_producto){
            $this->conect();
            $stmt = $this->conn->prepare("DELETE FROM producto 
            where id_producto=:id_producto;");
            $stmt->bindParam(':id_producto', $id_producto,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        }
        
        function update($id_producto,$dato){
            $this->conect();
            $nombre_archivo = $this->upload('productos');
            if($nombre_archivo){
                $stmt = $this->conn->prepare("UPDATE producto SET producto=:producto,
                precio=:precio, id_marca=:id_marca,fotografia=:fotografia
                WHERE id_producto=:id_producto;");
                $stmt->bindParam(':fotografia', $nombre_archivo,PDO::PARAM_STR);
            }else{
                $stmt = $this->conn->prepare("UPDATE producto SET producto=:producto,
                precio=:precio, id_marca=:id_marca
                WHERE id_producto=:id_producto;");
            }
            $stmt->bindParam(':id_producto', $id_producto,PDO::PARAM_INT);            
            $stmt->bindParam(':producto', $dato['producto'],PDO::PARAM_STR);
            $stmt->bindParam(':precio', $dato['precio'],PDO::PARAM_STR);
            $stmt->bindParam(':id_marca', $dato['marca'],PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount();
        }
        function validateMarca($dato){
            if(empty($dato['producto'])){
                return false;
            }
            return true;
        }
    }
?>