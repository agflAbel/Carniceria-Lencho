<?php
    require_once(__DIR__.'/sistema.class.php');
    class Rol extends Sistema{
        function getAll(){
            $sql = "SELECT * FROM rol";
            $this->conect();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $datos = $stmt->fetchAll();
            $this->SetCount(count($datos));
            return $datos;
        }
        function getOne($id_rol){
            $this->conect();
            $sql="SELECT * from rol r where id_rol=:id_rol;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_rol', $id_rol,PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $datos=array();
            $datos = $stmt->fetchAll();
            if(isset($datos[0])){
                $this->SetCount(count($datos));
                $datos=$datos[0];
                $sql="SELECT p.id_privilegio,p.privilegio FROM privilegio p 
                    join rol_privilegio rp on rp.id_privilegio = p.id_privilegio 
                    where rp.id_rol=:id_rol";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':id_rol', $id_rol,PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $datos['privilegios']=array();
                $misprivs=$stmt->fetchAll();
                foreach($misprivs as $privs){
                    $datos['privilegios'][$privs['id_privilegio']] = $privs['privilegio'];
                }
                // echo "<pre>";
                // print_r($datos);
                // die;
                return $datos;
            }
            return array();
        }
        function insert($dato,$privilegios){
            $this->conect();
            try{
                $this->conn->beginTransaction();
                $sql="SELECT * from rol where rol = :rol";
                $stmt=$this->conn->prepare($sql);
                $stmt->bindParam(':rol',$dato['rol'],PDO::PARAM_STR);
                $stmt->execute();
                $rol=$stmt->fetchAll();
                if(isset($rol[0])){
                    $this->conn->rollBack();
                    return false;
                }
                $sql="INSERT INTO rol (rol) VALUES (:rol);";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':rol', $dato['rol'],PDO::PARAM_STR);
                $stmt->execute();
                $sql="SELECT * FROM rol WHERE rol = :rol";
                $stmt=$this->conn->prepare($sql);
                $stmt->bindParam(':rol',$dato['rol'],PDO::PARAM_STR);
                $stmt->execute();
                $rol=$stmt->fetchAll();
                if($rol[0]){
                    $id_rol = $rol[0]['id_rol'];
                    foreach($privilegios as $privi):
                        // echo "<pre>";
                        // print_r($privi);
                        // print_r($dato);
                        // die;
                        if(array_key_exists($privi['id_privilegio'],$dato)){
                            if($dato[$privi['id_privilegio']]=='on'){
                                $sql='INSERT INTO rol_privilegio (id_rol,id_privilegio) VALUES (:id_rol,:id_privilegio);';
                                $stmt = $this->conn->prepare($sql);
                                $stmt->bindParam(':id_rol', $id_rol,PDO::PARAM_INT);
                                $stmt->bindParam(':id_privilegio', $privi['id_privilegio'],PDO::PARAM_INT);
                                $stmt->execute();
                                $sql="SELECT * FROM rol_privilegio WHERE id_rol=:id_rol AND id_privilegio=:id_privilegio";
                                $stmt=$this->conn->prepare($sql);
                                $stmt->bindParam(':id_rol',$id_rol,PDO::PARAM_INT);
                                $stmt->bindParam(':id_privilegio',$privi['id_privilegio'],PDO::PARAM_INT);
                                $stmt->execute();
                                $rol_privilegio=$stmt->fetchAll();
                                if(!isset($rol_privilegio[0])){
                                    $this->conn->rollBack();
                                    return false;
                                }
                            }
                        }
                    endforeach;
                    $this->conn->commit();
                    return true;
                }else{
                    $this->conn->rollBack();
                    return false;
                }
            }catch(PDOException $e){
                return false;
            }
        }
        function delete($id_rol){
            $this->conect();
            try{
                $this->conn->beginTransaction();
                $sql="DELETE FROM rol_privilegio WHERE id_rol=:id_rol";
                $stmt=$this->conn->prepare($sql);
                $stmt->bindParam(':id_rol',$id_rol,PDO::PARAM_INT);
                $stmt->execute();
                $sql="DELETE FROM rol WHERE id_rol=:id_rol";
                $stmt=$this->conn->prepare($sql);
                $stmt->bindParam(':id_rol',$id_rol,PDO::PARAM_INT);
                $stmt->execute();
                if($stmt->rowCount()){
                    $this->conn->commit();
                    return true;
                }
            }catch(PDOException $e){
                return false;
            }
        }
        
        function update($id_rol,$datos){
            $this->conect();
            $stmt = $this->conn->prepare("UPDATE rol SET rol=:rol
            WHERE id_rol=:id_rol;");
            $stmt->bindParam(':rol', $datos['rol'],PDO::PARAM_STR);
            $stmt->bindParam(':id_rol', $id_rol,PDO::PARAM_INT);   
            $stmt->execute();
            return $stmt->rowCount();
        }
    }
?>