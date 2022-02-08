<?php
#Models

use App\Models\Cart;
use App\Models\Client;
use App\Models\Notification;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Service;
use App\Models\Rate;
use App\Models\Settings;
use App\User;
#packages
use Carbon\Carbon;
#vendor files
use Illuminate\Support\Facades\App;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

/*
|----------------------------------------------------|
|----------------------------------------------------|
|                 phone Helper Start                 |
|----------------------------------------------------|
|----------------------------------------------------|
*/

#convert arabic number to english format
function convert_to_english($string)
{
    $newNumbers = range(0, 9);
    $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    $string =  str_replace($arabic, $newNumbers, $string);
    return $string;
}


/*
|----------------------------------------------------|
|----------------------------------------------------|
|                 Image Helper Start                 |
|----------------------------------------------------|
|----------------------------------------------------|
*/

#upload multi-part image
function upload_image($photo, $dir)
{
    #upload image
    // if (!is_dir($dir))
    //     mkdir($dir, 0777);
    $name = date('d-m-y') . time() . rand() . '.' . $photo->getClientOriginalExtension();
    $photo->move($dir . '/', $name);
    return '/' . $dir . '/' . $name;
}

/*
|----------------------------------------------------|
|----------------------------------------------------|
|                   Mail Helper Start                |
|----------------------------------------------------|
|----------------------------------------------------|
*/

function send_mail_php($email, $msg)
{
    // In case any of our lines are larger than 70 characters, we should use wordwrap()
    $message = wordwrap($msg, 70, "\r\n");

    // Send
    mail($email, Settings('site_name'), $message);
}

/*
|----------------------------------------------------|
|----------------------------------------------------|
|                 SMS Helper Start                   |
|----------------------------------------------------|
|----------------------------------------------------|
*/



/*
|----------------------------------------------------|
|----------------------------------------------------|
|                  API Helper Start                  |
|----------------------------------------------------|
|----------------------------------------------------|
*/

#api response format
function Api_response($status, $message, $data = [])
{
    $all_response['status']      = (int) $status; //0,1
    $all_response['message']     = $message;
    $all_response['data']        = $data;
    return response()->json($all_response);
}

#send notify
function send_notify($to_id, $message_ar, $message_en, $order_id = null, $order_status = null)
{
    Notification::create([
        'to_id'        => $to_id,
        'message_ar'   => $message_ar,
        'message_en'   => $message_en,
        'type'         => is_null($order_id) ? 'notify' : 'order',
        'order_id'     => $order_id,
        'order_status' => $order_status,
        'seen'         => 0,
    ]);
}

function show_user($user){
    return [
        'id'                    => (int)    $user->id,
        'name'                  => (string) $user->name,
        'phone'                 => (string) $user->phone,
        'email'                 => (string) $user->email,
        'api_token'             => (string) $user->api_token,
        'avatar'                => (string) url('' . $user->avatar),
        'image'                 => (string) url('' . $user->image),
        'is_active'             => (bool)   $user->active,
        'avalible'              => (bool)   $user->avalible,
        'city_id'               => (string) $user->city_id,
        'city_name'             => is_null($user->city) ? '' : (string)   $user->city->name,
        'neighborhood_id'       => (string)  $user->neighborhood_id,
        'neighborhood_name'     => is_null($user->neighborhood) ? '' : (string)   $user->neighborhood->name,
        'category_id'           => (string)  $user->category_id,
        'category_name'         => is_null($user->category) ? '' : (string)   $user->category->name,
        'Minimum_order'         => (string) $user->Minimum_order,
        'Delivery_Charge'       => (string) $user->Delivery_Charge,
        'contact_information'   => (string) $user->contact_information,
        'whats_app'             => (string) $user->whats_app,
    ];
}

/*
|----------------------------------------------------|
|----------------------------------------------------|
|                  FCM Helper Start                  |
|----------------------------------------------------|
|----------------------------------------------------|
*/

#send FCM
function Send_FCM_Badge_naitve($all_data, $token, $setBadge = 0)
{
    $priority = 'high'; // or 'normal'

    $optionBuilder = new OptionsBuilder();
    $optionBuilder->setTimeToLive(60 * 20);
    $optionBuilder->setPriority($priority);
    $notificationBuilder = new PayloadNotificationBuilder($all_data['title']);
    $notificationBuilder->setBody($all_data['msg'])->setSound('default')->setClickAction('/orders/has_provider');
    //$notificationBuilder->setBody($all_data['message'])->setSound('default')->setBadge($setBadge);

    $option = $optionBuilder->build();
    $notification = $notificationBuilder->build();
    $dataBuilder = new PayloadDataBuilder();
    $dataBuilder->addData($all_data);

    $data = $dataBuilder->build();
    //foreach (Device::where('device_type', 'web')->pluck('device_id')->toArray() as $token) {

    $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

    $downstreamResponse->numberSuccess();
    $downstreamResponse->numberFailure();
    $downstreamResponse->numberModification();

    //dd($downstreamResponse);
}

#send FCM
function send_fcm($device_id, $data, $type, $setBadge = 0)
{
    $priority = 'high'; // or 'normal'
    // $action = 'FLUTTER_NOTIFICATION_CLICK';
    // if ($device->device_type == 'web') $action = '/';
    $optionBuilder = new OptionsBuilder();
    $optionBuilder->setTimeToLive(60 * 20);
    $optionBuilder->setPriority($priority);
    $notificationBuilder = new PayloadNotificationBuilder($data['title']);
    $notificationBuilder->setBody($data['body'])->setSound('default');
    //$notificationBuilder->setBody($data['message'])->setSound('default')->setBadge($setBadge)->setClickAction($action);

    $option = $optionBuilder->build();
    $notification = $notificationBuilder->build();
    $dataBuilder = new PayloadDataBuilder();
    $dataBuilder->addData($data);
    $data = $dataBuilder->build();

    if ($type == 'android') {
        $downstreamResponse = FCM::sendTo($token, $option, null, $data);
    } else {
        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
    }

    $downstreamResponse->numberSuccess();
    $downstreamResponse->numberFailure();
    $downstreamResponse->numberModification();
}



function send_one_signal($notmessage, $tokens, $status = 0)
{
    $content = array(
        "en" => $notmessage
    );
    $token[] = $tokens;
    $fields = array(
        'app_id' => "01c1668a-1bad-4b77-afe9-1b1fa3cea93e",
        'include_player_ids' => $token,
        'data' => array("foo" => "bar", "radarId" => $status),
        "heading" => "headings",

        'contents' => $content,
        "content_available" => true,
    );

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic YjMyZmZmZGMtNDc5NS00MTc3LThiMmQtYzU3OWJmZDlhNTM0'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

#randome active code
function active_code()
{
    $code = '1234'; //for test work
    //$code = rand(1111, 9999); //for real work
    return $code;
}











