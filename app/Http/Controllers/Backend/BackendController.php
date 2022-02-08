<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\AdminInfoRequest;
use App\Models\User;
use Facade\FlareClient\Stacktrace\File;

use Intervention\Image\Facades\Image;


use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BackendController extends Controller
{
    public function login()
    {
        return view('backend.login');
    }
    
    public function post_login(Request $request){
        $validator = Validator::make($request->all(), [
            'username'    =>'required',
            'password'    =>'required',
        ],[
            'username.required'  => 'الاسم مطلوب',
            'password.required'  => 'كلمة المرور مطلوب',
        ]);
            
        //Check username
        $user= User::where('username', $request['username'])->first();
         //Check Password
        if(!$user || !Hash::check($request['password'], $user->password) ){
            return back();
        }

        $token = Str::random(80);
        $user->update(['api_token' => $token]);

        Auth::login($user);
        return redirect()->route('admin.index');
    }

    public function forgot_password()
    {
        return view('backend.forgot-password');
    }
    public function index()
    {
        return view('backend.index');
    }

    public function account_settings()
    {
        return view('backend.account_settings');
    }

    public function update_account_settings(AdminInfoRequest $request)
    {
        if($request->validated()){
            $date['first_name']                         = $request->first_name;
            $date['last_name']                          = $request->last_name;
            $date['username']                           = $request->username;
            $date['email']                              = $request->email;
            $date['mobile']                             = $request->mobile;
            $date['password']                           = $request->password;
            if($request->password != '') {
                $date['password'] = bcrypt($request->password);
            }

            if ($image = $request->file('user_image')) {
                if (auth()->user()->user_image != null && File::exists('assets/users/'. auth()->user()->user_image)){
                    unlink('assets/users/'. auth()->user()->user_image);
                }
                $file_name = Str::slug($request->username).".".$image->getClientOriginalExtension();
                $path = public_path('/assets/users/' . $file_name);
                Image::make($image->getRealPath())->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['user_image'] = $file_name;
            }

            auth()->user()->update($data);

            return redirect()->route('admin.account_settings')->with([
                'message' => 'Updated successfully',
                'alert-type' => 'success'
            ]);

            





        }
    }




    public function remove_image(Request $request)
    {
        // if (!auth()->user()->ability('admin', 'delete_supervisors')) {
        //     return redirect('admin/index');
        // }

        if (File::exists('assets/users/'. auth()->user()->user_image)){
            unlink('assets/users/'. auth()->user()->user_image);
            auth()->user()->user_image = null;
            auth()->user()->save();
        }
        return true;
    }
}
