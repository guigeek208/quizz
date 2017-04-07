<?php
use Phalcon\DI\FactoryDefault,
	Phalcon\Mvc\Micro,
	Phalcon\Http\Response,
	Phalcon\Http\Request;

require_once("../blindtest.php");

$blindtest = blindtest::getInstance();
//$blindtest->setTime("team 1");

$di = new FactoryDefault();

//Using an anonymous function, the instance will be lazy loaded
$di["response"] = function () {
	return new Response();
};

$di["request"] = function () {
	return new Request();
};

$app = new Micro();
//var_dump($di)

$app->setDI( $di );

$app->get( '/api', function () use ( $app ) {
	echo "Welcome";
} );

$app->get(
    "/team/time/{name}",
    function ($name) {
    	$blindtest = blindtest::getInstance();
        echo "<h1>Hello! $name</h1>";
        $blindtest->setTime($name);
    }
);

$app->notFound(
	function () use ( $app ) {
		$app->response->setStatusCode( 404, "Not Found" )->sendHeaders();
		echo 'This is crazy, but this page was not found!';
	}
);

$app->handle();
