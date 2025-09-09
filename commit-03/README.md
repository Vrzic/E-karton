# Commit 3: Dodatne User funkcionalnosti

## Opis
Proširivanje User modela sa dodatnim poljima i funkcionalnostima. Dodavanje role sistema i dodatnih korisničkih informacija.

## Šta je uključeno
- Prošireni User model sa dodatnim poljima
- Migracija za dodavanje novih kolona u users tabelu
- Role sistem (admin, doctor, nurse, patient)
- Dodatna korisnička polja (phone, date_of_birth, address)
- Role checking metode

## Modeli
### User (prošireni)
- Dodana polja: role, phone, date_of_birth, address
- Role checking metode: isAdmin(), isDoctor(), isNurse(), isPatient(), hasRole()
- Mass assignable polja proširena
- Date casting za date_of_birth

## Migracije
### 2025_09_02_155740_add_additional_fields_to_users_table.php
- Dodavanje role kolone (default: 'patient')
- Dodavanje phone kolone (nullable)
- Dodavanje date_of_birth kolone (nullable)
- Dodavanje address kolone (nullable)

## Struktura
```
commit-03/
├── app/
│   ├── Models/
│   │   └── User.php (prošireni)
│   └── Providers/
├── database/
│   └── migrations/
│       ├── 0001_01_01_000000_create_users_table.php
│       └── 2025_09_02_155740_add_additional_fields_to_users_table.php
├── ... (ostali Laravel fajlovi)
```

## Status
✅ **USER MODEL PROŠIREN** - Dodatna polja i role sistem
✅ **MIGRACIJA** - Dodatne kolone u users tabeli
✅ **ROLE SISTEM** - 4 uloge (admin, doctor, nurse, patient)
✅ **DODATNA POLJA** - phone, date_of_birth, address
✅ Osnovni setup (nasleđeno iz commit-02)

## Komit poruka
"Add role system and additional user fields to User model"