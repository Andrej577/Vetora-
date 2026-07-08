<?php

require_once dirname(__DIR__) . '/app/Core/ApiQueries.php';

$GLOBALS['__tests'] = [];

function test(string $name, callable $callback): void
{
    $GLOBALS['__tests'][] = [$name, $callback];
}

function assert_same($expected, $actual, string $message = ''): void
{
    if ($expected !== $actual) {
        throw new RuntimeException($message !== '' ? $message : sprintf(
            'Expected %s, got %s.',
            var_export($expected, true),
            var_export($actual, true)
        ));
    }
}

function assert_true(bool $condition, string $message = 'Expected condition to be true.'): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

function assert_null($actual, string $message = ''): void
{
    if ($actual !== null) {
        throw new RuntimeException($message !== '' ? $message : sprintf(
            'Expected null, got %s.',
            var_export($actual, true)
        ));
    }
}

function assert_count(int $expected, array $actual, string $message = ''): void
{
    if (count($actual) !== $expected) {
        throw new RuntimeException($message !== '' ? $message : sprintf(
            'Expected count %d, got %d.',
            $expected,
            count($actual)
        ));
    }
}

function normalize_sql(string $sql): string
{
    return preg_replace('/\s+/', ' ', trim($sql));
}
