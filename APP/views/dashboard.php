<?php
$titles = [
    'dashboard' => 'Dnevnik rada',
    'owners' => 'Vlasnici',
    'owners_new' => 'Novi vlasnik',
    'owners_edit' => 'Uredi vlasnika',
    'pets' => 'Ljubimci',
    'pets_new' => 'Novi ljubimac',
    'pets_edit' => 'Uredi ljubimca',
    'appointments' => 'Termini',
    'appointments_new' => 'Novi termin',
    'appointments_edit' => 'Uredi termin',
    'doctors' => 'Liječnici',
    'reports' => 'Izvještaji',
    'not_found' => 'Stranica nije pronađena',
];
$pageTitle = $titles[$page] ?? 'Dnevnik rada';
$statusLabels = [
    'zakazano' => 'Zakazano',
    'zavrseno' => 'Završeno',
    'otkazano' => 'Otkazano',
];

function nav_active(string $currentPage, array $pages): string
{
    return in_array($currentPage, $pages, true) ? ' active' : '';
}

function status_class(?string $status): string
{
    $classes = [
        'zakazano' => 'status-zakazano',
        'zavrseno' => 'status-zavrseno',
        'otkazano' => 'status-otkazano',
    ];

    return $classes[$status] ?? 'status-zakazano';
}

function status_icon(string $status): string
{
    $icons = [
        'zavrseno' => 'fi fi-sr-calendar-check',
        'otkazano' => 'fi fi-sr-calendar-xmark',
        'zakazano' => 'fi fi-sr-calendar-swap',
    ];

    return $icons[$status] ?? $icons['zakazano'];
}

function spol_icon(string $code): string
{
    $icons = [
        'musko' => '<svg viewBox="0 0 24 24"><circle cx="10" cy="14" r="5"/><path d="M14 10l6-6"/><path d="M15 4h5v5"/></svg>',
        'zensko' => '<svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="5"/><path d="M12 13v8"/><path d="M8 17h8"/></svg>',
    ];

    return $icons[$code] ?? '<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="6"/></svg>';
}

function nav_icon(string $name): string
{
    if ($name === 'pets') {
        return '<i class="fi fi-sr-pets"></i>';
    }

    if ($name === 'home') {
        return '<i class="fi fi-sr-home"></i>';
    }

    if ($name === 'owners') {
        return '<i class="fi fi-sr-users"></i>';
    }

    if ($name === 'calendar') {
        return '<i class="fi fi-sr-calendar-clock"></i>';
    }

    if ($name === 'doctor') {
        return '<i class="fi fi-sr-user-md"></i>';
    }

    if ($name === 'reports') {
        return '<i class="fi fi-sr-chart-pie-alt"></i>';
    }

    if (in_array($name, ['add', 'add_user'], true)) {
        return '<i class="fi fi-br-add"></i>';
    }

    $putanje = [
    ];

    if (!isset($putanje[$name])) {
        return '';
    }

    return '<img class="navigacija-ikona-slika" src="' . $putanje[$name] . '" alt="">';
}

