<?php

namespace App\Events;

use App\Models\Admin\Page;
use App\Models\Admin\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Viewer
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($type,$id)
    {
        if ($type=='post'){
            $post = Post::find($id);
            $post->timestamps = false;
            $post->views_count += 1;
            $post->save();
        }
        if ($type=='page'){
            $page = Page::find($id);
            $page->timestamps = false;
            $page->views_count += 1;
            $page->save();
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
