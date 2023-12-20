<?php
session_start();
class Crud
{
    private $conn;
    private $table_name = "usuario";
    private $db_name = "trabfinal";
    private $id;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // -----------------------------------------------------------------------------------------------



    public function read()
    {
        $query = "SELECT * FROM " . $this->db_name . "." . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function readTar($idtarefa)
    {
        $query = "SELECT texto FROM trabfinal.tarefa where idtarefa = " . $idtarefa;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = $row["id"];
        return $stmt;
        var_dump($stmt);
    }
    public function readTarefa($login)
    {
        $query = "SELECT id FROM trabfinal.usuario WHERE login = :login";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $login2 = $row["id"];

        $query = "SELECT * FROM " . $this->db_name . ".tarefa WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $login2);
        $stmt->execute();

        return $stmt;
    }
    public function readAllTarefa()
    {
        $query = "SELECT * FROM trabfinal.tarefa";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }







    // --------------------------------------------------------------------------------------------------------


    public function update($texto, $newTexto)
    {
        $query = "SELECT texto FROM trabfinal.tarefa WHERE idtarefa = :login";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':login', $texto);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $texto = $row["texto"];

        $query = "UPDATE trabfinal.tarefa SET texto = ? WHERE idtarefa = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$newTexto, $texto]);
        return $stmt;
    }

    public function delete($login)
    {
        $query = "DELETE FROM trabfinal.tarefa WHERE idtarefa = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$login]);
        return $stmt;
    }

    public function insert($nome, $senha)
    {

        $query = "INSERT INTO " . $this->db_name . "." . $this->table_name . " (login, senha) VALUES
        (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nome, $senha]);

        return $stmt;
    }
    public function insertTarefa($texto, $login)
    {
        $query = "SELECT id FROM trabfinal.usuario WHERE login = :login";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $login2 = $row["id"];

        $query = "INSERT INTO " . $this->db_name . ".tarefa (texto, usuario_id) VALUES
        (?, ?)";
        $stmt = $this->conn->prepare($query);
        try {
            $stmt->execute([$texto, $login2]);
        } catch (PDOException $e) {
            return null;
        }

        return $stmt;
    }
    public function insertTarefaADM($texto, $login)
    {
        $login = intval($login);

        $query = "INSERT INTO " . $this->db_name . ".tarefa (texto, usuario_id) VALUES
        (?, ?)";
        $stmt = $this->conn->prepare($query);
        try {
            $stmt->execute([$texto, $login]);
        } catch (PDOException $e) {
            return null;
        }

        return $stmt;
    }
}
