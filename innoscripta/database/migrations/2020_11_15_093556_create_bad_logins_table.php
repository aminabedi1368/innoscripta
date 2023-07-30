<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateBadLoginsTable
 */
class CreateBadLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bad_logins', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();

            $table->string('login_type')->comment('password|otp');
            $table->string('username')->nullable();
            $table->string('password');

            $table->string('ip', 20);
            $table->string('device_type', 20)->comment('mobile|desktop');
            $table->string('device_os', 20)->comment('windows|linux|ios|android|mac|...');

            $table->unsignedBigInteger('user_identifier_id')->nullable();

            $table->timestamp('created_at');
        });

        Schema::table('bad_logins', function(Blueprint $table) {
            $table->foreign('user_identifier_id')->references('id')->on('user_identifiers');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bad_logins');
    }

}
