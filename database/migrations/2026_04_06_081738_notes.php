<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //

        Schema::create('notes', function (Blueprint $notes) {
            $notes->id();
            $notes->string('name');
            $notes->date('date');
            $notes->string('url');
            $notes->foreignId('user_id')->constrained('users');
            $notes->timestamps();
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
