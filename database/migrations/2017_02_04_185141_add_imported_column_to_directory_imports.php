<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImportedColumnToDirectoryImports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('directory_imports', function (Blueprint $table) {
            $table->boolean('imported')->default(false)->after('path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('directory_imports', function (Blueprint $table) {
            $table->dropColumn('imported');
        });
    }
}
