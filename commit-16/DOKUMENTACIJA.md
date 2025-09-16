# Dokumentacija - Health Records Application

## Autori
- **Andrea Dorontic**
- **Aleksandra Vrzic**  
- **Jovana Sekulic**

## Opis projekta
Veb aplikacija za elektronski zdravstveni karton koja omogućava upravljanje pacijentima, doktorima, medicinskim sestrama i zdravstvenim kartonima. Aplikacija je kreirana u Laravel framework-u sa REST API pristupom.

## Tehnologije
- **Backend**: Laravel 12, PHP 8.2+
- **Baza podataka**: SQLite (može se konfigurisati za MySQL/PostgreSQL)
- **Autentifikacija**: Laravel Sanctum
- **API**: REST API sa JSON odgovorima
- **Testiranje**: Postman kolekcija

## Struktura projekta

### Modeli i veze
Aplikacija koristi 7 glavnih modela sa međusobnim vezama:

```php
// User model - osnovni korisnik
class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'role', 
        'phone', 'date_of_birth', 'address'
    ];
    
    // Veze sa drugim modelima
    public function patient() { return $this->hasOne(Patient::class); }
    public function doctor() { return $this->hasOne(Doctor::class); }
    public function nurse() { return $this->hasOne(Nurse::class); }
    
    // Role checking metode
    public function isAdmin() { return $this->role === 'admin'; }
    public function isDoctor() { return $this->role === 'doctor'; }
    public function isNurse() { return $this->role === 'nurse'; }
    public function isPatient() { return $this->role === 'patient'; }
}
```

```php
// Patient model - pacijent
class Patient extends Model
{
    protected $fillable = [
        'user_id', 'medical_record_number', 'blood_type',
        'allergies', 'medical_history', 'emergency_contact_name',
        'emergency_contact_phone', 'insurance_provider', 'insurance_number'
    ];
    
    // Veze
    public function user() { return $this->belongsTo(User::class); }
    public function healthRecords() { return $this->hasMany(HealthRecord::class); }
    public function appointments() { return $this->hasMany(Appointment::class); }
    public function prescriptions() { return $this->hasMany(Prescription::class); }
}
```

### Migracije
Kreirane su sledeće migracije koje pokrivaju sve zahteve:

1. **Kreiranje tabela**:
   - `users` - osnovni korisnici sa ulogama
   - `patients` - pacijenti sa zdravstvenim podacima
   - `doctors` - doktori sa specijalizacijama
   - `nurses` - medicinske sestre
   - `health_records` - zdravstveni kartoni
   - `appointments` - termini
   - `prescriptions` - recepti

2. **Izmena postojećih kolona**:
   - Dodavanje `role`, `phone`, `date_of_birth`, `address` u `users` tabelu

3. **Brisanje kolona**:
   - Uklanjanje `remember_token` iz `users` tabele

4. **Postavljanje dodatnih ograničenja**:
   - Indeksi za `appointments` tabelu (patient_id + appointment_date, doctor_id + appointment_date)

5. **Dodavanje spoljnih ključeva**:
   - Foreign keys za `health_records` tabelu

### API Rute
API je organizovan u logične grupe sa odgovarajućim middleware-om:

```php
// Javne rute
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Zaštićene rute (zahtevaju autentifikaciju)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('patients', PatientController::class);
    Route::apiResource('doctors', DoctorController::class);
    Route::apiResource('health-records', HealthRecordController::class);
    Route::apiResource('appointments', AppointmentController::class);
    
    // Dodatne funkcionalnosti
    Route::get('/patients/search', [PatientController::class, 'search']);
    Route::get('/patients/export/csv', [PatientController::class, 'exportCsv']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
});

// Role-based rute
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin/stats', [AuthController::class, 'adminStats']);
});

Route::middleware(['auth:sanctum', 'role:doctor'])->group(function () {
    Route::get('/doctor/patients', [DoctorController::class, 'myPatients']);
});
```

### Kontroleri
Svi kontroleri implementiraju REST API konvencije:

