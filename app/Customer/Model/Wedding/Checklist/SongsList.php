<?php

namespace App\Customer\Model\Wedding\Checklist;

use Illuminate\Database\Eloquent\Model;

class SongsList extends Model
{

    protected $table = 'wedding_checklist_music_song';

    protected $fillable = ['checklist_id', 'song_name', 'type'];

    protected $_song_data = [];

    protected $_checklist_id = [];


    public function fill(array $attributes)
    {
        foreach($attributes as $key => $value) {
            if($key == 'checklist_id'){
                $this->_checklist_id = $value;
                $this->_song_data['checklist_id'] = $this->_checklist_id;
            }
        }
        return parent::fill($attributes);
    }

    public function toArray()
    {
        $data = parent::toArray();
        return $data;
    }

    public function save(array $options = [])
    {
        $this->checklist_id = $this->_checklist_id;
        parent::save();
    }


}