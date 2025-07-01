<?php

namespace App\Observers;

use App\Services\Model\Service;
use App\Services\Model\Source\Status;
use Illuminate\Support\Facades\Log;
use App\Services\Model\Source\Type as ServiceType;

class PhotographyCompleteObserver
{
    public function updated(Service $service)
    {
        if ($service->isDirty(
                'status'
            ) && (int)$service->status === Status::COMPLETE && $service->type == ServiceType::PHOTO) {
            $this->sendPhotographyCompleteEmail($service);
        }
    }

    protected function sendPhotographyCompleteEmail(Service $service)
    {
        try {
            $historyComment = \App\Services\Model\Service\StatusHistory::where('is_customer_notified', 0)
                ->where('service_id', $service->id)->first();
            $comment = $historyComment ? $historyComment->comment : ' ';

            $customer = $service->customer;
            $query = $customer->invoices()->where('status', '!=', \App\Payments\Model\Source\Status::PAID);
            $totalDue = $query->sum('amount') + $query->sum('tax_amount');
            $data = [
                'first_newlywed_name' => $customer->first_newlywed->first_name,
                'second_newlywed_name' => $customer->second_newlywed->first_name,
                'location_name' => optional($service->pickup_location)->title,
                'balance_amount' => '$' . number_format($totalDue, 2),
                'service_detail_link' => url(route('service.view', ['service' => $service])),
                'comment' => $comment,
            ];
            Log::info('Photography Complete Sent Successfully. ' . print_r($data, true));

            \MandrillMail::send(
                'photography-complete',
                $customer->email,
                $data,
                \Settings::getConfigValue('email/photography-complete_email_recipients')
            );
        } catch (\Exception $e) {
            Log::error('Mandrill sending failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
