<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class TweetSms
{
    protected $url = 'http://www.tweetsms.ps/api.php?comm=sendsms&user={user}&pass={password}&to={to}&message={message}&sender={from}';
    
    public function send($notifiable, Notification $notification)
    {
        $config = config('services.tweetsms');

        $to = $notifiable->routeNotificationForNexmo();
        $to = str_replace('+972', '0', $to);

        $message = $notification->toTweetSms($notifiable);
        $message = urlencode($message);

        $url = str_replace([
            '{user}', '{password}', '{to}', '{message}', '{from}',
        ], [
            $config['user'], $config['password'], $to, $message, $config['from'],
        ], $this->url);

        //$content = file_get_contents($url);
        $ch = \curl_init($url);
        \curl_setopt($ch, CURLOPT_HEADER, false);
        \curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
		//var_dump($response);
        curl_close($ch);
    }
}