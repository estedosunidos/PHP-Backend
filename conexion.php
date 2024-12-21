<?php
abstract class Conectar {
    protected $con;  // Propiedad protegida

    public function __construct() {
        try {
            // Inicialización de la conexión
            $this->con = new PDO("mysql:dbname=ejemplo;host=localhost", "root", "");
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->con->exec("SET NAMES 'utf8'");
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    // Método público para acceder a la conexión
    public function getConnection() {
        return $this->con;
    }
}



class Dato extends Conectar {
    public function getDatas($sql) {
        // Usar el método getConnection para acceder a la conexión
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function setDato($sql) {
        // Usar el método getConnection para acceder a la conexión
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
    }
}

?>
