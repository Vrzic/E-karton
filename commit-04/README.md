# Commit 4: Doctor i Patient modeli

## Opis
Dodavanje Doctor i Patient modela sa njihovim migracijama. Ovo proširuje sistem sa specijalizovanim modelima za različite tipove korisnika.

## Šta je uključeno
- Doctor model sa specijalizacijom
- Patient model sa zdravstvenim podacima
- Migracije za doctors i patients tabele
- Relacije između User, Doctor i Patient modela

## Modeli
### Doctor
- Specijalizacija doktora
- Relacija sa User modelom (belongsTo)
- Relacija sa Patient modelom (hasMany)
- Relacija sa Appointment modelom (hasMany)

### Patient
- Medicinski broj kartona
- Krvna grupa
- Alergije
- Medicinska istorija
- Relacija sa User modelom (belongsTo)
- Relacija sa Doctor modelom (belongsTo)
- Relacija sa HealthRecord modelom (hasMany)
- Relacija sa Appointment modelom (hasMany)

## Migracije
### 2025_09_02_155748_create_patients_table.php
- Kreiranje patients tabele
- Kolone: id, user_id, medical_record_number, blood_type, allergies, medical_history, timestamps
- Foreign key za user_id

### 2025_09_02_155754_create_doctors_table.php
- Kreiranje doctors tabele
- Kolone: id, user_id, specialization, timestamps
- Foreign key za user_id

## Struktura
```
commit-04/
├── app/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Doctor.php
│   │   └── Patient.php
│   └── Providers/
├── database/
│   └── migrations/
│       ├── 0001_01_01_000000_create_users_table.php
│       ├── 2025_09_02_155740_add_additional_fields_to_users_table.php
│       ├── 2025_09_02_155748_create_patients_table.php
│       └── 2025_09_02_155754_create_doctors_table.php
├── ... (ostali Laravel fajlovi)
```

## Status
✅ **DOCTOR MODEL** - Doctor model sa specijalizacijom
✅ **PATIENT MODEL** - Patient model sa zdravstvenim podacima
✅ **MIGRACIJE** - Doctors i patients tabele
✅ **RELACIJE** - Povezivanje User, Doctor i Patient modela
✅ Osnovni setup (nasleđeno iz commit-03)

## Komit poruka
"Add Doctor and Patient models with their migrations"