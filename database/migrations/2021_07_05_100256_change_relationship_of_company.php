<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use InvoiceShelf\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $users = User::all();

        if ($users) {
            foreach ($users as $user) {
                $user->companies()->attach($user->company_id);
                $user->company_id = null;
                $user->save();
            }
        }

        Schema::table('users', function (Blueprint $table) {
            if (config('database.default') !== 'sqlite') {
                $table->dropForeign(['company_id']);
            }
            $table->dropColumn('company_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
