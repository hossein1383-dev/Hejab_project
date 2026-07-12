<?php

use Ipe\Sdk\Facades\SmsIr;
use Ghasedak\GhasedaksmsApi;

function imageUrl($image)
{
    return env('ADMIN_PANEL_URL') . env('PRODUCT_IMAGES_PATH') . $image;
}

function salePercent($price, $saleprice)
{
    return round((($price - $saleprice) / $price) * 100);
}

function sendOtp($cellphone, $otp)
{
    // $api = new GhasedaksmsApi(env('GHASEDAKAPI_KEY'));

    // $api->verify(
    //     $cellphone,
    //     1,
    //     "otp",
    //     $otp
    // );
    // $api = new SmsIr(env('GHASEDAKAPI_KEY'));
    $mobile =  '09119488266'; //$cellphone ; // شماره موبایل گیرنده
    $templateId = 100000; // شناسه الگو
    $parameters = [
        [
            'name' => 'Code',
            'value' => $otp,
        ],
    ];

    $response = SmsIr::verifySend($mobile, $templateId, $parameters);
}
