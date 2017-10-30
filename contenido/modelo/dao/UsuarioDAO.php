<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuarioDAO
 *
 * @author Josué Francisco
 */
//include_once "Conexion.php";
//include_once "UsuarioDTO.php";
//include_once "PreparedSQL.php";

final class UsuarioDAO implements DAOPaginable {

    private $db;
    private static $instancia = NULL;
    private static $id = "ID_USUARIO";
    private static $contrasena = "CONTRASENA";
    private static $rol = "ROL";
    private static $estado = "ESTADO";
    private static $email = "EMAIL";

    //--------CONSTANTES DE LOS ROLES POSIBLES PARA UN USUARIO
    const ROL_USER = "USER";
    const ROL_MAIN_ADMIN = "MANAGER";
    const ROL_SUB_ADMIN = "SUB_MANAGER";
    const ROL_APRENDIZ_SENA = "APRENDIZ_SENA";
    const ROL_INSTRUCTOR_SENA = "INSTRUCTOR_SENA";
    const ROL_COLEGIO = "INSTITUCION_COLEGIO";
    const ROL_PARTICULAR = "PARTICULAR";
    const ROL_EMPRESA = "EMPRESA";
    //---------CONSTANTES DE LOS ESTADO POSIBLES PARA UN USUARIO
    const EST_ACTIVO = "ENABLED";
    const EST_INACTIVO = "DISABLED";
    const EST_ELIMINADO = "DELETED";

    public function __construct() {
        $this->db = Conexion::getInstance();
    }

    public static function getInstancia() {
        if (is_null(self::$instancia)) {
            self::$instancia = new UsuarioDAO();
        }
        return self::$instancia;
    }

    private function resultToArray(mysqli_result $resultado) {
        $tablaUsuario = [];
        while ($fila = $resultado->fetch_array()) {
            $user = new UsuarioDTO();
            $user->setIdUsuario($fila[self::$id]);
            $user->setPassword($fila[self::$contrasena]);
            $user->setRol($fila[self::$rol]);
            $user->setEstado($fila[self::$estado]);
            $user->setEmail($fila[self::$email]);
            $tablaUsuario[] = $user;
        }
        return $tablaUsuario;
    }

    private function resultToObject(mysqli_result $resultado) {
        $user = new UsuarioDTO();
        $fila = $resultado->fetch_array();
        $user->setIdUsuario($fila[self::$id]);
        $user->setPassword($fila[self::$contrasena]);
        $user->setRol($fila[self::$rol]);
        $user->setEstado($fila[self::$estado]);
        $user->setEmail($fila[self::$email]);
        return $user;
    }

    public function find(UsuarioDTO $user) {
        $idUser = $user->getIdUsuario();
        $usuario = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::usuario_find);
            $stmt->bind_param("s", $idUser);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $resultado instanceof mysqli_result;
            if ($resultado->num_rows != 0) {
                $usuario = $this->resultToObject($resultado);
            }
            $resultado->close();
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $usuario;
    }

    public function findByEmail(UsuarioDTO $user) {
        $email = $user->getEmail();
        $usuario = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::usuario_by_email);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $resultado instanceof mysqli_result;
            if ($resultado->num_rows != 0) {
                $usuario = $this->resultToObject($resultado);
            }
            $resultado->close();
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $ex) {
            echo $ex->getMessage();
        }
        return $usuario;
    }

    public function findAll() {
        $tablaUsuario = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $resultado = $conexion->query(PreparedSQL::usuario_find_all);
            $resultado instanceof mysqli_result;
            if ($resultado->num_rows != 0) {
                $tablaUsuario = $this->resultToArray($resultado);
            }
            $resultado->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $tablaUsuario;
    }

    public function insert(UsuarioDTO $user) {
        $idUser = $user->getIdUsuario();
        $passUser = $user->getPassword();
        $rolUser = $user->getRol();
        $emailUser = $user->getEmail();
        $rta = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::usuario_insert);
            $stmt->bind_param("ssss", $idUser, $passUser, $rolUser, $emailUser);
            $stmt->execute();
            $rta = $stmt->affected_rows;

            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $rta;
    }

    public function update(UsuarioDTO $user) {
        $idUser = $user->getIdUsuario();
        $passUser = $user->getPassword();
        $emailUser = $user->getEmail();
        $rta = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::usuario_update);
            $stmt->bind_param("sss", $passUser, $emailUser, $idUser);
            $stmt->execute();
            $rta = $stmt->affected_rows;

            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $rta;
    }

    public function updatePassword(UsuarioDTO $user) {
        $rta = 0;
        $idUser = $user->getIdUsuario();
        $passUser = $user->getPassword();
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::usuario_update_password);
            $stmt->bind_param("ss", $passUser, $idUser);
            $stmt->execute();
            $rta = $stmt->affected_rows;

            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $rta;
    }

    public function delete(UsuarioDTO $user) {
        $idUser = $user->getIdUsuario();
        $rta = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::usuario_delete);
            $stmt->bind_param("s", $idUser);
            $stmt->execute();
            $rta = $stmt->affected_rows;

            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $rta;
    }

    public function putRol(UsuarioDTO $user) {
        $idUser = $user->getIdUsuario();
        $rolUser = $user->getRol();
        $rta = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::usuario_put_rol);
            $stmt->bind_param("ss", $rolUser, $idUser);
            $stmt->execute();
            $rta = $stmt->affected_rows;

            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $rta;
    }

    public function putEstado(UsuarioDTO $user) {
        $idUser = $user->getIdUsuario();
        $estadoUser = $user->getEstado();
        $rta = 0;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::usuario_put_estado);
            $stmt->bind_param("ss", $estadoUser, $idUser);
            $stmt->execute();
            $rta = $stmt->affected_rows;

            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $rta;
    }

    public function findByRolAndEstado(UsuarioDTO $user) {
        $rol = $user->getRol();
        $estado = $user->getEstado();
        $tablaUsuarios = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::usuario_find_by_rol_and_estado);
            $stmt->bind_param("ss", $rol, $estado);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $resultado instanceof mysqli_result;
            if ($resultado->num_rows != 0) {
                $tablaUsuarios = $this->resultToArray($resultado);
            }
            $resultado->close();
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $ex) {
            echo $ex->getMessage();
        }
        return $tablaUsuarios;
    }

    public function findByIdLike(UsuarioDTO $user) {
        $idUser = "%" . $user->getIdUsuario() . "%";
        $tablaUsuario = NULL;
        try {
            $conexion = $this->db->creaConexion();
            $conexion instanceof mysqli;
            $stmt = $conexion->prepare(PreparedSQL::usuario_find_by_id_like);
            $stmt->bind_param("s", $idUser);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $resultado instanceof mysqli_result;
            if ($resultado->num_rows != 0) {
                $tablaUsuario = $this->resultToArray($resultado);
            }
            $resultado->close();
            $stmt->close();
            $conexion->close();
        } catch (mysqli_sql_exception $exc) {
            echo $exc->getMessage();
        }
        return $tablaUsuario;
    }

    public function findByPaginationLimit($inicio, $cantidad) {
        
    }

}
