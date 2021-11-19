<?php

namespace App\Payments\Model\PayPal;

use App\WeddingSchedule\Model\Ceremony\Setting;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

use PayPal\Api\Address;
use PayPal\Api\BillingInfo;
use PayPal\Api\Cost;
use PayPal\Api\Currency;
use PayPal\Api\Invoice;
use PayPal\Api\InvoiceAddress;
use PayPal\Api\InvoiceItem;
use PayPal\Api\MerchantInfo;
use PayPal\Api\PaymentTerm;
use PayPal\Api\Phone;
use PayPal\Api\ShippingInfo;

use Settings;

class Api
{
    const APP_LOGO_PATH                  = 'app/logo';

    const PAYPAL_MODE_PATH               = 'paypal/mode';
    const PAYPAL_MERCHANT_EMAIL_PATH     = 'paypal/merchant_email';
    const PAYPAL_CLIENT_ID_PATH          = 'paypal/client_id';
    const PAYPAL_CLIENT_SECRET_PATH      = 'paypal/client_secret';
    const PAYPAL_FIRST_NAME_PATH         = 'paypal/first_name';
    const PAYPAL_LAST_NAME_PATH          = 'paypal/last_name';
    const PAYPAL_BUSINESS_NAME_PATH      = 'paypal/business_name';
    const PAYPAL_PHONE_COUNTRY_CODE_PATH = 'paypal/phone_country_code';
    const PAYPAL_PHONE_NUMBER_PATH       = 'paypal/phone_number';
    const PAYPAL_ADDRESS_LINE_1_PATH     = 'paypal/address_line_1';
    const PAYPAL_ADDRESS_LINE_2_PATH     = 'paypal/address_line_2';
    const PAYPAL_CITY_PATH               = 'paypal/city';
    const PAYPAL_STATE_PATH              = 'paypal/state';
    const PAYPAL_POSTAL_CODE_PATH        = 'paypal/postal_code';
    const PAYPAL_COUNTRY_CODE_PATH       = 'paypal/country_code';

    const CURRENCY = 'USD';
    const TAX_NAME = 'VAT';
    const ZULU_TIME_OFFSET = ' UTC+08:00';
    const PHONE_COUNTRY_CODE = '+1';

    public static function getApiContext()
    {
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                Settings::getConfigValue(self::PAYPAL_CLIENT_ID_PATH),
                Settings::getConfigValue(self::PAYPAL_CLIENT_SECRET_PATH)
            )
        );
        $apiContext->setConfig(
            array(
                'mode'           => Settings::getConfigValue(self::PAYPAL_MODE_PATH),
                'log.LogEnabled' => false,
                'cache.enabled'  => true,
            )
        );
        return $apiContext;
    }

    public static function getPayPalInvoice($invoice)
    {
        /* Init invoice instance */
        $paypalInvoice = new Invoice();
        
        /* Init merchant info */
        $paypalInvoice->setMerchantInfo(new MerchantInfo())
            ->setBillingInfo(array(new BillingInfo()))
            ->setPaymentTerm(new PaymentTerm())
            ->setShippingInfo(new ShippingInfo());
        
        /* Add Due Date */
        $paypalInvoice->getPaymentTerm()
            ->setDueDate($invoice->due_date->format('Y-m-d') . self::ZULU_TIME_OFFSET);
        
        /* Add merchant info */
        $paypalInvoice->getMerchantInfo()
            ->setEmail(Settings::getConfigValue(self::PAYPAL_MERCHANT_EMAIL_PATH))
            ->setFirstName(Settings::getConfigValue(self::PAYPAL_FIRST_NAME_PATH))
            ->setLastName(Settings::getConfigValue(self::PAYPAL_LAST_NAME_PATH))
            ->setbusinessName(Settings::getConfigValue(self::PAYPAL_BUSINESS_NAME_PATH))
            ->setPhone(new Phone())
            ->setAddress(new Address());

        /* Add merchant info phone */
        $paypalInvoice->getMerchantInfo()->getPhone()
            ->setCountryCode(Settings::getConfigValue(self::PAYPAL_PHONE_COUNTRY_CODE_PATH))
            ->setNationalNumber(Settings::getConfigValue(self::PAYPAL_PHONE_NUMBER_PATH));

        /* Add merchant info address */
        $paypalInvoice->getMerchantInfo()->getAddress()
            ->setLine1(Settings::getConfigValue(self::PAYPAL_ADDRESS_LINE_1_PATH))
            ->setLine2(Settings::getConfigValue(self::PAYPAL_ADDRESS_LINE_2_PATH))
            ->setCity(Settings::getConfigValue(self::PAYPAL_CITY_PATH))
            ->setState(Settings::getConfigValue(self::PAYPAL_STATE_PATH))
            ->setPostalCode(Settings::getConfigValue(self::PAYPAL_POSTAL_CODE_PATH))
            ->setCountryCode(Settings::getConfigValue(self::PAYPAL_COUNTRY_CODE_PATH));

        /* Add customer billing info */
        $phone = new Phone();
        $phone->setCountryCode(self::PHONE_COUNTRY_CODE)
            ->setNationalNumber($invoice->payer->phone);
        $billing = $paypalInvoice->getBillingInfo();
        $billing[0]->setEmail($invoice->payer->email)
            ->setFirstName($invoice->payer->first_name)
            ->setLastName($invoice->payer->last_name)
            ->setPhone($phone);

        /* Add shipping info */
        $paypalInvoice->getShippingInfo()
            ->setEmail($invoice->payer->email)
            ->setFirstName($invoice->payer->first_name)
            ->setLastName($invoice->payer->last_name)
            ->setPhone($phone);

        /* Add Invoice Items */
        $currency = new Currency();
        $currency->setCurrency(self::CURRENCY)->setValue($invoice->amount);
        
        $tax = new \PayPal\Api\Tax();
        $tax->setPercent($invoice->tax_amount / $invoice->amount * 100)->setName(self::TAX_NAME);
        
        $item = new InvoiceItem();
        $item->setName($invoice->item_description)
            ->setQuantity(1)
            ->setUnitPrice($currency)
            ->setTax($tax);
            
        $paypalInvoice->setItems([$item]);

        /* Add logo */
        // $paypalInvoice->setLogoUrl(url(Settings::getConfigValueUrl(self::APP_LOGO_PATH))); // Temporary comment - only https allowed

        return $paypalInvoice;
    }

}