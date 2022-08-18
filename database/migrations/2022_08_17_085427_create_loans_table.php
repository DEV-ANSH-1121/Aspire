<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Loan\Loan;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('loan_amount');
            $table->tinyInteger('loan_term');
            $table->enum('payment_frequency', Loan::getPaymentFreqKeys())->default(Loan::getPaymentFreqIdByValue('Weekly'))->nullable();
            $table->enum('status', Loan::getStatusKeys())->default(Loan::getStatusIdByValue('Active'))->nullable();
            $table->tinyInteger('left_term')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('loans');
    }
};
