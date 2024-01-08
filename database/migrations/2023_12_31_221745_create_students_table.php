<?php

use App\Models\Student;
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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string("dni", 10)->unique();
            $table->string("name");
            $table->string("lastname");
            $table->enum("sex", Student::$_SEXS);
            $table->enum("instruction", Student::$_INSTRUCTIONS);
            $table->string("address");
            $table->string("email");
            $table->string("cellphone", 20);
            $table->string("phone")->nullable()->default(null);
            $table->text("description");
            $table->string("entity_name");
            $table->string("entity_post");
            $table->string("entity_address");
            $table->string("entity_phone");
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
        Schema::dropIfExists('students');
    }
};
