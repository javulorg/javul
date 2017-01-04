<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Hashids\Hashids;

class MessageController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth',['except'=>['index','view','get_units_paginate']]);
    }
    public function inbox()
    {
        $filter = array(
            array('message.from',"=", Auth::user()->id),
        );
        view()->share("page", 'inbox');
        view()->share("messages", Message::getMsg($filter,true) );
        return view("message.inbox");
    }
    public function view($message_id)
    {
    	$filter = array(
    		array('message.message_id',"=", $message_id),
    	);
    	$message = Message::getMsg($filter);
        if(!empty($message['message'])){
            $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
            $user_id = $userIDHashID->encode($message['message'][0]['to']);
            $message['message'][0]['link'] = url('userprofiles/'. $user_id .'/'.strtolower($message['message'][0]['first_name'].'_'.$message['message'][0]['last_name']));
            view()->share("message", $message['message'][0] );
            view()->share("myId", Auth::user()->id );
            view()->share("page", '' );
           
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
    		array('message.to',"=", Auth::user()->id),
    	);
    	view()->share("page", 'sent');
    	view()->share("messages", Message::getMsg($filter,true) );
    	return view("message.inbox");
    }
    public function send(Request $request, $user_id = 0)
    {
        if($user_id == Auth::user()->id){
            return view("errors.404");
        }
        
    	if ($request->isMethod('post')) {
    		 $inputData = $request->all();
    	
	        $validator = \Validator::make($inputData, [
	            'message'=> 'required',
                'user_id'=> 'required',
	            'subject'=> 'required',
	        ],[
                'message.required'=>'Please enter message',
	            'subject.required'=>'Please enter subject',
	        ]);

	        if ($validator->fails()){
	            return json_encode(array(
					'errors' => $validator->getMessageBag()->toArray()
				), 200);
	        }
	        $messageId = Message::send($inputData);
	        $json = array();
	        if($messageId){
	            $json['success'] = "Message Send successfully";
	        }
	        else
	        {
	        	$json['error'] = "Error in Sending Message";
	        }
	        return json_encode($json);
    	}
    	else {
            $user = Message::users();
             
            view()->share("user_id",$user_id);
            view()->share("page",'new');
    		view()->share("user",$user);
    		return view("message.send");
    	}
    }
}
