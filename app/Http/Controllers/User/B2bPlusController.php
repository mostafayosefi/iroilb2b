<?php

namespace App\Http\Controllers\User;

use App\Events\Viewer;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PageCollection;
use App\Models\Admin\Form;
use App\Models\Admin\Page;
use Illuminate\Http\Request;

class B2bPlusController extends Controller
{
    // b2b plus page
    public function index()
    {
        $b2b = Page::where('type', 'b2bplus')->get();
        $item = [];
        $i = 0;
        foreach ($b2b as $row) {
            if ($row['id'] > 4) {
                $item[$i]['titleFa'] = $row['title_fa'];
                $item[$i]['titleEn'] = $row['title_en'];
                $item[$i]['slug'] = $row['slug'];
                $i++;
            }
        }
        return response()->json([
            'status' => '200',
            'data' => $item
        ], 200);
    }

    // b2bplus page
    public function about()
    {
        $page = new PageCollection(Page::find(2));
        event(new Viewer('page', 2));
        return response()->json($page, 200);
    }

    // contact page
    public function contact()
    {
        $page = new PageCollection(Page::find(3));
        event(new Viewer('page', 3));
        return response()->json($page, 200);
    }

    // faq page
    public function faq()
    {
        $page = new PageCollection(Page::find(4));
        event(new Viewer('page', 4));
        $data = [];
        $i = 0;
        $question = Form::where('status', 'publish')->get();
        foreach ($question as $item) {
            if ($item['type'] == 'faq') {
                $data[$i] = $item;
                $i++;
            }
        }
        return response()->json([
            'data' => $page,
            'form' => $data], 200);
    }

    // single page
    public function page($page)
    {
        $one = Page::where('slug', $page)->first();
        if ($one == null) {
            return response()->json('null', 200);
        }
        $page = new PageCollection($one);
        if ($page->status == 'draft') {
            return response()->json('null', 200);
        } else {

            event(new Viewer('page', $page->id));
            return response()->json($page, 200);
        }

    }
}
