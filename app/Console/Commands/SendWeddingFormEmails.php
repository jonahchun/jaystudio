<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SendWeddingFormEmails extends Command
{

    protected $signature = 'customer:send_wedding_form_emails';

    protected $description = 'Send wedding form available emails';

    public function handle()
    {
        $this->_sendWeddingFormAvailableEmail();
    }

    protected function _sendWeddingFormAvailableEmail(){
        $customers = \Customer::whereHas('detail', function($query) {
            $query->where('is_disable_update','No');
            $query->where('wedding_date', Carbon::now()->addMonth(4)->format('Y-m-d'));
        })->get();

        foreach($customers as $customer) {
            \MandrillMail::send('wedding-form-available', $customer->email, [
                'first_newlywed_name'  => $customer->first_newlywed->first_name,
                'second_newlywed_name' => $customer->second_newlywed->first_name,
                'login_link'           => url(route('login')),
                'details_link'         => url(route('customer.details.form')),
                'checklist_link'       => url(route('customer.wedding.checklist')),
                'schedule_link'        => url(route('customer.wedding.schedule')),
            ], \Settings::getConfigValue('email/wedding-form-available_email_recipients'));
        }
    }

}
