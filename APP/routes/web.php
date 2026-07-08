<?php

if ($method === 'POST' && $path === '/vlasnici') {
    validate_csrf();
    $db->execute(
        'INSERT INTO vlasnici (ime, prezime, telefon, email, adresa) VALUES (:ime, :prezime, :telefon, :email, :adresa)',
        [
            'ime' => trim($_POST['first_name'] ?? ''),
            'prezime' => trim($_POST['last_name'] ?? ''),
            'telefon' => trim($_POST['phone'] ?? ''),
            'email' => trim($_POST['email'] ?? '') ?: null,
            'adresa' => trim($_POST['address'] ?? '') ?: null,
        ]
    );
    redirect('/vlasnici');
}

if ($method === 'POST' && preg_match('#^/vlasnici/(\d+)/uredi$#', $path, $matches)) {
    validate_csrf();
    $vlasnikId = (int) $matches[1];

    $db->execute(
        'UPDATE vlasnici
         SET ime = :ime,
             prezime = :prezime,
             telefon = :telefon,
             email = :email,
             adresa = :adresa
         WHERE id = :id',
        [
            'id' => $vlasnikId,
            'ime' => trim($_POST['first_name'] ?? ''),
            'prezime' => trim($_POST['last_name'] ?? ''),
            'telefon' => trim($_POST['phone'] ?? ''),
            'email' => trim($_POST['email'] ?? '') ?: null,
            'adresa' => trim($_POST['address'] ?? '') ?: null,
        ]
    );
    redirect('/vlasnici');
}

if ($method === 'POST' && $path === '/ljubimci') {
    validate_csrf();
    $db->execute(
        'INSERT INTO ljubimci (vlasnik_id, spol_id, vrsta_id, ime, pasmina, datum_rodenja, mikrocip, napomene) VALUES (:vlasnik_id, :spol_id, :vrsta_id, :ime, :pasmina, :datum_rodenja, :mikrocip, :napomene)',
        [
            'vlasnik_id' => (int) ($_POST['owner_id'] ?? 0),
            'spol_id' => (int) ($_POST['spol_id'] ?? 0),
            'vrsta_id' => (int) ($_POST['species_id'] ?? 0),
            'ime' => trim($_POST['name'] ?? ''),
            'pasmina' => trim($_POST['breed'] ?? '') ?: null,
            'datum_rodenja' => trim($_POST['birth_date'] ?? '') ?: null,
            'mikrocip' => trim($_POST['microchip'] ?? '') ?: null,
            'napomene' => trim($_POST['notes'] ?? '') ?: null,
        ]
    );
    redirect('/ljubimci');
}

if ($method === 'POST' && preg_match('#^/ljubimci/(\d+)/uredi$#', $path, $matches)) {
    validate_csrf();
    $petId = (int) $matches[1];

    $db->execute(
        'UPDATE ljubimci
         SET vlasnik_id = :vlasnik_id,
             spol_id = :spol_id,
             vrsta_id = :vrsta_id,
             ime = :ime,
             pasmina = :pasmina,
             datum_rodenja = :datum_rodenja,
             mikrocip = :mikrocip,
             napomene = :napomene
         WHERE id = :id',
        [
            'id' => $petId,
            'vlasnik_id' => (int) ($_POST['owner_id'] ?? 0),
            'spol_id' => (int) ($_POST['spol_id'] ?? 0),
            'vrsta_id' => (int) ($_POST['species_id'] ?? 0),
            'ime' => trim($_POST['name'] ?? ''),
            'pasmina' => trim($_POST['breed'] ?? '') ?: null,
            'datum_rodenja' => trim($_POST['birth_date'] ?? '') ?: null,
            'mikrocip' => trim($_POST['microchip'] ?? '') ?: null,
            'napomene' => trim($_POST['notes'] ?? '') ?: null,
        ]
    );
    redirect('/ljubimci');
}

if ($method === 'POST' && $path === '/termini') {
    validate_csrf();
    $db->execute(
        'INSERT INTO termini (ljubimac_id, lijecnik_id, status_posjete_id, vrijeme_termina, razlog)
         VALUES (:ljubimac_id, :lijecnik_id, :status_posjete_id, :vrijeme_termina, :razlog)',
        [
            'ljubimac_id' => (int) ($_POST['pet_id'] ?? 0),
            'lijecnik_id' => (int) ($_POST['doctor_id'] ?? 0),
            'status_posjete_id' => (int) ($_POST['status_posjete_id'] ?? 0),
            'vrijeme_termina' => str_replace('T', ' ', trim($_POST['appointment_at'] ?? '')),
            'razlog' => trim($_POST['reason'] ?? ''),
        ]
    );
    redirect('/termini');
}

