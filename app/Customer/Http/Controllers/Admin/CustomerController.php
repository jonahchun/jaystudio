<?php
namespace App\Customer\Http\Controllers\Admin;

use Alert,Storage;
use Illuminate\Support\Str;
use App\Customer\Model\Customer\InviteToken;
use App\Customer\Model\Wedding\Schedule\Reception;

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
    public function downloadFile($index,$id){
        $wedding_reception = Reception::find($id);
        // dd($wedding_reception);
        $all_files = explode('|',$wedding_reception->timeline_file);
        $file = $all_files[$index];
        
        $files = explode('/',$file); 
        $file_name = array_pop($files);
        if($files[0] == 'tmp'){
            $file_url = storage_path().'/app/public/'.$file;
        }else{
            $file_url = storage_path().'/app/public/customer-wedding-reception/'.$file;

        }
        return \Response::download($file_url);

    }
}