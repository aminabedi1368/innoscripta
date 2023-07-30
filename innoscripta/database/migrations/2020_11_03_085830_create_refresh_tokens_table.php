<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateRefreshTokensTable
 */
class CreateRefreshTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refresh_tokens', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->string('access_token_id', 100);
            $table->boolean('is_revoked');
            $table->timestamp('created_at');
            $table->timestamp('expires_at')->nullable();
        });

        Schema::table('refresh_tokens', function (Blueprint $table) {
            $table->foreign('access_token_id')->references('id')->on('access_tokens');
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
        Schema::dropIfExists('refresh_tokens');
    }
}
