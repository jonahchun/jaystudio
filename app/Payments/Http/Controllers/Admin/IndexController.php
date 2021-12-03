<?php
namespace App\Payments\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Alert;
class IndexController extends \WFN\Admin\Http\Controllers\Crud\Controller
{
    
    protected function _init(Request $request)
    {
        $this->gridBlock   = new \App\Payments\Block\Admin\Invoice\Grid($request);
        $this->formBlock   = new \App\Payments\Block\Admin\Invoice\Form();
        $this->entity      = new \App\Payments\Model\Invoice();
        $this->entityTitle = 'Invoices';
        $this->adminRoute  = 'admin.payments.invoices';
        return $this;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'customer_id' => 'required|exists:customer,id',
            'type'        => 'required|in:1,2',
            'due_date'    => 'required|date',
            'amount'      => 'required|numeric|min:0',
        ]);
    }

    public function new()
    {
        if($customerId = request('customer_id')) {
            $this->entity->customer_id = $customerId;
        }
        return parent::new();
    }

    public function markAsPaid($id)
    {
        try {
            $invoice = $this->entity->findOrFail($id);
            if($invoice->type == \App\Payments\Model\Source\Type::PAYPAL) {
                throw new \Exception('Illegal operation');
            }
            $invoice->update(['status' => \App\Payments\Model\Source\Status::PAID]);
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please, try again later');
            return redirect()->route($this->adminRoute);
        }
        return redirect()->route($this->adminRoute . '.edit', ['id' => $invoice->id]);

    }

    public function payersListByCustomer(\Customer $customer)
    {
        return [
            'newlyweds' => [$customer->first_newlywed, $customer->second_newlywed],
            'contacts'  => $customer->contacts
        ];
    }

    public function save(Request $request)
    {
        // dd($request->all());
        try {
            if($request->input('id')) {
                $this->entity = $this->entity->findOrFail($request->input('id'));
            }

            $this->validator($request->all())->validate();

            $data = $this->_prepareData($request->all());
            $this->entity->fill($data)->save();

            $this->_afterSave($request);

            Alert::addSuccess($this->entityTitle . ' has been saved');

        } catch (ValidationException $e) {
            foreach($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Alert::addError($message);
                }
            }
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please, try again');
        }

        if($request->btn_state == "Save & New"){
            return redirect()->route($this->adminRoute . '.new',['customer_id'=>$request->customer_id]);

        }else{
            return !$this->entity->id ? redirect()->route($this->adminRoute . '.new') : redirect()->route($this->adminRoute . '.edit', ['id' => $this->entity->id]);

        }
    }
    
}
