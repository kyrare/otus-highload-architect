<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $interests = [
            'Прорамирование',
            'Музыка',
            'Спорт',
            'Книги',
            'Путешествие',
            'Шопинг',
            'Ставки',
            'Фотография',
            'Танцы',
            'Рисование',
        ];

        foreach ($interests as $interest) {
            DB::table('interests')->insert(['name' => $interest]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interests');
    }
}
