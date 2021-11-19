<?php
namespace App\WeddingChecklist\Model;

use Illuminate\Database\Eloquent\Model;

class Reception extends Model
{

    protected $table = 'wedding_checklist_receptions';

    protected $fillable = ['title', 'sort_order', 'has_details'];

}