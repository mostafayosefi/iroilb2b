<?php

namespace App\Events;

use App\Mail\PostNotices;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($type, $post = null)
    {
        // send sms adv to user active notifiaction
        $users = User::all();
        if ($type == 'sms') {
            foreach ($users as $user) {
                $notification = json_decode($user['setting']);
                if ($notification->advsms == true) {
                    // active phone user
                    if ($user['phone_verified']==1){
                        $countryCode = str_split($user['phone'], 2);
                        // iran user
                        if ($countryCode[0] == 98) {
                            $apikey = 'TT_ME2lIEpHnnWAXprvOcjTVu61EgeicsZHmXYKOLNs=';
                            $client = new \IPPanel\Client($apikey);
                            $pattern = 'by1f4h0qj5hz435';
                            $client->sendPattern(
                                $pattern,    // pattern code
                                "+983000505",      // originator
                                $user['phone'],  // recipient
                                []  // pattern values
                            );
                        }
                    }
                }
            }
        } elseif ($type == 'email') {
            foreach ($users as $user) {
                $notification = json_decode($user['setting']);
                if ($notification->postemail == true) {
                    // active phone user
                    if ($user['email_verified'] == 1) {
                        $countryCode = str_split($user['phone'], 2);
                        // iran user
                        if ($countryCode[0] == 98) {
                            Mail::to($user['email'])->send(new PostNotices('fa', $post));
                        } else {
                            Mail::to($user['email'])->send(new PostNotices('en', $post));
                        }
                    }
                }
            }
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