```php
// PatientController - primer resource kontrolera
class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with(['user', 'healthRecords', 'appointments'])
            ->paginate(10);
        return PatientResource::collection($patients);
    }
    
    public function store(StorePatientRequest $request)
    {
        $patient = Patient::create($request->validated());
        return new PatientResource($patient);
    }
    
    public function show(string $id)
    {
        $patient = Patient::with(['user', 'healthRecords', 'appointments', 'prescriptions'])
            ->findOrFail($id);
        return new PatientResource($patient);
    }
    
    // Dodatne funkcionalnosti
    public function search(Request $request)
    {
        $query = $request->get('q');
        $patients = Patient::whereHas('user', function($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('email', 'like', "%{$query}%");
        })->orWhere('medical_record_number', 'like', "%{$query}%")
          ->with('user')
          ->paginate(10);
        
        return PatientResource::collection($patients);
    }
    
    public function exportCsv()
    {
        $patients = Patient::with('user')->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="patients.csv"',
        ];
        
        $callback = function() use ($patients) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Medical Record Number', 'Blood Type']);
            
            foreach ($patients as $patient) {
                fputcsv($file, [
                    $patient->id,
                    $patient->user->name,
                    $patient->user->email,
                    $patient->medical_record_number,
                    $patient->blood_type
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
```

### Autentifikacija i autorizacija
Aplikacija koristi Laravel Sanctum za API autentifikaciju:

```php
// AuthController - registracija
public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|in:patient,doctor,nurse',
        'phone' => 'nullable|string|max:20',
        'date_of_birth' => 'nullable|date',
        'address' => 'nullable|string|max:500',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'phone' => $request->phone,
        'date_of_birth' => $request->date_of_birth,
        'address' => $request->address,
    ]);

    // Kreiranje role-specific zapisa
    switch ($request->role) {
        case 'patient':
            Patient::create([
                'user_id' => $user->id,
                'medical_record_number' => 'MRN' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
            ]);
            break;
        case 'doctor':
            Doctor::create([
                'user_id' => $user->id,
                'license_number' => 'DR' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
                'specialization' => $request->specialization ?? 'General Medicine',
            ]);
            break;
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'success' => true,
        'message' => 'User registered successfully',
        'data' => [
            'user' => $user,
            'token' => $token
        ]
    ], 201);
}
```

### Middleware za autorizaciju
Kreiran je custom middleware za proveru uloga:

```php
// CheckRole middleware
class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user() || !$request->user()->hasRole($role)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        return $next($request);
    }
}
```

### Resource klase
API koristi resource klase za formatiranje odgovora:

```php
// PatientResource
class PatientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
                'date_of_birth' => $this->user->date_of_birth,
                'address' => $this->user->address,
            ],
            'medical_record_number' => $this->medical_record_number,
            'blood_type' => $this->blood_type,
            'allergies' => $this->allergies,
            'medical_history' => $this->medical_history,
            'emergency_contact_name' => $this->emergency_contact_name,
            'emergency_contact_phone' => $this->emergency_contact_phone,
            'insurance_provider' => $this->insurance_provider,
            'insurance_number' => $this->insurance_number,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
```

### Validacija
Kreirane su request klase za validaciju:

```php
// StorePatientRequest
class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'medical_record_number' => 'required|unique:patients',
            'blood_type' => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'allergies' => 'nullable|array',
            'medical_history' => 'nullable|array',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'insurance_provider' => 'nullable|string|max:255',
            'insurance_number' => 'nullable|string|max:255',
        ];
    }
}
```

### Factory-ji i Seederi
Kreirani su factory-ji za generisanje test podataka:

```php
// PatientFactory
class PatientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'medical_record_number' => 'MRN' . $this->faker->unique()->numberBetween(100000, 999999),
            'blood_type' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'allergies' => $this->faker->optional()->randomElements(['Penicillin', 'Aspirin', 'Ibuprofen', 'Latex', 'Peanuts'], $this->faker->numberBetween(0, 3)),
            'medical_history' => $this->faker->optional()->randomElements(['Hypertension', 'Diabetes', 'Asthma', 'Heart Disease'], $this->faker->numberBetween(0, 2)),
            'emergency_contact_name' => $this->faker->optional()->name(),
            'emergency_contact_phone' => $this->faker->optional()->phoneNumber(),
            'insurance_provider' => $this->faker->optional()->company(),
            'insurance_number' => $this->faker->optional()->regexify('[A-Z]{2}[0-9]{8}'),
        ];
    }
}
```

## Funkcionalnosti za višu ocenu

### 1. API rute za paginaciju i filtriranje
```php
// Paginacija u kontrolerima
public function index()
{
    $patients = Patient::with(['user', 'healthRecords', 'appointments'])
        ->paginate(10);
    return PatientResource::collection($patients);
}

// Pretraga sa paginacijom
public function search(Request $request)
{
    $query = $request->get('q');
    $patients = Patient::whereHas('user', function($q) use ($query) {
        $q->where('name', 'like', "%{$query}%")
          ->orWhere('email', 'like', "%{$query}%");
    })->orWhere('medical_record_number', 'like', "%{$query}%")
      ->with('user')
      ->paginate(10);
    
    return PatientResource::collection($patients);
}
```

