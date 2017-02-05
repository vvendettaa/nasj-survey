<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSurveyIdColumnToQuestionImport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_imports', function (Blueprint $table) {
            $table->integer('survey_id')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('question_imports', function (Blueprint $table) {
            $table->dropColumn('survey_id');
        });
    }
}
