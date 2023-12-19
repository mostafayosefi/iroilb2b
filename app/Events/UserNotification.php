<?php

namespace App\Events;

use App\Models\User;
use App\Mail\UserNotification as UserEmail;
use App\Models\Site\UserNotification as UserModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class UserNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $action, $senderId)
    {
        $countryCode = str_split($user->phone, 2);
        $lang = 'fa';
        if ($countryCode[0] == 98) {
            if ($action == 'company') {
                $pattern = '8gewkayxe3vnmbr';
                $message = 'شرکت شما تایید شد.';
            }

            if ($action == 'password') {
                $pattern = '8gewkayxe3vnmbr';
                $message = 'رمز عبور شما تغییر کرد.';
            }

            if ($action == 'message') {
                $pattern = 'tmz00kg7kx0ot45';
                $message = 'پیام جدید دارید. لطفا به پنل کاربری مراجعه نمایید.';
            }

            if ($action == 'ticket') {
                $pattern = 'ktv4dat1wrx54zw';
                $message = 'تیکت شما پاسخ داده شد.';
            }

            if ($action == 'send') {
                $pattern = 'tmz00kg7kx0ot45';
            }
        } else {
            if ($action == 'company') {
                $pattern = 'zmxkelp7d9mykrd';
                $message = 'Your company has been verified.';
            }

            if ($action == 'password') {
                $pattern = 'zmxkelp7d9mykrd';
                $message = 'Your password has been changed.';
            }

            if ($action == 'message') {
                $pattern = 'zmxkelp7d9mykrd';
                $message = 'You have a new message. Please refer to the user panel.';
            }

            if ($action == 'ticket') {
                $pattern = 'zmxkelp7d9mykrd';
                $message = 'Your ticket has been answered.';
            }
            if ($action == 'send') {
                $pattern = 'tmz00kg7kx0ot45';
            }

            $lang = 'en';
        }

        if ($user->phone) {
            $apikey = 'TT_ME2lIEpHnnWAXprvOcjTVu61EgeicsZHmXYKOLNs=';
            $client = new \IPPanel\Client($apikey);
            $client->sendPattern(
                $pattern,    // pattern code
                "+983000505",      // originator
                $user->phone,  // recipient
                []  // pattern values
            );
        }

        if ($user->email) {
            Mail::to($user->email)->send(new UserEmail($action, $lang));
        }

        if ($action!='send'){
            $notification = new UserModel([
                'user_id_receiver' => $user->id,
                'user_id_sender' => $senderId,
                'status' => 'unread',
                'message' => $message
            ]);
            $notification->save();
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
