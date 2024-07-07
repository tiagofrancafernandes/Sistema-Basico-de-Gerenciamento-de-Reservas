<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->integer('document_type')->nullable();
            $table->string('document')->nullable();
            $table->json('attachments')->nullable();
            $table->json('children')->nullable(); // name, age, note, ?document_type, ?document,
            $table->json('emergency_contacts')->nullable(); // - [?name, phone, ?note]
            $table->longText('internal_note')->nullable();
            $table->string('source')->nullable()->index();
            $table->string('partner_code')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
