<?php

namespace App\Http\Controllers\User;

use App\Events\AdminNotfication;
use App\Http\Controllers\Controller;
use App\Models\Admin\Form;
use App\Models\Site\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class FormController extends Controller
{
    // store user faq
    public function faq(Request $request)
    {
        App::setLocale($request->input('lang'));
        $form = new Form([
            'type' => 'faq',
            'status' => 'draft',
            'language' => $request->input('lang'),
            'body' => json_encode($request->input('body'))
        ]);
        $form->save();
        event(new AdminNotfication('سوال متداول جدید ثبت شد'));
        return response()->json([
            'status' => 200
        ], 200);

    }

    // store user contact
    public function contact(Request $request)
    {
        App::setLocale($request->input('lang'));
        $form = new Form([
            'type' => 'contact',
            'status' => 'draft',
            'language' => $request->input('lang'),
            'body' => json_encode($request->input('body'))
        ]);
        $form->save();
        event(new AdminNotfication('درخواست تماس با ما جدید'));
        return response()->json([
            'status' => 200
        ], 200);

    }

    // store user feedback
    public function feedback(Request $request)
    {
        $form = new Form([
            'type' => 'feedback',
            'status' => 'draft',
            'language' => $request->input('lang'),
            'body' => json_encode($request->input('body'))
        ]);
        $form->save();
        if ($request->get('step') == 'three') {
            $user = User::find(intval($request->get('id')));
            $user->step = 'four';
            $user->save();
        }
        event(new AdminNotfication("بازخورد جدید ثبت شد."));
        return response()->json([
            'status' => 200
        ], 200);

    }

    // get admin forms
    public function index()
    {
        $forms = Form::orderByDesc('id')->get();
        if ($forms->count() == 0) {
            return response()->json('null', 200);
        } else {
            $data = [];
            $i = 0;
            foreach ($forms as $form) {
                if ($form['type'] == 'contact') {
                    $title = 'تماس با ما';
                } elseif ($form['type'] == 'feedback') {
                    $title = 'سخن مشتریان';
                } else {
                    $title = 'سوالات متداول';
                }
                $data[$i]['type'] = $title;
                $data[$i]['id'] = $form['id'];
                $data[$i]['language'] = $form['language'];
                $data[$i]['status'] = $form['status'];
                $data[$i]['time'] = jdate($form['created_at'])->format('H:i Y/m/d');
                $i++;
            }
            return response()->json($data, 200);
        }
    }

    // delete admin form input
    public function delete($id)
    {
        $form = Form::find($id);
        $form->delete();
        return response()->json('successfully deleted', 200);
    }

    // get form input admin
    public function get($id)
    {
        $form = Form::find($id);
        if ($form->count() == 0) {
            return response()->json('null', 200);
        } else {
            $data = [];
            $data['id'] = $form['id'];
            $data['type'] = $form['type'];
            $data['language'] = $form['language'];
            $data['status'] = $form['status'];
            $data['body'] = json_decode($form['body']);
            return response()->json($data, 200);
        }
    }

    // update form admin input
    public function update(Request $request, $id)
    {
        $form = Form::find($id);
        $form->language = $request->input('language');
        $form->status = $request->input('status');
        $form->body = $request->input('body');
        $form->save();
        return response()->json('successfully updated', 200);
    }

    // get feedback users
    public function getfeedback(Request $request)
    {
        $feeds = Form::where('type', 'feedback')->get();
        if ($feeds->count() == 0) {
            return response()->json('null', 200);
        } else {
            $data = [];
            $i = 0;
            if ($request->input('language') == 'fa') {
                foreach ($feeds as $feed) {
                    if ($feed['language'] == 'fa') {
                        if ($feed['status'] == 'publish') {
                            $value = json_decode($feed['body']);
                            $company = Company::find($value->companyId);
                            $data[$i]['verified'] = $company['verified'];
                            $data[$i]['slug'] = $company['slug'];
                            $body = json_decode($company->body_fa);
                            if ($body->name) {
                                $data[$i]['company']['fa'] = $body->name;
                            } else {
                                $data[$i]['company']['fa'] = "-";
                            }
                            $body = json_decode($company->body_en);
                            if ($body->name) {
                                $data[$i]['company']['en'] = $body->name;
                            } else {
                                $data[$i]['company']['en'] = "-";
                            }
                            $data[$i]['text'] = $value->text;
                            $i++;
                        }
                    }
                }
            } else {
                foreach ($feeds as $feed) {
                    if ($feed['language'] == 'en') {
                        if ($feed['status'] == 'publish') {
                            $value = json_decode($feed['body']);
                            $company = Company::find($value->companyId);
                            $data[$i]['verified'] = $company['verified'];
                            $data[$i]['slug'] = $company['slug'];
                            $body = json_decode($company->body_fa);
                            if ($body->name) {
                                $data[$i]['company']['fa'] = $body->name;
                            } else {
                                $data[$i]['company']['fa'] = "-";
                            }
                            $body = json_decode($company->body_en);
                            if ($body->name) {
                                $data[$i]['company']['en'] = $body->name;
                            } else {
                                $data[$i]['company']['en'] = "-";
                            }
                            $data[$i]['text'] = $value->text;
                            $i++;
                        }
                    }
                }
            }
        }
        return response()->json($data, 200);
    }
}
