<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Services\Model\Service;
use App\Services\Model\Source\Type as ServiceType;
use App\Services\Model\Source\Status;

class UpdateServiceStatus extends Command
{

    protected $signature = 'services:update_status';

    protected $description = 'Update service status in wedding date';

    public function handle()
    {
        $services = Service::where('status', Status::PENDING)
            ->whereIn('type', [ServiceType::PHOTO, ServiceType::VIDEO])
            ->whereHas('customer', function($query) {
                $query->whereHas('detail', function($query) {
                    $query->where('wedding_date', Carbon::now()->format('Y-m-d'));
                });
            });

        foreach($services->get() as $service) {
            try {
                $service->update(['status' => Status::PROCESSING]);
                $service->addStatusHistoryComment();
            } catch (\Exception $e) {
                // pass
            }
        }
    }

}
