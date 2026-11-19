
<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Filme.php';
require_once __DIR__ . '/../interfaces/RepositoryInterface.php';

class FilmeRepository implements RepositoryInterface {

    private $conn;

    public function __construct() {
        $this->conn = Database::conectar();
    }

    public function criar($filme) {

        $sql = "INSERT INTO filmes (nome, ano, diretor, duracao)
                VALUES (:n, :a, :d, :du)";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':n' => $filme->getNome(),
            ':a' => $filme->getAno(),
            ':d' => $filme->getDiretor(),
            ':du' => $filme->getDuracao()
        ]);
    }

    public function listar() {

        $stmt = $this->conn->query(
            "SELECT * FROM filmes ORDER BY id"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {

        $stmt = $this->conn->prepare(
            "SELECT * FROM filmes WHERE id = :id"
        );

        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $filme) {

        $sql = "UPDATE filmes
                SET nome=:n, ano=:a, diretor=:d, duracao=:du
                WHERE id=:id";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':n' => $filme->getNome(),
            ':a' => $filme->getAno(),
            ':d' => $filme->getDiretor(),
            ':du' => $filme->getDuracao(),
            ':id' => $id
        ]);
    }

    public function excluir($id) {

        $stmt = $this->conn->prepare(
            "DELETE FROM filmes WHERE id = :id"
        );

        $stmt->execute([':id' => $id]);
    }

}

?>
