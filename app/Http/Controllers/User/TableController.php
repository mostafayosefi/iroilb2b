<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Site\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TableController extends Controller
{
    // get all tables admin
    public function index()
    {
        $table = Table::select('id', 'title', 'updated_at', 'language')->orderByDesc('id')->get();
        if ($table->count() == 0) {
            return response()->json('null', 200);
        } else {
            $data = [];
            $i = 0;
            foreach ($table as $item) {
                $data[$i]['id'] = $item['id'];
                $data[$i]['title'] = $item['title'];
                $data[$i]['language'] = $item['language'];
                $data[$i]['time'] = jdate($item['updated_at'])->format('H:i Y/m/d');
                $i++;
            }
            return response()->json($data, 200);
        }
    }

    // store admin tables
    public function store(Request $request)
    {
        $table = new Table([
            'title' => $request->get('title'),
            'language' => $request->get('language'),
            'key' => 'tab-' . Str::random(50),
            'header' => json_encode($request->get('header')),
            'data' => json_encode($request->get('data')),
            'detail' => json_encode($request->get('detail'))
        ]);
        $table->save();
        return response()->json('success', 200);
    }

    // delete admin table
    public function delete($id)
    {
        $table = Table::find($id);
        $table->delete();
        return response()->json('successfully deleted', 200);
    }

    // get table admin
    public function get($id)
    {
        $table = Table::find($id);
        if (!$table) {
            return response()->json('null', 200);
        } else {
            return response()->json([
                'id' => $table->id,
                'title' => $table->title,
                'language' => $table->language,
                'key' => $table->key,
                'header' => json_decode($table->header),
                'data' => json_decode($table->data),
                'detail' => json_decode($table->detail),
            ], 200);
        }
    }

    // update table admin
    public function update(Request $request, $id)
    {
        $table = Table::find($id);
        $table->title = $request->get('title');
        $table->language = $request->get('language');
        $table->header = json_encode($request->get('header'));
        $table->data = json_encode($request->get('data'));
        $table->detail = json_encode($request->get('detail'));
        $table->save();
        return response()->json('successfully updated', 200);
    }

    // show user tables
    public function all(Request $request)
    {
        $table = Table::where('language', 'all')->orWhere('language', 'en')->get();
        if ($table->count() == 0) {
            return response()->json('null', 200);
        } else {
            $data = [];
            $i = 0;
            foreach ($table as $item) {
                $data[$i]['id'] = $item['id'];
                $data[$i]['title'] = $item['title'];
                $data[$i]['key'] = $item['key'];
                $data[$i]['header'] = json_decode($item['header']);
                $data[$i]['data'] = json_decode($item['data']);
                $data[$i]['detail'] = json_decode($item['detail']);
                $data[$i]['language'] = $item['language'];
                $data[$i]['time'] = jdate($item['updated_at'])->format('H:i Y/m/d');
                $i++;
            }
            return response()->json($data, 200);
        }
    }
}
