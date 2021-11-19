<?php
namespace App\WeddingChecklist\Model;

use Illuminate\Database\Eloquent\Model;

class FirstLook extends Model
{

    protected $table = 'wedding_checklist_portrait_sessions_first_looks';

    protected $fillable = ['title', 'sort_order', 'has_details'];

}