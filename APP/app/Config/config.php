<?php

function env_value(string $key, ?string $default = null): ?string
{
    static $loaded = false;

    if (!$loaded) {
        $envPath = dirname(__DIR__, 2) . '/.env';

        if (is_file($envPath)) {
            foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                $line = trim($line);

                if ($line === '' || strpos($line, '#') === 0 || strpos($line, '=') === false) {
                    continue;
                }

                [$name, $value] = explode('=', $line, 2);
                $value = trim($value, " \t\n\r\0\x0B\"'");

                if (getenv($name) === false) {
                    putenv(trim($name) . '=' . $value);
                }
            }
        }

        $loaded = true;
    }

    $value = getenv($key);

    return $value === false ? $default : $value;
}

return [
    'app_name' => env_value('APP_NAME', 'Veterinarska ambulanta'),
    'app_env' => env_value('APP_ENV', 'local'),
    'db' => [
        'host' => env_value('DB_HOST', '127.0.0.1'),
        'port' => env_value('DB_PORT', '3306'),
        'database' => env_value('DB_DATABASE', 'vet_ambulanta'),
        'username' => env_value('DB_USERNAME', 'root'),
        'password' => env_value('DB_PASSWORD', ''),
    ],
];

