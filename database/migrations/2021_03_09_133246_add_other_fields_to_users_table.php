<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('preferred_origin_lat', 10, 7)->nullable()->after('preferred_origin');
            $table->decimal('preferred_origin_long', 10, 7)->nullable()->after('preferred_origin_lat');
            $table->decimal('preferred_destination_lat', 10, 7)->nullable()->after('preferred_destination');
            $table->decimal('preferred_destination_long', 10, 7)->nullable()->after('preferred_destination_lat');
            $table->decimal('home_location_lat', 10, 7)->nullable()->after('home_location');
            $table->decimal('home_location_long', 10, 7)->nullable()->after('home_location_lat');
            $table->boolean('notification')->default(1)->after('home_location_long');
            $table->text('equipment')->nullable()->after('notification');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('preferred_origin_lat');
            $table->dropColumn('preferred_origin_long');
            $table->dropColumn('preferred_destination_lat');
            $table->dropColumn('preferred_destination_long');
            $table->dropColumn('home_location_lat');
            $table->dropColumn('home_location_long');
            $table->dropColumn('notification');
            $table->dropColumn('equipment');
        });
    }
}
