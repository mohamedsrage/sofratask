<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ResturantResource;
use App\Models\Role;
use App\Models\City;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Device;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use App\Models\Resturant;

use function GuzzleHttp\Promise\all;

class AuthController extends Controller
{
    /************************
    |     Client Auth       |
    ************************/

    public function register(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            //required
            'name'        => 'required|max:255',
            'phone'       => 'required|min:9|max:13|unique:clients,phone',
            'password'    => 'required|max:255',
            'photo'       => 'required',
            'email'       => 'required|max:255|email|unique:clients,email',
            //nullable
            'city_id'         => 'nullable|exists:cities,id',
            'neighborhood_id' => 'nullable|exists:neighborhoods,id',

        ]);

         #error response
         if ($validator->fails()) return Api_response(0, $validator->errors()->first());

         #check phone if in used
         $phone  = convert_to_english($request->phone);

         #send code to client's phone #####MO
         $code   = active_code();

         #avatar
         if ($request->hasFile('photo')) $avatar = upload_image($request->file('photo'), 'public/images/clients');
         else $avatar = '';

            #store new client
            $request->request->add([
            'active'    => 0,
            'pin_code'  => $code,
            'phone'     => $phone,
            'avatar'    => $avatar,
            'password'  => bcrypt($request->password),
        ]);
            $user = Client::create($request->except(['_token', 'photo']));

        #success response
        return Api_response(1, 'تم التسجيل بنجاح وارسال كود التحقق الى هاتفك', new ClientResource($user));
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email'    =>'required|string|email',
            'password' =>'required|string',
        ],[
            'email.required'    => 'الايميل مطلوب',
            'email.string'      => 'الايميل يجب ان يكون نصي',
            'email.email'       => 'الايميل صيغته غير صحيحه',
            'password.required' => 'كلمة المرور مطلوب',
            'password.string'   => 'كلمة المرور يجب ان يكون نصي',
        ]);

            #error response
            if ($validator->fails()) return Api_response(0, $validator->errors()->first());

            //Check email

         $user= Client::where('email', $request['email'])->first();

            //Check Password
            if(!$user || !Hash::check($request['password'], $user->password) ){
            return Api_response(0, 'Invalid Credentials');
        }

        $token = Str::random(80);
        $user->update(['api_token' => $token]);

        return Api_response(1, 'تم بنجاح', new ClientResource($user));
    }

    public function profile(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            //required
            'user_id'         => 'required|exists:clients,id',
            //nullable
            'name'            => 'nullable|max:255',
            'phone'           => 'nullable|min:9|max:13|unique:clients,phone,' . $request->user_id,
            'photo'           => 'nullable',
            'email'           => 'nullable|max:255|email|unique:clients,email,' . $request->user_id,
            'city_id'         => 'nullable|exists:cities,id',
            'neighborhood_id' => 'nullable|exists:neighborhoods,id',
        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        #avatar
        if ($request->hasFile('photo')) $request->request->add(['avatar' => upload_image($request->file('photo'), 'public/images/clients')]);
        
        #update client
        $user = Client::whereId($request->user_id)->first();
        $user->update($request->except(['user_id', 'photo']));
      
        return Api_response(1, 'تم تحديث البيانات', new ClientResource($user));
    }

    public function showUser(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'  => 'required|exists:clients,id',
        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        #show client
        $user = Client::whereId($request->user_id)->first();
    
        return Api_response(1, 'تم بنجاح', new ClientResource($user));
    }

    public function logout(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'api_token'  => 'required|exists:clients,api_token',
        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        #show client
        $user = Client::where('api_token', $request->api_token)->first();
        $user->api_token = null ;
        $user->save();
    
        return Api_response(1, ' تم تسجيل الخروج بنجاح  ');
    }


        #forgetPassword account
    public function forgetPassword(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'phone' => 'required'

        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());
        
            $user = Client::where('phone', $request->phone)->first();
            if ($user) {
            $code   = active_code();
            $update = $user->update(['pin_code' => $code]);
            if ($update) {

                // send email
                Mail::to($user->email)
                ->bcc("eng.mohamed@gmail.com")
                ->send(new ResetPassword($user));

                return Api_response(1, 'تم بنجاح',
                [
                    'pin_code_for_test' => $code,
                    'mail_fails'        => Mail::failures(),
                    'email'             => $user->email,
                ]);
            }
        } 
            
        return Api_response(0, 'لا يوجد أي حساب مرتبط بهذا الهاتف');
    }
        #active account
    public function activeAccount(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'pin_code' => 'required',
            // 'password' => 'required|string'
        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());
        
        $user = Client::where('pin_code', $request->pin_code)->where('phone', $request->phone)->first();
        if ($user) {
            $user->active   = 1;
            $user->pin_code = null;
            $user->save();

            return Api_response(1, 'تم بنجاح ');
        }

        return Api_response(0, 'جدث خطأ حاول مرة اخرى');
    }
     #reset_PAssword
    public function resetPassword(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'phone'    => 'required',
            'pin_code' => 'required',
            'password' => 'required|string'


        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());
        
        $user = Client::where('pin_code', $request->pin_code)->where('phone', $request->phone)->first();
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->pin_code = null;
            $user->save();

            return Api_response(1, 'تم بنجاح ', new ClientResource($user));
        }

        return Api_response(0, 'جدث خطأ حاول مرة اخرى');
    }

    #resend code
    public function resendCode(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:clients,id',
        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());
        $user = Client::whereId($request->user_id)->first();

        if ($user) {

        $user = Client::whereId($request->user_id)->first();
        $code = active_code();
        $user->save();
        }
        return Api_response(1, 'تم بنجاح', new ClientResource($user));

    }


    /************************
    |     Resturant Auth     |
    ************************/

    public function registerResturant(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            //required
            'name'        => 'required|max:255',
            'phone'       => 'required|min:9|max:13|unique:resturants,phone',
            'password'    => 'required|max:255',
            'photo'       => 'required',
            'email'       => 'required|max:255|email|unique:resturants,email',
            //nullable
            'category_id'     => 'nullable|exists:categories,id',
            'city_id'         => 'nullable|exists:cities,id',
            'neighborhood_id' => 'nullable|exists:neighborhoods,id',

        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        #check phone if in used
        $phone  = convert_to_english($request->phone);

        #send code to client's phone #####MO
        $code   = active_code();

        #avatar
        if ($request->hasFile('photo')) $avatar = upload_image($request->file('photo'), 'public/images/resturants');
        else $avatar = '';
        #image
        if ($request->hasFile('provider_photo')) $image = upload_image($request->file('provider_photo'), 'public/images/resturants');
        else $image = '';

        #store new client
        $request->request->add([
            'active'    => 0,
            'pin_code'  => $code,
            'phone'     => $phone,
            'avatar'    => $avatar,
            'image'     => $image,
            'password'  => bcrypt($request->password),
        ]);
        $user = Resturant::create($request->except(['_token', 'photo', 'provider_photo']));

        #success response
        return Api_response(1, 'تم التسجيل بنجاح وارسال كود التحقق الى هاتفك', new ResturantResource($user));
    }

    public function loginResturant(Request $request){
        $validator = Validator::make($request->all(), [
            'email'    =>'required|string|email',
            'password' =>'required|string',
        ],[
            'email.required'    => 'الايميل مطلوب',
            'email.string'      => 'الايميل يجب ان يكون نصي',
            'email.email'       => 'الايميل صيغته غير صحيحه',
            'password.required' => 'كلمة المرور مطلوب',
            'password.string'   => 'كلمة المرور يجب ان يكون نصي',
        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        //Check email

        $user= Resturant::where('email', $request['email'])->first();

        //Check Password
        if(!$user || !Hash::check($request['password'], $user->password) ){
            return Api_response(0, 'Invalid Credentials');
        }

        $token = Str::random(80);
        $user->update(['api_token' => $token]);

        return Api_response(1, 'تم بنجاح', new ResturantResource($user));
    }

    public function profileResturant(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            //required
            'user_id'         => 'required|exists:resturants,id',
            //nullable
            'name'            => 'nullable|max:255',
            'phone'           => 'nullable|min:9|max:13|unique:resturants,phone,' . $request->user_id,
            'photo'           => 'nullable',
            'user_type'       => 'nullable|in:client,provider',
            'email'           => 'nullable|max:255|email|unique:resturants,email,' . $request->user_id,
            'category_id'     => 'nullable|exists:categories,id',
            'city_id'         => 'nullable|exists:cities,id',
            'neighborhood_id' => 'nullable|exists:neighborhoods,id',
        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        #avatar
        if ($request->hasFile('photo')) $request->request->add(['avatar' => upload_image($request->file('photo'), 'public/images/resturants')]);
        #image
        if ($request->hasFile('provider_photo')) $request->request->add(['image' => upload_image($request->file('provider_photo'), 'public/images/resturants')]);
        
        #update client
        $user = Resturant::whereId($request->user_id)->first();
        $user->update($request->except(['user_id']));
      
        return Api_response(1, 'تم تحديث البيانات', new ResturantResource($user));
    }

    public function showUserResturant(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'  => 'required|exists:resturants,id',
        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        #show client
        $user = Resturant::whereId($request->user_id)->first();
    
        return Api_response(1, 'تم بنجاح', new ResturantResource($user));
    }
    public function logoutResturant(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'api_token'  => 'required|exists:resturants,api_token',
        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        #show client
        $user = Resturant::where('api_token', $request->api_token)->first();
        $user->api_token = null ;
        $user->save();
    
        return Api_response(1, ' تم تسجيل الخروج بنجاح  ');
    }


        #forgetPassword account
    public function forgetPasswordResturant(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'phone' => 'required'

        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());
        
        $user = Resturant::where('phone', $request->phone)->first();
        if ($user) {
            $code   = active_code();
            $update = $user->update(['pin_code' => $code]);
            if ($update) {

                // send email
                Mail::to($user->email)
                ->bcc("eng.mohamed@gmail.com")
                ->send(new ResetPassword($user));

                return Api_response(1, 'تم بنجاح',
                [
                    'pin_code_for_test' => $code,
                    'mail_fails'        => Mail::failures(),
                    'email'             => $user->email,
                ]);
            }
        } 
            
        return Api_response(0, 'لا يوجد أي حساب مرتبط بهذا الهاتف');
    }
        #active account
    public function activeAccountResturant(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'pin_code' => 'required',
            // 'password' => 'required|string'
        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());
        
        $user = Resturant::where('pin_code', $request->pin_code)->where('phone', $request->phone)->first();
        if ($user) {
            $user->active   = 1;
            $user->pin_code = null;
            $user->save();

            return Api_response(1, 'تم بنجاح ');
        }

        return Api_response(0, 'جدث خطأ حاول مرة اخرى');
    }
     #reset_PAssword
    public function resetPasswordResturant(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'phone'    => 'required',
            'pin_code' => 'required',
            'password' => 'required|string'


        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());
        
        $user = Resturant::where('pin_code', $request->pin_code)->where('phone', $request->phone)->first();
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->pin_code = null;
            $user->save();

            return Api_response(1, 'تم بنجاح ', new ResturantResource($user));
        }

        return Api_response(0, 'جدث خطأ حاول مرة اخرى');
    }

    #resend code
    public function resendCodeResturant(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'phone' => 'required'

        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());
        
        $user = Resturant::where('phone', $request->phone)->first();
        if ($user) {
            $code   = active_code();
            $update = $user->update(['pin_code' => $code]);
            if ($update) {

                // send email
                Mail::to($user->email)
                ->bcc("eng.mohamed@gmail.com")
                ->send(new ResetPassword($user));

                return Api_response(1, 'تم بنجاح',
                [
                    'pin_code_for_test' => $code,
                    'mail_fails'        => Mail::failures(),
                    'email'             => $user->email,
                ]);
            }
        } 
            
        return Api_response(0, 'لا يوجد أي حساب مرتبط بهذا الهاتف');
        

    }






















    






}
