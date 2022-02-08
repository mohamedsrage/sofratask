<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\cartResource;
use App\Http\Resources\categoryResource;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\ContactResource;
use App\Http\Resources\OfferResource;
use App\Http\Resources\ResturantResource;
use App\Models\Cart;
use App\Models\Category;
use App\Models\City;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Neighborhood;
use App\Models\Offer;
use App\Models\Rate;
use App\Models\Resturant;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{


    public function cities(Request $request)
    {
        $cities = City::all();
        return Api_response(1, 'success', categoryResource::collection($cities));
    }


    public function neighborhoods(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            //required
            'city_id'         => 'required|exists:cities,id',
        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        $neighborhoods = Neighborhood::where('city_id', $request->city_id)->get();
        return Api_response(1, 'success', categoryResource::collection($neighborhoods));
    }



    public function categories(Request $request)
    {
        $categories = Category::all();
        return Api_response(1, 'success', categoryResource::collection($categories));
    }


    public function storeService(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            //required
            'client_id'     => 'required|exists:resturants,id',
            'photo'       => 'required|max:255',
            'name'        => 'required|max:255',
            'desc'        => 'required|max:255',
            'duration'    => 'required|max:255',
            'price'       => 'required|max:255',
            'offer_price' => 'required|max:255',
        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        #store new client
        if ($request->has('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/clients')]);
        $service = Service::create($request->except(['_token', 'photo']));

        #success response
        return Api_response(1, 'تم بنجاح', new ServiceResource($service));
    }

    public function updateService(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            //required
            'section_id'  => 'required|exists:services,id',
            'photo'       => 'nullable|max:255',
            'name'        => 'nullable|max:255',
            'desc'        => 'nullable|max:255',
            'duration'    => 'nullable|max:255',
            'price'       => 'nullable|max:255',
            'offer_price' => 'nullable|max:255',
        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        #update new client
        $service = Service::whereId($request->service_id)->first();
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/clients')]);
        $service->update($request->except(['_token', 'photo']));

        #success response
        return Api_response(1, 'تم بنجاح', new ServiceResource($service));
    }

    public function deleteService(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            //required
            'service_id'  => 'required|exists:services,id',
        ]);

         #error response
         if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        #delete client
        Service::whereId($request->service_id)->delete();

        #success response
        return Api_response(1, 'تم بنجاح');
    }

    public function showService(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            //required
            'service_id'  => 'required|exists:services,id'
        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        #update new client
        $service = Service::whereId($request->service_id)->first();

        #success response
        return Api_response(1, 'تم بنجاح', new ServiceResource($service));
    }

    public function showAllServices(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            //required
            'user_id'     => 'required|exists:resturants,id',
        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        #update new client
        $service = Service::where('user_id', $request->user_id)->get();

        #success response
        return Api_response(1, 'تم بنجاح', ServiceResource::collection($service));
    }

    public function home(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            //required
            'user_id'     => 'required|exists:resturants,id',
        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        #update new client
        $user = Client::where('user_id', $request->user_id)->get();

        #success response
        return Api_response(1, 'تم بنجاح', );
    }

    public function contact(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            //required
            'name'     => 'required',
            'email'    => 'required',
            'phone'    => 'required',
            'message'  => 'required',
            'type'     => 'required',
        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        #success response
        Contact::create($request->all());

        #success response
        return Api_response(1, 'تم بنجاح');
    }
    
    public function showResturants(Request $request)
    {
        #success response
        return Api_response(1, 'تم بنجاح', ResturantResource::collection(Resturant::get()));
    }

    public function showResturant(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            //required
            'resturant_id'  => 'required|exists:resturants,id',
        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        #success response
        return Api_response(1, 'تم بنجاح', new ResturantResource(Resturant::whereId($request->resturant_id)->first()));
    }
    public function Offers(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            //required
            'user_id' => 'nullable|exists:users,id',

        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        #data
        $data = OfferResource::collection(Offer::get());

        #success response
        return Api_response(1, 'تم بنجاح', $data);
    }
    public function showOffer(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            //required
            'offer_id' => 'required|exists:offers,id',

        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        #success response
        return Api_response(1, 'تم بنجاح', new OfferResource(Offer::whereId($request->offer_id)->first()));
    }
    public function rateResturant(Request $request)
    {       
        #validation
        $validator = Validator::make($request->all(), [
            //required
            'client_id'    => 'required|exists:clients,id',
            'resturant_id' => 'nullable|exists:resturants,id',
            'rate'         => 'required|in:1,2,3,4,5',
            'desc'         => 'required',
        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        #success response
        Rate::create($request->all());


        #success response
        return Api_response(1, 'تم بنجاح');   
    }





    
    /*
    |---------------------------------------------|
    |                 Cart Pages                  |
    |---------------------------------------------|
    */

    public function addToCart(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            //required
            'client_id'      => 'required|exists:clients,id',
            'service_id'     => 'required|exists:services,id',
            'count'          => 'required',
        ]);

        #error response
        if ($validator->fails()) return Api_response(0, $validator->errors()->first());

        #data
        $service        = Service::whereId($request->service_id)->first();
        $another_cart   = Cart::where('client_id', $request->client_id)->where('resturant_id', '!=', $service->user_id)->first();
        if (isset($another_cart)) return api_response('0', 'السلة حاليا بها منتجات لمطعم اخر قم بأفراغ السلة اولا');

         #store new cart
         $cart = Cart::where('client_id', $request->client_id)->where('service_id', $request->service_id)->first();
         if(isset($cart)){
            $cart->update([
                'count' => $cart->count + $request->count,
                'total' => ($cart->count + $request->count) * $service->price
            ]);

         }else{
            $request->request->add([
                'resturant_id'  => $service->user_id,
                'delivery_time' => $service->duration,
                'total'         => $service->price * $request->count,
            ]);
            Cart::create($request->all());
         }


        #success response
        return Api_response(1, 'تم بنجاح');   
    }




    #update cart
    public function updateToCart(Request $request)
    {
        /* Validate Request */
        $validate = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'cart_id'   => 'required|exists:carts,id',
            'count'     => 'required',
        ]);

        /* Send Error Massages */
        if ($validate->fails())
            return api_response('0', $validate->errors()->first());

        /* update cart */
        $cart     = Cart::whereId($request->cart_id)->first();
        $service  = Service::whereId($cart->service_id)->first();

        if ($request->count > 0) {
            $cart->update([
                'count' => $request->count,
                'total' => $request->count * $service->price
            ]);

        } else {
            $cart->delete();
        }

        /* Send Success Massage */
        return api_response('1', 'تم بنجاح', cartResource::collection(Cart::where('client_id', $request->client_id)->get()));
    }

    #show cart
    public function showCart(Request $request)
    {
        /* Validate Request */
        $validate = Validator::make($request->all(), [
            'client_id'      => 'required|exists:clients,id',
        ]);

        /* Send Error Massages */
        if ($validate->fails()) return api_response('0', $validate->errors()->first());

        /* get cart Data */
        $data = cartResource::collection(Cart::where('client_id', $request->client_id)->get());

        /* Send Success Massage */
        return api_response('1', 'تم بنجاح', $data);
    }
















}
