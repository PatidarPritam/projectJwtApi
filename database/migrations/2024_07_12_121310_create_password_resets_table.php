<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetsTable extends Migration
{
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token'); // This will store the OTP
            $table->timestamp('created_at')->nullable();
            // Add a unique constraint to the 'email' field if needed
            $table->unique('email'); // Ensure 'email' is unique to avoid duplication
        });
    }

    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
}
