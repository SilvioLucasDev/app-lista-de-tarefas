<?php

//CRUD
class TarefaService {

	private $conexao;
	private $tarefa;

	public function __construct(Conexao $conexao, Tarefa $tarefa) {
		$this->conexao = $conexao->conectar();
		$this->tarefa = $tarefa;
	}

	//Create
	public function inserir() { 
		$query = 'INSERT INTO tb_tarefas (tarefa) VALUES (:tarefa)';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
		$stmt->execute();
	}

	//Read
	public function recuperar() { 
			$query = '
				SELECT t.id, s.status, t.tarefa 
				FROM tb_tarefas as t LEFT JOIN tb_status as s ON (t.id_status = s.id)';
			$stmt = $this->conexao->prepare($query); 
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	//Update
	public function atualizar() { 
			$query = 'UPDATE tb_tarefas SET tarefa = :tarefa WHERE id = :id';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
			$stmt->bindValue(':id', $this->tarefa->__get('id'));
			return $stmt->execute();
	}

	//Delete
	public function remover() { 
			$query = 'DELETE FROM tb_tarefas WHERE id = :id';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':id', $this->tarefa->__get('id'));
			return $stmt->execute();
	}

	//Marcar como realizada
	public function marcarRealizada() { 
			$query = 'UPDATE tb_tarefas SET id_status = :status WHERE id = :id';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':status', $this->tarefa->__get('id_status'));
			$stmt->bindValue(':id', $this->tarefa->__get('id'));
			return $stmt->execute();
	}

	// Recuperar pendentes
	public function recuperarTarefasPendetes() {
			$query = '
				SELECT t.id, s.status, t.tarefa 
				FROM tb_tarefas as t LEFT JOIN tb_status as s ON (t.id_status = s.id)
				WHERE t.id_status = :id_status';
			$stmt = $this->conexao->prepare($query); 
			$stmt->bindValue(':id_status', $this->tarefa->__get('id_status'));
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
}

?>