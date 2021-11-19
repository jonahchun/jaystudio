<?php
namespace App\Customer\Http\Controllers\Admin;

use Alert;
use Illuminate\Support\Str;
use App\Customer\Model\Customer\InviteToken;

class CustomerController extends \WFN\Admin\Http\Controllers\Controller
{

    public function sendInviteEmail(\Customer $customer)
    {
        try {
            $inviteToken = InviteToken::where('customer_id', $customer->id)->first();
            if(!$inviteToken) {
                $inviteToken = InviteToken::create([
                    'customer_id' => $customer->id,
                    'token'       => Str::random(60),
                ]);
            }

            \MandrillMail::send('complete-profile', $customer->email, [
                'first_newlywed_name'   => $customer->first_newlywed->first_name,
                'second_newlywed_name'  => $customer->second_newlywed->first_name,
                'complete_profile_link' => url(route('customer.complete.profile', ['token' => $inviteToken->token]))
            ], \Settings::getConfigValue('email/complete-profile_email_recipients'));

            Alert::addSuccess('Invite email has been sent');
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please, try again');
        }

        return redirect()->route('admin.customer.edit', ['id' => $customer->id]);
    }

}