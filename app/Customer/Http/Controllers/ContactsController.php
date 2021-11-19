<?php

namespace App\Customer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Customer\Model\Contact;
use Alert;

class ContactsController extends \WFN\Customer\Http\Controllers\Controller
{

    public function index(Request $request)
    {
        $contacts = Auth::user()->contacts()->orderBy('created_at', 'desc')->paginate(\Settings::getConfigValue('contacts/per_page') ?: 7);
        return $request->ajax() ? $contacts : view('customer.contacts', compact('contacts'));
    }

    public function save(Request $request)
    {
        try {
            $data = $request->all();
            $contact = $request->input('id') ? Contact::findOrFail($request->input('id')) : new Contact();
            
            $this->validator($data)->validate();

            $data['customer_id'] = Auth::user()->id;
            $contact->fill($data)->save();

            Alert::addSuccess('Your contact has been saved');
        } catch (ValidationException $e) {
            foreach($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Alert::addError($message);
                }
            }
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please try again later');
            Alert::addError($e->getMessage());
        }
        return redirect()->route('customer.contacts');
    }

    public function delete($id)
    {
        try {
            $contact = Auth::user()->contacts()->where('id', $id)->first();
            if(!$contact) {
                throw new \Exception();
            }
            
            $contact->delete();
            
            Alert::addSuccess('Your contact has been deleted');
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please try again later');
        }
        return redirect()->route('customer.contacts');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'role_id'     => 'required|exists:customer_contact_roles,id',
            'email'       => 'required|string|email|max:255',
            'telephone'   => 'required|string|max:255',
        ]);
    }

}