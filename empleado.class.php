<?php
    require_once(__DIR__.'/sistema.class.php');
    class Empleado extends Sistema{
        function getAll(){
            $sql = "SELECT id_empleado, CONCAT(primer_apellido,' ',segundo_apellido)apellidos,nombre,rfc,curp FROM empleado";
            $this->conect();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $datos = $stmt->fetchAll();
            $this->SetCount(count($datos));
            return $datos;
        }
        function getOne($id_empleado){
            $this->conect();
            $stmt = $this->conn->prepare("SELECT * FROM empleado 
            where id_empleado=:id_empleado;");
            $stmt->bindParam(':id_empleado', $id_empleado,PDO::PARAM_INT);
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
            /*
            Tomar una fotografía y guardarla en MySQL
            @date @date 2020-04-06
            @author parzibyte
            @web parzibyte.me/blog
            */
            $imagenCodificada = file_get_contents("php://input"); //Obtener la imagen
            if(strlen($imagenCodificada) <= 0) exit("No se recibió ninguna imagen");
            //La imagen traerá al inicio data:image/png;base64, cosa que debemos remover
            
            //Venía en base64 pero sólo la codificamos así para que viajara por la red, ahora la decodificamos y
            //todo el contenido lo guardamos en un archivo
            $imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", urldecode($imagenCodificada));
            $imagenDecodificada = base64_decode($imagenCodificadaLimpia);
            
            $this->conect();
            $this->conn->query("set names utf8;");
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            if($this->validateEmpleado($dato)){
                $stmt = $this->conn->prepare("INSERT INTO empleado (nombre,primer_apellido,segundo_apellido,rfc,curp,fotografia)
                VALUES (:nombre,:primer_apellido,:segundo_apellido,:rfc,:curp,:fotografia);");
                $stmt->bindParam(':nombre', $dato['nombre'],PDO::PARAM_STR);
                $stmt->bindParam(':primer_apellido', $dato['primer_apellido'],PDO::PARAM_STR);
                $stmt->bindParam(':segundo_apellido', $dato['segundo_apellido'],PDO::PARAM_STR);
                $stmt->bindParam(':rfc', $dato['rfc'],PDO::PARAM_STR); 
                $stmt->bindParam(':curp', $dato['curp'],PDO::PARAM_STR);
                $stmt->bindParam(':fotografia', $imagenCodificadaLimpia,PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->rowCount();
            } 
            return 0;
        }
        function delete($id_empleado){
            $this->conect();
            $stmt = $this->conn->prepare("DELETE FROM empleado 
            where id_empleado=:id_empleado;");
            $stmt->bindParam(':id_empleado', $id_empleado,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        }
        
        function update($id_empleado,$datos){
            $this->conect();
            $stmt = $this->conn->prepare("UPDATE empleado SET nombre=:nombre,primer_apellido=:primer_apellido,segundo_apellido=:segundo_apellido,rfc=:rfc,curp=:curp
            WHERE id_empleado=:id_empleado;");
            $stmt->bindParam(':primer_apellido', $datos['primer_apellido'],PDO::PARAM_STR);
            $stmt->bindParam(':segundo_apellido', $datos['segundo_apellido'],PDO::PARAM_STR);
            $stmt->bindParam(':rfc', $datos['rfc'],PDO::PARAM_STR);
            $stmt->bindParam(':curp', $datos['curp'],PDO::PARAM_STR);
            $stmt->bindParam(':id_empleado', $id_empleado,PDO::PARAM_INT);            
            $stmt->bindParam(':nombre', $datos['nombre'],PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount();
        }
        function validarRFC($rfc){
            $regex = '/^[A-Z]{4}[0-9]{6}[A-Z0-9]{3}$/';
            return preg_match($regex, $rfc);
        }   
        function validarCurp($curp){
            $regex = '/^[A-Z]{4}[0-9]{6}[H|M]{1}[A-Z0-9]{7}$/';
            return preg_match($regex, $curp);
        }
        function validateEmpleado($dato){
            if(empty($dato['nombre'])){
                return false;
            }
            if(empty($dato['rfc'])){
                return false;
            }
            if(empty($dato['curp'])){
                return false;
            }
            if(!$this->validarCurp($dato['curp'])){
                return false;
            }
            if(!$this->validarRFC($dato['rfc'])){
                return false;
            }
            return true;
        }
    }
?>