<?php
namespace App\Model;

use App\Model\Model;

class Criticidade extends Model
{
	private $table = 'criticidades';

	/**
	 * Editar um criticidade
	 *
	 * @param array $request
	 * @param array $response
	 * @param array $args
	 *
	 * @return array
	 */
	public function listar($request, $response, $args)
	{
		try {
			$stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY id DESC");

			return $stmt->fetchAll(\PDO::FETCH_OBJ);
		} catch (\PDOException $e) {
			die(print_r($e->getMessage()));
		}
	}

	/**
	 * Adicioanar um criticidade
	 *
	 * @param array $request
	 * @param array $response
	 * @param array $args
	 *
	 * @return bool
	 */
	public function adicionar($request, $response, $args)
	{
		$titulo 	 = $request->getParam('titulo');
		$status 	 = $request->getParam('status');
		$dataCriacao = date('Y-m-d H:i:s');

		try {
			$stmt = $this->db->prepare("INSERT INTO {$this->table} (titulo, status, data_criacao) VALUES (:titulo, :status, :data_criacao)");

			$stmt->bindParam(':titulo', $titulo);
			$stmt->bindParam(':status', $status);
			$stmt->bindParam(':data_criacao', $dataCriacao);

			$stmt->execute();

			return true;
		} catch (\PDOException $e) {
			return false;
		}		
	}

	/**
	 * Editar um criticidade
	 *
	 * @param array $request
	 * @param array $response
	 * @param array $args
	 *
	 * @return bool
	 */
	public function editar($request, $response, $args)
	{
		$id    		   = $request->getAttribute('id');
		$titulo  	   = $request->getParam('titulo');
		$status 	   = $request->getParam('status');
		$dataAlteracao = $request->getParam('data_alteracao');

		$sql = "UPDATE {$this->table} SET titulo = :titulo, status = :status, data_alteracao = :data_alteracao WHERE id = {$id}";

		try {
			$stmt = $this->db->prepare($sql);

			$stmt->bindParam('titulo', $titulo);
			$stmt->bindParam('status', $status);
			$stmt->bindParam('data_alteracao', $dataAlteracao);

			$stmt->execute();

			return true;
		} catch (\PDOException $e) {
			return false;
		}		
	}

	/**
	 * Deletar um criticidade
	 *
	 * @param int $id
	 *
	 * @return bool
	 */
	public function deletar($id = null)
	{
		if (!is_null($id)) {
			try {
				$stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = {$id}");
				$stmt->execute();

				return true;
			} catch (\PDOException $e) {
				return false;
			}			
		}
	}

	/**
	 * Pega um criticidade
	 *
	 * @param int $id
	 *
	 * @return bool
	 */
	public function pegar($id = null)
	{
		if (!is_null($id)) {
			$stmt = $this->db->query("SELECT * FROM {$this->table} WHERE id = {$id}");
			$criticidade = $stmt->fetch(\PDO::FETCH_OBJ);

			if ($criticidade) return $criticidade;
		}
	}
}