<?php

namespace App\Console\Commands;

use App\Services\Model\Service\Image;
use Illuminate\Console\Command;
use App\Services\Model\Source\Status;
use App\Services\Model\Source\Type;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class CleanUpTeaserPhotos extends Command
{

    protected $signature = 'customer:cleanUpTeaserPhotos';

    protected $description = 'Clean Up Teaser Photos';

    public function handle()
    {
        $photos = Image::select('service_teaser_photos.*')
            ->join('customer', 'customer.id', '=', 'service_teaser_photos.customer_id')
            ->join('services', 'services.customer_id', '=', 'service_teaser_photos.customer_id')
            ->join('customer_details', 'customer_details.customer_id', '=', 'service_teaser_photos.customer_id')
            ->where('customer_details.wedding_date', '<', Carbon::now()->subYears(1)->format('Y-m-d'))
            ->where('services.type', Type::PHOTO)
            ->whereIn('services.status', [Status::PROCESSING, Status::COMPLETE])
//            ->where('customer.id', 73)
            ->limit(500)
            ->get();

        foreach ($photos as $photo) {
            $path = 'public' . DIRECTORY_SEPARATOR . Image::MEDIA_PATH . $photo->image;

            if (Storage::exists($path)) {
                Storage::delete($path);
                $photo->delete();
            }
        }

        echo PHP_EOL . "Done." . PHP_EOL;
    }

}
