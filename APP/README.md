# Veterinarska ambulanta

PHP/MySQL aplikacija za osnovno vođenje veterinarske ambulante: vlasnici, ljubimci, termini i API.

## Tehnologije

- PHP 8+
- MySQL 5.7+ ili MariaDB 10+
- Bootstrap 4.6 preko CDN-a
- PDO za bazu

## Lokalno pokretanje

### Docker

Pokreni cijelu aplikaciju, MySQL i phpMyAdmin:

```bash
docker compose up -d
```

Otvori aplikaciju:

```text
http://localhost:8000
```

Otvori phpMyAdmin:

```text
http://localhost:8080
```

Podaci za bazu u Dockeru:

```text
Host: db
Database: vet_ambulanta
User: vet_user
Password: vet_password
Root password: root_password
```

Ako želiš obrisati bazu i ponovno importati `database/schema.sql`:

```bash
docker compose down -v
docker compose up -d
```

### Bez Dockera

1. Napravi bazu i tablice:

```sql
CREATE DATABASE vet_ambulanta CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Zatim importaj `database/schema.sql`.

2. Kopiraj konfiguraciju:

```bash
cp .env.example .env
```

3. Uredi `.env` podatke za MySQL.

4. Pokreni PHP development server:

```bash
php -S localhost:8000 -t public
```

5. Otvori:

```text
http://localhost:8000
```

## Produkcija

- Document root mora pokazivati na `public/`.
- `.env` ne smije biti javno dostupan.
- Uključi HTTPS.
- Postavi `APP_ENV=production`.
- Koristi MySQL korisnika s minimalnim potrebnim pravima.

## API

Svi API odgovori su JSON.

- `GET /api/vlasnici`
- `GET /api/ljubimci`
- `GET /api/termini`

## Testovi

Preporučeni flow je pokretanje testova u Dockeru, kroz isti PHP image koji koristi aplikacija.

Ako je stack već podignut:

```bash
docker compose exec app php tests/run.php
```

Ako želiš jednokratni test container:

```bash
docker compose --profile test run --rm test
```

Za puni flow od nule:

```bash
docker compose up -d db
docker compose --profile test run --rm test
```

Testovi trenutno pokrivaju API DB upite za vlasnike, ljubimce i termine. Lokalno bez Dockera možeš ih pokrenuti i ovako:

```bash
php tests/run.php
```
