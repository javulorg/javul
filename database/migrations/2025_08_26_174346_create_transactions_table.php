<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            
            $table->string('transaction_id'); // varchar(255)
            
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by', 'fk_transactions_created_by')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'fk_transactions_user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            
            $table->integer('unit_id')->nullable();
            $table->integer('task_id')->nullable();
            $table->integer('idea_id')->nullable();
            $table->integer('issue_id')->nullable();
            $table->integer('objective_id')->nullable();

            $table->decimal('amount', 10, 2);

            $table->string('trans_type', 10)->comment('debit or credit');
            $table->string('pay_key');
            $table->string('status');
            $table->text('comments')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('fk_transactions_created_by');
            $table->dropForeign('fk_transactions_user_id');
        });
        Schema::dropIfExists('transactions');
    }
};
