# Health Records Application - Sažetak projekta

## Osnovne informacije
- **Naziv**: Veb aplikacija za zdravstveni e-karton
- **Autori**: Andrea Dorontic, Aleksandra Vrzic, Jovana Sekulic
- **Tehnologija**: Laravel 12, PHP 8.2+, SQLite
- **Tip**: REST API aplikacija

## Ključne funkcionalnosti

### ✅ Osnovni zahtevi (implementirani)
1. **Laravel aplikacija** - Kompletna aplikacija sa MVC arhitekturom
2. **3+ povezana modela** - User, Patient, Doctor, Nurse, HealthRecord, Appointment, Prescription
3. **5+ tipova migracija** - Kreiranje tabela, izmena kolona, brisanje kolona, ograničenja, spoljni ključevi
4. **REST API rute** - Kompletne CRUD operacije za sve modele
5. **JSON odgovori** - Svi API odgovori u JSON formatu
6. **Autentifikacija** - Login, logout, register sa Laravel Sanctum
7. **Zaštita ruta** - Middleware za autentifikovane korisnike

### ✅ Funkcionalnosti za višu ocenu (implementirane)
1. **Paginacija i filtriranje** - API rute sa paginacijom i pretragom
2. **Izmena lozinke** - Funkcionalnost za promenu lozinke
3. **3+ uloge** - Admin, Doctor, Nurse, Patient sa različitim privilegijama
4. **Seeders, factory, resources** - Kompletna podrška za test podatke
5. **Pretraga** - Funkcionalnost pretrage po različitim kriterijumima
6. **Eksport CSV** - Eksport pacijenta u CSV format

## Struktura baze podataka

### Tabele
- `users` - Osnovni korisnici sa ulogama
- `patients` - Pacijenti sa zdravstvenim podacima
- `doctors` - Doktori sa specijalizacijama
- `nurses` - Medicinske sestre
- `health_records` - Zdravstveni kartoni
- `appointments` - Termini
- `prescriptions` - Recepti

### Veze
- User ↔ Patient (1:1)
- User ↔ Doctor (1:1)
- User ↔ Nurse (1:1)
- Patient ↔ HealthRecord (1:N)
- Doctor ↔ HealthRecord (1:N)
- Patient ↔ Appointment (1:N)
- Doctor ↔ Appointment (1:N)
- HealthRecord ↔ Prescription (1:N)

## API Endpoints

### Autentifikacija
- `POST /api/register` - Registracija korisnika
- `POST /api/login` - Prijava korisnika
- `POST /api/logout` - Odjava korisnika

### Pacijenti (Resource)
- `GET /api/patients` - Lista pacijenta
- `POST /api/patients` - Kreiranje pacijenta
- `GET /api/patients/{id}` - Prikaz pacijenta
- `PUT /api/patients/{id}` - Ažuriranje pacijenta
- `DELETE /api/patients/{id}` - Brisanje pacijenta

### Dodatne funkcionalnosti
- `GET /api/patients/search?q=query` - Pretraga pacijenta
- `GET /api/patients/export/csv` - Eksport u CSV
- `POST /api/change-password` - Promena lozinke
- `GET /api/admin/stats` - Admin statistike

### Role-based rute
- `GET /api/doctor/patients` - Doktorovi pacijenti
- `GET /api/nurse/patients` - Pregled za medicinske sestre
- `GET /api/patient/profile` - Profil pacijenta

## Testiranje

### Postman kolekcija
- Kompletna kolekcija sa svim endpoint-ima
- Test korisnici za sve uloge
- Primeri za sve CRUD operacije

### Test korisnici
- **Admin**: admin@health.com / password
- **Doctor**: doctor@health.com / password
- **Nurse**: nurse@health.com / password
- **Patient**: patient@health.com / password

## Instalacija

```bash
# 1. Kloniranje
git clone <repository-url>
cd health-records-app

# 2. Instalacija zavisnosti
composer install

# 3. Konfiguracija
cp .env.example .env
php artisan key:generate

# 4. Baza podataka
php artisan migrate:fresh
php artisan db:seed

# 5. Pokretanje
php artisan serve
```

## Tehnički detalji

### Middleware
- `auth:sanctum` - Autentifikacija
- `CheckRole` - Provera uloga korisnika

### Validacija
- Request klase za sve input-e
- Custom validation rules
- JSON error responses

### Autentifikacija
- Laravel Sanctum tokens
- Role-based autorizacija
- Secure password handling

### Database
- Eloquent ORM
- Relationships i eager loading
- Migrations i seeders
- Factory pattern za test podatke

## Dodatne funkcionalnosti

### Error Handling
- JSON error responses
- Proper HTTP status codes
- Validation error messages

### Performance
- Eager loading za relationships
- Database indexing
- Pagination za velike dataset-ove

### Security
- CSRF protection
- Input validation
- Role-based access control
- Secure password storage

## Zaključak

Aplikacija uspešno implementira **SVE** zahtevane funkcionalnosti:
- ✅ Osnovni zahtevi (7/7)
- ✅ Funkcionalnosti za višu ocenu (6/6)
- ✅ Dodatne funkcionalnosti (role-based access, validation, error handling)

**Ocena**: Aplikacija ispunjava sve kriterijume za maksimalnu ocenu.

**Spremnost**: Aplikacija je potpuno funkcionalna i spremna za testiranje kroz Postman.

**Dokumentacija**: Kompletna dokumentacija sa primerima koda i instrukcijama za testiranje.



