<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Deposit;
use App\Models\Expense;
use Carbon\Carbon;

class DepositExpenseModuleTest extends TestCase
{
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::first();
    }

    public function test_deposit_crud_validation_and_date_handling()
    {
        // 1. Validation fails without required fields
        $response = $this->actingAs($this->admin)->post(route('deposit.store'), []);
        $response->assertSessionHasErrors(['title', 'amount', 'deposit_type', 'payment_type']);

        // 2. Create deposit with custom date
        $testDate = '2026-05-15';
        $response = $this->actingAs($this->admin)->post(route('deposit.store'), [
            'title' => 'Test Deposit Alpha',
            'amount' => 5000,
            'deposit_type' => '1',
            'payment_type' => '2',
            'date' => $testDate,
            'status' => '1',
        ]);
        $response->assertRedirect(route('deposit.index'));

        $deposit = Deposit::where('title', 'Test Deposit Alpha')->first();
        $this->assertNotNull($deposit);
        $this->assertEquals(5000, $deposit->amount);
        $this->assertEquals($testDate, $deposit->date);
        $this->assertEquals(1, $deposit->status);

        // 3. Validation fails on update without required fields
        $response = $this->actingAs($this->admin)->post(route('deposit.update', $deposit->id), [
            'title' => '',
            'amount' => 'not-a-number',
        ]);
        $response->assertSessionHasErrors(['title', 'amount']);

        // 4. Update deposit without overwriting historical date
        $response = $this->actingAs($this->admin)->post(route('deposit.update', $deposit->id), [
            'title' => 'Test Deposit Updated',
            'amount' => 7500,
            'deposit_type' => '2',
            'payment_type' => '1',
            'date' => $testDate,
            // status unchecked -> 0
        ]);
        $response->assertRedirect(route('deposit.index'));

        $deposit->refresh();
        $this->assertEquals('Test Deposit Updated', $deposit->title);
        $this->assertEquals(7500, $deposit->amount);
        $this->assertEquals($testDate, $deposit->date);
        $this->assertEquals(0, $deposit->status);

        // 5. Delete deposit
        $response = $this->actingAs($this->admin)->post(route('deposit.destroy', $deposit->id));
        $response->assertRedirect(route('deposit.index'));
        $this->assertNull(Deposit::find($deposit->id));
    }

    public function test_expense_crud_validation_and_date_handling()
    {
        // 1. Validation fails without required fields
        $response = $this->actingAs($this->admin)->post(route('expense.store'), []);
        $response->assertSessionHasErrors(['title', 'amount', 'expense_type', 'payment_type']);

        // 2. Create expense with custom date
        $testDate = '2026-06-20';
        $response = $this->actingAs($this->admin)->post(route('expense.store'), [
            'title' => 'Test Office Rent',
            'amount' => 12000,
            'expense_type' => '2',
            'payment_type' => '1',
            'date' => $testDate,
            'status' => '1',
        ]);
        $response->assertRedirect(route('expense.index'));

        $expense = Expense::where('title', 'Test Office Rent')->first();
        $this->assertNotNull($expense);
        $this->assertEquals(12000, $expense->amount);
        $this->assertEquals($testDate, $expense->date);
        $this->assertEquals(1, $expense->status);

        // 3. Validation fails on update without required fields
        $response = $this->actingAs($this->admin)->post(route('expense.update', $expense->id), [
            'title' => '',
            'amount' => '',
        ]);
        $response->assertSessionHasErrors(['title', 'amount']);

        // 4. Update expense
        $response = $this->actingAs($this->admin)->post(route('expense.update', $expense->id), [
            'title' => 'Test Office Rent Updated',
            'amount' => 14000,
            'expense_type' => '2',
            'payment_type' => '3',
            'date' => '2026-06-25',
            'status' => '1',
        ]);
        $response->assertRedirect(route('expense.index'));

        $expense->refresh();
        $this->assertEquals('Test Office Rent Updated', $expense->title);
        $this->assertEquals(14000, $expense->amount);
        $this->assertEquals('2026-06-25', $expense->date);

        // 5. Delete expense via POST
        $response = $this->actingAs($this->admin)->post(route('expense.destroy', $expense->id));
        $response->assertRedirect(route('expense.index'));
        $this->assertNull(Expense::find($expense->id));
    }

    public function test_deposit_and_expense_filters_and_dashboard_balance()
    {
        // Create deposits
        $d1 = Deposit::create([
            'title' => 'Courier Test Jan 2035',
            'amount' => 5000,
            'deposit_type' => 1,
            'payment_type' => 1,
            'date' => '2035-01-10',
            'status' => 1,
        ]);
        $d2 = Deposit::create([
            'title' => 'Office Test Jan 2035',
            'amount' => 3000,
            'deposit_type' => 2,
            'payment_type' => 2,
            'date' => '2035-01-15',
            'status' => 1,
        ]);
        $d3 = Deposit::create([
            'title' => 'Others Inactive 2035',
            'amount' => 2000,
            'deposit_type' => 3,
            'payment_type' => 3,
            'date' => '2035-01-20',
            'status' => 0,
        ]);

        // Create expenses
        $e1 = Expense::create([
            'title' => 'Boost Test Jan 2035',
            'amount' => 1500,
            'expense_type' => 1,
            'payment_type' => 2,
            'date' => '2035-01-12',
            'status' => 1,
        ]);
        $e2 = Expense::create([
            'title' => 'Packaging Test Jan 2035',
            'amount' => 1000,
            'expense_type' => 4,
            'payment_type' => 1,
            'date' => '2035-01-18',
            'status' => 1,
        ]);

        // Test Deposit filtering by date and type
        $response = $this->actingAs($this->admin)->get(route('deposit.index', [
            'start_date' => '2035-01-01',
            'end_date' => '2035-01-31',
            'deposit_type' => 1,
        ]));
        $response->assertOk();
        $response->assertViewHas('total_amount', 5000.0);
        $response->assertViewHas('active_amount', 5000.0);
        $response->assertViewHas('total_count', 1);

        // Test Expense filtering by date
        $response = $this->actingAs($this->admin)->get(route('expense.index', [
            'start_date' => '2035-01-01',
            'end_date' => '2035-01-31',
            'expense_type' => 4,
        ]));
        $response->assertOk();
        $response->assertViewHas('total_amount', 1000.0);
        $response->assertViewHas('total_count', 1);

        // Test Dashboard accounting balance calculation
        $response = $this->actingAs($this->admin)->get(route('dashboard', [
            'start_date' => '2035-01-01',
            'end_date' => '2035-01-31',
        ]));
        $response->assertOk();
        // For Jan 2035: Active Deposits = 5000 + 3000 = 8000, Expenses = 1500 + 1000 = 2500, Net Balance = 5500
        $response->assertViewHas('total_payment', 8000.0);
        $response->assertViewHas('total_cost', 2500.0);
        $response->assertViewHas('account_balance', 5500.0);
        $response->assertViewHas('courier_payment', 5000.0);
        $response->assertViewHas('officesale_payment', 3000.0);
        $response->assertViewHas('boost_cost', 1500.0);
        $response->assertViewHas('packaging_cost', 1000.0);

        // Clean up created records
        $d1->delete();
        $d2->delete();
        $d3->delete();
        $e1->delete();
        $e2->delete();
    }
}