function page_icon_name(string $page): string
{
    $icons = [
        'dashboard' => 'home',
        'owners' => 'owners',
        'owners_new' => 'owners',
        'owners_edit' => 'owners',
        'pets' => 'pets',
        'pets_new' => 'pets',
        'pets_edit' => 'pets',
        'appointments' => 'calendar',
        'appointments_new' => 'calendar',
        'appointments_edit' => 'calendar',
        'doctors' => 'doctor',
        'reports' => 'reports',
        'not_found' => 'reports',
    ];

    return $icons[$page] ?? 'home';
}
?>
<!doctype html>
<html lang="hr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= e($pageTitle . ' - ' . $config['app_name']) ?></title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    <script>
        (function () {
            var navigation = performance.getEntriesByType && performance.getEntriesByType('navigation')[0];

            if (navigation && navigation.type === 'reload') {
                document.documentElement.classList.add('nav-reload');
            }
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/3.0.0/uicons-solid-rounded/css/uicons-solid-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/3.0.0/uicons-bold-rounded/css/uicons-bold-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/3.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="/assets/css/app.css?v=20260702-status-boje-termina">
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <a class="sidebar-brand" href="/">
            <span class="brand-mark">
                <img src="/assets/images/logo.svg" alt="<?= e($config['app_name']) ?>">
            </span>
            <span class="brand-copy">
                <strong>Vetora</strong>
                <small>Ambulanta</small>
            </span>
        </a>
        <a class="sidebar-action" href="/termini/novi">
            <span>Novi termin</span>
            <span class="sidebar-action-key"><?= nav_icon('calendar') ?></span>
        </a>
        <nav class="sidebar-nav">
            <a class="sidebar-link<?= nav_active($page, ['dashboard']) ?>" href="/"><span class="nav-icon"><?= nav_icon('home') ?></span>Početna</a>
            <a class="sidebar-link<?= nav_active($page, ['pets', 'pets_new', 'pets_edit']) ?>" href="/ljubimci"><span class="nav-icon"><?= nav_icon('pets') ?></span>Ljubimci</a>
            <a class="sidebar-link<?= nav_active($page, ['owners', 'owners_new', 'owners_edit']) ?>" href="/vlasnici"><span class="nav-icon"><?= nav_icon('owners') ?></span>Vlasnici</a>
            <a class="sidebar-link<?= nav_active($page, ['appointments', 'appointments_new', 'appointments_edit']) ?>" href="/termini"><span class="nav-icon"><?= nav_icon('calendar') ?></span>Termini</a>
            <a class="sidebar-link<?= nav_active($page, ['doctors']) ?>" href="/lijecnici"><span class="nav-icon"><?= nav_icon('doctor') ?></span>Liječnici</a>
            <a class="sidebar-link<?= nav_active($page, ['reports']) ?>" href="/izvjestaji"><span class="nav-icon"><?= nav_icon('reports') ?></span>Izvještaji</a>
        </nav>
        <div class="sidebar-footer">
            <span class="sidebar-date-icon"><?= nav_icon('calendar') ?></span>
            <span>
                <small>Danas</small>
                <strong><?= e(date('d.m.Y.')) ?></strong>
            </span>
        </div>
    </aside>

    <main class="content<?= (strpos($page, '_new') !== false || strpos($page, '_edit') !== false) ? ' form-content' : '' ?><?= $page === 'dashboard' ? ' dashboard-content' : '' ?>">
        <section class="page-header">
            <div class="page-title-block">
                <span class="page-title-icon"><?= nav_icon(page_icon_name($page)) ?></span>
                <h1 class="h3 mb-0"><?= e($pageTitle) ?></h1>
            </div>
            <img class="page-header-art page-header-art-right" src="/assets/images/dashboard-right.png" alt="">
        </section>

        <?php if ($page === 'not_found'): ?>
            <div class="alert alert-warning">Stranica nije pronađena. Odaberi opciju iz bočnog menija.</div>
        <?php endif; ?>

        <?php if ($page === 'dashboard' || $page === 'not_found'): ?>
            <section class="workdesk">
                <div class="schedule-panel">
                    <div class="section-kicker">Danas</div>
                    <div class="schedule-head">
                        <div>
                            <h2>Dnevnik rada</h2>
                            <p><?= e(date('d.m.Y.')) ?></p>
                        </div>
                        <a class="btn btn-vet btn-sm" href="/termini/novi"><span class="btn-icon"><?= nav_icon('add') ?></span>Novi termin</a>
                    </div>

                    <div class="timeline">
                        <?php foreach ($todayAppointments as $appointment): ?>
                            <article class="timeline-item">
                                <time><?= e(date('H:i', strtotime($appointment['vrijeme_termina']))) ?></time>
                                <div>
                                    <strong><?= e($appointment['ljubimac_ime']) ?></strong>
                                    <span><?= e($appointment['vlasnik_ime']) ?></span>
                                    <p><?= e($appointment['razlog']) ?></p>
                                </div>
                                <span class="badge badge-status <?= e(status_class($appointment['stanje'])) ?>"><i class="<?= e(status_icon($appointment['stanje'])) ?>"></i><?= e($appointment['stanje_puni_naziv'] ?? ($statusLabels[$appointment['stanje']] ?? $appointment['stanje'])) ?></span>
                            </article>
                        <?php endforeach; ?>
                        <?php if (!$todayAppointments): ?>
                            <div class="empty-state">
                                <strong>Nema termina za danas.</strong>
                                <span>Dodaj prvi termin ili pregledaj sve zakazane dolaske.</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <aside class="workdesk-side">
                    <section class="summary-block">
                        <div class="section-kicker">Sažetak</div>
                        <div class="summary-grid">
                            <a href="/vlasnici">
                                <span>Vlasnici</span>
                                <strong><?= (int) $stats['owners'] ?></strong>
                            </a>
                            <a href="/ljubimci">
                                <span>Ljubimci</span>
                                <strong><?= (int) $stats['pets'] ?></strong>
                            </a>
                            <a href="/termini">
                                <span>Termini</span>
                                <strong><?= (int) $stats['appointments'] ?></strong>
                            </a>
                        </div>
                    </section>

                    <section class="action-strip">
                        <a href="/vlasnici/novi">Dodaj vlasnika</a>
                        <a href="/ljubimci/novi">Dodaj ljubimca</a>
                        <a href="/termini">Svi termini</a>
                    </section>

                    <section class="recent-list">
                        <div class="section-kicker">Zadnji ljubimci</div>
                        <?php foreach (array_slice($pets, 0, 4) as $pet): ?>
                            <div class="recent-row">
                                <strong><?= e($pet['ime']) ?></strong>
                                <span><?= e($pet['vlasnik_ime']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </section>
                </aside>
            </section>
        <?php endif; ?>

        <?php if ($page === 'owners'): ?>
            <section class="owners-flat">
                <div class="vlasnici-alati">
                    <div class="vlasnici-pretraga">
                        <label for="pretraga-vlasnika">Tražilica vlasnika</label>
                        <input id="pretraga-vlasnika" class="form-control" type="search" placeholder="Pretraži po imenu, telefonu, emailu ili adresi" data-pretraga-vlasnika autofocus>
                    </div>
                    <a class="btn btn-vet btn-sm" href="/vlasnici/novi"><span class="btn-icon"><?= nav_icon('add_user') ?></span>Novi vlasnik</a>
                </div>
                <div class="vlasnici-separator"></div>
                <div class="owners-flat-title">
                    <h2 class="h5 mb-0">Popis vlasnika</h2>
                </div>
                <div class="owners-grid" data-popis-vlasnika>
                    <?php foreach ($owners as $owner): ?>
                        <a class="owner-card owner-card-link" href="/vlasnici/<?= (int) $owner['id'] ?>/uredi">
                            <div class="owner-card-media">
                                <span><?= e(substr($owner['ime'], 0, 1) . substr($owner['prezime'], 0, 1)) ?></span>
                            </div>
                            <div class="owner-card-copy">
                                <h2><?= e($owner['ime'] . ' ' . $owner['prezime']) ?></h2>
                                <strong><?= e($owner['telefon']) ?></strong>
                                <?php if ($owner['email']): ?>
                                    <p><?= e($owner['email']) ?></p>
                                <?php endif; ?>
                                <?php if ($owner['adresa']): ?>
                                    <small><?= e($owner['adresa']) ?></small>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
                <div class="vlasnici-prazno" data-prazni-vlasnici hidden>Nema vlasnika koji odgovaraju pretrazi.</div>
            </section>
        <?php endif; ?>

        <?php if (in_array($page, ['owners_new', 'owners_edit'], true)): ?>
            <?php
                $ownerForm = $editingOwner ?? [
                    'id' => null,
                    'ime' => '',
                    'prezime' => '',
                    'telefon' => '',
                    'email' => '',
                    'adresa' => '',
                ];
                $isOwnerEdit = $page === 'owners_edit';
                $ownerFormAction = $isOwnerEdit ? '/vlasnici/' . (int) $ownerForm['id'] . '/uredi' : '/vlasnici';
            ?>
            <section class="settings-form" data-saving-panel>
                <div class="settings-form-head">
                    <h2><?= $isOwnerEdit ? 'Uredi vlasnika' : 'Novi vlasnik' ?></h2>
                    <span><?= $isOwnerEdit ? 'Ažuriranje podataka o vlasniku' : 'Podaci o vlasniku' ?></span>
                </div>
                <form method="post" action="<?= e($ownerFormAction) ?>" class="settings-card" data-saving-form>
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                    <div class="settings-row">
                        <label>Ime</label>
                        <input class="form-control" name="first_name" value="<?= e($ownerForm['ime']) ?>" required>
                    </div>
                    <div class="settings-row">
                        <label>Prezime</label>
                        <input class="form-control" name="last_name" value="<?= e($ownerForm['prezime']) ?>" required>
                    </div>
                    <div class="settings-row">
                        <label>Telefon</label>
                        <input class="form-control" name="phone" value="<?= e($ownerForm['telefon']) ?>" required>
                    </div>
                    <div class="settings-row">
                        <label>Email</label>
                        <input class="form-control" type="email" name="email" value="<?= e($ownerForm['email'] ?? '') ?>">
                    </div>
                    <div class="settings-row">
                        <label>Adresa</label>
                        <input class="form-control" name="address" value="<?= e($ownerForm['adresa'] ?? '') ?>">
                    </div>
                    <div class="settings-actions">
                        <a class="btn btn-outline-vet" href="/vlasnici">Odustani</a>
                        <button class="btn btn-vet" type="submit" data-saving-label="Spremanje..."><span class="btn-icon"><?= nav_icon('add_user') ?></span><span data-button-text><?= $isOwnerEdit ? 'Ažuriraj vlasnika' : 'Spremi vlasnika' ?></span></button>
                    </div>
                </form>
                <div class="form-loading-overlay" aria-hidden="true">
                    <div class="form-loading-box">
                        <span class="form-loading-spinner"></span>
                        <span><?= $isOwnerEdit ? 'Ažuriranje vlasnika...' : 'Spremanje vlasnika...' ?></span>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ($page === 'pets'): ?>
            <section class="pets-flat">
                <div class="ljubimci-alati">
                    <div class="ljubimci-pretraga">
                        <label for="pretraga-ljubimaca">Tražilica ljubimaca</label>
                        <input id="pretraga-ljubimaca" class="form-control" type="search" placeholder="Pretraži po imenu, vrsti, pasmini, vlasniku ili spolu" data-pretraga-ljubimaca autofocus>
                    </div>
                    <a class="btn btn-vet btn-sm" href="/ljubimci/novi"><span class="btn-icon"><?= nav_icon('add') ?></span>Novi ljubimac</a>
                </div>
                <div class="ljubimci-separator"></div>
                <div class="pets-flat-title">
                    <h2 class="h5 mb-0">Popis ljubimaca</h2>
                </div>
                <div class="pets-grid" data-popis-ljubimaca>
                    <?php foreach ($pets as $pet): ?>
                        <a class="list-card" href="/ljubimci/<?= (int) $pet['id'] ?>/uredi">
                            <div class="ljubimac-kartica-medij">
                                <?php if (!empty($pet['vrsta_slika'])): ?>
                                    <img class="ljubimac-ikona-velika" src="<?= e($pet['vrsta_slika']) ?>" alt="<?= e($pet['vrsta']) ?>">
                                <?php endif; ?>
                            </div>
                            <div class="ljubimac-kartica-sadrzaj">
                                <strong><?= e($pet['ime']) ?></strong>
                                <span><?= e($pet['vrsta']) ?><?= $pet['pasmina'] ? ' · ' . e($pet['pasmina']) : '' ?></span>
                                <small><?= e($pet['vlasnik_ime']) ?></small>
                                <span class="ljubimac-kartica-spol">
                                    <span class="ljubimac-kartica-spol-ikona"><?= spol_icon($pet['spol_kod']) ?></span>
                                    <?= e($pet['spol_naziv']) ?>
                                </span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
                <div class="ljubimci-prazno" data-prazni-ljubimci hidden>Nema ljubimaca koji odgovaraju pretrazi.</div>
            </section>
        <?php endif; ?>

        <?php if (in_array($page, ['pets_new', 'pets_edit'], true)): ?>
            <?php
                $petForm = $editingPet ?? [
                    'id' => null,
                    'vlasnik_id' => '',
                    'spol_id' => '',
                    'vrsta_id' => '',
                    'ime' => '',
                    'vrsta' => '',
                    'pasmina' => '',
                    'datum_rodenja' => '',
                    'mikrocip' => '',
                    'napomene' => '',
                ];
                $isPetEdit = $page === 'pets_edit';
                $petFormAction = $isPetEdit ? '/ljubimci/' . (int) $petForm['id'] . '/uredi' : '/ljubimci';
                $odabraniVlasnikTekst = '';

                foreach ($owners as $owner) {
                    if ((int) $petForm['vlasnik_id'] === (int) $owner['id']) {
                        $odabraniVlasnikTekst = $owner['ime'] . ' ' . $owner['prezime'];
                        break;
                    }
                }
            ?>
            <section class="settings-form">
                <div class="settings-form-head">
                    <h2><?= $isPetEdit ? 'Uredi ljubimca' : 'Novi ljubimac' ?></h2>
                    <span><?= $isPetEdit ? 'Ažuriranje podataka o ljubimcu' : 'Podaci o ljubimcu' ?></span>
                </div>
                <form method="post" action="<?= e($petFormAction) ?>" class="settings-card" data-saving-form>
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                    <div class="settings-row">
                        <label>Vlasnik</label>
                        <div class="vlasnik-odabir" data-vlasnik-odabir>
                            <input type="hidden" name="owner_id" value="<?= e((string) $petForm['vlasnik_id']) ?>" data-vlasnik-id required>
                            <input class="form-control" type="search" autocomplete="off" placeholder="Pretraži vlasnika po imenu, telefonu ili emailu" value="<?= e($odabraniVlasnikTekst) ?>" data-vlasnik-pretraga required>
                            <div class="vlasnik-odabir-popis" data-vlasnik-popis hidden>
                                <?php foreach ($owners as $owner): ?>
                                    <button class="vlasnik-odabir-stavka" type="button" data-vlasnik-stavka data-vlasnik-id-vrijednost="<?= (int) $owner['id'] ?>" data-vlasnik-naziv="<?= e($owner['ime'] . ' ' . $owner['prezime']) ?>" data-vlasnik-pretrazivo="<?= e($owner['ime'] . ' ' . $owner['prezime'] . ' ' . ($owner['telefon'] ?? '') . ' ' . ($owner['email'] ?? '')) ?>">
                                        <span class="vlasnik-odabir-inicijali"><?= e(mb_substr($owner['ime'], 0, 1) . mb_substr($owner['prezime'], 0, 1)) ?></span>
                                        <span>
                                            <strong><?= e($owner['ime'] . ' ' . $owner['prezime']) ?></strong>
                                            <small><?= e($owner['telefon'] ?: ($owner['email'] ?? '')) ?></small>
                                        </span>
                                    </button>
                                <?php endforeach; ?>
                                <div class="vlasnik-odabir-prazno" data-vlasnik-prazno hidden>Nema vlasnika za unesenu pretragu.</div>
                            </div>
                        </div>
                    </div>
                    <div class="settings-row">
                        <label>Ime</label>
                        <input class="form-control" name="name" value="<?= e($petForm['ime']) ?>" required>
                    </div>
                    <div class="settings-row">
                        <label>Vrsta</label>
                        <select class="form-control" name="species_id" required>
                            <option value="">Odaberi vrstu</option>
                            <?php foreach ($vrsteLjubimaca as $vrsta): ?>
                                <option value="<?= (int) $vrsta['id'] ?>" <?= (int) $petForm['vrsta_id'] === (int) $vrsta['id'] ? 'selected' : '' ?>><?= e($vrsta['naziv']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="settings-row">
                        <label>Spol</label>
                        <div class="spol-options">
                            <?php foreach ($spolovi as $index => $spol): ?>
                                <label class="spol-option">
                                    <input type="radio" name="spol_id" value="<?= (int) $spol['id'] ?>" <?= ((int) $petForm['spol_id'] === (int) $spol['id'] || (!$isPetEdit && $index === 0)) ? 'checked' : '' ?> required>
                                    <span class="spol-option-icon"><?= spol_icon($spol['kod']) ?></span>
                                    <span><?= e($spol['naziv']) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="settings-row">
                        <label>Pasmina</label>
                        <input class="form-control" name="breed" value="<?= e($petForm['pasmina'] ?? '') ?>">
                    </div>
                    <div class="settings-row">
                        <label>Datum rođenja</label>
                        <input class="form-control" type="date" name="birth_date" value="<?= e($petForm['datum_rodenja'] ?? '') ?>">
                    </div>
                    <div class="settings-row">
                        <label>Mikročip</label>
                        <input class="form-control" name="microchip" value="<?= e($petForm['mikrocip'] ?? '') ?>">
                    </div>
                    <div class="settings-row settings-row-tall">
                        <label>Napomene</label>
                        <textarea class="form-control" name="notes" rows="4"><?= e($petForm['napomene'] ?? '') ?></textarea>
                    </div>
                    <div class="settings-actions">
                        <a class="btn btn-outline-vet" href="/ljubimci">Odustani</a>
                        <button class="btn btn-vet" type="submit"><span class="btn-icon"><?= nav_icon('add') ?></span><?= $isPetEdit ? 'Ažuriraj ljubimca' : 'Spremi ljubimca' ?></button>
                    </div>
                </form>
            </section>
        <?php endif; ?>

        <?php if ($page === 'appointments'): ?>
            <section class="appointments-flat">
                <div class="termini-alati">
                    <div class="termini-pretraga">
                        <label for="pretraga-termina">Tražilica termina</label>
                        <input id="pretraga-termina" class="form-control" type="search" placeholder="Pretraži po vremenu, ljubimcu, vlasniku, liječniku, razlogu ili statusu" data-pretraga-termina autofocus>
                    </div>
                    <a class="btn btn-vet btn-sm" href="/termini/novi"><span class="btn-icon"><?= nav_icon('add') ?></span>Novi termin</a>
                </div>
                <div class="termini-separator"></div>
                <div class="appointments-flat-title">
                    <h2 class="h5 mb-0">Popis termina</h2>
                </div>
                <div class="termini-dan-navigacija">
                    <a class="termini-dan-strelica" href="/termini?datum=<?= e($prethodniDatum) ?>" aria-label="Prethodni dan"><i class="fi fi-rr-angle-small-left"></i></a>
                    <div class="termini-dan-odabran">
                        <strong><?= e($odabraniDanPrikaz) ?>, <?= e($odabraniDatumPrikaz) ?></strong>
                    </div>
                    <a class="termini-dan-strelica" href="/termini?datum=<?= e($sljedeciDatum) ?>" aria-label="Sljedeći dan"><i class="fi fi-rr-angle-small-right"></i></a>
                </div>
                <div class="termini-popis" data-popis-termina>
                    <div class="termini-zaglavlje" aria-hidden="true">
                        <span>Vrijeme</span>
                        <span>Ljubimac</span>
                        <span>Vlasnik</span>
                        <span>Liječnik</span>
                        <span>Razlog</span>
                        <span>Status</span>
                    </div>
                    <div class="termini-kartice">
                        <?php foreach ($statusiPosjeta as $statusPosjete): ?>
                            <?php
                                $grupaStatus = $statusPosjete['naziv'];
                                $terminiGrupe = array_values(array_filter($appointments, static fn (array $appointment): bool => $appointment['stanje'] === $grupaStatus));
                            ?>
                            <?php if ($terminiGrupe): ?>
                                <section class="termini-status-grupa">
                                    <div class="termini-status-grupa-naslov">
                                        <span class="badge badge-status <?= e(status_class($grupaStatus)) ?>"><i class="<?= e(status_icon($grupaStatus)) ?>"></i><?= e($statusPosjete['puni_naziv']) ?></span>
                                        <strong><?= count($terminiGrupe) ?></strong>
                                    </div>
                                    <div class="termini-status-grupa-popis">
                                        <?php foreach ($terminiGrupe as $appointment): ?>
                                            <a class="termin-kartica" href="/termini/<?= (int) $appointment['id'] ?>/uredi">
                                                <div class="termin-stavka" data-label="Vrijeme"><?= e(date('H:i', strtotime($appointment['vrijeme_termina']))) ?></div>
                                                <div class="termin-stavka" data-label="Ljubimac">
                                                    <span class="termin-ljubimac">
                                                        <?php if (!empty($appointment['vrsta_slika'])): ?>
                                                            <img src="<?= e($appointment['vrsta_slika']) ?>" alt="<?= e($appointment['vrsta_naziv'] ?? 'Ljubimac') ?>">
                                                        <?php endif; ?>
                                                        <span><?= e($appointment['ljubimac_ime']) ?></span>
                                                    </span>
                                                </div>
                                                <div class="termin-stavka" data-label="Vlasnik"><?= e($appointment['vlasnik_ime']) ?></div>
                                                <div class="termin-stavka" data-label="Liječnik"><?= e($appointment['lijecnik_ime']) ?></div>
                                                <div class="termin-stavka" data-label="Razlog"><?= e($appointment['razlog']) ?></div>
                                                <div class="termin-stavka" data-label="Status"><span class="badge badge-status <?= e(status_class($appointment['stanje'])) ?>"><i class="<?= e(status_icon($appointment['stanje'])) ?>"></i><?= e($appointment['stanje_puni_naziv'] ?? ($statusLabels[$appointment['stanje']] ?? $appointment['stanje'])) ?></span></div>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </section>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="termini-prazno" data-prazni-termini <?= $appointments ? 'hidden' : '' ?>>Nema termina za odabrani dan.</div>
                </div>
            </section>
        <?php endif; ?>

        <?php if (in_array($page, ['appointments_new', 'appointments_edit'], true)): ?>
            <?php
                $appointmentForm = $editingAppointment ?? [
                    'id' => null,
                    'ljubimac_id' => '',
                    'lijecnik_id' => '',
                    'status_posjete_id' => '',
                    'vrijeme_termina' => '',
                    'razlog' => '',
                    'stanje' => 'zakazano',
                ];
                $isAppointmentEdit = $page === 'appointments_edit';
                $appointmentFormAction = $isAppointmentEdit ? '/termini/' . (int) $appointmentForm['id'] . '/uredi' : '/termini';
                $appointmentDateTime = $appointmentForm['vrijeme_termina'] ? date('Y-m-d\TH:i', strtotime($appointmentForm['vrijeme_termina'])) : date('Y-m-d\TH:i');
                $zadaniStatusPosjeteId = '';
                $odabraniLjubimacTekst = '';
                $odabraniLijecnikTekst = '';

                foreach ($statusiPosjeta as $statusPosjete) {
                    if ($statusPosjete['naziv'] === 'zakazano') {
                        $zadaniStatusPosjeteId = (string) $statusPosjete['id'];
                        break;
                    }
                }

                if ($appointmentForm['status_posjete_id'] === '') {
                    $appointmentForm['status_posjete_id'] = $zadaniStatusPosjeteId;
                }

                foreach ($pets as $pet) {
                    if ((int) $appointmentForm['ljubimac_id'] === (int) $pet['id']) {
                        $odabraniLjubimacTekst = $pet['ime'] . ' - ' . $pet['vlasnik_ime'];
                        break;
                    }
                }

                foreach ($doctors as $doctor) {
                    if ((int) $appointmentForm['lijecnik_id'] === (int) $doctor['id']) {
                        $odabraniLijecnikTekst = $doctor['name'];
                        break;
                    }
                }
            ?>
            <section class="settings-form" data-saving-panel>
                <div class="settings-form-head">
                    <h2><?= $isAppointmentEdit ? 'Uredi termin' : 'Novi termin' ?></h2>
                    <span><?= $isAppointmentEdit ? 'Ažuriranje podataka o terminu' : 'Podaci o terminu' ?></span>
                </div>
                <form method="post" action="<?= e($appointmentFormAction) ?>" class="settings-card" data-saving-form>
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                    <div class="settings-row">
                        <label>Ljubimac</label>
                        <div class="ljubimac-odabir" data-ljubimac-odabir>
                            <input type="hidden" name="pet_id" value="<?= e((string) $appointmentForm['ljubimac_id']) ?>" data-ljubimac-id required>
                            <input class="form-control" type="search" autocomplete="off" placeholder="Pretraži ljubimca ili vlasnika" value="<?= e($odabraniLjubimacTekst) ?>" data-ljubimac-pretraga required>
                            <div class="ljubimac-odabir-popis" data-ljubimac-popis hidden>
                                <?php foreach ($pets as $pet): ?>
                                    <button class="ljubimac-odabir-stavka" type="button" data-ljubimac-stavka data-ljubimac-id-vrijednost="<?= (int) $pet['id'] ?>" data-ljubimac-naziv="<?= e($pet['ime'] . ' - ' . $pet['vlasnik_ime']) ?>" data-ljubimac-pretrazivo="<?= e($pet['ime'] . ' ' . $pet['vlasnik_ime'] . ' ' . ($pet['vrsta'] ?? '') . ' ' . ($pet['spol_naziv'] ?? '')) ?>">
                                        <?php if (!empty($pet['vrsta_slika'])): ?>
                                            <img src="<?= e($pet['vrsta_slika']) ?>" alt="<?= e($pet['vrsta'] ?? 'Ljubimac') ?>">
                                        <?php endif; ?>
                                        <span>
                                            <strong><?= e($pet['ime']) ?></strong>
                                            <small><?= e($pet['vlasnik_ime']) ?></small>
                                        </span>
                                    </button>
                                <?php endforeach; ?>
                                <div class="ljubimac-odabir-prazno" data-ljubimac-prazno hidden>Nema ljubimaca za unesenu pretragu.</div>
                            </div>
                        </div>
                    </div>
                    <div class="settings-row">
                        <label>Datum i vrijeme</label>
                        <input class="form-control" type="datetime-local" name="appointment_at" value="<?= e($appointmentDateTime) ?>" required>
                    </div>
                    <div class="settings-row">
                        <label>Liječnik</label>
                        <div class="lijecnik-odabir" data-lijecnik-odabir>
                            <input type="hidden" name="doctor_id" value="<?= e((string) $appointmentForm['lijecnik_id']) ?>" data-lijecnik-id required>
                            <input class="form-control" type="search" autocomplete="off" placeholder="Pretraži liječnika po imenu, ulozi ili fokusu" value="<?= e($odabraniLijecnikTekst) ?>" data-lijecnik-pretraga required>
                            <div class="lijecnik-odabir-popis" data-lijecnik-popis hidden>
                                <?php foreach ($doctors as $doctor): ?>
                                    <button class="lijecnik-odabir-stavka" type="button" data-lijecnik-stavka data-lijecnik-id-vrijednost="<?= (int) $doctor['id'] ?>" data-lijecnik-naziv="<?= e($doctor['name']) ?>" data-lijecnik-pretrazivo="<?= e($doctor['name'] . ' ' . ($doctor['role'] ?? '') . ' ' . ($doctor['focus'] ?? '') . ' ' . ($doctor['email'] ?? '')) ?>">
                                        <span class="lijecnik-odabir-ikona"><i class="fi fi-sr-user-md"></i></span>
                                        <span>
                                            <strong><?= e($doctor['name']) ?></strong>
                                            <small><?= e($doctor['role'] ?: ($doctor['focus'] ?? '')) ?></small>
                                        </span>
                                    </button>
                                <?php endforeach; ?>
                                <div class="lijecnik-odabir-prazno" data-lijecnik-prazno hidden>Nema liječnika za unesenu pretragu.</div>
                            </div>
                        </div>
                    </div>
                    <div class="settings-row">
                        <label>Status</label>
                        <div class="status-options">
                            <?php foreach ($statusiPosjeta as $statusPosjete): ?>
                                <?php $statusKod = $statusPosjete['naziv']; ?>
                                <label class="status-option status-option-<?= e($statusKod) ?>">
                                    <input type="radio" name="status_posjete_id" value="<?= (int) $statusPosjete['id'] ?>" <?= (int) $appointmentForm['status_posjete_id'] === (int) $statusPosjete['id'] ? 'checked' : '' ?> required>
                                    <span class="status-option-icon"><i class="<?= e(status_icon($statusKod)) ?>"></i></span>
                                    <span><?= e($statusPosjete['puni_naziv']) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="settings-row settings-row-tall">
                        <label>Razlog dolaska</label>
                        <textarea class="form-control" name="reason" rows="2" required><?= e($appointmentForm['razlog']) ?></textarea>
                    </div>
                    <div class="settings-actions">
                        <a class="btn btn-outline-vet" href="/termini">Odustani</a>
                        <button class="btn btn-vet" type="submit" data-saving-label="Spremanje..."><span class="btn-icon"><?= nav_icon('add') ?></span><span data-button-text><?= $isAppointmentEdit ? 'Ažuriraj termin' : 'Spremi termin' ?></span></button>
                    </div>
                </form>
            </section>
        <?php endif; ?>

        <?php if ($page === 'doctors'): ?>
            <section class="doctors-flat">
                <div class="lijecnici-alati">
                    <div class="lijecnici-pretraga">
                        <label for="pretraga-lijecnika">Tražilica liječnika</label>
                        <input id="pretraga-lijecnika" class="form-control" type="search" placeholder="Pretraži po imenu, specijalizaciji ili fokusu" data-pretraga-lijecnika>
                    </div>
                </div>
                <div class="lijecnici-separator"></div>
                <div class="doctors-flat-title">
                    <h2 class="h5 mb-0">Popis liječnika</h2>
                </div>
                <div class="doctors-grid" data-popis-lijecnika>
                    <?php foreach ($doctors as $doctor): ?>
                        <article class="doctor-card">
                            <div class="lijecnik-kartica-medij">
                                <img src="<?= e($doctor['image']) ?>" alt="<?= e($doctor['name']) ?>">
                            </div>
                            <div class="lijecnik-kartica-sadrzaj">
                                <h2><?= e($doctor['name']) ?></h2>
                                <strong><?= e($doctor['role']) ?></strong>
                                <p><?= e($doctor['focus']) ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
                <div class="lijecnici-prazno" data-prazni-lijecnici hidden>Nema liječnika koji odgovaraju pretrazi.</div>
            </section>
        <?php endif; ?>

        <?php if (in_array($page, ['reports'], true)): ?>
            <section class="panel empty-module">
                <h2 class="h5"><?= e($pageTitle) ?></h2>
                <p>Modul je pripremljen u navigaciji i spreman za daljnju razradu.</p>
            </section>
        <?php endif; ?>
    </main>
</div>
<script>
    document.addEventListener('submit', function (event) {
        var form = event.target;

        if (!form.matches('[data-saving-form]')) {
            return;
        }

        var ljubimacId = form.querySelector('[data-ljubimac-id]');
        var ljubimacPretraga = form.querySelector('[data-ljubimac-pretraga]');
        var vlasnikId = form.querySelector('[data-vlasnik-id]');
        var vlasnikPretraga = form.querySelector('[data-vlasnik-pretraga]');
        var lijecnikId = form.querySelector('[data-lijecnik-id]');
        var lijecnikPretraga = form.querySelector('[data-lijecnik-pretraga]');

        if (ljubimacId && ljubimacPretraga && ljubimacId.value === '') {
            event.preventDefault();
            ljubimacPretraga.setCustomValidity('Odaberi ljubimca iz popisa.');
            ljubimacPretraga.reportValidity();
            return;
        }

        if (ljubimacPretraga) {
            ljubimacPretraga.setCustomValidity('');
        }

        if (vlasnikId && vlasnikPretraga && vlasnikId.value === '') {
            event.preventDefault();
            vlasnikPretraga.setCustomValidity('Odaberi vlasnika iz popisa.');
            vlasnikPretraga.reportValidity();
            return;
        }

        if (vlasnikPretraga) {
            vlasnikPretraga.setCustomValidity('');
        }

        if (lijecnikId && lijecnikPretraga && lijecnikId.value === '') {
            event.preventDefault();
            lijecnikPretraga.setCustomValidity('Odaberi liječnika iz popisa.');
            lijecnikPretraga.reportValidity();
            return;
        }

        if (lijecnikPretraga) {
            lijecnikPretraga.setCustomValidity('');
        }

        if (form.dataset.submitting === 'true') {
            event.preventDefault();
            return;
        }

        if (!form.checkValidity()) {
            return;
        }

        form.dataset.submitting = 'true';

        var panel = form.closest('[data-saving-panel]');
        var button = form.querySelector('[type="submit"]');

        if (panel) {
            panel.classList.add('is-saving');
            panel.setAttribute('aria-busy', 'true');
        }

        if (button) {
            var text = button.querySelector('[data-button-text]');

            button.disabled = true;

            if (text && button.dataset.savingLabel) {
                text.textContent = button.dataset.savingLabel;
            }
        }
    });

    function postaviPretraguKartica(pretraga, popis, selektorKartice, praznoStanje) {
        if (!pretraga || !popis) {
            return;
        }

        pretraga.addEventListener('input', function () {
            var pojam = pretraga.value.trim().toLocaleLowerCase('hr-HR');
            var kartice = Array.prototype.slice.call(popis.querySelectorAll(selektorKartice));
            var vidljiveKartice = 0;

            kartice.forEach(function (kartica) {
                var tekstKartice = kartica.textContent.toLocaleLowerCase('hr-HR');
                var odgovara = pojam === '' || tekstKartice.indexOf(pojam) !== -1;

                kartica.hidden = !odgovara;

                if (odgovara) {
                    vidljiveKartice += 1;
                }
            });

            if (praznoStanje) {
                praznoStanje.hidden = vidljiveKartice > 0;
            }
        });
    }

    postaviPretraguKartica(
        document.querySelector('[data-pretraga-termina]'),
        document.querySelector('[data-popis-termina]'),
        '.termin-kartica',
        document.querySelector('[data-prazni-termini]')
    );

    postaviPretraguKartica(
        document.querySelector('[data-pretraga-ljubimaca]'),
        document.querySelector('[data-popis-ljubimaca]'),
        '.list-card',
        document.querySelector('[data-prazni-ljubimci]')
    );

    postaviPretraguKartica(
        document.querySelector('[data-pretraga-vlasnika]'),
        document.querySelector('[data-popis-vlasnika]'),
        '.owner-card',
        document.querySelector('[data-prazni-vlasnici]')
    );

    postaviPretraguKartica(
        document.querySelector('[data-pretraga-lijecnika]'),
        document.querySelector('[data-popis-lijecnika]'),
        '.doctor-card',
        document.querySelector('[data-prazni-lijecnici]')
    );

    document.querySelectorAll('[data-ljubimac-odabir]').forEach(function (odabir) {
        var pretraga = odabir.querySelector('[data-ljubimac-pretraga]');
        var skriveniId = odabir.querySelector('[data-ljubimac-id]');
        var popis = odabir.querySelector('[data-ljubimac-popis]');
        var prazno = odabir.querySelector('[data-ljubimac-prazno]');
        var stavke = Array.prototype.slice.call(odabir.querySelectorAll('[data-ljubimac-stavka]'));

        if (!pretraga || !skriveniId || !popis) {
            return;
        }

        function prikaziPopis() {
            popis.hidden = false;
        }

        function sakrijPopis() {
            popis.hidden = true;
        }

        function filtrirajLjubimce() {
            var pojam = pretraga.value.trim().toLocaleLowerCase('hr-HR');
            var vidljiveStavke = 0;

            stavke.forEach(function (stavka) {
                var tekst = (stavka.dataset.ljubimacPretrazivo || '').toLocaleLowerCase('hr-HR');
                var odgovara = pojam === '' || tekst.indexOf(pojam) !== -1;

                stavka.hidden = !odgovara;

                if (odgovara) {
                    vidljiveStavke += 1;
                }
            });

            if (prazno) {
                prazno.hidden = vidljiveStavke > 0;
            }
        }

        pretraga.addEventListener('focus', function () {
            filtrirajLjubimce();
            prikaziPopis();
        });

        pretraga.addEventListener('input', function () {
            skriveniId.value = '';
            filtrirajLjubimce();
            prikaziPopis();
        });

        stavke.forEach(function (stavka) {
            stavka.addEventListener('click', function () {
                skriveniId.value = stavka.dataset.ljubimacIdVrijednost || '';
                pretraga.value = stavka.dataset.ljubimacNaziv || stavka.textContent.trim();
                sakrijPopis();
            });
        });

        document.addEventListener('click', function (event) {
            if (!odabir.contains(event.target)) {
                sakrijPopis();
            }
        });
    });

    document.querySelectorAll('[data-vlasnik-odabir]').forEach(function (odabir) {
        var pretraga = odabir.querySelector('[data-vlasnik-pretraga]');
        var skriveniId = odabir.querySelector('[data-vlasnik-id]');
        var popis = odabir.querySelector('[data-vlasnik-popis]');
        var prazno = odabir.querySelector('[data-vlasnik-prazno]');
        var stavke = Array.prototype.slice.call(odabir.querySelectorAll('[data-vlasnik-stavka]'));

        if (!pretraga || !skriveniId || !popis) {
            return;
        }

        function prikaziPopis() {
            popis.hidden = false;
        }

        function sakrijPopis() {
            popis.hidden = true;
        }

        function filtrirajVlasnike() {
            var pojam = pretraga.value.trim().toLocaleLowerCase('hr-HR');
            var vidljiveStavke = 0;

            stavke.forEach(function (stavka) {
                var tekst = (stavka.dataset.vlasnikPretrazivo || '').toLocaleLowerCase('hr-HR');
                var odgovara = pojam === '' || tekst.indexOf(pojam) !== -1;

                stavka.hidden = !odgovara;

                if (odgovara) {
                    vidljiveStavke += 1;
                }
            });

            if (prazno) {
                prazno.hidden = vidljiveStavke > 0;
            }
        }

        pretraga.addEventListener('focus', function () {
            filtrirajVlasnike();
            prikaziPopis();
        });

        pretraga.addEventListener('input', function () {
            skriveniId.value = '';
            filtrirajVlasnike();
            prikaziPopis();
        });

        stavke.forEach(function (stavka) {
            stavka.addEventListener('click', function () {
                skriveniId.value = stavka.dataset.vlasnikIdVrijednost || '';
                pretraga.value = stavka.dataset.vlasnikNaziv || stavka.textContent.trim();
                sakrijPopis();
            });
        });

        document.addEventListener('click', function (event) {
            if (!odabir.contains(event.target)) {
                sakrijPopis();
            }
        });
    });

    document.querySelectorAll('[data-lijecnik-odabir]').forEach(function (odabir) {
        var pretraga = odabir.querySelector('[data-lijecnik-pretraga]');
        var skriveniId = odabir.querySelector('[data-lijecnik-id]');
        var popis = odabir.querySelector('[data-lijecnik-popis]');
        var prazno = odabir.querySelector('[data-lijecnik-prazno]');
        var stavke = Array.prototype.slice.call(odabir.querySelectorAll('[data-lijecnik-stavka]'));

        if (!pretraga || !skriveniId || !popis) {
            return;
        }

        function prikaziPopis() {
            popis.hidden = false;
        }

        function sakrijPopis() {
            popis.hidden = true;
        }

        function filtrirajLijecnike() {
            var pojam = pretraga.value.trim().toLocaleLowerCase('hr-HR');
            var vidljiveStavke = 0;

            stavke.forEach(function (stavka) {
                var tekst = (stavka.dataset.lijecnikPretrazivo || '').toLocaleLowerCase('hr-HR');
                var odgovara = pojam === '' || tekst.indexOf(pojam) !== -1;

                stavka.hidden = !odgovara;

                if (odgovara) {
                    vidljiveStavke += 1;
                }
            });

            if (prazno) {
                prazno.hidden = vidljiveStavke > 0;
            }
        }

        pretraga.addEventListener('focus', function () {
            filtrirajLijecnike();
            prikaziPopis();
        });

        pretraga.addEventListener('input', function () {
            skriveniId.value = '';
            filtrirajLijecnike();
            prikaziPopis();
        });

        stavke.forEach(function (stavka) {
            stavka.addEventListener('click', function () {
                skriveniId.value = stavka.dataset.lijecnikIdVrijednost || '';
                pretraga.value = stavka.dataset.lijecnikNaziv || stavka.textContent.trim();
                sakrijPopis();
            });
        });

        document.addEventListener('click', function (event) {
            if (!odabir.contains(event.target)) {
                sakrijPopis();
            }
        });
    });
</script>
</body>
</html>
