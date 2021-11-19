<?php
namespace App\WeddingChecklist\Model;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{

    protected $table = 'wedding_checklist_vendors';

    protected $fillable = ['title', 'sort_order', 'is_required'];

}