# Commit 7: Middleware i dodatni kontroleri

## Opis
Dodavanje middleware-a za role-based autorizaciju i dodatnih kontrolera za kompletnu funkcionalnost sistema.

## Šta je uključeno
- CheckRole middleware za autorizaciju
- DoctorController za upravljanje doktorima
- HealthRecordController za upravljanje zdravstvenim kartonima
- AppointmentController za upravljanje terminima
- Role-based pristup kontroli

## Middleware
### CheckRole
- Proverava da li korisnik ima potrebnu ulogu
- Koristi se za zaštitu ruta prema ulozi korisnika
- Podržava više uloga odjednom
- Vraća 403 Forbidden ako korisnik nema potrebnu ulogu

## Kontroleri
### DoctorController
- **GET /api/doctors** - Lista svih doktora
- **POST /api/doctors** - Kreiranje novog doktora
- **GET /api/doctors/{id}** - Prikaz određenog doktora
- **PUT /api/doctors/{id}** - Ažuriranje doktora
- **DELETE /api/doctors/{id}** - Brisanje doktora
- **GET /api/doctors/{id}/patients** - Pacijenti određenog doktora

### HealthRecordController
- **GET /api/health-records** - Lista zdravstvenih kartona
- **POST /api/health-records** - Kreiranje novog zdravstvenog kartona
- **GET /api/health-records/{id}** - Prikaz određenog zdravstvenog kartona
- **PUT /api/health-records/{id}** - Ažuriranje zdravstvenog kartona
- **DELETE /api/health-records/{id}** - Brisanje zdravstvenog kartona

### AppointmentController
- **GET /api/appointments** - Lista svih termina
- **POST /api/appointments** - Kreiranje novog termina
- **GET /api/appointments/{id}** - Prikaz određenog termina
- **PUT /api/appointments/{id}** - Ažuriranje termina
- **DELETE /api/appointments/{id}** - Brisanje termina
- **GET /api/appointments/doctor/{id}** - Termini određenog doktora
- **GET /api/appointments/patient/{id}** - Termini određenog pacijenta

## Funkcionalnosti
- Role-based autorizacija
- CRUD operacije za sve entitete
- Paginacija rezultata
- Validacija ulaznih podataka
- JSON odgovori
- Zaštita ruta prema ulozi korisnika

## Struktura
```
commit-07/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── PatientController.php
│   │   │   ├── DoctorController.php
│   │   │   ├── HealthRecordController.php
│   │   │   └── AppointmentController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   ├── Models/ (svi modeli iz commit-05)
│   └── Providers/
├── database/
│   └── migrations/ (sve migracije iz commit-05)
├── ... (ostali Laravel fajlovi)
```

## Status
✅ **MIDDLEWARE** - CheckRole middleware za autorizaciju
✅ **DOCTOR CONTROLLER** - CRUD operacije za doktore
✅ **HEALTH RECORD CONTROLLER** - CRUD operacije za zdravstvene kartone
✅ **APPOINTMENT CONTROLLER** - CRUD operacije za termine
✅ **ROLE-BASED PRISTUP** - Autorizacija prema ulozi
✅ Osnovni setup (nasleđeno iz commit-06)

## Komit poruka
"Add middleware and additional controllers for complete system functionality"