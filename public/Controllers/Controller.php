<?php 
namespace App\Controllers;

use App\Config\Database;

abstract class Controller
{
	protected $container;

	public function __construct(\Slim\Container $container)
	{
		$this->container = $container;

		$this->loadModel();

		$this->view->offsetSet('rand', rand(111111, 999999));
	}

	public function __get($key)
	{
		if ($this->container->{$key}) {
			return $this->container->{$key};
		}
	}

	public function __invoke($request, $response, $args) {
		$this->view->offsetSet('flash', $this->flash);

      $this->loadController($request);

		if (isset($args['metodo']) && method_exists($this, $args['metodo'])) {
			return $this->{$args['metodo']}($request, $response, $args);
		}
	}

   private function loadController($request)
   {
      if ($request && $request->getUri()->getPath()) {
         $path = explode('/', $request->getUri()->getPath());
         
         if (isset($path[1])) $this->view->offsetSet('controller', $path[1]);
      }
   }

	/**
	 * Carrega o model da classe e existir
	 *
	 * @return void
	 */
	private function loadModel()
	{
		if (isset($this->model) && !is_null($this->model)) {
			$class = "App\Model\\{$this->model}";
			$this->container[$this->model] = new $class;

			$this->loadInit();
		}
	}

	/**
	 * Verifica se tem o método init, se existir ele carrega
	 *
	 * @return void
	 */
	private function loadInit()
	{
		if (method_exists($this, 'init')) {
			$this->init();
		}
	}
}