<?php
namespace App\Payments\Block\Admin\Invoice;

class Grid extends \WFN\Admin\Block\Widget\AbstractGrid
{

    protected $filterableFields = ['customer_id', 'type', 'invoice_id', 'amount', 'tax_amount', 'status'];

    protected $adminRoute = 'admin.payments.invoices';

    public function getInstance()
    {
        return new \App\Payments\Model\Invoice();
    }

    protected function _beforeRender()
    {
        $this->addColumn('invoice_id', 'Invoice ID');
        $this->addColumn('customer_id', 'Customer', 'select', false, \App\Customer\Model\Source\Customers::getInstance());
        $this->addColumn('type', 'Type', 'select', true, \App\Payments\Model\Source\Type::getInstance());
        $this->addColumn('amount', 'Amount');
        $this->addColumn('tax_amount', 'Tax Amount');
        $this->addColumn('due_date', 'Due Date', 'date');
        $this->addColumn('status', 'Status', 'select', true, \App\Payments\Model\Source\Status::getInstance());
        return parent::_beforeRender();
    }

    public function getTitle()
    {
        return 'Invoices';
    }

}
