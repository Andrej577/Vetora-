<?php

function api_payload_for_path(string $path, object $db): ?array
{
    if ($path === '/api/vlasnici') {
        return ['data' => api_owners($db)];
    }

    if ($path === '/api/ljubimci') {
        return ['data' => api_pets($db)];
    }

    if ($path === '/api/termini') {
        return ['data' => api_appointments($db)];
    }

    return null;
}

function api_owners(object $db): array
{
    return $db->all('SELECT * FROM vlasnici ORDER BY prezime, ime');
}

function api_pets(object $db): array
{
    return $db->all(
        'SELECT ljubimci.*, vrste_ljubimaca.naziv AS vrsta, vrste_ljubimaca.kod AS vrsta_kod, vrste_ljubimaca.slika AS vrsta_slika, CONCAT(vlasnici.ime, " ", vlasnici.prezime) AS vlasnik_ime
         FROM ljubimci
         JOIN vlasnici ON vlasnici.id = ljubimci.vlasnik_id
         JOIN vrste_ljubimaca ON vrste_ljubimaca.id = ljubimci.vrsta_id
         ORDER BY ljubimci.ime'
    );
}

function api_appointments(object $db): array
{
    return $db->all(
        'SELECT termini.*,
                statusi_posjeta.naziv AS stanje,
                statusi_posjeta.puni_naziv AS stanje_puni_naziv,
                ljubimci.ime AS ljubimac_ime,
                CONCAT(vlasnici.ime, " ", vlasnici.prezime) AS vlasnik_ime,
                CONCAT(korisnici.titula, " ", korisnici.ime, " ", korisnici.prezime) AS lijecnik_ime
         FROM termini
         JOIN ljubimci ON ljubimci.id = termini.ljubimac_id
         JOIN vlasnici ON vlasnici.id = ljubimci.vlasnik_id
         JOIN korisnici ON korisnici.id = termini.lijecnik_id
         JOIN statusi_posjeta ON statusi_posjeta.id = termini.status_posjete_id
         ORDER BY termini.vrijeme_termina'
    );
}
