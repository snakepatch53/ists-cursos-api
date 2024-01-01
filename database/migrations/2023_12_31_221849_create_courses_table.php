<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->text("image");
            $table->string("name");
            $table->integer("duration");
            $table->date("date_start");
            $table->date("date_end");
            $table->integer("quota");
            $table->text("whatsapp");
            $table->foreignId('teacher_id')->constrained('users');
            $table->foreignId('responsible_id')->constrained('users');
            $table->foreignId('template_id')->constrained('templates');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
