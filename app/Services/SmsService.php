<?php

// namespace AppNotifications;

// use CarbonCarbon;
// use Carbon\Carbon;
// use IlluminateBusQueueable;
// use Illuminate\Foundation\Queue\Queueable;
// use GhasedakDataTransferObjectsRequestInputDTO;
// use Ghasedak\DataTransferObjects\Request\InputDTO;
// use GhasedakDataTransferObjectsRequestReceptorDTO;
// use App\Notifications\AppNotificationsSendOtpToUser;
// use Ghasedak\DataTransferObjects\Request\ReceptorDTO;
// use GhasedaksmsGhasedaksmsLaravelMessageGhasedaksmsVerifyLookUp;
// use Ghasedaksms\GhasedaksmsLaravel\Message\GhasedaksmsVerifyLookUp;
// use GhasedaksmsGhasedaksmsLaravelNotificationGhasedaksmsBaseNotification;

// class SendOtpToUser extends GhasedaksmsBaseNotification
// {
//     use Queueable;

//     public function __construct()
//     {
//         //
//     }

//     public function toGhasedaksms($notifiable): GhasedaksmsVerifyLookUp
//     {
//         $message = new GhasedaksmsVerifyLookUp();
//         $message->setSendDate(Carbon::now());
//         $message->setReceptors([new ReceptorDTO($notifiable->mobile, 'client referenceId')]);
//         $message->setTemplateName('newOTP');
//         $message->setInputs([new InputDTO('code', '******')]);
//         return $message;
//     }
// }
// $user = new AppModelsUser();
// $user->mobile = '09032168880';
// $user->notify(new AppNotificationsSendOtpToUser());