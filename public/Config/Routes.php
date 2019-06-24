<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$container = $app->getContainer();

$container['view'] = function ($container) {
	$viewPath = __DIR__ . '/../Views';

	$view = new \Slim\Views\Twig($viewPath, [
		'cache' => false
	]);

	$view->addExtension(new \Slim\Views\TwigExtension(
		$container->get('router'),
		$container->get('request')->getUri()
	));

	return $view;
};

$container['HomeController'] = function($container) {
    return new App\Controllers\HomeController($container);
};

$container['flash'] = function ($container) {
    return new \Slim\Flash\Messages();
};

$app->get('/', 'HomeController:index');

$app->map(['get', 'post'], '/incidentes/{metodo}', App\Controllers\IncidentesController::class);
$app->map(['get', 'delete', 'put'], '/incidentes/{metodo}/{id}', App\Controllers\IncidentesController::class);

$app->map(['get', 'post'], '/tipos/{metodo}', App\Controllers\TiposController::class);
$app->map(['get', 'delete', 'put'], '/tipos/{metodo}/{id}', App\Controllers\TiposController::class);

$app->map(['get', 'post'], '/criticidades/{metodo}', App\Controllers\CriticidadesController::class);
$app->map(['get', 'delete', 'put'], '/criticidades/{metodo}/{id}', App\Controllers\CriticidadesController::class);