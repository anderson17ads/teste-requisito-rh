<?php
namespace App\Controllers;

use App\Controllers\Controller;

class CriticidadesController extends Controller
{
	protected $model = 'Criticidade';

	/**
	 * Lista todos os criticidades
	 *
	 * @return void
	 */
	public function listar($request, $response, $args)
	{
		$criticidades = $this->Criticidade->listar($request, $response, $args);

		return $this->view->render($response, 'Criticidades/listar.twig', [
			'criticidades' => $criticidades
		]);
	}

	/**
	 * Adicionar um novo criticidade
	 *
	 * @return void
	 */
	public function adicionar($request, $response, $args)
	{
		if ($request->isPost()) {
			if ($this->Criticidade->adicionar($request, $response, $args)) {
				$this->flash->addMessage('Alert', 'Criticidade inserido com sucesso!');
				return $response->withRedirect('listar');
			} else {
				$this->flash->addMessage('Alert', 'Erro ao cadastrar criticidade!');
			}
		}

		return $this->view->render($response, 'Criticidades/adicionar.twig');
	}

	/**
	 * Editar o criticidade
	 *
	 * @return void
	 */
	public function editar($request, $response, $args)
	{

		if ($request->isPut()) {
			if ($this->Criticidade->editar($request, $response, $args)) {
				$this->flash->addMessage('Alert', 'Criticidade alterado com sucesso!');
				return $response->withRedirect($request->getUri()->getBasePath() . '/criticidades/listar');
			} else {
				$this->flash->addMessage('Alert', 'Erro ao alterar criticidade!');
			}
		}

		$criticidade = $this->Criticidade->pegar($request->getAttribute('id'));

		return $this->view->render($response, 'Criticidades/editar.twig', [
			'criticidade' => $criticidade
		]);
	}

	/**
	 * Deletar o criticidade
	 *
	 * @return void
	 */
	public function deletar($request, $response, $args)
	{
		if ($request->isDelete()) {
			if ($this->Criticidade->deletar($request->getAttribute('id'))) {
				$this->flash->addMessage('Alert', 'Criticidade excluído com sucesso!');
			} else {
				$this->flash->addMessage('Alert', 'Erro ao excluir criticidade!');
			}
		} else {
			$this->flash->addMessage('Alert', 'Erro ao excluir criticidade!');
		}

		return $response->withRedirect($request->getUri()->getBasePath() . '/criticidades/listar');
	}
}