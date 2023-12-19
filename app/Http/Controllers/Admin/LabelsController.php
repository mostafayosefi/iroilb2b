<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\LabelsCollection;
use App\Models\Admin\Labels;

class LabelsController extends Controller
{
    // get all labels
    public function index()
    {
        $labels = new LabelsCollection(Labels::all());
        if ($labels->count() == 0) {
            return response()->json('null');
        } else {
            return $labels;
        }

    }

    // add admin store lables
    public function store(Request $request)
    {
        $labels = new Labels([
            'lang' => $request->get('lang'),
            'title' => $request->get('title'),
            'slug' => $request->get('slug'),
            'description' => $request->get('text')
        ]);
        $labels->save();
        return response()->json('success', 200);
    }

    // delete admin labels
    public function delete($id)
    {
        $labels = Labels::find($id);
        $labels->delete();
        return response()->json('successfully deleted', 200);
    }

    // get admin label
    public function edit($id)
    {
        $labels = Labels::find($id);
        return response()->json($labels, 200);
    }

    // update admin label
    public function update($id, Request $request)
    {

        $labels = Labels::find($id);
        $labels->title = $request->get('label')['title'];
        $labels->lang = $request->get('label')['lang'];
        $labels->slug = $request->get('label')['link'];
        $labels->description = $request->get('label')['description'];
        $labels->save();
        return response()->json('successfully updated', 200);
    }

}
