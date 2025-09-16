# Postman Testiranje - Health Records API

## Uvod
Ova dokumentacija opisuje kako testirati Health Records API kroz Postman aplikaciju. API je kreiran u Laravel framework-u i podržava sve CRUD operacije za zdravstvene kartone.

## Instalacija i pokretanje
1. Klonirati repozitorijum
2. Instalirati zavisnosti: `composer install`
3. Kopirati `.env.example` u `.env` i konfigurisati bazu
4. Pokrenuti migracije: `php artisan migrate:fresh`
5. Pokrenuti seeder-e: `php artisan db:seed`
6. Pokrenuti aplikaciju: `php artisan serve`

## Import Postman kolekcije
1. Otvoriti Postman
2. Kliknuti "Import" dugme
3. Učitati `Health_Records_API.postman_collection.json` fajl
4. Postaviti environment varijable:
   - `base_url`: `http://localhost:8000`
   - `auth_token`: ostaviti prazno za sada

## Test korisnici
Nakon pokretanja seeder-a, dostupni su sledeći test korisnici:
- **Admin**: admin@health.com / password
- **Doctor**: doctor@health.com / password  
- **Nurse**: nurse@health.com / password
- **Patient**: patient@health.com / password

## Testiranje autentifikacije

### 1. Registracija korisnika
**Endpoint**: `POST /api/register`
**Body**:
```json
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

**Očekivani odgovor**: 201 Created sa token-om

### 2. Prijava korisnika
**Endpoint**: `POST /api/login`
**Body**:
```json
{
    "email": "patient@test.com",
    "password": "password123"
}
```

**Očekivani odgovor**: 200 OK sa token-om

**Važno**: Kopirati token iz odgovora i postaviti ga u `auth_token` varijablu

## Testiranje CRUD operacija

### 3. Kreiranje pacijenta
**Endpoint**: `POST /api/patients`
**Headers**: 
- Authorization: Bearer {token}
- Content-Type: application/json

**Body**:
```json
{
    "user_id": 1,
    "medical_record_number": "MRN000001",
    "blood_type": "A+",
    "allergies": ["Penicillin"],
    "medical_history": ["Hypertension"]
}
```

**Očekivani odgovor**: 201 Created sa podacima pacijenta

### 4. Pregled svih pacijenta
**Endpoint**: `GET /api/patients`
**Headers**: Authorization: Bearer {token}

**Očekivani odgovor**: 200 OK sa listom pacijenta (paginacija)

### 5. Pregled pojedinačnog pacijenta
**Endpoint**: `GET /api/patients/{id}`
**Headers**: Authorization: Bearer {token}

**Očekivani odgovor**: 200 OK sa podacima pacijenta

### 6. Ažuriranje pacijenta
**Endpoint**: `PUT /api/patients/{id}`
**Headers**: 
- Authorization: Bearer {token}
- Content-Type: application/json

**Body**:
```json
{
    "blood_type": "B+",
    "allergies": ["Penicillin", "Aspirin"]
}
```

**Očekivani odgovor**: 200 OK sa ažuriranim podacima

### 7. Brisanje pacijenta
**Endpoint**: `DELETE /api/patients/{id}`
**Headers**: Authorization: Bearer {token}

**Očekivani odgovor**: 200 OK sa porukom o uspešnom brisanju

## Testiranje dodatnih funkcionalnosti

### 8. Pretraga pacijenta
**Endpoint**: `GET /api/patients/search?q=test`
**Headers**: Authorization: Bearer {token}

**Očekivani odgovor**: 200 OK sa rezultatima pretrage

### 9. Eksport pacijenta u CSV
**Endpoint**: `GET /api/patients/export/csv`
**Headers**: Authorization: Bearer {token}

**Očekivani odgovor**: 200 OK sa CSV fajlom

### 10. Admin statistike
**Endpoint**: `GET /api/admin/stats`
**Headers**: Authorization: Bearer {token}

**Očekivani odgovor**: 200 OK sa statistikama sistema (samo za admin korisnike)

## Testiranje role-based pristupa

### 11. Pristup doktor rutama
**Endpoint**: `GET /api/doctor/patients`
**Headers**: Authorization: Bearer {token}

**Očekivani odgovor**: 200 OK sa listom pacijenta (samo za doktore)

### 12. Pristup medicinska sestra rutama
**Endpoint**: `GET /api/nurse/patients`
**Headers**: Authorization: Bearer {token}

**Očekivani odgovor**: 200 OK sa pregledom pacijenta (samo za medicinske sestre)

### 13. Pristup pacijent rutama
**Endpoint**: `GET /api/patient/profile`
**Headers**: Authorization: Bearer {token}

**Očekivani odgovor**: 200 OK sa profilom pacijenta (samo za pacijente)

## Testiranje grešaka

### 14. Pristup bez autentifikacije
**Endpoint**: `GET /api/patients`
**Headers**: bez Authorization header-a

**Očekivani odgovor**: 401 Unauthorized

### 15. Pristup sa nevažećim token-om
**Endpoint**: `GET /api/patients`
**Headers**: Authorization: Bearer invalid_token

**Očekivani odgovor**: 401 Unauthorized

### 16. Pristup sa nedozvoljenom ulogom
**Endpoint**: `GET /api/admin/stats`
**Headers**: Authorization: Bearer {patient_token}

**Očekivani odgovor**: 403 Forbidden

## Validacija podataka

### 17. Kreiranje pacijenta sa nevažećim podacima
**Endpoint**: `POST /api/patients`
**Headers**: 
- Authorization: Bearer {token}
- Content-Type: application/json

**Body**:
```json
{
    "user_id": 999,
    "medical_record_number": "",
    "blood_type": "INVALID"
}
```

**Očekivani odgovor**: 422 Unprocessable Entity sa listom grešaka

## Testiranje paginacije

### 18. Paginacija pacijenta
**Endpoint**: `GET /api/patients?page=2`
**Headers**: Authorization: Bearer {token}

**Očekivani odgovor**: 200 OK sa drugom stranicom rezultata

## Napomene za testiranje

1. **Token management**: Nakon svake prijave, ažurirati `auth_token` varijablu
2. **Role testing**: Testirati sve rute sa različitim ulogama
3. **Error handling**: Proveriti da li se greške vraćaju u JSON formatu
4. **Response format**: Svi odgovori moraju biti u JSON formatu
5. **Status codes**: Proveriti da li se koriste odgovarajući HTTP status kodovi

## Česti problemi i rešenja

1. **401 Unauthorized**: Proveriti da li je token validan i da li je postavljen
2. **403 Forbidden**: Proveriti da li korisnik ima odgovarajuću ulogu
3. **422 Validation Error**: Proveriti da li su svi obavezni podaci poslati
4. **500 Internal Server Error**: Proveriti da li je aplikacija pokrenuta i da li je baza dostupna

## Zaključak

Ovaj API podržava sve zahtevane funkcionalnosti:
- ✅ Autentifikacija (login, register, logout)
- ✅ CRUD operacije za sve modele
- ✅ Role-based pristup (admin, doctor, nurse, patient)
- ✅ Paginacija i pretraga
- ✅ Eksport podataka
- ✅ Validacija i error handling
- ✅ REST API konvencije
- ✅ JSON odgovori za sve rute



