<?php

namespace Finance\Routes;

use Finance\Http\Controllers\FinanceCostAllocationController;
use Finance\Http\Controllers\FinanceCostCenterController;
use Finance\Http\Controllers\FinanceExpenseController;
use Finance\Http\Controllers\FinanceFinancialSummaryController;
use Finance\Http\Controllers\FinanceJournalController;
use Finance\Http\Controllers\FinanceJournalEntryController;
use Finance\Http\Controllers\FinanceLedgerController;
use Finance\Http\Controllers\FinanceProfitCalculationController;
use Finance\Http\Controllers\FinanceRevenueController;
use Illuminate\Support\Facades\Route;

final class FinanceRoutes
{
    public static function register(): void
    {
        Route::prefix('finance')->group(function (): void {
            Route::apiResource('cost-centers', FinanceCostCenterController::class);
            Route::post('cost-centers/{cost_center}/restore', [FinanceCostCenterController::class, 'restore']);
            Route::delete('cost-centers/{cost_center}/force', [FinanceCostCenterController::class, 'forceDelete']);

            Route::apiResource('expenses', FinanceExpenseController::class);
            Route::post('expenses/{expense}/restore', [FinanceExpenseController::class, 'restore']);
            Route::delete('expenses/{expense}/force', [FinanceExpenseController::class, 'forceDelete']);

            Route::apiResource('revenues', FinanceRevenueController::class);
            Route::post('revenues/{revenue}/restore', [FinanceRevenueController::class, 'restore']);
            Route::delete('revenues/{revenue}/force', [FinanceRevenueController::class, 'forceDelete']);

            Route::apiResource('journals', FinanceJournalController::class);
            Route::post('journals/{journal}/restore', [FinanceJournalController::class, 'restore']);
            Route::delete('journals/{journal}/force', [FinanceJournalController::class, 'forceDelete']);

            Route::apiResource('ledgers', FinanceLedgerController::class);
            Route::post('ledgers/{ledger}/restore', [FinanceLedgerController::class, 'restore']);
            Route::delete('ledgers/{ledger}/force', [FinanceLedgerController::class, 'forceDelete']);

            Route::apiResource('journal-entries', FinanceJournalEntryController::class);
            Route::post('journal-entries/{journal_entry}/restore', [FinanceJournalEntryController::class, 'restore']);
            Route::delete('journal-entries/{journal_entry}/force', [FinanceJournalEntryController::class, 'forceDelete']);

            Route::apiResource('cost-allocations', FinanceCostAllocationController::class);
            Route::post('cost-allocations/{cost_allocation}/restore', [FinanceCostAllocationController::class, 'restore']);
            Route::delete('cost-allocations/{cost_allocation}/force', [FinanceCostAllocationController::class, 'forceDelete']);

            Route::apiResource('profit-calculations', FinanceProfitCalculationController::class);
            Route::post('profit-calculations/{profit_calculation}/restore', [FinanceProfitCalculationController::class, 'restore']);
            Route::delete('profit-calculations/{profit_calculation}/force', [FinanceProfitCalculationController::class, 'forceDelete']);

            Route::apiResource('financial-summaries', FinanceFinancialSummaryController::class);
            Route::post('financial-summaries/{financial_summary}/restore', [FinanceFinancialSummaryController::class, 'restore']);
            Route::delete('financial-summaries/{financial_summary}/force', [FinanceFinancialSummaryController::class, 'forceDelete']);
        });
    }
}
