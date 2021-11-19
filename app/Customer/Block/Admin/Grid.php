<?php

namespace App\Customer\Block\Admin;

class Grid extends \WFN\Customer\Block\Admin\Grid
{

    protected $filterableFields = ['email', 'newlywed_names', 'account_id'];
    
    protected function _beforeRender()
    {
        $this->addColumn('id', 'ID', 'text', true);
        $this->addColumn('email', 'Email');
        $this->addColumn('newlywed_names', 'Names');
        $this->addColumn('account_id', 'Account ID');
        $this->addColumn('wedding_date', 'Wedding Date', 'date', false, false, [
            'format' => 'm/d/Y'
        ]);

        return \WFN\Admin\Block\Widget\AbstractGrid::_beforeRender();
    }

    protected function _getCollection()
    {
        $query = $this->getInstance()->newQuery();

        if(isset($this->request['email'])) {
            $query->where('email', 'like', '%' . $this->request['email'] . '%');
        }
        
        if(isset($this->request['account_id'])) {
            $value = $this->request['account_id'];
            $query->whereHas('detail', function($query) use ($value) {
                $query->where('account_id', 'like', '%' . $value . '%');
            });
        }

        if(isset($this->request['newlywed_names'])) {
            $names = explode(' ', $this->request['newlywed_names']);
            $firstPart = array_shift($names);
            $query->whereHas('first_newlywed', function($_query) use ($firstPart, $names) {
                $_query->where('first_name', 'like', '%' . $firstPart . '%')
                    ->orWhere('last_name', 'like', '%' . $firstPart . '%');
                foreach($names as $part) {
                    $_query->orWhere('first_name', 'like', '%' . $part . '%')
                        ->orWhere('last_name', 'like', '%' . $part . '%');
                }
            })->orWhereHas('second_newlywed', function($_query) use ($firstPart, $names) {
                $_query->where('first_name', 'like', '%' . $firstPart . '%')
                    ->orWhere('last_name', 'like', '%' . $firstPart . '%');
                foreach($names as $part) {
                    $_query->orWhere('first_name', 'like', '%' . $part . '%')
                        ->orWhere('last_name', 'like', '%' . $part . '%');
                }
            });
        }

        $query->orderBy($this->getOrderBy(), $this->getDirection());
        return $query;
    }

}