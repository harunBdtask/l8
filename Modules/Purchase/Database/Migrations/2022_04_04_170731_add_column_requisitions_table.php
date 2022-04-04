<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            $table->string('voucher_no')->nullable()->after('id');
            $table->date('date')->nullable()->after('voucher_no');
            $table->integer('type')->nullable()->after('date');
            $table->integer('received')->nullable()->after('type');
            $table->integer('is_approved')->nullable()->after('received');
            $table->integer('approved_by')->nullable()->after('is_approved');
            $table->integer('created_by')->nullable()->after('approved_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            $table->dropColumn('voucher_no','date', 'type', 'received', 'is_approved', 'approved_by', 'created_by');
        });
    }
}