### 2. Funkcionalnost za izmenu lozinke
```php
public function changePassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Current password is incorrect'
        ], 400);
    }

    $user->update([
        'password' => Hash::make($request->new_password)
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Password changed successfully'
    ]);
}
```

### 3. 3+ uloge u sistemu
- **Admin**: Pristup svim funkcionalnostima
- **Doctor**: Pristup svojim pacijentima i terminima
- **Nurse**: Pregled zdravstvenih kartona
- **Patient**: Pristup sopstvenim podacima

### 4. Seeders, factory, resources za sve modele
- ✅ UserFactory sa role podrškom
- ✅ PatientFactory sa realističnim podacima
- ✅ DoctorFactory sa specijalizacijama
- ✅ Seederi za sve modele
- ✅ Resource klase za formatiranje odgovora

### 5. Funkcionalnost pretrage po određenim kriterijumima
```php
// Pretraga pacijenta po imenu, email-u ili broju kartona
public function search(Request $request)
{
    $query = $request->get('q');
    $patients = Patient::whereHas('user', function($q) use ($query) {
        $q->where('name', 'like', "%{$query}%")
          ->orWhere('email', 'like', "%{$query}%");
    })->orWhere('medical_record_number', 'like', "%{$query}%")
      ->with('user')
      ->paginate(10);
    
    return PatientResource::collection($patients);
}
```

### 6. Eksport podataka u CSV format
```php
public function exportCsv()
{
    $patients = Patient::with('user')->get();
    
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="patients.csv"',
    ];
    
    $callback = function() use ($patients) {
        $file = fopen('php://output', 'w');
        fputcsv($file, ['ID', 'Name', 'Email', 'Medical Record Number', 'Blood Type']);
        
        foreach ($patients as $patient) {
            fputcsv($file, [
                $patient->id,
                $patient->user->name,
                $patient->user->email,
                $patient->medical_record_number,
                $patient->blood_type
            ]);
        }
        
        fclose($file);
    };
    
    return response()->stream($callback, 200, $headers);
}
```

## Testiranje

### Postman kolekcija
Kreirana je kompletna Postman kolekcija (`Health_Records_API.postman_collection.json`) koja uključuje:
- Autentifikaciju (register, login, logout)
- CRUD operacije za sve modele
- Role-based rute
- Dodatne funkcionalnosti (pretraga, eksport)

### Test korisnici
Nakon pokretanja seeder-a, dostupni su test korisnici:
- **Admin**: admin@health.com / password
- **Doctor**: doctor@health.com / password  
- **Nurse**: nurse@health.com / password
- **Patient**: patient@health.com / password

## Instalacija i pokretanje

### Preduslovi
- PHP 8.2+
- Composer
- SQLite (ili MySQL/PostgreSQL)

### Koraci
1. Kloniranje repozitorijuma
2. `composer install`
3. Kopiranje `.env.example` u `.env`
4. `php artisan key:generate`
5. `php artisan migrate:fresh`
6. `php artisan db:seed`
7. `php artisan serve`

## Zaključak

Aplikacija za zdravstvene e-kartone uspešno implementira sve zahtevane funkcionalnosti:

✅ **Osnovni zahtevi**:
- Laravel aplikacija sa 3+ povezana modela
- 5+ različitih tipova migracija
- REST API rute i kontroleri
- JSON odgovori za sve rute
- Autentifikacija korisnika (login, logout, register)
- Zaštita ruta za autentifikovane korisnike

✅ **Funkcionalnosti za višu ocenu**:
- API rute za paginaciju i filtriranje
- Funkcionalnost za izmenu lozinke
- 3+ uloge u sistemu
- Seeders, factory, resources za sve modele
- Funkcionalnost pretrage
- Eksport podataka u CSV format

✅ **Dodatne funkcionalnosti**:
- Role-based autorizacija
- Validacija podataka
- Error handling
- Factory-ji za test podatke
- Kompletna Postman kolekcija
- Detaljna dokumentacija

Aplikacija je spremna za testiranje kroz Postman i može se koristiti kao osnova za dalji razvoj zdravstvenog informacionog sistema.



