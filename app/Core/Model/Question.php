<?php
namespace App\Core\Model;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    protected $table = 'general_questions';

    protected $fillable = ['question', 'form_step', 'sort_order'];

}