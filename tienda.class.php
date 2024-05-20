<?php
    require_once(__DIR__.'/sistema.class.php');
    class Tienda extends Sistema{
        function getAll(){
            $sql = "SELECT * FROM tienda";
            $this->conect();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $datos = $stmt->fetchAll();
            $this->SetCount(count($datos));
            return $datos;
        }
        function getOne($id_tienda){
            $this->conect();
            $stmt = $this->conn->prepare("SELECT * FROM tienda 
            where id_tienda=:id_tienda;");
            $stmt->bindParam(':id_tienda', $id_tienda,PDO::PARAM_INT);
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
            $nombre_archivo = $this->upload('tiendas');
            if($nombre_archivo){
                if($dato['latitud']==''){
                    if($dato['longitud']==''){
                        $stmt = $this->conn->prepare("INSERT INTO tienda (tienda,fotografia)
                        VALUES (:tienda,:fotografia);");
                    }else{
                        $stmt = $this->conn->prepare("INSERT INTO tienda (tienda,fotografia,longitud)
                        VALUES (:tienda,:fotografia,:longitud);");
                        $stmt->bindParam(':longitud', $dato['longitud'],PDO::PARAM_STR);
                    }
                }else if($dato['longitud']==''){ 
                    $stmt = $this->conn->prepare("INSERT INTO tienda (tienda,fotografia,latitud)
                    VALUES (:tienda,:fotografia,:latitud);");
                    $stmt->bindParam(':latitud', $dato['latitud'],PDO::PARAM_STR);
                }else{
                    $stmt = $this->conn->prepare("INSERT INTO tienda (tienda,fotografia,latitud,longitud)
                    VALUES (:tienda,:fotografia,:latitud,:longitud);");
                    $stmt->bindParam(':latitud', $dato['latitud'],PDO::PARAM_STR);
                    $stmt->bindParam(':longitud', $dato['longitud'],PDO::PARAM_STR);
                }
                $stmt->bindParam(':fotografia', $nombre_archivo,PDO::PARAM_STR);
            }else{
                if($dato['latitud']==''){
                    if($dato['longitud']==''){
                        $stmt = $this->conn->prepare("INSERT INTO tienda (tienda)
                        VALUES (:tienda);");
                    }else{
                        $stmt = $this->conn->prepare("INSERT INTO tienda (tienda,longitud)
                        VALUES (:tienda,:longitud);");
                        $stmt->bindParam(':longitud', $dato['longitud'],PDO::PARAM_STR);
                    }
                }else if($dato['longitud']==''){ 
                    $stmt = $this->conn->prepare("INSERT INTO tienda (tienda,latitud)
                    VALUES (:tienda,:latitud);");
                    $stmt->bindParam(':latitud', $dato['latitud'],PDO::PARAM_STR);
                }else{
                    $stmt = $this->conn->prepare("INSERT INTO tienda (tienda,latitud,longitud)
                    VALUES (:tienda,:latitud,:longitud);");
                    $stmt->bindParam(':latitud', $dato['latitud'],PDO::PARAM_STR);
                    $stmt->bindParam(':longitud', $dato['longitud'],PDO::PARAM_STR);
                }
            }
            $stmt->bindParam(':tienda', $dato['tienda'],PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount();
            
        }
        function delete($id_tienda){
            $this->conect();
            $stmt = $this->conn->prepare("DELETE FROM tienda 
            where id_tienda=:id_tienda;");
            $stmt->bindParam(':id_tienda', $id_tienda,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        }
        
        function update($id_tienda,$dato){
            $this->conect();
            $nombre_archivo = $this->upload('tiendas');
            if($nombre_archivo){
                if($dato['latitud']==''){
                    if($dato['longitud']==''){
                        $stmt = $this->conn->prepare("UPDATE tienda SET tienda=:tienda, fotografia=:fotografia
                        WHERE id_tienda=:id_tienda;");
                    }else{
                        $stmt = $this->conn->prepare("UPDATE tienda SET tienda=:tienda,
                            longitud=:longitud, fotografia=:fotografia
                            WHERE id_tienda=:id_tienda;");
                        $stmt->bindParam(':longitud', $dato['longitud'],PDO::PARAM_STR);
                    }
                }else if($dato['longitud']==''){ 
                    $stmt = $this->conn->prepare("UPDATE tienda SET tienda=:tienda,
                        latitud=:latitud,fotografia=:fotografia
                        WHERE id_tienda=:id_tienda;");
                    $stmt->bindParam(':latitud', $dato['latitud'],PDO::PARAM_STR);
                }else{
                    $stmt = $this->conn->prepare("UPDATE tienda SET tienda=:tienda,
                        longitud=:longitud, latitud=:latitud,fotografia=:fotografia
                        WHERE id_tienda=:id_tienda;");
                    $stmt->bindParam(':latitud', $dato['latitud'],PDO::PARAM_STR);
                    $stmt->bindParam(':longitud', $dato['longitud'],PDO::PARAM_STR);
                }
                $stmt->bindParam(':fotografia', $nombre_archivo,PDO::PARAM_STR);
            }else{
                if($dato['latitud']==''){
                    if($dato['longitud']==''){
                        $stmt = $this->conn->prepare("UPDATE tienda SET tienda=:tienda
                        WHERE id_tienda=:id_tienda;");
                    }else{
                        $stmt = $this->conn->prepare("UPDATE tienda SET tienda=:tienda,
                            longitud=:longitud   WHERE id_tienda=:id_tienda;");
                        $stmt->bindParam(':longitud', $dato['longitud'],PDO::PARAM_STR);
                    }
                }else if($dato['longitud']==''){ 
                    $stmt = $this->conn->prepare("UPDATE tienda SET tienda=:tienda,
                        latitud=:latitud
                        WHERE id_tienda=:id_tienda;");
                    $stmt->bindParam(':latitud', $dato['latitud'],PDO::PARAM_STR);
                }else{
                    $stmt = $this->conn->prepare("UPDATE tienda SET tienda=:tienda,
                    longitud=:longitud, latitud=:latitud
                    WHERE id_tienda=:id_tienda;");
                    $stmt->bindParam(':latitud', $dato['latitud'],PDO::PARAM_STR);
                    $stmt->bindParam(':longitud', $dato['longitud'],PDO::PARAM_STR);
                }
            }
            if($nombre_archivo){
                $stmt = $this->conn->prepare("UPDATE tienda SET tienda=:tienda,
                longitud=:longitud, latitud=:latitud,fotografia=:fotografia
                WHERE id_tienda=:id_tienda;");
                $stmt->bindParam(':fotografia', $nombre_archivo,PDO::PARAM_STR);
            }else{
                $stmt = $this->conn->prepare("UPDATE tienda SET tienda=:tienda,
                longitud=:longitud, latitud=:latitud
                WHERE id_tienda=:id_tienda;");
            }
            $stmt->bindParam(':id_tienda', $id_tienda,PDO::PARAM_INT);            
            $stmt->bindParam(':tienda', $dato['tienda'],PDO::PARAM_STR);
            $stmt->bindParam(':longitud', $dato['longitud'],PDO::PARAM_STR);
            $stmt->bindParam(':latitud', $dato['latitud'],PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount();
        }
        
    }
?>