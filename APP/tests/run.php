<?php

require __DIR__ . '/bootstrap.php';

foreach (glob(__DIR__ . '/*Test.php') as $file) {
    require $file;
}

$failures = 0;

foreach ($GLOBALS['__tests'] as [$name, $callback]) {
    try {
        $callback();
        echo "[PASS] {$name}\n";
    } catch (Throwable $exception) {
        $failures++;
        echo "[FAIL] {$name}\n";
        echo '  ' . $exception->getMessage() . "\n";
    }
}

if ($failures > 0) {
    exit(1);
}

echo "All tests passed.\n";
