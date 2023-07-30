<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateAccessTokensTable
 */
class CreateAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_tokens', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->unsignedInteger('user_id')->nullable()->comment('nullable for client tokens');
            $table->unsignedBigInteger('user_identifier_id')->nullable()->comment('nullable for client tokens');
            $table->unsignedSmallInteger('client_id');
            $table->string('ip')->comment('User IP')->nullable();
            $table->string('device_os')->comment('Windows/Android/MacOS/iOS')->nullable();
            $table->string('device_type')->comment('PC/Mobile/tablet')->nullable();
            $table->string('details')->nullable();
            $table->text('scopes')->nullable();
            $table->boolean('is_revoked');
            $table->timestamp('expires_at');
            $table->timestamps();
        });

        Schema::table('access_tokens', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('user_identifier_id')->references('id')->on('user_identifiers');
            $table->foreign('client_id')->references('id')->on('clients');
        });

        Schema::table('access_tokens', function(Blueprint $table) {
            $table->index('is_revoked');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_tokens');
    }

}
