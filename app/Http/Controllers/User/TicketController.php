<?php

namespace App\Http\Controllers\User;

use App\Events\AdminNotfication;
use App\Events\UserNotification as UserNotificate;
use App\Http\Controllers\Controller;
use App\Models\Site\Ticket;
use App\Models\Site\TicketConversation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    // get user tickets
    public function index($id, Request $request)
    {
        $tickets = Ticket::where('user_id', $id)->first();
        if ($tickets == null) {
            return response()->json('null', 200);
        }
        $tickets = Ticket::orderByDesc('updated_at')->where('user_id', $id)->get();
        $i = 0;
        $data = [];
        foreach ($tickets as $ticket) {
            $data[$i]['subject'] = $ticket['subject'];
            $data[$i]['id'] = $ticket['id'];
            $data[$i]['text'] = $ticket['text'];
            $data[$i]['status'] = $ticket['status'];
            $data[$i]['file'] = $ticket['file'];
            if ($request->get('language') == 'fa') {
                $data[$i]['time'] = jdate($ticket['updated_at'])->format('H:i Y/m/d');
            } else {
                $data[$i]['time'] = $ticket['updated_at']->format('Y/m/d H:i');
            }
            $i++;
        }

        return response()->json($data, 200);
    }

    // user add new ticket
    public function store(Request $request, Filesystem $filesystem)
    {
        $imagePath = '/upload/support/';
        $document = $request->file('file');
        if ($document) {
            $documentName = $document->getClientOriginalName();
            if ($filesystem->exists(public_path("{$imagePath}/{$documentName}"))) {
                $documentName = Carbon::now()->timestamp . "-{$documentName}";
            }
            $document->move(public_path($imagePath), $documentName);
        } else {
            $documentName = null;
        }
        $ticket = new Ticket([
            'user_id' => $request->get('user_id'),
            'status' => 'new',
            'subject' => $request->get('subject'),
            'text' => $request->get('message'),
            'file' => $documentName
        ]);
        $ticket->save();
        event(new AdminNotfication('تیکت جدید ثبت شد'));
        return response()->json('success', 200);
    }

    // get tickets admin
    public function all()
    {
        $tickets = Ticket::all();
        if ($tickets == null) {
            return response()->json('null', 200);
        }
        $i = 0;
        $data = [];
        foreach ($tickets as $ticket) {
            $user = User::find($ticket['user_id']);
            $data[$i]['id'] = $ticket['id'];
            $data[$i]['subject'] = $ticket['subject'];
            $data[$i]['status'] = $ticket['status'];
            $data[$i]['user'] = $user->name;
            $data[$i]['time'] = jdate($ticket['updated_at'])->format('H:i Y/m/d');
            $i++;
        }

        return response()->json($data, 200);
    }

    // get ticket admin
    public function single($id, Request $request)
    {
        $ticket = Ticket::find($id);
        $i = 0;
        $data = [];
        $user = User::find($ticket['user_id']);
        $data['id'] = $ticket['id'];
        $data['subject'] = $ticket['subject'];
        $data['status'] = $ticket['status'];
        $data['user'] = $user->name;
        $data['userId'] = $ticket['user_id'];
        $data['text'] = $ticket['text'];
        $data['file'] = $ticket['file'];
        if ($request->get('language') == 'fa') {
            $data['time'] = jdate($ticket['updated_at'])->format('H:i Y/m/d');
        } else {
            $data['time'] = $ticket['updated_at']->format('Y/m/d H:i');
        }
        $tickets = TicketConversation::where('ticket_id', $id)->get();
        foreach ($tickets as $item) {
            $user = User::find($item['answer_id']);
            $data['dialog'][$i]['id'] = $item['id'];
            $data['dialog'][$i]['text'] = $item['text'];
            $data['dialog'][$i]['file'] = $item['file'];
            $data['dialog'][$i]['user'] = $user->name;
            if ($request->get('language') == 'fa') {
                $data['dialog'][$i]['time'] = jdate($item['updated_at'])->format('H:i Y/m/d');
            } else {
                $data['dialog'][$i]['time'] = $item['updated_at']->format('Y/m/d H:i');
            }
            $i++;
        }
        return response()->json($data, 200);
    }

    // add answer user
    public function update(Request $request, Filesystem $filesystem)
    {
        $imagePath = '/upload/support/';
        $document = $request->file('file');
        if ($document) {
            $documentName = $document->getClientOriginalName();
            if ($filesystem->exists(public_path("{$imagePath}/{$documentName}"))) {
                $documentName = Carbon::now()->timestamp . "-{$documentName}";
            }
            $document->move(public_path($imagePath), $documentName);
        } else {
            $documentName = null;
        }

        $ticket = Ticket::find($request->get('ticket'));
        $ticket->status = $request->get('status');
        $ticket->save();
        $new = new TicketConversation([
            'ticket_id' => $request->get('ticket'),
            'answer_id' => $request->get('userid'),
            'text' => $request->get('text'),
            'file' => $documentName
        ]);
        $new->save();
        if ($request->get('type') == 'admin') {
            $reciver = User::find($ticket->user_id);
            event(new UserNotificate($reciver, 'ticket', $ticket->user_id));
        } else {
            event(new AdminNotfication('تیکت جدید ثبت شد'));
        }

        return response()->json('success', 200);
    }
}