if ($method === 'POST' && preg_match('#^/termini/(\d+)/uredi$#', $path, $matches)) {
    validate_csrf();
    $terminId = (int) $matches[1];

    $db->execute(
        'UPDATE termini
         SET ljubimac_id = :ljubimac_id,
             lijecnik_id = :lijecnik_id,
             status_posjete_id = :status_posjete_id,
             vrijeme_termina = :vrijeme_termina,
             razlog = :razlog
         WHERE id = :id',
        [
            'id' => $terminId,
            'ljubimac_id' => (int) ($_POST['pet_id'] ?? 0),
            'lijecnik_id' => (int) ($_POST['doctor_id'] ?? 0),
            'status_posjete_id' => (int) ($_POST['status_posjete_id'] ?? 0),
            'vrijeme_termina' => str_replace('T', ' ', trim($_POST['appointment_at'] ?? '')),
            'razlog' => trim($_POST['reason'] ?? ''),
        ]
    );
    redirect('/termini');
}

$owners = $db->all('SELECT * FROM vlasnici ORDER BY datum_unosa DESC');
$spolovi = $db->all('SELECT * FROM spolovi ORDER BY id ASC');
$vrsteLjubimaca = $db->all('SELECT * FROM vrste_ljubimaca ORDER BY id ASC');
$statusiPosjeta = $db->all('SELECT * FROM statusi_posjeta ORDER BY id ASC');
$pets = $db->all(
    'SELECT ljubimci.*, vrste_ljubimaca.naziv AS vrsta, vrste_ljubimaca.kod AS vrsta_kod, vrste_ljubimaca.slika AS vrsta_slika, CONCAT(vlasnici.ime, " ", vlasnici.prezime) AS vlasnik_ime, spolovi.naziv AS spol_naziv, spolovi.kod AS spol_kod
     FROM ljubimci
     JOIN vlasnici ON vlasnici.id = ljubimci.vlasnik_id
     JOIN spolovi ON spolovi.id = ljubimci.spol_id
     JOIN vrste_ljubimaca ON vrste_ljubimaca.id = ljubimci.vrsta_id
     ORDER BY ljubimci.datum_unosa DESC'
);
$odabraniDatum = $_GET['datum'] ?? date('Y-m-d');
$odabraniDatumObjekt = DateTimeImmutable::createFromFormat('Y-m-d', $odabraniDatum);
$greskeDatuma = DateTimeImmutable::getLastErrors();

if (
    $odabraniDatumObjekt === false
    || ($greskeDatuma !== false && ($greskeDatuma['warning_count'] > 0 || $greskeDatuma['error_count'] > 0))
    || $odabraniDatumObjekt->format('Y-m-d') !== $odabraniDatum
) {
    $odabraniDatumObjekt = new DateTimeImmutable(date('Y-m-d'));
    $odabraniDatum = $odabraniDatumObjekt->format('Y-m-d');
}

$prethodniDatum = $odabraniDatumObjekt->modify('-1 day')->format('Y-m-d');
$sljedeciDatum = $odabraniDatumObjekt->modify('+1 day')->format('Y-m-d');
$odabraniDatumPrikaz = $odabraniDatumObjekt->format('d.m.Y.');
$odabraniDanPrikaz = [
    'Monday' => 'Ponedjeljak',
    'Tuesday' => 'Utorak',
    'Wednesday' => 'Srijeda',
    'Thursday' => 'Četvrtak',
    'Friday' => 'Petak',
    'Saturday' => 'Subota',
    'Sunday' => 'Nedjelja',
][$odabraniDatumObjekt->format('l')] ?? $odabraniDatumObjekt->format('l');

