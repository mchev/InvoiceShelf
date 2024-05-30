<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use InvoiceShelf\Models\Address;
use InvoiceShelf\Models\Setting;
use InvoiceShelf\Models\User;
use InvoiceShelf\Space\InstallUtils;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::whereIs('super admin')->first();

        $user->setSettings(['language' => 'en']);

        Address::create(['company_id' => $user->companies()->first()->id, 'country_id' => 1]);

        Setting::setSetting('profile_complete', 'COMPLETED');

        InstallUtils::createDbMarker();
    }
}
