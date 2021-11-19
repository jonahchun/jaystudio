<?php

namespace App\Payments\Helper;

use Illuminate\Support\Facades\DB;
use App\Payments\Model\Source\Status;

class Data
{

    public static function getRecentInvoices()
    {
        return \App\Payments\Model\Invoice::whereIn('status', [Status::DUE, Status::OVERDUE])
            ->orderBy('status', 'desc')
            ->orderBy('created_at', 'asc')
            ->limit(10)
            ->get();
    }
    
    public static function getUnpaidTotalAmount()
    {
        return number_format(self::getTotalDueAmount() + self::getTotalOverdueAmount(), 2);
    }

    public static function getPaidTotalAmount()
    {
        return number_format(self::getTotalPaidAmount(), 2);
    }
    
    public static function getTotalDueAmount()
    {
        $query = self::_getTotalAmountQuery();
        $query->where('status', Status::DUE);
        return optional($query->first())->total;
    }

    public static function getTotalOverdueAmount()
    {
        $query = self::_getTotalAmountQuery();
        $query->where('status', Status::OVERDUE);
        return optional($query->first())->total;
    }

    public static function getTotalPaidAmount()
    {
        $query = self::_getTotalAmountQuery();
        $query->where('status', Status::PAID);
        return optional($query->first())->total;
    }

    protected static function _getTotalAmountQuery()
    {
        return DB::table('invoices')
            ->select(DB::raw('sum(amount) + sum(tax_amount) AS total'));
    }

}