<?php

require_once dirname(__DIR__) . '/app/Core/ApiQueries.php';

$payload = api_payload_for_path($path, $db);

if ($payload !== null) {
    json_response($payload);
}

http_response_code(404);
json_response(['error' => 'API ruta nije pronadena.']);
