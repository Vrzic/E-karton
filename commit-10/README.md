# Health Records Application

## Opis projekta
Veb aplikacija za elektronski zdravstveni karton koja omogućava upravljanje pacijentima, doktorima, medicinskim sestrama i zdravstvenim kartonima.

## Autori
- Andrea Dorontic
- Aleksandra Vrzic  
- Jovana Sekulic

## Tehnologije
- Laravel 12
- PHP 8.2+
- MySQL/SQLite
- Sanctum Authentication
- REST API

## Funkcionalnosti

### Osnovne funkcionalnosti
- Registracija i prijava korisnika
- Upravljanje korisnicima sa različitim ulogama (admin, doctor, nurse, patient)
- CRUD operacije za pacijente, doktore, medicinske sestre
- Upravljanje zdravstvenim kartonima
- Upravljanje terminima
- Upravljanje receptima

### Funkcionalnosti za višu ocenu
- API rute za paginaciju i filtriranje
- Funkcionalnost za izmenu lozinke
- 3+ uloge u sistemu (admin, doctor, nurse, patient)
- Seeders, factories i resources za sve modele
- Funkcionalnost pretrage po određenim kriterijumima
- Eksport podataka u CSV formatu

## Struktura baze podataka

### Modeli
1. **User** - osnovni korisnik sa ulogom
2. **Patient** - pacijent sa zdravstvenim podacima
3. **Doctor** - doktor sa specijalizacijom
4. **Nurse** - medicinska sestra
5. **HealthRecord** - zdravstveni karton
6. **Appointment** - termin
7. **Prescription** - recept

### Migracije
- Kreiranje tabela (users, patients, doctors, nurses, health_records, appointments, prescriptions)
- Izmena postojećih kolona (dodavanje phone kolone u users)
- Brisanje kolona (uklanjanje remember_token iz users)
- Postavljanje dodatnih ograničenja (check constraints za appointments)
- Dodavanje spoljnih ključeva (foreign keys za health_records)

## API Rute

### Javne rute
- `POST /api/register` - Registracija korisnika
- `POST /api/login` - Prijava korisnika

### Zaštićene rute (zahtevaju autentifikaciju)
- `POST /api/logout` - Odjava
- `GET /api/patients` - Lista pacijenta
- `POST /api/patients` - Kreiranje pacijenta
- `GET /api/patients/{id}` - Prikaz pacijenta
- `PUT /api/patients/{id}` - Ažuriranje pacijenta
- `DELETE /api/patients/{id}` - Brisanje pacijenta
- `GET /api/patients/search` - Pretraga pacijenta
- `GET /api/patients/export/csv` - Eksport pacijenta u CSV

### Rute za admin korisnike
- `GET /api/admin/stats` - Statistike sistema
- `DELETE /api/admin/users/{id}` - Brisanje korisnika

### Rute za doktore
- `GET /api/doctor/patients` - Moji pacijenti
- `GET /api/doctor/appointments` - Moji termini

### Rute za medicinske sestre
- `GET /api/nurse/patients` - Pregled pacijenta

### Rute za pacijente
- `GET /api/patient/profile` - Moj profil
- `GET /api/patient/appointments` - Moji termini
- `GET /api/patient/health-records` - Moji zdravstveni kartoni

## Instalacija i pokretanje

### Preduslovi
- PHP 8.2+
- Composer
- MySQL/SQLite

### Koraci instalacije
1. Kloniranje repozitorijuma
```bash
git clone <repository-url>
cd health-records-app
```

2. Instalacija zavisnosti
```bash
composer install
```

3. Konfiguracija baze podataka
```bash
cp .env.example .env
# Urediti .env fajl sa podacima baze
```

4. Generisanje aplikacionog ključa
```bash
php artisan key:generate
```

5. Pokretanje migracija
```bash
php artisan migrate
```

6. Pokretanje seeder-a
```bash
php artisan db:seed
```

7. Pokretanje aplikacije
```bash
php artisan serve
```

## Testiranje kroz Postman

### Registracija korisnika
```
POST /api/register
Content-Type: application/json

{
    "name": "Test Patient",
    "email": "patient@test.com",
    "password": "password123",
    "password_confirmation": "password123",
    "role": "patient",
    "phone": "+381601234567",
    "date_of_birth": "1990-01-01",
    "address": "Test Address 123"
}
```

### Prijava korisnika
```
POST /api/login
Content-Type: application/json

{
    "email": "patient@test.com",
    "password": "password123"
}
```

### Kreiranje pacijenta (zahtevaju token)
```
POST /api/patients
Authorization: Bearer {token}
Content-Type: application/json

{
    "user_id": 1,
    "medical_record_number": "MRN000001",
    "blood_type": "A+",
    "allergies": ["Penicillin"],
    "medical_history": ["Hypertension"]
}
```

### Pretraga pacijenta
```
GET /api/patients/search?q=test
Authorization: Bearer {token}
```

### Eksport pacijenta u CSV
```
GET /api/patients/export/csv
Authorization: Bearer {token}
```

## Test korisnici

Nakon pokretanja seeder-a, dostupni su sledeći test korisnici:

- **Admin**: admin@health.com / password
- **Doctor**: doctor@health.com / password  
- **Nurse**: nurse@health.com / password
- **Patient**: patient@health.com / password

## Autentifikacija

Aplikacija koristi Laravel Sanctum za API autentifikaciju. Nakon uspešne prijave, korisnik dobija token koji se koristi u `Authorization` header-u kao `Bearer {token}`.

## Autorizacija

Različite rute su zaštićene prema ulozi korisnika:
- **Admin**: Pristup svim funkcionalnostima
- **Doctor**: Pristup svojim pacijentima i terminima
- **Nurse**: Pregled zdravstvenih kartona
- **Patient**: Pristup sopstvenim podacima

## Paginacija

Većina API ruta podržava paginaciju sa 10 rezultata po stranici. Paginacija se može kontrolisati preko `page` query parametra.

## Pretraga i filtriranje

API podržava pretragu pacijenta po imenu, email-u ili broju medicinskog kartona.

## Eksport podataka

Pacijenti se mogu eksportovati u CSV format sa osnovnim informacijama.

## Dodatne napomene

- Svi API odgovori su u JSON formatu
- Greške se vraćaju u JSON formatu sa odgovarajućim HTTP status kodovima
- Validacija se vrši na nivou request klasa
- Middleware proverava autentifikaciju i autorizaciju
- Factory-ji i seederi omogućavaju brzo popunjavanje test podacima
