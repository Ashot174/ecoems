<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistartionRequest;
use App\Mail\UserCredentailEmail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /**
     * @param UserRegistartionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(UserRegistartionRequest $request)
    {

        $user = new User();
        $user['name'] = $request['name'];
        $user['role_id'] = $request['role_id'];
        $user['avatar'] = 'users/default.png';
        $user['email'] = $request['email'];
        $user['password'] = Hash::make($request['password']);
        if($user->save())
        {
            $mail = new UserCredentailEmail($user,$request['password']);
            Mail::to($user['email'])->queue($mail->onQueue('emails'));
            return redirect()->back()->with('success','Registration was completed');
        }else{
            return redirect()->back()->withErrors('Something went wrong');
        }
    }
}
