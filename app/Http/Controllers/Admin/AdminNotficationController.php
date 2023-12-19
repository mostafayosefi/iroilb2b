<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdminNotfication;
use Illuminate\Http\Request;

class AdminNotficationController extends Controller
{
    // get admin all notification
    public function index()
    {
        $notficate = AdminNotfication::orderByDesc('id')->limit(5)->get();
        $rows = AdminNotfication::where('status', 'unread')->get();
        $data = [];
        $i = 0;
        foreach ($notficate as $item) {
            $data[$i]['status'] = $item['status'];
            $data[$i]['text'] = $item['text'];
            $data[$i]['time'] = jdate($item['created_at'])->format('H:i Y/m/d');
            $i++;
        }

        return response()->json([
            'notficate' => $data,
            'count' => $rows->count()
        ], 200);
    }

    // reed notification admin
    public function read(Request $request)
    {

        if ($request->input('data') == 'read-message') {
            AdminNotfication::where('status', 'unread')->update(['status' => 'read']);
        }

        return response()->json([
            'status' => 200,
        ], 200);

    }
}
