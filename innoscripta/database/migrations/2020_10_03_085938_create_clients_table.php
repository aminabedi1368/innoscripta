<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateClientsTable
 */
class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->unsignedSmallInteger('id')->autoIncrement();
            $table->string('name');
            $table->string('slug');
            $table->string('type')->comment('type can be mobile/web/backend/...')->nullable();
            $table->string('client_id');
            $table->string('oauth_client_type')->comment("confidential|public");
            $table->string('client_secret');
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('project_id');
            $table->json('redirect_urls')->comment('comma separated redirect_urls')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('client_id');

            $table->foreign('project_id')->references('id')->on('projects');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }

}
