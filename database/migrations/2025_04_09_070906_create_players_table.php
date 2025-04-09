<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('role', ['Roamer', 'EXPLaner', 'GoldLaner', 'MidLaner', 'Jungler']);
            $table->integer('mechanics')->default(10);
            $table->integer('strategy')->default(10);
            $table->integer('decision_making')->default(10);
            $table->integer('communication')->default(10);
            $table->integer('stamina')->default(100);
            $table->integer('xp')->default(0);
            $table->integer('money')->default(0);
            $table->enum('rank', [
                'Warrior',
                'Elite',
                'Master',
                'Grandmaster',
                'Epic',
                'Legend',
                'Mythic',
                'Mythical Glory',
                'Mythical Immortal'
            ])->default('Warrior');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
