<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateOtpTable
 */
class CreateOtpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otp', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('code', 10);

            $table->unsignedBigInteger('user_identifier_id');
            $table->unsignedInteger('user_id');
            $table->timestamp('used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        Schema::table('otp', function(Blueprint $table) {
            $table->foreign('user_identifier_id')->references('id')->on('user_identifiers');
            $table->foreign('user_id')->references('id')->on('users');

            $table->index('code');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('otp');
    }

}
