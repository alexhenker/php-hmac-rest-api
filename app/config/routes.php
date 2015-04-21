    <?php

/**
 * @author Jete O'Keeffe
 * @version 1.0
 * @link http://docs.phalconphp.com/en/latest/reference/micro.html#defining-routes
 * @eg.

$routes[] = [
 	'method' => 'post', 
	'route' => '/api/update', 
	'handler' => 'myFunction'
];

 */

$routes[] = [
	'method' => 'get', 
	'route' => '/api/v1/shop/{shop_id}', 
	'handler' => ['Controllers\ShopsController', 'getAction']
];

$routes[] = [
	'method' => 'post', 
	'route' => '/api/v1/shop', 
	'handler' => ['Controllers\ShopsController', 'postAction']
];

$routes[] = [
	'method' => 'put', 
	'route' => '/api/v1/shop', 
	'handler' => ['Controllers\ShopsController', 'putAction']
];

$routes[] = [
	'method' => 'delete', 
	'route' => '/api/v1/shop', 
	'handler' => ['Controllers\ShopsController', 'deleteAction']
];


return $routes;