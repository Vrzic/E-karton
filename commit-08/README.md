# Commit 8: API rute i validacija

## Opis
Dodavanje kompletnih API ruta sa role-based autorizacijom i validacijom podataka. Ovo završava API funkcionalnost sistema.

## Šta je uključeno
- Kompletne API rute za sve entitete
- Role-based autorizacija (admin, doctor, nurse, patient)
- Request klase za validaciju
- Javne i zaštićene rute
- Dodatne funkcionalnosti za višu ocenu

## API Rute

### Javne rute
- **POST /api/register** - Registracija korisnika
- **POST /api/login** - Prijava korisnika

### Zaštićene rute (auth:sanctum)
- **POST /api/logout** - Odjava korisnika
- **GET /api/patients** - Lista pacijenta
- **POST /api/patients** - Kreiranje pacijenta
- **GET /api/patients/{id}** - Prikaz pacijenta
- **PUT /api/patients/{id}** - Ažuriranje pacijenta
- **DELETE /api/patients/{id}** - Brisanje pacijenta
- **GET /api/patients/search** - Pretraga pacijenta
- **GET /api/patients/export/csv** - Eksport pacijenta u CSV
- **POST /api/change-password** - Izmena lozinke
- **POST /api/forgot-password** - Zaboravljena lozinka
- **POST /api/reset-password** - Reset lozinke

### Admin rute (role:admin)
- **GET /api/admin/stats** - Statistike sistema
- **DELETE /api/admin/users/{user}** - Brisanje korisnika

### Doctor rute (role:doctor)
- **GET /api/doctor/patients** - Moji pacijenti
- **GET /api/doctor/appointments** - Moji termini

### Nurse rute (role:nurse)
- **GET /api/nurse/patients** - Pregled pacijenta

### Patient rute (role:patient)
- **GET /api/patient/profile** - Moj profil
- **GET /api/patient/appointments** - Moji termini
- **GET /api/patient/health-records** - Moji zdravstveni kartoni

## Request klase
### StorePatientRequest
- Validacija za kreiranje pacijenta
- Proverava obavezna polja
- Validira format podataka

### UpdatePatientRequest
- Validacija za ažuriranje pacijenta
- Opciona polja za ažuriranje
- Validira format podataka

## Funkcionalnosti
- Laravel Sanctum autentifikacija
- Role-based autorizacija
- CRUD operacije za sve entitete
- Paginacija i pretraga
- Eksport podataka
- Validacija ulaznih podataka
- JSON odgovori

## Struktura
```
commit-08/
├── app/
│   ├── Http/
│   │   ├── Controllers/ (svi kontroleri iz commit-07)
│   │   ├── Middleware/ (CheckRole iz commit-07)
│   │   └── Requests/
│   │       ├── StorePatientRequest.php
│   │       └── UpdatePatientRequest.php
│   ├── Models/ (svi modeli iz commit-05)
│   └── Providers/
├── routes/
│   └── api.php (kompletne API rute)
├── database/
│   └── migrations/ (sve migracije iz commit-05)
├── ... (ostali Laravel fajlovi)
```

## Status
✅ **API RUTE** - Kompletne API rute implementirane
✅ **ROLE-BASED AUTORIZACIJA** - 4 uloge sa različitim pristupom
✅ **VALIDACIJA** - Request klase za validaciju
✅ **FUNKCIONALNOSTI ZA VIŠU OCENU** - Pretraga, eksport, izmena lozinke
✅ **AUTENTIFIKACIJA** - Laravel Sanctum
✅ Osnovni setup (nasleđeno iz commit-07)

## Komit poruka
"Add complete API routes with role-based authorization and validation"