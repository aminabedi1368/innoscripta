<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateProjectsTable
 */
class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->unsignedSmallInteger('id')->autoIncrement();
            $table->string('name');
            $table->string('slug');
            $table->string('project_id');
            $table->text('description')->nullable();
            $table->unsignedInteger('creator_user_id');
            $table->boolean('is_first_party')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::table('projects', function(Blueprint $table) {
            $table->index('project_id');
            $table->index('name');
            $table->index('slug');
            $table->foreign('creator_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
