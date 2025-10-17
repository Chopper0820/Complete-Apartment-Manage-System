<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Apartment;
use App\Models\Unit;
use App\Models\Tenant;
use App\Models\UtilityMeter;
use App\Models\UtilityReading;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\MaintenanceRequest;

echo "Testing models and CRUD operations...\n";

try {
    // Get the seeded admin user
    $user = User::where('email', 'admin@example.com')->first();
    if (!$user) {
        throw new Exception('Admin user not found. Please run php artisan db:seed');
    }
    echo "User found: " . $user->name . "\n";

    // Create Apartment
    $apartment = Apartment::create([
        'name' => 'Test Apartment Complex',
        'address' => '123 Test Street',
        'city' => 'Manila',
        'province' => 'Metro Manila',
        'zip_code' => '1000',
        'total_units' => 10
    ]);
    echo "Apartment created: " . $apartment->name . "\n";

    // Create Unit
    $unit = Unit::create([
        'apartment_id' => $apartment->id,
        'unit_number' => '101',
        'rent_amount' => 5000.00,
        'status' => 'vacant'
    ]);
    echo "Unit created: " . $unit->unit_number . "\n";

    // Create Tenant
    $tenant = Tenant::create([
        'user_id' => $user->id,
        'unit_id' => $unit->id,
        'lease_start' => now(),
        'lease_end' => now()->addYear(),
        'deposit_amount' => 5000.00
    ]);
    echo "Tenant created for user: " . $user->name . "\n";

    // Create Utility Meter
    $meter = UtilityMeter::create([
        'unit_id' => $unit->id,
        'type' => 'electricity',
        'meter_number' => 'E' . rand(100000, 999999),
        'rate_per_unit' => 12.50
    ]);
    echo "Utility Meter created: " . $meter->meter_number . "\n";

    // Create Utility Reading
    $reading = UtilityReading::create([
        'utility_meter_id' => $meter->id,
        'previous_reading' => 100.00,
        'current_reading' => 150.00,
        'reading_date' => now(),
        'units_used' => 50.00,
        'amount' => 625.00
    ]);
    echo "Utility Reading created: " . $reading->units_used . " units\n";

    // Create Bill
    $bill = Bill::create([
        'tenant_id' => $tenant->id,
        'billing_period_start' => now()->startOfMonth(),
        'billing_period_end' => now()->endOfMonth(),
        'rent_amount' => 5000.00,
        'utility_charges' => 625.00,
        'total_amount' => 5625.00,
        'due_date' => now()->endOfMonth()->addDays(15),
        'status' => 'pending'
    ]);
    echo "Bill created: ₱" . $bill->total_amount . "\n";

    // Create Payment
    $payment = Payment::create([
        'bill_id' => $bill->id,
        'tenant_id' => $tenant->id,
        'amount_paid' => 5625.00,
        'payment_method' => 'cash',
        'payment_date' => now()
    ]);
    echo "Payment created: ₱" . $payment->amount . "\n";

    // Update bill status to paid
    $bill->update(['status' => 'paid']);
    echo "Bill status updated to paid\n";

    // Create Maintenance Request
    $maintenance = MaintenanceRequest::create([
        'tenant_id' => $tenant->id,
        'unit_id' => $unit->id,
        'title' => 'Leaky Faucet',
        'description' => 'The kitchen faucet is leaking water continuously.',
        'priority' => 'medium',
        'status' => 'pending',
        'requested_date' => now()
    ]);
    echo "Maintenance Request created: " . $maintenance->title . "\n";

    // Test relationships
    echo "\nTesting relationships:\n";
    echo "Apartment has " . $apartment->units->count() . " unit(s)\n";
    echo "Unit belongs to apartment: " . $unit->apartment->name . "\n";
    echo "Tenant belongs to user: " . $tenant->user->name . "\n";
    echo "Tenant belongs to unit: " . $tenant->unit->unit_number . "\n";
    echo "Meter belongs to unit: " . $meter->unit->unit_number . "\n";
    echo "Reading belongs to meter: " . $reading->utilityMeter->meter_number . "\n";
    echo "Bill belongs to tenant: " . $bill->tenant->user->name . "\n";
    echo "Payment belongs to bill: ₱" . $payment->bill->total_amount . "\n";
    echo "Maintenance belongs to tenant: " . $maintenance->tenant->user->name . "\n";

    echo "\nAll CRUD operations and relationships tested successfully!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
