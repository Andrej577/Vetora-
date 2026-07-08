# Production checklist

## Server

- PHP 8.1+ s uključenim PDO MySQL extensionom
- MySQL ili MariaDB
- Apache ili Nginx document root na `public/`
- HTTPS certifikat
- Dnevni backup baze

## Konfiguracija

- Kopirati `.env.example` u `.env`
- Postaviti `APP_ENV=production`
- Postaviti jaku MySQL lozinku
- Zabraniti javni pristup folderima `app/`, `routes/`, `views/`, `database/`, `docs/`

## Sigurnost

- Svi SQL upiti koriste prepared statements
- Forme koriste CSRF token
- Output se escapira kroz `e()`
- Dodati login prije stvarnog rada s podacima klijenata
- Ograniciti API pristup tokenom prije povezivanja vanjskih sustava

## Sljedeće prije stvarne ambulante

- Login za administratore i veterinare
- CRUD uređivanje i brisanje zapisa
- Medicinski karton po ljubimcu
- Privole vlasnika i GDPR izvoz/brisanje
- Audit log izmjena
- PDF računi i potvrde
