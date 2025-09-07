<?php
// database/migrations/2025_08_22_170846__create_transactions_table.php delete create_transactions_table.php fie
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('transactions', function (Blueprint $table) {
    $table->id();
        $table->string('transaction_id')->unique();
    $table->unsignedBigInteger('created_by');
    $table->foreign('created_by')->references('id')->on('users');

    $table->unsignedBigInteger('user_id');
    $table->foreign('user_id')->references('id')->on('users');

    $table->decimal('amount', 10, 2);
    $table->string('trans_type', 10)->comment('debit or credit');
    $table->string('pay_key');
    $table->string('status');
    $table->text('comments')->nullable();

    // Optional relation columns (make nullable if not always required)
    $table->unsignedBigInteger('unit_id')->nullable();
    $table->unsignedBigInteger('task_id')->nullable();
    $table->unsignedBigInteger('idea_id')->nullable();
    $table->unsignedBigInteger('issue_id')->nullable();
    $table->unsignedBigInteger('objective_id')->nullable();

    // Foreign keys
    $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
    $table->foreign('task_id')->references('id')->on('tasks')->onDelete('set null');
    $table->foreign('idea_id')->references('id')->on('ideas')->onDelete('set null');
    $table->foreign('issue_id')->references('id')->on('issues')->onDelete('set null');
    $table->foreign('objective_id')->references('id')->on('objectives')->onDelete('set null');

    $table->timestamps();
    $table->softDeletes();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
