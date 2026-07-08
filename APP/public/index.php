<?php

session_start();

$config = require dirname(__DIR__) . '/app/Config/config.php';
require dirname(__DIR__) . '/app/Core/Database.php';
require dirname(__DIR__) . '/app/Core/helpers.php';

$db = new Database($config['db']);
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$method = $_SERVER['REQUEST_METHOD'];

if (strpos($path, '/api/') === 0) {
    require dirname(__DIR__) . '/routes/api.php';
    exit;
}

require dirname(__DIR__) . '/routes/web.php';

