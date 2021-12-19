<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Customer;

class CreatePurchaseTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class);
            $table->decimal('total_spent', 10, 2);
            $table->decimal('total_saving', 10, 2);
            $table->timestamp('transaction_at');
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
        Schema::dropIfExists('purchase_transactions');
    }
}
