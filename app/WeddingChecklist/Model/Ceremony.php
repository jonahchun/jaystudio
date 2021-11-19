<?php
namespace App\WeddingChecklist\Model;

use Illuminate\Database\Eloquent\Model;

class Ceremony extends Model
{

    protected $table = 'wedding_checklist_ceremonies';

    protected $fillable = ['title', 'sort_order', 'has_details'];

}