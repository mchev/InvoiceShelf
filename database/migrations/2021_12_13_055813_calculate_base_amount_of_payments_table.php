<?php

use Illuminate\Database\Migrations\Migration;
use InvoiceShelf\Models\Payment;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $payments = Payment::where('exchange_rate', '<>', null)->get();

        if ($payments) {
            foreach ($payments as $payment) {
                $payment->base_amount = $payment->exchange_rate * $payment->amount;
                $payment->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        //
    }
};
