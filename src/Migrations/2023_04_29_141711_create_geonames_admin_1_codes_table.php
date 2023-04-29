<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
  /**
   * Run the migrations.
   * Source of data: http://download.geonames.org/export/dump/admin1CodesASCII.txt
   * Sample data:
   * US.CO    Colorado    Colorado    5417618
   * @return void
   */
  public function up()
  {
    // In the command that I run to fill this table, I split the concatenated values in column 1 into
    // country_code and admin1_code
    Schema::create('geonames_admin_1_codes', function (Blueprint $table) {
      $table->id('geonameid', FALSE, TRUE);         // 5417618
      $table->char('country_code', 2)->index();      // US
      $table->string('admin1_code', 20)->index();    // CO
      $table->string('name', 255);          // Colorado
      $table->string('asciiname', 255)->index();     // Colorado
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
    Schema::dropIfExists('geonames_admin_1_codes');
  }
};
