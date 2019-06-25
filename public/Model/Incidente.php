<?php
namespace App\Model;

use App\Model\Model;

class Incidente extends Model
{
	private $table = 'incidentes';

	/**
	 * Editar um incidente
	 *
	 * @return array
	 */
	public function listar()
	{
		try {
			$stmt = $this->db->query("SELECT i.*, t.titulo as tipo_titulo, c.titulo as criticidade_titulo 
				FROM {$this->table} i
				INNER JOIN tipos t ON (t.id = i.tipo_id)
				INNER JOIN criticidades c ON (c.id = i.criticidade_id) 
				ORDER BY i.id DESC");

			return $stmt->fetchAll(\PDO::FETCH_OBJ);
		} catch (\PDOException $e) {
			die(print_r($e->getMessage()));
		}
	}

	/**
	 * Adicioanr um incidente
	 *
	 * @param array $request
	 * @param array $response
	 * @param array $args
	 *
	 * @return bool
	 */
	public function adicionar($request, $response, $args)
	{
		$titulo 	   = $request->getParam('titulo');
		$tipoId 	   = $request->getParam('tipo_id');
		$criticidadeId = $request->getParam('criticidade_id');
		$status 	   = $request->getParam('status');
		$descricao 	   = $request->getParam('descricao');

		try {
			$stmt = $this->db->prepare("INSERT INTO {$this->table} (titulo, tipo_id, criticidade_id, status, descricao) VALUES (:titulo, :tipo_id, :criticidade_id, :status, :descricao)");

			$stmt->bindParam(':titulo', $titulo);
			$stmt->bindParam(':tipo_id', $tipoId);
			$stmt->bindParam(':criticidade_id', $criticidadeId);
			$stmt->bindParam(':status', $status);
			$stmt->bindParam(':descricao', $descricao);

			$stmt->execute();

			return true;
		} catch (\PDOException $e) {
			return false;
		}		
	}

	/**
	 * Editar um incidente
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
		$tipoId 	   = $request->getParam('tipo_id');
		$criticidadeId = $request->getParam('criticidade_id');
		$status 	   = $request->getParam('status');
		$descricao 	   = $request->getParam('descricao');

		$sql = "UPDATE {$this->table} SET 
			titulo 		   = :titulo, 
			tipo_id 	   = :tipo_id, 
			criticidade_id = :criticidade_id,
			status 		   = :status,
			descricao 	   = :descricao
			WHERE id = {$id}";

		try {
			$stmt = $this->db->prepare($sql);

			$stmt->bindParam('titulo', $titulo);
			$stmt->bindParam('tipo_id', $tipoId);
			$stmt->bindParam('criticidade_id', $criticidadeId);
			$stmt->bindParam('status', $status);
			$stmt->bindParam('descricao', $descricao);

			$stmt->execute();

			return true;
		} catch (\PDOException $e) {
			return false;
		}		
	}

	/**
	 * Deletar um incidente
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
	 * Pega um incidente
	 *
	 * @param int $id
	 *
	 * @return bool
	 */
	public function pegar($id = null)
	{
		if (!is_null($id)) {
			$stmt = $this->db->query("SELECT * FROM {$this->table} WHERE id = {$id}");
			$incidente = $stmt->fetch(\PDO::FETCH_OBJ);

			if ($incidente) return $incidente;
		}
	}
}