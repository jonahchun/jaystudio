<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Customer\Model\Customer;
use Illuminate\Support\Facades\DB;

class FindInvalidWeddingDates extends Command
{
    protected $signature = 'customer:findInvalidDates';
    protected $description = 'Find customers with invalid wedding date format';

    public function handle()
    {
        $this->line("Searching for invalid wedding dates...");

        $invalidFormat = DB::table('customer_details')
            ->select('customer_details.*', 'customer.email')
            ->join('customer', 'customer_details.customer_id', '=', 'customer.id')
            ->whereNotNull('customer_details.wedding_date')
            ->where('customer_details.wedding_date', '!=', '0000-00-00')
            ->whereRaw("customer_details.wedding_date NOT REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$'")
            ->orderBy('customer_details.customer_id')
            ->get();

        $this->info("=== INVALID DATE FORMAT ===");
        if ($invalidFormat->count() > 0) {
            $this->table(
                ['Customer ID', 'Email', 'Wedding Date', 'Issue'],
                $invalidFormat->map(function($row) {
                    return [
                        $row->customer_id,
                        $row->email ?? 'N/A',
                        $row->wedding_date,
                        'Invalid format'
                    ];
                })
            );
        } else {
            $this->line("No invalid format dates found.");
        }

        $invalidYear = DB::table('customer_details')
            ->select('customer_details.*', 'customer.email')
            ->join('customer', 'customer_details.customer_id', '=', 'customer.id')
            ->whereNotNull('customer_details.wedding_date')
            ->where('customer_details.wedding_date', '!=', '0000-00-00')
            ->whereRaw("YEAR(customer_details.wedding_date) < 2000")
            ->whereRaw("customer_details.wedding_date REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$'")
            ->orderBy('customer_details.wedding_date')
            ->get();

        $this->info("\n=== YEARS BEFORE 2000 (possible error) ===");
        if ($invalidYear->count() > 0) {
            $this->table(
                ['Customer ID', 'Email', 'Wedding Date', 'Year', 'Issue'],
                $invalidYear->map(function($row) {
                    $year = date('Y', strtotime($row->wedding_date));
                    return [
                        $row->customer_id,
                        $row->email ?? 'N/A',
                        $row->wedding_date,
                        $year,
                        'Year before 2000'
                    ];
                })
            );
        } else {
            $this->line("No dates with year before 2000 found.");
        }

        $emptyDates = DB::table('customer_details')
            ->select('customer_details.*', 'customer.email')
            ->join('customer', 'customer_details.customer_id', '=', 'customer.id')
            ->where(function($query) {
                $query->whereNull('customer_details.wedding_date')
                    ->orWhere('customer_details.wedding_date', '=', '0000-00-00')
                    ->orWhere('customer_details.wedding_date', '=', '');
            })
            ->orderBy('customer_details.customer_id')
            ->get();

        $this->info("\n=== EMPTY/NULL DATES ===");
        if ($emptyDates->count() > 0) {
            $this->table(
                ['Customer ID', 'Email', 'Wedding Date', 'Issue'],
                $emptyDates->map(function($row) {
                    return [
                        $row->customer_id,
                        $row->email ?? 'N/A',
                        $row->wedding_date ?? 'NULL',
                        'Empty or null'
                    ];
                })
            );
        } else {
            $this->line("No empty/null dates found.");
        }

        $this->info("\n=== SUMMARY ===");
        $this->line("Invalid format: " . $invalidFormat->count());
        $this->line("Year before 2000: " . $invalidYear->count());
        $this->line("Empty/null dates: " . $emptyDates->count());

        $total = $invalidFormat->count() + $invalidYear->count() + $emptyDates->count();
        $this->line("TOTAL issues found: " . $total);

        if ($total > 0) {
            $this->warn("\n=== ACTION REQUIRED ===");
            $this->line("Managers need to fix these records before running cleanup.");
            $this->line("Check each customer and correct the wedding_date field.");
        }

        return 0;
    }
}
