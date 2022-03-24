<?php
namespace App\Payments\Block\Admin\Invoice;

use App\Payments\Model\Source\Status;
use App\Payments\Model\Source\Type;

class Form extends \WFN\Admin\Block\Widget\AbstractForm
{

    const PAYPAL_INVOICE_LINK = 'https://www.paypal.com/invoice/p/#';

    protected $adminRoute = 'admin.payments.invoices';

    protected function _beforeRender()
    {
        $this->addField('general', 'id', 'ID', 'hidden', ['required' => false]);

        if(\Auth::guard('admin')->user()->role->id == config('common.role.superadmin')){
            $this->addField('general', 'status', 'Status', 'select', [
                'readonly' => false,
                'source'   => Status::class,
            ]);

        }else{
            $this->addField('general', 'status', 'Status', 'select', [
                'readonly' => true,
                'source'   => Status::class,
            ]);

        }

        $this->addField('general', 'customer_id', 'Customer', 'select', [
            'required' => true,
            'source'   => \App\Customer\Model\Source\Customers::class,
        ]);
        $this->addField('general', 'payer_id', 'Payer', 'payer_select', [
            'required' => true,
        ]);
        $this->addField('general', 'type', 'Type', 'select', [
            'required' => true,
            'source'   => Type::class,
        ]);

        $this->addField('general', 'invoice_id', '', 'text', ['readonly' => true]);
        $this->addField('general', 'paypal_invoice_id', 'Paypal ', 'text', ['readonly' => true]);

        $this->addField('general', 'due_date', 'Due Date', 'date', ['format'   => config('app.date_format'),'required' => true]);
        $this->addField('general', 'item_description', 'Item Description', 'text', ['required' => true]);
        $this->addField('general', 'amount', 'Amount', 'text', ['required' => true]);
        // $this->addField('general', 'tax_amount', 'Tax Amount', 'text', ['required' => true]);
        $this->buttons[] = [
            'label'    => 'Print',
            'action'       => route('admin.paymets.invoice.view', ['id' => $this->instance->id]),
            'type'     => 'print',
            'class'    => 'success',
            'route'    => 'admin.paymets.invoice.view',
        ];

        if($this->getInstance()->status != Status::PAID && $this->getInstance()->type == Type::OFFLINE) {
            $this->buttons[] = [
                'label'        => 'Mark as Paid',
                'action'       => route('admin.payments.invoices.mark_as_paid', ['id' => $this->instance->id]),
                'class'        => 'info',
                'confirmation' => true,
                'route'        => 'admin.payments.invoices.mark_as_paid'
            ];
        }

        if($this->getInstance()->customer_id) {
            $this->addButton('Back to Customer', route('admin.customer.edit', ['id' => optional($this->instance->customer)->id]), 'admin.customer.edit', 'back');
        }
        $this->buttons[] = [
            'label'    => 'Save & New',
            'type'     => 'save',
            'class'    => 'success',
            'route'    => $this->adminRoute . '.save',
        ];
        if($this->getInstance()->paypal_invoice_id) {
            $this->buttons[] = [
                'label'    => 'View in PayPal',
                'jsaction' => 'window.open(\'' . $this->_getPayPalInvoiceLink() . '\')',
                'class'    => 'info',
                'route'    => 'admin.payments.invoices'
            ];
        }

        return parent::_beforeRender();
    }

    protected function _getPayPalInvoiceLink()
    {
        $invoiceId = $this->getInstance()->paypal_invoice_id;
        $invoiceId = str_replace('INV2-', '', $invoiceId);
        $invoiceId = str_replace('-', '', $invoiceId);
        return self::PAYPAL_INVOICE_LINK . $invoiceId;
    }

}
