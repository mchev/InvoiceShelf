<?php

use Illuminate\Database\Migrations\Migration;
use InvoiceShelf\Models\Invoice;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $overdueInvoices = Invoice::where('status', 'OVERDUE')->get();

        if ($overdueInvoices) {
            $overdueInvoices->map(function ($overdueInvoice) {
                $overdueInvoice->status = Invoice::STATUS_SENT;
                $overdueInvoice->overdue = true;
                $overdueInvoice->save();
            });
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
