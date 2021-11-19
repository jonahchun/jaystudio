<?php
namespace App\Card\Model;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{

    protected $table = 'card_sizes';

    protected $fillable = ['title', 'card_type', 'sort_order'];

}