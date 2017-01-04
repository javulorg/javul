<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class Message extends Model
{
    public static function send($data = array())
    {
    	$member = array(
            'body' => $data['message'],
			'subject' => $data['subject'],
			'to' => Auth::user()->id,
			'from' => $data['user_id'],
			'isRead' => 0,
			'datetime' => date("Y-m-d H:i:s"),
		);
		return DB::table('message')->insertGetId($member);
    }
    public static function users($data = array())
    {
       return  DB::table("users")
                    ->where("id","<>",DB::raw(Auth::user()->id))
                    ->select(["users.id","users.first_name","users.last_name"])
                    ->get();
    }
    public static function getMsg($filter = array(),$sortDesc = false)
    {
    	$messages =  DB::table("message")
    				->select(["message.*","users.first_name","users.last_name"])
    				->leftJoin('users', 'users.id', '=', 'message.to')
                    ->where(function ($query) {
                        $query->where("to","=",DB::raw(Auth::user()->id))->orWhere("to","=",DB::raw(Auth::user()->id));
                    })
    				->where($filter)
    				->orderBy("message_id","DESC")
    				->paginate(10);
 
    	$data = array();
        $data['message'] = array();
        
    	foreach ($messages->items() as $key => $message) {
    		$data['message'][] = array(
    			'message_id' => $message->message_id,
			    'body' => $sortDesc ?  substr(strip_tags($message->body),0,250) : $message->body,
			    'to' => $message->to,
                'from' => $message->from,
			    'subject' => strip_tags( $message->subject ),
			    'datetime' => Carbon::createFromFormat('Y-m-d H:i:s', $message->datetime)->diffForHumans(),
			    'isRead' => $message->isRead,
			    'first_name' => $message->first_name,
			    'last_name' => $message->last_name,
		    );
    	}
    	$data['pagination'] = $messages->links();
    	return $data;
    }
}
