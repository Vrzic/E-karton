# Commit 1: Osnovni Laravel setup

## Opis
Inicijalni commit sa osnovnim Laravel setup-om. Ovo je početna verzija aplikacije sa osnovnim konfiguracijama i strukturom.

## Šta je uključeno
- Osnovni Laravel framework setup
- Composer konfiguracija
- Osnovne konfiguracije (app, auth, cache, database, etc.)
- Bootstrap fajlovi
- Public direktorijum sa index.php
- Osnovne rute (web.php, api.php, console.php)
- Test struktura
- Vendor direktorijum sa zavisnostima
- AppServiceProvider

## Struktura
```
commit-01/
├── app/
│   └── Providers/
│       └── AppServiceProvider.php
├── bootstrap/
├── config/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── vendor/
├── composer.json
├── composer.lock
├── artisan
├── package.json
├── phpunit.xml
└── vite.config.js
```

## Status
✅ **OSNOVNI SETUP** - Laravel aplikacija je inicijalizovana
✅ Composer zavisnosti instalirane
✅ Osnovne konfiguracije postavljene
✅ Bootstrap i public direktorijumi
✅ Osnovne rute definisane
✅ Test struktura kreirana

## Komit poruka
"Initial Laravel setup with basic configuration"