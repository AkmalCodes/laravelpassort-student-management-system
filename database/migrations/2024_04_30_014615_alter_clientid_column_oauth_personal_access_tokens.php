<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('oauth_personal_access_clients', function (Blueprint $table) {
            $table->string('client_id', 100)->change(); // Adjust to store UUIDs
        });
    }

    public function down()
    {
        Schema::table('oauth_personal_access_clients', function (Blueprint $table) {
            $table->integer('client_id')->change(); // Revert back to integer if necessary
        });
    }


};
