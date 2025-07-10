<?php

namespace App\Http\Controllers;

use App\Models\SiteActivity;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Hashids\Hashids;
use App\Models\UserMessages;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'view', 'get_units_paginate']]);
        $site_activity = SiteActivity::orderBy('created_at', 'desc')->paginate(Config::get('app.site_activity_page_limit'));
        view()->share('site_activity', $site_activity);
        view()->share('site_activity_text', 'Global Activity Log');
    }
    public function new_msg()
    {
        $json = array();
        $json['count'] = DB::table('message')->where("to", "=", Auth::user()->id)->where("isRead", "=", DB::raw(0))->count();

        return json_encode($json);
    }

    public function inbox()
    {
        Message::setRead();

        $filter = array(
            array('message.to', "=", Auth::user()->id),
        );
        view()->share("page", 'inbox');
        view()->share("messages", Message::getMsg($filter, true));
        return view("message.inbox");
    }
    public function view($message_id)
    {
        $filter = array(
            array('message.id', "=", $message_id),
        );
        $message = Message::getMsg($filter);
        if (!empty($message['message'])) {
            $userIDHashID = new Hashids('user id hash', 10, Config::get('app.encode_chars'));
            $user_id = $userIDHashID->encode($message['message'][0]['from']);

            $message['message'][0]['link'] = url('userprofiles/' . $user_id . '/' . strtolower($message['message'][0]['first_name'] . '_' . $message['message'][0]['last_name']));


            view()->share("message", $message['message'][0]);
            view()->share("myId", Auth::user()->id);
            view()->share("page", '');

            return view("message.view");
        }
        return view('errors.404');
    }
    public function newmsg()
    {
        return view("message.new");
    }
    public function sent()
    {
        $filter = array(
            array('message.from', "=", Auth::user()->id),
        );

        view()->share("page", 'sent');
        view()->share("messages", Message::getMsg($filter, true));
        return view("message.inbox");
    }



    public function send(Request $request, $user_id = 0)
    {
        if ((int)$user_id == Auth::user()->id) {
            return view("errors.404");
        }


        $user = Message::users();

        view()->share("user_id", $user_id);
        view()->share("page", 'new');
        view()->share("user", $user);
        return view("message.send");
    }

    public function sendMessage(Request $request, $user_id = 0)
    {
        if ((int)$user_id === Auth::user()->id) {
            return view("errors.404");
        }

        $userIDHashID = new Hashids('user id hash', 10, Config::get('app.encode_chars'));
        $hashed_user_id = $userIDHashID->encode(Auth::user()->id);

        if ($request->isMethod('post')) {
            $inputData = $request->all();

            $validator = Validator::make($inputData, [
                'message' => 'required',
                'user_id' => 'required',
                'subject' => 'required',
            ], [
                'message.required' => 'Please enter message',
                'subject.required' => 'Please enter subject',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $messageId = Message::send($inputData);

            if ($messageId) {
                $receiverObj = User::find($inputData['user_id']);

                $content = 'User <a style="text-decoration:none;" href="' . url('userprofiles/' . $hashed_user_id . '/' .
                    strtolower(Auth::user()->first_name . '_' . Auth::user()->last_name)) . '">' . Auth::user()->first_name . ' ' . Auth::user()->last_name . '</a> ' .
                    ' sent you a message';
                $email_subject = 'User ' . Auth::user()->first_name . ' ' . Auth::user()->last_name . ' sent you a message';

                User::SendEmailAndOnSiteAlert($content, $email_subject, [$receiverObj], true, 'inbox');

                return redirect('message/sent')->with('success', 'Message sent successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to send message. Please try again.');
            }
        } else {
            $user = Message::users();

            view()->share("user_id", $user_id);
            view()->share("page", 'new');
            view()->share("user", $user);
            return view("message.send");
        }
    }
}
