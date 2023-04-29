<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use MichaelDrennen\Geonames\Models\GeoSetting;

return new class  extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    Schema::create('geonames_settings', function (Blueprint $table) {
      $table->increments('id'); // We should only ever have one record in this table.
      $table->text('countries')->nullable(); // A json encoded array of the countries we want to maintain in our database.
      $table->text('countries_to_be_added')->nullable(); // These are countries that need to be added after the initial install.
      $table->text('languages')->nullable(); // A json encoded array of the languages. This really only has bearing on what version of the feature codes file that we pull down. It's the only file that is language dependent.
      $table->string('connection')->nullable(); // Let the user specify a database connection name for the geonames system. Leave NULL for default.
      $table->dateTime('installed_at')->nullable(); // The date and time when this database was first filled with geonames records.
      $table->dateTime('last_modified_at')->nullable(); // The date and time when the geonames table was last updated with the modifications file.
      $table->string('status')->nullable(); // Is it live? Currently updating? Offline?
      $table->string('storage_subdir')->nullable(); // The name of a directory under storage_dir()
      $table->timestamps(); // Laravel created_at and updated_at timestamp fields.
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(): void
  {
    Schema::dropIfExists('geonames_settings');
  }
};
