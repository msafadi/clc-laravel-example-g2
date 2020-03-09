<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('username', '24')->after('name')->unique()->nullable();
            $table->enum('type', ['user', 'admin', 'super-admin'])->after('remember_token')->default('user');
            $table->enum('status', ['active', 'inactive', 'blocked'])->after('type')->default('active');
        });

        Schema::table('products', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('user_id')->after('id')->nullable();
            $table->enum('status', ['published', 'draft', 'stock-out'])->after('price')->default('published');

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('username');
            $table->dropColumn('type');
            $table->dropColumn('status');
        });

        Schema::table('products', function (Blueprint $table) {
            //
            $table->dropForeign('products_user_id_foreign');
            $table->dropColumn('user_id');
            $table->dropColumn('status');
        });
    }
}
