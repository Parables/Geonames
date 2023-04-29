<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


return new class extends Migration
{
  /**
   * This small table is filled with static data from geonames.org.
   */
  public function up()
  {
    Schema::create('geonames_feature_classes', function (Blueprint $table) {
      $table->char('id', 1)->primary();
      $table->string('description', 255);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('geonames_feature_classes');
  }
};
