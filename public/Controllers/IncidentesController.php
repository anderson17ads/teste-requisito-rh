<?php
namespace App\Controllers;

use App\Controllers\Controller;

class IncidentesController extends Controller
{
	protected $model = 'Incidente';

	/**
	 * Lista todos os incidentes
	 *
	 * @return void
	 */
	public function listar($request, $response, $args)
	{
		$users = $this->Incidente->listar($request, $response, $args);

		return $this->view->render($response, 'Incidentes/listar.twig', [
			'users' => $users
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

		return $this->view->render($response, 'Incidentes/adicionar.twig');
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

		$user = $this->Incidente->pegar($request->getAttribute('id'));

		return $this->view->render($response, 'Incidentes/editar.twig', [
			'user' => $user
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