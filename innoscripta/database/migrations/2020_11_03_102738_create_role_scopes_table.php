<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateRoleScopesTable
 */
class CreateRoleScopesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_scopes', function (Blueprint $table) {
            $table->unsignedSmallInteger('scope_id');
            $table->unsignedSmallInteger('role_id');

            $table->primary(['scope_id', 'role_id']);
        });

        Schema::table('role_scopes', function(Blueprint $table) {
            $table->foreign('scope_id')->references('id')->on('scopes');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_scopes');
    }
}
