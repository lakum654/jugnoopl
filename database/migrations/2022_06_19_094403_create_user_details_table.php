<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->enum('userType', ['shopkeeper','supplier','warehouse'])->nullable();
            $table->string('store_owner');
            $table->string('store_name');
            $table->string('business_email');
            $table->string('gst_no');
            $table->string('phone');
            $table->string('mobile');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->integer('pincode');
            $table->string('logo');
            $table->string('store_cover_photo');
            $table->longText('store_address');
            $table->longText('store_description');
            $table->enum('status', ['1','0'])->default('1')->comment('1:Active, 0:Inactive');
            $table->enum('verified_store', ['1','0'])->default('1')->comment('1:Active, 0:Inactive');
            $table->string('gst_certificate');
            $table->string('u_a_msme_certificate');
            $table->string('shop_licence');
            $table->string('trade_licence');
            $table->string('fssai_registration');
            $table->string('drug_licence');
            $table->string('current_account_cheque');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
    }
};
