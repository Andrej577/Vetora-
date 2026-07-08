SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE vlasnici (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ime VARCHAR(100) NOT NULL,
    prezime VARCHAR(100) NOT NULL,
    telefon VARCHAR(50) NOT NULL,
    email VARCHAR(150) NULL,
    adresa VARCHAR(255) NULL,
    datum_unosa TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE spolovi (
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    naziv VARCHAR(20) NOT NULL,
    kod VARCHAR(10) NOT NULL UNIQUE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE vrste_ljubimaca (
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    naziv VARCHAR(40) NOT NULL,
    kod VARCHAR(20) NOT NULL UNIQUE,
    slika VARCHAR(160) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE ljubimci (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    vlasnik_id INT UNSIGNED NOT NULL,
    spol_id TINYINT UNSIGNED NOT NULL,
    vrsta_id TINYINT UNSIGNED NOT NULL,
    ime VARCHAR(100) NOT NULL,
    pasmina VARCHAR(100) NULL,
    datum_rodenja DATE NULL,
    mikrocip VARCHAR(80) NULL,
    napomene TEXT NULL,
    datum_unosa TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_ljubimci_vlasnik FOREIGN KEY (vlasnik_id) REFERENCES vlasnici(id) ON DELETE CASCADE,
    CONSTRAINT fk_ljubimci_spol FOREIGN KEY (spol_id) REFERENCES spolovi(id),
    CONSTRAINT fk_ljubimci_vrsta FOREIGN KEY (vrsta_id) REFERENCES vrste_ljubimaca(id),
    INDEX idx_ljubimci_spol (spol_id),
    INDEX idx_ljubimci_vrsta (vrsta_id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE korisnici (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ime VARCHAR(100) NOT NULL,
    prezime VARCHAR(100) NOT NULL,
    titula VARCHAR(20) NOT NULL DEFAULT 'dr.',
    email VARCHAR(150) NULL,
    uloga VARCHAR(120) NULL,
    fokus VARCHAR(255) NULL,
    slika VARCHAR(120) NULL,
    spol_id TINYINT UNSIGNED NOT NULL,
    is_lijecnik TINYINT(1) NOT NULL DEFAULT 0,
    datum_unosa TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_korisnici_spol FOREIGN KEY (spol_id) REFERENCES spolovi(id),
    INDEX idx_korisnici_is_lijecnik (is_lijecnik),
    INDEX idx_korisnici_spol (spol_id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE statusi_posjeta (
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    naziv VARCHAR(30) NOT NULL UNIQUE,
    puni_naziv VARCHAR(80) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE termini (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ljubimac_id INT UNSIGNED NOT NULL,
    lijecnik_id INT UNSIGNED NOT NULL,
    status_posjete_id TINYINT UNSIGNED NOT NULL,
    vrijeme_termina DATETIME NOT NULL,
    razlog VARCHAR(255) NOT NULL,
    datum_unosa TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_termini_ljubimac FOREIGN KEY (ljubimac_id) REFERENCES ljubimci(id) ON DELETE CASCADE,
    CONSTRAINT fk_termini_lijecnik FOREIGN KEY (lijecnik_id) REFERENCES korisnici(id),
    CONSTRAINT fk_termini_status_posjete FOREIGN KEY (status_posjete_id) REFERENCES statusi_posjeta(id),
    INDEX idx_termini_lijecnik (lijecnik_id),
    INDEX idx_termini_status_posjete (status_posjete_id),
    INDEX idx_termini_vrijeme (vrijeme_termina)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

INSERT INTO vlasnici (ime, prezime, telefon, email, adresa)
VALUES (
        'Snježana',
        'Tomljenović',
        '+385 91 123 4567',
        'snjeska@ri-tocm.hr',
        'Hreljin 1, Bakar'
    ),
    (
        'Karlo',
        'Brlas',
        '+385 98 555 000',
        'enduserproblem@gmail.com',
        'Vukovarska 10, Rijeka'
    );

INSERT INTO spolovi (naziv, kod)
VALUES ('Muško', 'musko'),
    ('Žensko', 'zensko');

INSERT INTO vrste_ljubimaca (naziv, kod, slika)
VALUES (
        'Pas',
        'pas',
        '/assets/images/vrste-zivotinja/pas.svg'
    ),
    (
        'Macka',
        'macka',
        '/assets/images/vrste-zivotinja/macka.svg'
    ),
    (
        'Riba',
        'riba',
        '/assets/images/vrste-zivotinja/riba.svg'
    ),
    (
        'Zec',
        'zec',
        '/assets/images/vrste-zivotinja/zec.svg'
    );

INSERT INTO ljubimci (
        vlasnik_id,
        spol_id,
        vrsta_id,
        ime,
        pasmina,
        datum_rodenja,
        mikrocip,
        napomene
    )
VALUES (
        1,
        2,
        1,
        'Luna',
        'Labrador',
        '2020-04-12',
        '191100000001',
        'Alergija na piletinu.'
    ),
    (
        2,
        1,
        1,
        'Rex',
        'Njemacki ovcar',
        '2019-07-22',
        '191100000002',
        'Aktivan i dobro podnosi terapije.'
    ),
    (
        2,
        1,
        2,
        'Miki',
        'Europska kratkodlaka',
        '2021-09-03',
        NULL,
        'Redovite kontrole zubi.'
    ),
    (
        1,
        2,
        2,
        'Nera',
        'Maine Coon',
        '2022-02-18',
        NULL,
        'Osjetljiva na promjenu hrane.'
    ),
    (
        1,
        1,
        3,
        'Nemo',
        'Zlatna ribica',
        '2023-05-10',
        NULL,
        'Kontrola kvalitete vode.'
    ),
    (
        2,
        2,
        3,
        'Bubbles',
        'Betta',
        '2024-01-14',
        NULL,
        'Pratiti apetit.'
    ),
    (
        2,
        1,
        4,
        'Skok',
        'Patuljasti zec',
        '2021-11-05',
        NULL,
        'Redovito kratiti nokte.'
    ),
    (
        1,
        2,
        4,
        'Mrkva',
        'Lavoglavi zec',
        '2022-08-27',
        NULL,
        'Kontrola zubi svaka tri mjeseca.'
    );

INSERT INTO korisnici (
        ime,
        prezime,
        titula,
        email,
        uloga,
        fokus,
        slika,
        spol_id,
        is_lijecnik
    )
VALUES (
        'Dea',
        'Bonetić',
        'dr.',
        'deabonetic@vetora.hr',
        'Veterinarka opće prakse',
        'Preventiva, cijepljenja i hitni pregledi',
        NULL,
        2,
        1
    ),
    (
        'Andrija',
        'Tatić',
        'dr.',
        'andrijatatic@vetora.hr',
        'Kirurg',
        'Meka tkiva, sterilizacije i postoperativna skrb',
        NULL,
        1,
        1
    ),
    (
        'Anja',
        'Kovač',
        'dr.',
        'anjakovac@vetora.hr',
        'Dermatologinja',
        'Alergije, koža, uši i kronični svrbež',
        NULL,
        2,
        1
    ),
    (
        'Ivana',
        'Trgovinić',
        'dr.',
        'ivnatrgovinic@vetora.hr',
        'Internist',
        'Dijagnostika, krvne pretrage i kronične bolesti',
        NULL,
        1,
        1
    );

INSERT INTO statusi_posjeta (naziv, puni_naziv)
VALUES ('zavrseno', 'Završeno'),
    ('otkazano', 'Otkazano'),
    ('zakazano', 'Zakazano');

INSERT INTO termini (
        ljubimac_id,
        lijecnik_id,
        status_posjete_id,
        vrijeme_termina,
        razlog
    )
VALUES (
        1,
        1,
        3,
        DATE_ADD(NOW(), INTERVAL 1 DAY),
        'Cijepljenje'
    ),
    (
        2,
        2,
        3,
        DATE_ADD(NOW(), INTERVAL 3 DAY),
        'Kontrola zubi'
    );
