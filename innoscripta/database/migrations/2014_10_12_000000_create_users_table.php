<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateUsersTable
 */
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->boolean('is_super_admin')->default(false);
            $table->string('avatar')->nullable();
            $table->json('app_fields')->nullable();
            $table->string('status')->comment('active|locked @see \App\Constants\UserStatus.php');

            $table->string('password');

            $table->string('year_month')->comment('user creation date Jalali year_month');
            $table->string('year_month_day')->comment('user creation date Jalali year_month_day');
            $table->string('year_week')->comment('user creation date Jalali year_week');

            $table->index('year_month');
            $table->index('year_month_day');
            $table->index('year_week');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }

}
