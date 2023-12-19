<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\FilterCollection;
use App\Models\Admin\Filter;
use Illuminate\Http\Request;

class FilterController extends Controller
{

    // store admin filter company
    public function store(Request $request)
    {
        $filter = new Filter([
            'name_fa' => $request->get('filter')['nameFa'],
            'name_en' => $request->get('filter')['nameEn'],
        ]);
        $filter->save();
        return response()->json('success', 200);
    }

    // show user filter company
    public function index()
    {
        $filter = new FilterCollection(Filter::all());
        if ($filter->count() == 0) {
            return response()->json('null', 200);
        } else {
            return $filter;
        }
    }

    // get admin filter company
    public function edit($id)
    {
        $filter = Filter::find($id);
        return response()->json($filter, 200);
    }

    // update admin filter company
    public function update($id, Request $request)
    {
        $filter = Filter::find($id);
        $filter->name_fa = $request->get('filter')['nameFa'];
        $filter->name_en = $request->get('filter')['nameEn'];
        $filter->save();
        return response()->json('successfully updated', 200);
    }

    // delete admin filter company
    public function delete($id)
    {
        $filter = Filter::find($id);
        $filter->delete();
        return response()->json('successfully deleted', 200);
    }
}
