<?php
namespace App\Controllers;

use App\Controllers\Controller;

class TiposController extends Controller
{
	protected $model = 'Tipo';

	/**
	 * Lista todos os tipos
	 *
	 * @return void
	 */
	public function listar($request, $response, $args)
	{
		$tipos = $this->Tipo->listar($request, $response, $args);

		return $this->view->render($response, 'Tipos/listar.twig', [
			'tipos' => $tipos
		]);
	}

	/**
	 * Adicionar um novo tipo
	 *
	 * @return void
	 */
	public function adicionar($request, $response, $args)
	{
		if ($request->isPost()) {
			if ($this->Tipo->adicionar($request, $response, $args)) {
				$this->flash->addMessage('Alert', 'Tipo inserido com sucesso!');
				return $response->withRedirect('listar');
			} else {
				$this->flash->addMessage('Alert', 'Erro ao cadastrar tipo!');
			}
		}

		return $this->view->render($response, 'Tipos/adicionar.twig');
	}

	/**
	 * Editar o tipo
	 *
	 * @return void
	 */
	public function editar($request, $response, $args)
	{

		if ($request->isPut()) {
			if ($this->Tipo->editar($request, $response, $args)) {
				$this->flash->addMessage('Alert', 'Tipo alterado com sucesso!');
				return $response->withRedirect($request->getUri()->getBasePath() . '/tipos/listar');
			} else {
				$this->flash->addMessage('Alert', 'Erro ao alterar tipo!');
			}
		}

		$tipo = $this->Tipo->pegar($request->getAttribute('id'));

		return $this->view->render($response, 'Tipos/editar.twig', [
			'tipo' => $tipo
		]);
	}

	/**
	 * Deletar o tipo
	 *
	 * @return void
	 */
	public function deletar($request, $response, $args)
	{
		if ($request->isDelete()) {
			if ($this->Tipo->deletar($request->getAttribute('id'))) {
				$this->flash->addMessage('Alert', 'Tipo excluído com sucesso!');
			} else {
				$this->flash->addMessage('Alert', 'Erro ao excluir tipo!');
			}
		} else {
			$this->flash->addMessage('Alert', 'Erro ao excluir tipo!');
		}

		return $response->withRedirect($request->getUri()->getBasePath() . '/tipos/listar');
	}
}