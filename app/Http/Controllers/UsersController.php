<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Users;
use SebastianBergmann\Type\Type;

class UsersController extends Controller
{
    private $users;
    public function __construct(){
        $this->users = new Users();
    }
    public function index(){
        $title = 'Lists users';

        $users = new Users();

        $usersList = $this->users->getAllUsers();

        return view('clients.users.lists', compact('title','usersList'));
    }
    public function add(){
        $title='Add lists users';
        return view('clients.users.add', compact('title'));
    }

    public function postAdd(Request $request){
        $request-> validate([
            'name'=>'required|min:5',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role_id' => 'required'
        ],[
            'name.required' =>'full name is required to enter ',
            'name.min'=>'Full name with minimum 5 characters or more',
            'email.required' => "Email required to enter",
            'email.email'=> 'Email Malformed',
            'email.unique'=>'already exists in the system'
        ]);
        //return 'ok';
        $dataInsert = [
            $request->name,
            $request->email,
            $request->password,
            $request->role_id            
        ];
        $this->users->addUser($dataInsert);
        return redirect()->route('users.index')->with('msg','Add successfully');
    }

    public function getEdit($id=0){
        $title='Update users';
        if(!empty($id)){
            $userDetail = $this->users->getDetail($id);
            if(!empty($userDetail[0])){
                $userDetail = $userDetail[0];
            }else{
                return redirect()->route('users.index')->with('msg', 'User does not exist');
            }
        }else{
            return redirect()->route('users.index')->with('msg', 'link does not exist');

        }
        return view('clients.users.edit', compact('title','userDetail'));
    }

    public function postEdit(Request $request, $id=0){
        $request-> validate([
            'name'=>'required|min:5',
            'email' => 'required|email|',
            'password' => 'required',
            'role_id' => 'required'
        ],[
            'name.required' =>'full name is required to enter',
            'name.min'=>'Full name with minimum 5 characters or more',
            'email.required' => "Email required to enter",
            'email.email'=> 'already exists in the system',
            
        ]);

        $dataUpdate = [
            $request->name,
            $request->email,
            $request->password,
            $request->role_id         
        ];
        $this->users->updateUser($dataUpdate,$id);
        return back()->with('msg','Update successfully');
    }
    public function delete($id=0){
        if(!empty($id)){
            $userDetail = $this->users->getDetail($id);
            if(!empty($userDetail[0])){
               $deleteStatus = $this->users->deleteUser($id);
                if($deleteStatus){
                    $msg = 'delete users not successfully';
                }else{
                    $msg = 'you can not now, please come back later';
                }
            }else{
                $msg = 'Product exist';
            }
        }else{
            $msg = 'Link exist';
        }
        return redirect()->route('users.index')->with('msg',$msg);
    }
}
