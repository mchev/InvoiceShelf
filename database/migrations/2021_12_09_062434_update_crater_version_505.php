<?php

use Illuminate\Database\Migrations\Migration;
use InvoiceShelf\Models\Setting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Setting::setSetting('version', '5.0.5');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
