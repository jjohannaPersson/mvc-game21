<?php

/**
 * Load the routes into the router, this file is included from
 * `htdocs/index.php` during the bootstrapping to prepare for the request to
 * be handled.
 */

declare(strict_types=1);

use FastRoute\RouteCollector;

$router = $router ?? null;

$router->addRoute("GET", "/test", function () {
    // A quick and dirty way to test the router or the request.
    return "Testing response";
});

$router->addRoute("GET", "/", "\Mos\Controller\Index");
$router->addRoute("GET", "/debug", "\Mos\Controller\Debug");
$router->addRoute("GET", "/twig", "\Mos\Controller\TwigView");

$router->addGroup("/session", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Mos\Controller\Session", "index"]);
    $router->addRoute("GET", "/destroy", ["\Mos\Controller\Session", "destroy"]);
});

$router->addGroup("/some", function (RouteCollector $router) {
    $router->addRoute("GET", "/where", ["\Mos\Controller\Sample", "where"]);
});

$router->addGroup("/form", function (RouteCollector $router) {
    $router->addRoute("GET", "/view", ["\Mos\Controller\Form", "view"]);
    $router->addRoute("POST", "/process", ["\Mos\Controller\Form", "process"]);
});

$router->addRoute("GET", "/dice", ["\Mos\Controller\Game", "dice"]);

$router->addGroup("/game21", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Mos\Controller\Game", "game21"]);
    $router->addRoute("POST", "", ["\Mos\Controller\Game", "game21post"]);
});

$router->addGroup("/play21", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Mos\Controller\Game", "play21"]);
    $router->addRoute("POST", "", ["\Mos\Controller\Game", "play21post"]);
});

$router->addGroup("/yatzy", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Mos\Controller\Yatzy", "yatzy"]);
    $router->addRoute("POST", "/playyatzy", ["\Mos\Controller\Yatzy", "yatzypost"]);
    $router->addRoute("GET", "/playyatzy", ["\Mos\Controller\Yatzy", "yatzypost"]);
    $router->addRoute("POST", "/rollagain", ["\Mos\Controller\Yatzy", "rollagain"]);
    $router->addRoute("POST", "/score", ["\Mos\Controller\Yatzy", "score"]);
    $router->addRoute("POST", "/record-score", ["\Mos\Controller\Yatzy", "recordScore"]);
    $router->addRoute("POST", "/game-over", ["\Mos\Controller\Yatzy", "gameOver"]);
});
