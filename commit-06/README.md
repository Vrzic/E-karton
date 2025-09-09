# Commit 6: Osnovni kontroleri

## Opis
Dodavanje osnovnih kontrolera za autentifikaciju i upravljanje pacijentima. Ovo predstavlja početak API funkcionalnosti.

## Šta je uključeno
- AuthController za autentifikaciju (login, register, logout)
- PatientController za CRUD operacije sa pacijentima
- Osnovne API funkcionalnosti

## Kontroleri
### AuthController
- **POST /api/register** - Registracija novog korisnika
- **POST /api/login** - Prijava korisnika
- **POST /api/logout** - Odjava korisnika
- Validacija podataka
- Generisanje token-a za autentifikaciju

### PatientController
- **GET /api/patients** - Lista svih pacijenta (sa paginacijom)
- **POST /api/patients** - Kreiranje novog pacijenta
- **GET /api/patients/{id}** - Prikaz određenog pacijenta
- **PUT /api/patients/{id}** - Ažuriranje pacijenta
- **DELETE /api/patients/{id}** - Brisanje pacijenta
- **GET /api/patients/search** - Pretraga pacijenta
- **GET /api/patients/export/csv** - Eksport pacijenta u CSV format

## Funkcionalnosti
- Autentifikacija sa Laravel Sanctum
- CRUD operacije za pacijente
- Paginacija rezultata
- Pretraga po imenu, email-u ili broju medicinskog kartona
- Eksport podataka u CSV format
- Validacija ulaznih podataka
- JSON odgovori

## Struktura
```
commit-06/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthController.php
│   │       └── PatientController.php
│   ├── Models/ (svi modeli iz commit-05)
│   └── Providers/
├── database/
│   └── migrations/ (sve migracije iz commit-05)
├── ... (ostali Laravel fajlovi)
```

## Status
✅ **AUTH CONTROLLER** - Autentifikacija implementirana
✅ **PATIENT CONTROLLER** - CRUD operacije za pacijente
✅ **API FUNKCIONALNOSTI** - Osnovne API rute
✅ **VALIDACIJA** - Validacija ulaznih podataka
✅ **JSON ODGOVORI** - Svi odgovori u JSON formatu
✅ Osnovni setup (nasleđeno iz commit-05)

## Komit poruka
"Add basic controllers: AuthController and PatientController"