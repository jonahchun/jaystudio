<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SendWeddingEmails extends Command
{

    protected $signature = 'customer:send_wedding_emails';

    protected $description = 'Send congradulation and reminder emails';

    public function handle()
    {
        $this->_sendCongradulationEmails();
        $this->_sendWeddingInfoReminders(\Settings::getConfigValue('email/wedding_information_reminder_first'));
        $this->_sendWeddingInfoReminders(\Settings::getConfigValue('email/wedding_information_reminder_second'));
    }

    protected function _sendCongradulationEmails()
    {
        $customers = \Customer::whereHas('detail', function($query) {
            $query->where('wedding_date', Carbon::now()->subDay()->format('Y-m-d'));
        })->get();

        foreach($customers as $customer) {
            \MandrillMail::send('congratulations', $customer->email, [
                'first_newlywed_name'  => $customer->first_newlywed->first_name,
                'second_newlywed_name' => $customer->second_newlywed->first_name,
                'login_link'           => url(route('login')),
            ], \Settings::getConfigValue('email/congratulations_email_recipients'));
        }
    }

    protected function _sendWeddingInfoReminders($daysBefore)
    {
        $customers = \Customer::whereHas('detail', function($query) use ($daysBefore) {
            $query->where('wedding_date', Carbon::now()->subDays($daysBefore)->format('Y-m-d'));
        })->get();

        foreach($customers as $customer) {
            \MandrillMail::send('wedding-info-reminder', $customer->email, [
                'first_newlywed_name'  => $customer->first_newlywed->first_name,
                'second_newlywed_name' => $customer->second_newlywed->first_name,
                'login_link'           => url(route('login')),
                'details_link'         => url(route('customer.details.form')),
                'checklist_link'       => url(route('customer.wedding.checklist')),
                'schedule_link'        => url(route('customer.wedding.schedule')),
            ], \Settings::getConfigValue('email/wedding-info-reminder_email_recipients'));
        }
    }

}
