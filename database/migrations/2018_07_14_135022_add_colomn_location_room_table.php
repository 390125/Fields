<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColomnLocationRoomTable extends Migration
{
    /**
     * Run the migrations.
         *
         * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE rooms ADD COLUMN location geometry;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropColumn('location');
    }
}
