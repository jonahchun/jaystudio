<?php

namespace App\Customer\Http\Controllers;

use WFN\Customer\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Http\Request;
use App\Customer\Model\Customer\InviteToken;

class CustomerController extends ResetPasswordController
{

    public function completeProfile($token)
    {
        $inviteToken = InviteToken::where('token', $token)->first();
        if(!$inviteToken) {
            return abort(404);
        }

        $customer = $inviteToken->customer;
        return view('customer.auth.complete', compact('customer', 'token'));
    }

    public function completeProfileSave(Request $request)
    {
        $inviteToken = InviteToken::where('token', $request->input('token'))->first();
        if(!$inviteToken) {
            return abort(404);
        }

        $request->validate($this->rules());
        $this->resetPassword($inviteToken->customer, $request->input('password'));
        $inviteToken->delete();

        $customer = $inviteToken->customer;
        \MandrillMail::send('profile-completed', $customer->email, [
            'first_newlywed_name'  => $customer->first_newlywed->first_name,
            'second_newlywed_name' => $customer->second_newlywed->first_name,
            'details_link'         => url(route('customer.wedding.info')),
            'schedule_link'        => url(route('customer.wedding.schedule')),
            'checklist_link'       => url(route('customer.wedding.checklist')),
            'login_link'           => url(route('login')),
        ], \Settings::getConfigValue('email/profile-completed_email_recipients'));

        return redirect()->route('customer.account');
    }

    protected function rules()
    {
        return [
            'token'    => 'required',
            'password' => 'required|confirmed|min:8',
        ];
    }

}