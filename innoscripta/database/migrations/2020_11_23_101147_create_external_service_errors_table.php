<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateExternalServiceErrorsTable
 */
class CreateExternalServiceErrorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_service_errors', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();

            $table->string('action');
            $table->string('service_name');
            $table->text('exception_class');
            $table->text('error_message');

            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_service_errors');
    }
}
