<?php
namespace App\Controllers;

use App\Controllers\Controller;

use App\Model\Criticidade;
use App\Model\Tipo;

class IncidentesController extends Controller
{
	protected $model = 'Incidente';

	public function init()
	{
		$this->Criticidade = new Criticidade;
		$this->criticidades = $this->Criticidade->listar();

		$this->Tipo = new Tipo;
		$this->tipos = $this->Tipo->listar();
	}

	/**
	 * Lista todos os incidentes
	 *
	 * @return void
	 */
	public function listar($request, $response, $args)
	{
		$incidentes = $this->Incidente->listar();

		return $this->view->render($response, 'Incidentes/listar.twig', [
			'incidentes' => $incidentes
		]);
	}

	/**
	 * Adicionar um novo incidente
	 *
	 * @return void
	 */
	public function adicionar($request, $response, $args)
	{
		if ($request->isPost()) {
			if ($this->Incidente->adicionar($request, $response, $args)) {
				$this->flash->addMessage('Alert', 'Incidente inserido com sucesso!');
				return $response->withRedirect('listar');
			} else {
				$this->flash->addMessage('Alert', 'Erro ao cadastrar incidente!');
			}
		}

		return $this->view->render($response, 'Incidentes/adicionar.twig', [
			'tipos' 	   => $this->tipos,
			'criticidades' => $this->criticidades
		]);
	}

	/**
	 * Editar o incidente
	 *
	 * @return void
	 */
	public function editar($request, $response, $args)
	{

		if ($request->isPut()) {
			if ($this->Incidente->editar($request, $response, $args)) {
				$this->flash->addMessage('Alert', 'Incidente alterado com sucesso!');
				return $response->withRedirect($request->getUri()->getBasePath() . '/incidentes/listar');
			} else {
				$this->flash->addMessage('Alert', 'Erro ao alterar incidente!');
			}
		}

		$incidente = $this->Incidente->pegar($request->getAttribute('id'));

		return $this->view->render($response, 'Incidentes/editar.twig', [
			'incidente'    => $incidente,
			'tipos' 	   => $this->tipos,
			'criticidades' => $this->criticidades
		]);
	}

	/**
	 * Deletar o incidente
	 *
	 * @return void
	 */
	public function deletar($request, $response, $args)
	{
		if ($request->isDelete()) {
			if ($this->Incidente->deletar($request->getAttribute('id'))) {
				$this->flash->addMessage('Alert', 'Incidente excluído com sucesso!');
			} else {
				$this->flash->addMessage('Alert', 'Erro ao excluir incidente!');
			}
		} else {
			$this->flash->addMessage('Alert', 'Erro ao excluir incidente!');
		}

		return $response->withRedirect($request->getUri()->getBasePath() . '/incidentes/listar');
	}
}