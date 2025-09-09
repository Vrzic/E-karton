# Commit 5: Kompletni modeli sistema

## Opis
Dodavanje svih preostalih modela sistema - Nurse, HealthRecord, Appointment i Prescription. Ovo završava definisanje svih entiteta u zdravstvenom sistemu.

## Šta je uključeno
- Nurse model za medicinske sestre
- HealthRecord model za zdravstvene kartone
- Appointment model za termine
- Prescription model za recepte
- Sve migracije za nove tabele
- Kompletne relacije između svih modela

## Modeli
### Nurse
- Relacija sa User modelom (belongsTo)
- Relacija sa HealthRecord modelom (hasMany)

### HealthRecord
- Sadržaj zdravstvenog kartona
- Relacija sa Patient modelom (belongsTo)
- Relacija sa Doctor modelom (belongsTo)
- Relacija sa Nurse modelom (belongsTo)

### Appointment
- Termin između doktora i pacijenta
- Datum i vreme termina
- Status termina
- Relacija sa Patient modelom (belongsTo)
- Relacija sa Doctor modelom (belongsTo)

### Prescription
- Recept sa lekovima
- Relacija sa Patient modelom (belongsTo)
- Relacija sa Doctor modelom (belongsTo)

## Migracije
### 2025_09_02_155758_create_nurses_table.php
- Kreiranje nurses tabele
- Kolone: id, user_id, department, timestamps
- Foreign key za user_id

### 2025_09_02_155802_create_health_records_table.php
- Kreiranje health_records tabele
- Kolone: id, patient_id, doctor_id, nurse_id, content, timestamps
- Foreign keys za patient_id, doctor_id, nurse_id

### 2025_09_02_155806_create_appointments_table.php
- Kreiranje appointments tabele
- Kolone: id, patient_id, doctor_id, appointment_date, status, notes, timestamps
- Foreign keys za patient_id, doctor_id

### 2025_09_02_155812_create_prescriptions_table.php
- Kreiranje prescriptions tabele
- Kolone: id, patient_id, doctor_id, medication, dosage, instructions, timestamps
- Foreign keys za patient_id, doctor_id

## Struktura
```
commit-05/
├── app/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Doctor.php
│   │   ├── Patient.php
│   │   ├── Nurse.php
│   │   ├── HealthRecord.php
│   │   ├── Appointment.php
│   │   └── Prescription.php
│   └── Providers/
├── database/
│   └── migrations/
│       ├── 0001_01_01_000000_create_users_table.php
│       ├── 2025_09_02_155740_add_additional_fields_to_users_table.php
│       ├── 2025_09_02_155748_create_patients_table.php
│       ├── 2025_09_02_155754_create_doctors_table.php
│       ├── 2025_09_02_155758_create_nurses_table.php
│       ├── 2025_09_02_155802_create_health_records_table.php
│       ├── 2025_09_02_155806_create_appointments_table.php
│       └── 2025_09_02_155812_create_prescriptions_table.php
├── ... (ostali Laravel fajlovi)
```

## Status
✅ **NURSE MODEL** - Nurse model za medicinske sestre
✅ **HEALTH RECORD MODEL** - HealthRecord model za zdravstvene kartone
✅ **APPOINTMENT MODEL** - Appointment model za termine
✅ **PRESCRIPTION MODEL** - Prescription model za recepte
✅ **MIGRACIJE** - Sve tabele kreirane
✅ **RELACIJE** - Kompletne relacije između svih modela
✅ Osnovni setup (nasleđeno iz commit-04)

## Komit poruka
"Add remaining models: Nurse, HealthRecord, Appointment, and Prescription"