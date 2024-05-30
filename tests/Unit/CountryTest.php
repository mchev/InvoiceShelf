<?php

use Illuminate\Support\Facades\Artisan;
use App\Models\Address;
use App\Models\Country;

beforeEach(function () {
    Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);
    Artisan::call('db:seed', ['--class' => 'DemoSeeder', '--force' => true]);
});

test('country has many addresses', function () {
    $country = Country::find(1);

    $address = Address::factory()->count(5)->create([
        'country_id' => $country->id,
    ]);

    $this->assertTrue($country->address()->exists());
});
