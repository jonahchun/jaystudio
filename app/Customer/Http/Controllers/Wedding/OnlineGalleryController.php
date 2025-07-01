<?php

namespace App\Customer\Http\Controllers\Wedding;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;
use App\Services\Model\Source\Status;
use App\Core\Model\OnlineGalleryLink;
use App\Services\Model\Service\OnlineGallery;
use App\Services\Model\Source\Gallery;
use App\Services\Model\Source\EngagementSessionGallery;
use App\Services\Model\Source\Status as ServiceStatus;
use App\Services\Model\Source\Type as ServiceType;

class OnlineGalleryController extends \WFN\Customer\Http\Controllers\Controller
{

    public function link(Request $request)
    {
        $user = Auth::user();
        $name = $user->onlineGalleryLink->name;
        $link = $user->onlineGalleryLink->url;
        return view('customer.online-gallery.link', ['link' => $link, 'name' => $name]);
    }

    public function index($gallery_name)
    {
        // Online Gallery Detail
        $link_count = OnlineGalleryLink::count();

        $online_gallery_link = '';

        if($link_count > 0){
            $gallery_links = OnlineGalleryLink::first();
            $online_gallery_link = $gallery_links->url;
        }

        $online_gallery_data = Auth::user()->online_gallery()->with('services', 'customer.onlineGalleryLink')->get()->toArray();

        $online_gallery = [];
        $online_gallery_engage = [];
        $online_gallery_photo = [];

        foreach ($online_gallery_data as $link_key => $link_value) {
            if($link_value['services']['status'] == ServiceStatus::COMPLETE){
                if($link_value['services']['type'] == ServiceType::PHOTO){
                    $config_file = new Gallery;
                    $data = $link_value;
                    $data['gallery_name'] = $config_file->getOptionLabel($link_value['gallery_name']);
                    $online_gallery_photo[] = $data;
                }
                if($link_value['services']['type'] == ServiceType::ENGAGEMENT_SESSION){
                    $config_file = new EngagementSessionGallery;
                    $data = $link_value;
                    $data['gallery_name'] = $config_file->getOptionLabel($link_value['gallery_name']);
                    $online_gallery_engage[0] = $data;
                }

            }
        }
        if($gallery_name == ServiceType::ENGAGEMENT_SESSION){
            $online_gallery = $online_gallery_engage;
        }
        if($gallery_name == ServiceType::PHOTO){
            $online_gallery = $online_gallery_photo;
        }

        return view('customer.online_gallery',compact('online_gallery','online_gallery_link','gallery_name'));
    }
}
