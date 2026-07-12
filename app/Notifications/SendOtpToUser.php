<?php

namespace AppNotifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Ghasedak\DataTransferObjects\Request\InputDTO;
use Ghasedak\DataTransferObjects\Request\ReceptorDTO;
use Ghasedaksms\GhasedaksmsLaravel\Message\GhasedaksmsVerifyLookUp;

// class SendOtpToUser extends GhasedaksmsBaseNotification
// {
//     use Queueable;

//     public function __construct(public string $code) {}

//     public function toGhasedaksms($notifiable): GhasedaksmsVerifyLookUp
//     {
//         $message = new GhasedaksmsVerifyLookUp();

//         // تنظیم زمان ارسال
//         $message->setSendDate(Carbon::now());

//         // تنظیم گیرنده (فرض بر این است که مدل کاربر فیلد mobile دارد)
//         $message->setReceptors([new ReceptorDTO($notifiable->mobile, 'client_reference_id')]);

//         // نام قالب OTP
//         $message->setTemplateName('verify');

//         // پارامترهای قالب
//         $message->setInputs([new InputDTO('code', $this->code)]);

//         return $message;
//     }
// }