$appointments = $db->all(
    'SELECT termini.*,
            statusi_posjeta.naziv AS stanje,
            statusi_posjeta.puni_naziv AS stanje_puni_naziv,
            ljubimci.ime AS ljubimac_ime,
            vrste_ljubimaca.naziv AS vrsta_naziv,
            vrste_ljubimaca.slika AS vrsta_slika,
            CONCAT(vlasnici.ime, " ", vlasnici.prezime) AS vlasnik_ime,
            CONCAT(korisnici.titula, " ", korisnici.ime, " ", korisnici.prezime) AS lijecnik_ime
     FROM termini
     JOIN ljubimci ON ljubimci.id = termini.ljubimac_id
     JOIN vrste_ljubimaca ON vrste_ljubimaca.id = ljubimci.vrsta_id
     JOIN vlasnici ON vlasnici.id = ljubimci.vlasnik_id
     JOIN korisnici ON korisnici.id = termini.lijecnik_id
     JOIN statusi_posjeta ON statusi_posjeta.id = termini.status_posjete_id
     WHERE DATE(termini.vrijeme_termina) = :odabrani_datum
     ORDER BY termini.vrijeme_termina ASC',
    ['odabrani_datum' => $odabraniDatum]
);
$appointmentsTotal = $db->one('SELECT COUNT(*) AS total FROM termini');
$todayAppointments = $db->all(
    'SELECT termini.*,
            statusi_posjeta.naziv AS stanje,
            statusi_posjeta.puni_naziv AS stanje_puni_naziv,
            ljubimci.ime AS ljubimac_ime,
            CONCAT(vlasnici.ime, " ", vlasnici.prezime) AS vlasnik_ime
     FROM termini
     JOIN ljubimci ON ljubimci.id = termini.ljubimac_id
     JOIN vlasnici ON vlasnici.id = ljubimci.vlasnik_id
     JOIN statusi_posjeta ON statusi_posjeta.id = termini.status_posjete_id
     WHERE DATE(termini.vrijeme_termina) = CURDATE()
     ORDER BY termini.vrijeme_termina ASC'
);
$doctors = $db->all(
    'SELECT korisnici.id,
            korisnici.ime,
            korisnici.prezime,
            korisnici.titula,
            korisnici.email,
            CONCAT(titula, " ", ime, " ", prezime) AS name,
            uloga AS role,
            fokus AS focus,
            CASE
                WHEN spolovi.kod = "zensko" THEN "/assets/images/lijecnici/zenski-lijecnik.svg"
                ELSE "/assets/images/lijecnici/muski-lijecnik.svg"
            END AS image
     FROM korisnici
     JOIN spolovi ON spolovi.id = korisnici.spol_id
     WHERE is_lijecnik = 1
     ORDER BY korisnici.id ASC'
);
$stats = [
    'owners' => count($owners),
    'pets' => count($pets),
    'appointments' => (int) ($appointmentsTotal['total'] ?? 0),
];
$editingOwner = null;
$editingPet = null;
$editingAppointment = null;

$pageMap = [
    '/' => 'dashboard',
    '/vlasnici' => 'owners',
    '/vlasnici/novi' => 'owners_new',
    '/ljubimci' => 'pets',
    '/ljubimci/novi' => 'pets_new',
    '/termini' => 'appointments',
    '/termini/novi' => 'appointments_new',
    '/lijecnici' => 'doctors',
    '/izvjestaji' => 'reports',
];

if ($method === 'GET' && preg_match('#^/ljubimci/(\d+)/uredi$#', $path, $matches)) {
    $editingPet = $db->one(
        'SELECT ljubimci.*, vrste_ljubimaca.naziv AS vrsta, vrste_ljubimaca.kod AS vrsta_kod, vrste_ljubimaca.slika AS vrsta_slika, CONCAT(vlasnici.ime, " ", vlasnici.prezime) AS vlasnik_ime, spolovi.naziv AS spol_naziv, spolovi.kod AS spol_kod
         FROM ljubimci
         JOIN vlasnici ON vlasnici.id = ljubimci.vlasnik_id
         JOIN spolovi ON spolovi.id = ljubimci.spol_id
         JOIN vrste_ljubimaca ON vrste_ljubimaca.id = ljubimci.vrsta_id
         WHERE ljubimci.id = :id',
        ['id' => (int) $matches[1]]
    );

    if ($editingPet === null) {
        http_response_code(404);
        $page = 'not_found';
    } else {
        $page = 'pets_edit';
    }
} elseif ($method === 'GET' && preg_match('#^/vlasnici/(\d+)/uredi$#', $path, $matches)) {
    $editingOwner = $db->one(
        'SELECT * FROM vlasnici WHERE id = :id',
        ['id' => (int) $matches[1]]
    );

    if ($editingOwner === null) {
        http_response_code(404);
        $page = 'not_found';
    } else {
        $page = 'owners_edit';
    }
} elseif ($method === 'GET' && preg_match('#^/termini/(\d+)/uredi$#', $path, $matches)) {
    $editingAppointment = $db->one(
        'SELECT termini.*,
                statusi_posjeta.naziv AS stanje,
                statusi_posjeta.puni_naziv AS stanje_puni_naziv,
                ljubimci.ime AS ljubimac_ime,
                CONCAT(vlasnici.ime, " ", vlasnici.prezime) AS vlasnik_ime
         FROM termini
         JOIN ljubimci ON ljubimci.id = termini.ljubimac_id
         JOIN vlasnici ON vlasnici.id = ljubimci.vlasnik_id
         JOIN statusi_posjeta ON statusi_posjeta.id = termini.status_posjete_id
         WHERE termini.id = :id',
        ['id' => (int) $matches[1]]
    );

    if ($editingAppointment === null) {
        http_response_code(404);
        $page = 'not_found';
    } else {
        $page = 'appointments_edit';
    }
} elseif (!isset($pageMap[$path])) {
    http_response_code(404);
    $page = 'not_found';
} else {
    $page = $pageMap[$path];
}

require dirname(__DIR__) . '/views/dashboard.php';
