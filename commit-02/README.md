# Commit 2: User model i osnovna migracija

## Opis
Dodavanje User modela i osnovne migracije za users tabelu. Ovo je prvi model u aplikaciji koji definiše osnovnu strukturu korisnika.

## Šta je uključeno
- User model sa osnovnim funkcionalnostima
- Migracija za kreiranje users tabele
- Osnovni Laravel setup (nasleđeno iz commit-01)

## Modeli
### User
- Osnovni korisnik sa imenom, email-om i lozinkom
- Laravel autentifikacija (HasApiTokens, HasFactory, Notifiable)
- Timestamps (created_at, updated_at)

## Migracije
### 0001_01_01_000000_create_users_table.php
- Kreiranje users tabele
- Kolone: id, name, email, email_verified_at, password, remember_token, timestamps
- Indeksi za email i remember_token

## Struktura
```
commit-02/
├── app/
│   ├── Models/
│   │   └── User.php
│   └── Providers/
├── database/
│   └── migrations/
│       └── 0001_01_01_000000_create_users_table.php
├── ... (ostali Laravel fajlovi)
```

## Status
✅ **USER MODEL** - Osnovni User model kreiran
✅ **MIGRACIJA** - Users tabela definisana
✅ Laravel autentifikacija konfigurisana
✅ Osnovni setup (nasleđeno iz commit-01)

## Komit poruka
"Add User model and basic users table migration"