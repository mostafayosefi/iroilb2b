<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Advertise;
use App\Models\Admin\Category;
use App\Models\Admin\Labels;
use App\Models\Admin\Page;
use App\Models\Admin\Post;
use App\Models\Site\Company;

class SitemapController extends Controller
{
    // persian site map
    public function persian()
    {
        $data = [
            'companies' => company::orderByDesc('updated_at')->first(),
            'ads' => Advertise::orderByDesc('updated_at')->first(),
            'pages' => page::orderByDesc('updated_at')->first(),
            'articles' => post::orderByDesc('updated_at')->first(),
            'categories' => category::orderByDesc('updated_at')->first(),
            'tags' => labels::orderByDesc('updated_at')->first(),

        ];
        return response()->view('sitemap.fa', $data)->header('Content-Type', 'text/xml');
    }

    // english sitemap
    public function english()
    {
        $data = [
            'companies' => company::orderByDesc('updated_at')->first(),
            'ads' => Advertise::orderByDesc('updated_at')->first(),
            'pages' => page::orderByDesc('updated_at')->first(),
            'articles' => post::orderByDesc('updated_at')->first(),
            'categories' => category::orderByDesc('updated_at')->first(),
            'tags' => labels::orderByDesc('updated_at')->first(),

        ];
        return response()->view('sitemap.en', $data)->header('Content-Type', 'text/xml');
    }

    // insert company
    public function companies()
    {
        $companies = Company::all();
        $list = [];
        $i = 0;
        foreach ($companies as $item) {
            if ($item['status'] == 'active' or $item['status'] == 'timeout') {
                $list['companies'][$i]['slug'] = $item['slug'];
                $list['companies'][$i]['time'] = $item['updated_at'];
                $i++;
            }
        }
        return response()->view('sitemap.companies-fa', $list)->header('Content-Type', 'text/xml');
    }

    // insert persian ads
    public function adsFa()
    {
        $ads = advertise::where('language', 'fa')->get();
        $list = [];
        $i = 0;
        foreach ($ads as $item) {
            if ($item['status'] == 'active' or $item['status'] == 'timeout') {
                $list['ads'][$i]['slug'] = $item['slug'];
                $list['ads'][$i]['time'] = $item['updated_at'];
                $i++;
            }
        }
        return response()->view('sitemap.ads-fa', $list)->header('Content-Type', 'text/xml');
    }

    // insert english ads
    public function adsEn()
    {
        $ads = advertise::where('language', 'en')->get();
        $list = [];
        $i = 0;
        foreach ($ads as $item) {
            if ($item['status'] == 'active' or $item['status'] == 'timeout') {
                $list['ads'][$i]['slug'] = $item['slug'];
                $list['ads'][$i]['time'] = $item['updated_at'];
                $i++;
            }
        }
        return response()->view('sitemap.ads-en', $list)->header('Content-Type', 'text/xml');
    }

    // insert persian page
    public function pagesFa()
    {
        $pages = Page::where('status', 'publish')->get();
        $list = [];
        $i = 0;
        foreach ($pages as $item) {
            if ($item['slug'] == 'home')
                continue;
            $list['pages'][$i]['slug'] = $item['type'] . "/" . $item['slug'];
            $list['pages'][$i]['time'] = $item['updated_at'];
            $i++;

        }
        return response()->view('sitemap.pages-fa', $list)->header('Content-Type', 'text/xml');
    }

    // insert english page
    public function pagesEn()
    {
        $pages = Page::where('status', 'publish')->get();
        $list = [];
        $i = 0;
        foreach ($pages as $item) {
            if ($item['slug'] == 'home')
                continue;
            $list['pages'][$i]['slug'] = $item['type'] . "/" . $item['slug'];
            $list['pages'][$i]['time'] = $item['updated_at'];
            $i++;

        }
        return response()->view('sitemap.pages-en', $list)->header('Content-Type', 'text/xml');
    }

    // insert persian post
    public function postFa()
    {
        $postes = Post::where('language', 'fa')->get();
        $list = [];
        $i = 0;
        foreach ($postes as $item) {
            if ($item['status'] == 'publish') {
                $list['postes'][$i]['slug'] = $item['slug'];
                $list['postes'][$i]['time'] = $item['updated_at'];
                $i++;
            }
        }
        return response()->view('sitemap.postes-fa', $list)->header('Content-Type', 'text/xml');
    }

    // insert english post
    public function postEn()
    {
        $postes = Post::where('language', 'en')->first();
        $list = [];
        $i = 0;
        if ($postes) {
            $postes = Post::where('language', 'en')->get();
            foreach ($postes as $item) {
                if ($item['status'] == 'publish') {
                    $list['postes'][$i]['slug'] = $item['slug'];
                    $list['postes'][$i]['time'] = $item['updated_at'];
                    $i++;
                }
            }
        } else {
            $list['postes'] = '';
        }
        return response()->view('sitemap.postes-en', $list)->header('Content-Type', 'text/xml');
    }

    // insert persian categories
    public function catFa()
    {
        $categories = Category::all();
        $list = [];
        $i = 0;
        foreach ($categories as $item) {
            $list['categories'][$i]['slug'] = $item['slug'];
            $list['categories'][$i]['time'] = $item['updated_at'];
            $i++;
        }
        return response()->view('sitemap.categories-fa', $list)->header('Content-Type', 'text/xml');
    }

    // insert english categories
    public function catEn()
    {
        $categories = Category::all();
        $list = [];
        $i = 0;
        foreach ($categories as $item) {
            $list['categories'][$i]['slug'] = $item['slug'];
            $list['categories'][$i]['time'] = $item['updated_at'];
            $i++;
        }
        return response()->view('sitemap.categories-en', $list)->header('Content-Type', 'text/xml');
    }

    // insert persian tags
    public function tagFa()
    {
        $tags = Labels::where('lang', 'fa')->get();
        $list = [];
        $i = 0;
        foreach ($tags as $item) {
            $list['tags'][$i]['slug'] = $item['slug'];
            $list['tags'][$i]['time'] = $item['updated_at'];
            $i++;
        }
        return response()->view('sitemap.tags-fa', $list)->header('Content-Type', 'text/xml');
    }

    // insert english tags
    public function tagEn()
    {
        $tags = Labels::where('lang', 'en')->first();
        $list = [];
        $i = 0;

        if ($tags) {
            $tags = Labels::where('lang', 'en')->get();
            foreach ($tags as $item) {
                $list['tags'][$i]['slug'] = $item['slug'];
                $list['tags'][$i]['time'] = $item['updated_at'];
                $i++;
            }
        } else {
            $list['tags'] = '';
        }

        return response()->view('sitemap.tags-en', $list)->header('Content-Type', 'text/xml');
    }
}
