<?php

final class FakeDatabase
{
    public array $queries = [];

    public function __construct(private array $rows)
    {
    }

    public function all(string $sql, array $params = []): array
    {
        $this->queries[] = ['sql' => $sql, 'params' => $params];

        return $this->rows;
    }
}

test('vlasnici API fetches owners ordered by last and first name', function (): void {
    $rows = [
        ['id' => 1, 'ime' => 'Ana', 'prezime' => 'Horvat'],
    ];
    $db = new FakeDatabase($rows);

    $payload = api_payload_for_path('/api/vlasnici', $db);

    assert_same(['data' => $rows], $payload);
    assert_count(1, $db->queries);
    assert_same('SELECT * FROM vlasnici ORDER BY prezime, ime', normalize_sql($db->queries[0]['sql']));
    assert_same([], $db->queries[0]['params']);
});

test('ljubimci API fetches pets with owner full name', function (): void {
    $rows = [
        ['id' => 1, 'ime' => 'Luna', 'vlasnik_ime' => 'Ana Horvat'],
    ];
    $db = new FakeDatabase($rows);

    $payload = api_payload_for_path('/api/ljubimci', $db);

    assert_same(['data' => $rows], $payload);
    assert_count(1, $db->queries);
    assert_same(
        'SELECT ljubimci.*, vrste_ljubimaca.naziv AS vrsta, vrste_ljubimaca.kod AS vrsta_kod, CONCAT(vlasnici.ime, " ", vlasnici.prezime) AS vlasnik_ime FROM ljubimci JOIN vlasnici ON vlasnici.id = ljubimci.vlasnik_id JOIN vrste_ljubimaca ON vrste_ljubimaca.id = ljubimci.vrsta_id ORDER BY ljubimci.ime',
        normalize_sql($db->queries[0]['sql'])
    );
});

test('termini API fetches appointments with pet and owner names', function (): void {
    $rows = [
        ['id' => 1, 'ljubimac_ime' => 'Luna', 'vlasnik_ime' => 'Ana Horvat'],
    ];
    $db = new FakeDatabase($rows);

    $payload = api_payload_for_path('/api/termini', $db);

    assert_same(['data' => $rows], $payload);
    assert_count(1, $db->queries);
    assert_same(
        'SELECT termini.*, ljubimci.ime AS ljubimac_ime, CONCAT(vlasnici.ime, " ", vlasnici.prezime) AS vlasnik_ime FROM termini JOIN ljubimci ON ljubimci.id = termini.ljubimac_id JOIN vlasnici ON vlasnici.id = ljubimci.vlasnik_id ORDER BY termini.vrijeme_termina',
        normalize_sql($db->queries[0]['sql'])
    );
});

test('unknown API path does not query the database', function (): void {
    $db = new FakeDatabase([]);

    $payload = api_payload_for_path('/api/missing', $db);

    assert_null($payload);
    assert_count(0, $db->queries);
});
