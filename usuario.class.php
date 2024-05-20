<?php
    require_once(__DIR__.'/sistema.class.php');
    class Usuario extends Sistema{
        function getAll(){
            $sql = "SELECT * FROM usuario";
            $this->conect();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $datos = $stmt->fetchAll();
            $this->SetCount(count($datos));
            return $datos;
        }
        function getOne($id_usuario){
            $this->conect();
            $sql="SELECT * from usuario u where id_usuario=:id_usuario;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario,PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $datos=array();
            $datos = $stmt->fetchAll();
            if(isset($datos[0])){
                $this->SetCount(count($datos));
                $datos=$datos[0];
                $sql="SELECT r.id_rol,r.rol FROM rol r 
                    join usuario_rol ur on ur.id_rol = r.id_rol 
                    where ur.id_usuario=:id_usuario";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':id_usuario', $id_usuario,PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $datos['roles']=array();
                $misRoles=$stmt->fetchAll();
                foreach($misRoles as $rol){
                    $datos['roles'][$rol['id_rol']] = $rol['rol'];
                }
                return $datos;
            }
            return array();
        }
        function insert($dato,$roles){
            $this->conect();
            $contrasena=md5($dato['contrasena']);
            try{
                $this->conn->beginTransaction();
                $sql="SELECT * from usuario where correo = :correo";
                $stmt=$this->conn->prepare($sql);
                // echo "<pre>";
                // print_r($dato);
                // die;
                $stmt->bindParam(':correo',$dato['correo'],PDO::PARAM_STR);
                $stmt->execute();
                $usuario=$stmt->fetchAll();
                if(isset($usuario[0])){
                    $this->conn->rollBack();
                    return false;
                }
                $sql="INSERT INTO usuario (correo,contrasena) VALUES (:correo,:contrasena);";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':correo', $dato['correo'],PDO::PARAM_STR);
                $stmt->bindParam(':contrasena', $contrasena,PDO::PARAM_STR);
                $stmt->execute();
                $sql="SELECT * FROM usuario WHERE correo = :correo";
                $stmt=$this->conn->prepare($sql);
                $stmt->bindParam(':correo',$dato['correo'],PDO::PARAM_STR);
                $stmt->execute();
                $usuario=array();
                $usuario=$stmt->fetchAll();
                if($usuario[0]){
                    $id_usuario = $usuario[0]['id_usuario'];
                    foreach($roles as $rol):
                        // echo "<pre>";
                        // print_r($usuario);
                        // print_r($dato);
                        // print_r($rol);
                        // die;
                        if(array_key_exists($rol['id_rol'],$dato)){
                            if($dato[$rol['id_rol']]=='on'){
                                $sql='INSERT INTO usuario_rol (id_usuario,id_rol) VALUES (:id_usuario,:id_rol);';
                                $stmt = $this->conn->prepare($sql);
                                $stmt->bindParam(':id_usuario', $id_usuario,PDO::PARAM_INT);
                                $stmt->bindParam(':id_rol', $rol['id_rol'],PDO::PARAM_INT);
                                $stmt->execute();
                                $sql="SELECT * FROM usuario_rol WHERE id_usuario=:id_usuario AND id_rol=:id_rol";
                                $stmt=$this->conn->prepare($sql);
                                $stmt->bindParam(':id_usuario',$id_usuario,PDO::PARAM_INT);
                                $stmt->bindParam(':id_rol',$rol['id_rol'],PDO::PARAM_INT);
                                $stmt->execute();
                                $usuario_rol=$stmt->fetchAll();
                                if(!isset($usuario_rol[0])){
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
        function delete($id_usuario){
            $this->conect();
            try{
                $this->conn->beginTransaction();
                $sql="DELETE FROM usuario_rol WHERE id_usuario=:id_usuario";
                $stmt=$this->conn->prepare($sql);
                $stmt->bindParam(':id_usuario',$id_usuario,PDO::PARAM_INT);
                $stmt->execute();
                $sql="DELETE FROM usuario WHERE id_usuario=:id_usuario";
                $stmt=$this->conn->prepare($sql);
                $stmt->bindParam(':id_usuario',$id_usuario,PDO::PARAM_INT);
                $stmt->execute();
                if($stmt->rowCount()){
                    $this->conn->commit();
                    return true;
                }
            }catch(PDOException $e){
                $this->conn->rollback();
                return false;
            }
        }
        
        function update($id_usuario,$datos,$roles){
            $this->conect();
            $contrasena='';
            // echo "<pre>";
            // print_r($id_usuario);
            // die;
            // print_r($datos);
            // print_r($datos['contrasena']);
            try{
                $this->conn->beginTransaction();
                if($datos['contrasena']==''){
                    $sql="UPDATE usuario SET correo=:correo where id_usuario=:id_usuario";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':correo', $datos['correo'],PDO::PARAM_STR);
                    $stmt->bindParam(':id_usuario', $id_usuario,PDO::PARAM_INT);
                    $stmt->execute();
                    // print("----------------------------------------");
                }else{
                    $contrasena=md5($datos['contrasena']);
                    $sql="UPDATE usuario SET correo=:correo, contrasena=:contrasena where id_usuario=:id_usuario";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':correo', $datos['correo'],PDO::PARAM_STR);
                    $stmt->bindParam(':contrasena', $contrasena,PDO::PARAM_STR);
                    $stmt->bindParam(':id_usuario', $id_usuario,PDO::PARAM_INT);
                    $stmt->execute();
                }
                // print_r($stmt->rowCount());
                // die;
                    foreach($roles as $rol):
                        // echo "<pre>";
                        // print_r($roles);
                        // print_r($datos);
                        // print_r($rol);
                        // die;
                        if(array_key_exists($rol['id_rol'],$datos)){
                            if($datos[$rol['id_rol']]=='on'){
                                $sql="SELECT * from usuario_rol where id_rol=:id_rol and id_usuario=:id_usuario";
                                $stmt=$this->conn->prepare($sql);
                                $stmt->bindParam(':id_rol',$rol['id_rol'],PDO::PARAM_INT);
                                $stmt->bindParam(':id_usuario',$id_usuario,PDO::PARAM_INT);
                                $stmt->execute();
                                if(!$stmt->rowCount()){
                                    $sql="INSERT INTO usuario_rol (id_rol,id_usuario) VALUES (:id_rol,:id_usuario);";
                                    $stmt = $this->conn->prepare($sql);
                                    $stmt->bindParam(':id_rol', $rol['id_rol'],PDO::PARAM_INT);
                                    $stmt->bindParam(':id_usuario', $id_usuario,PDO::PARAM_INT);
                                    $stmt->execute();
                                    $sql="SELECT * FROM usuario_rol WHERE id_usuario=:id_usuario AND id_rol=:id_rol";
                                    $stmt=$this->conn->prepare($sql);
                                    $stmt->bindParam(':id_usuario',$id_usuario,PDO::PARAM_INT);
                                    $stmt->bindParam(':id_rol',$rol['id_rol'],PDO::PARAM_INT);
                                    $stmt->execute();
                                    $usuario_rol=$stmt->fetchAll();
                                    if(!isset($usuario_rol[0])){
                                        $this->conn->rollBack();
                                        return false;
                                    }
                                }
                            }
                        }else{
                            $sql="DELETE FROM usuario_rol WHERE id_usuario=:id_usuario AND id_rol=:id_rol";
                            $stmt = $this->conn->prepare($sql);
                            $stmt->bindParam(':id_usuario', $id_usuario,PDO::PARAM_INT);
                            $stmt->bindParam(':id_rol', $rol['id_rol'],PDO::PARAM_INT);
                            $stmt->execute();
                        }
                    endforeach;
                    $this->conn->commit();
                    return true;
            }catch(PDOException $e){
                return false;
            }
        }
    }
?>