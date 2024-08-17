<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('observation')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('signatures');
    }
};
