<?php
namespace App\Core\Model;

use Illuminate\Database\Eloquent\Model;

class PickupLocation extends Model
{

    protected $table = 'general_pickup_locations';

    protected $fillable = ['title', 'address', 'telephone', 'working_hours', 'sort_order'];

    public function getTelephoneAsNumber()
    {
        return str_replace('+', '', str_replace('-', '', $this->telephone));
    }

}