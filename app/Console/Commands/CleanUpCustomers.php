<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Customer\Model\Customer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CleanUpCustomers extends Command
{
    protected $signature = 'customer:cleanUpCustomers
                            {--limit=10 : Maximum number of records to delete per run}';

    protected $description = 'Automatic deletion of customers older than 3 years based on wedding date';

    public function handle()
    {
        $limit = (int)$this->option('limit');
        $cutoffDate = Carbon::now()->subYears(3)->format('Y-m-d');

        $this->line("[".now()->format('Y-m-d H:i:s')."] Cleaning up customers older than 3 years (wedding date before {$cutoffDate})");

        $query = Customer::select('customer.*', 'customer_details.wedding_date')
            ->join('customer_details', 'customer.id', '=', 'customer_details.customer_id')
            ->where('customer_details.wedding_date', '<', $cutoffDate)
            ->whereNotNull('customer_details.wedding_date')
            ->where('customer_details.wedding_date', '!=', '0000-00-00')
            ->whereRaw("YEAR(customer_details.wedding_date) >= 2000")
            ->orderBy('customer_details.wedding_date', 'asc')
            ->limit($limit);

        $customers = $query->get();
        $totalFound = $customers->count();

        if ($totalFound === 0) {
            $this->line("No customers found for deletion.");
            return 0;
        }

        $deletedCount = 0;
        $errorCount = 0;

        foreach ($customers as $customer) {
            try {
                DB::beginTransaction();

                $customer->load(['services', 'invoices']);

                $this->line("Deleting customer #{$customer->id} ({$customer->email}), wedding date: " . ($customer->wedding_date ?? 'not set'));

                $customer->delete();

                DB::commit();

                $deletedCount++;

                Log::info('Customer account deleted (older than 3 years)', [
                    'customer_id' => $customer->id,
                    'email' => $customer->email,
                    'wedding_date' => $customer->wedding_date,
                    'deleted_at' => now()->toDateTimeString()
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                $errorCount++;

                $this->error("Error deleting customer #{$customer->id}: " . $e->getMessage());
                Log::error('Error deleting customer account', [
                    'customer_id' => $customer->id,
                    'email' => $customer->email,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $this->line("Deletion completed. Deleted: {$deletedCount}, Errors: {$errorCount}");

        return $errorCount === 0 ? 0 : 1;
    }
}
