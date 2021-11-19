<?php
namespace App\WeddingChecklist\Model;

use Illuminate\Database\Eloquent\Model;

class Preparation extends Model
{

    protected $table = 'wedding_checklist_preparations';

    protected $fillable = ['title', 'sort_order', 'has_details'];

}