<?php
namespace App\Core\Block\Admin\Question;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = ['question', 'form_step', 'sort_order'];

    protected $adminRoute = 'admin.questions';

    public function getInstance()
    {
        return new \App\Core\Model\Question();
    }

    protected function _beforeRender()
    {
        $this->addColumn('question', 'Question');
        $this->addColumn('form_step', 'Form Step', 'select', true, new \App\Core\Model\Source\FormStep());
        $this->addColumn('sort_order', 'Sort Order');
        return parent::_beforeRender();
    }

    public function getTitle()
    {
        return 'Details About You - Questions';
    }

}