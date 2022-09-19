<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Market;
use App\Models\Sector;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->float('price');
            $table->integer('quantify');
            $table->timestamps();
            $table->foreignIdFor(Market::class)->references('id')->on('markets')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreignIdFor(Sector::class)->references('id')->on('sectors')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreignIdFor(User::class)->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
