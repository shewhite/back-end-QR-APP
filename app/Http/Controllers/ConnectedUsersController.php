<?php

namespace App\Http\Controllers;

use App\ConnectedUsers;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use DB;
use Mail;
//use Illuminate\Support\Facades\Mail;
use App\Mail\InformUserMail;

class ConnectedUsersController extends Controller
{
    protected $user;
 
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
    public function index(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
        $users = $this->user
        ->connectedUsers($request['id']);
        /*
        ->get(['connected_user'])
        ->toArray();
        $usersDetails = array();
        
        foreach($users as $u){
 
        $usersDetails[] = DB::select('select * from users where id = ?',$u['connected_user']);
       // ->pluck("symbol","id");
        }
        /*
        $symbol = DB::table("connected_users")
        ->where("market_id", $id)
        ->get()
        ->pluck("symbol","id");*/
   // return response() -> json($symbol);
        return response()->json($users);
        /*
        return $this->user
            ->connectedUsers()
            ->get(['connected_user'])
            ->toArray();
            */
        
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
        /*
        $this->validate($request, [
            'user_id' => 'required',
            'connected_user' => 'required|integer'
        ]);
        */
    
        $connectedUser = new ConnectedUsers();
        $connectedUser->user_id = $request->userId;
        $connectedUser->connected_user = $request->userToConnect;
        $userData = User::where('id', '=', $connectedUser->user_id)->get()->toArray();
        $connectedUserData = User::where('id', '=', $connectedUser->connected_user)->get()->toArray();
        $mailForUser = new \stdClass();
        $mailForUser->forUser = true;
        $mailForUser->myName = $userData[0]['first_name'] . " " . $userData[0]['last_name'];
        $mailForUser->toName = $connectedUserData[0]['first_name'] . " " . $connectedUserData[0]['last_name'];
        $mailForUser->email = $connectedUserData[0]['email'];
        $mailForUser->company = $connectedUserData[0]['company'];
        $mailForUser->website = $connectedUserData[0]['website'];
        $mailForUser->phone = $connectedUserData[0]['phone'];


        $mailForConnectedUser = new \stdClass();
        $mailForConnectedUser->forUser = false;
        $mailForConnectedUser->myName = $connectedUserData[0]['first_name'] . " " . $connectedUserData[0]['last_name'];
        $mailForConnectedUser->toName = $userData[0]['first_name'] . " " . $userData[0]['last_name'];
        $mailForConnectedUser->email = $userData[0]['email'];
        $mailForConnectedUser->company = $userData[0]['company'];
        $mailForConnectedUser->website = $userData[0]['website'];
        $mailForConnectedUser->phone = $userData[0]['phone'];

        Mail::to($userData[0]['email'])->send(new InformUserMail($mailForUser));
        Mail::to($connectedUserData[0]['email'])->send(new InformUserMail($mailForConnectedUser));


        if ($this->user->connectUsers()->save($connectedUser))
            return response()->json([
                'success' => true,
                'connectedUser' => $connectedUser
        ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, users cant connect'
            ], 500);

       // $mailForUser->sender = 'SenderUserName';
       // $mailForUser->receiver = 'ReceiverUserName';
    

            
    }
}
