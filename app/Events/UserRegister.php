<?php

namespace App\Events;

use App\Mail\ActivationCode;
use App\Models\Site\ActivationCodes;
use App\Models\User;
use http\Client;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


class UserRegister
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $phoneCode;
    public $emailCode;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $action)
    {
        $this->phoneCode = rand(1000, 9999);
        $this->emailCode = rand(10000, 99999);
        $this->user = $user;
        ActivationCodes::createCode($user, $this->phoneCode, $this->emailCode);
        $countryCode = str_split($user->phone, 2);
        if ($countryCode[0] == 98) {
            $pattern = 'zmxkelp7d9mykrd';
            $lang = 'fa';
        } else {
            $pattern = '7ssvity30b5h2fs';
            $lang = 'en';
        }

        if ($action == 'phone' or $action == 'both') {
            $apikey = 'TT_ME2lIEpHnnWAXprvOcjTVu61EgeicsZHmXYKOLNs=';
            $client = new \IPPanel\Client($apikey);
            $patternValues = [
                "verification-code" => $this->phoneCode,
            ];
            $client->sendPattern(
                $pattern,    // pattern code
                "+983000505",      // originator
                $user->phone,  // recipient
                $patternValues  // pattern values
            );
        }

        if ($action == 'email' or $action == 'both') {
            Mail::to($user->email)->send(new ActivationCode($this->emailCode, $lang));
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
