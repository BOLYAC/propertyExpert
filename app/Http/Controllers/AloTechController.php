<?php

namespace App\Http\Controllers;

use AloTech\AloTech;
use AloTech\Authentication;
use AloTech\Click2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AloTechController extends Controller
{
    public function loginAloTech(Request $request)
    {

        $token = 'ahRzfm11c3RlcmktaGl6bWV0bGVyaXIfCxISVGVuYW50QXBwbGljYXRpb25zGICA5Ibn17YKDKIBGGhhc2hpbWdyb3VwLmFsby10ZWNoLmNvbQ';
        $userName = $request->email;
        if ($userName == auth()->user()->email) {
            return redirect()->back()->with('toast_error', __('You can note access!'));
        }
        $authentication = new Authentication();
        $authentication->setUsername($userName);
        $authentication->setAppToken($token);
        $authentication->setEmail($userName);

        $aloTech = new AloTech($authentication);

        $aloTech->login($userName);

        Session::put('alotech', $aloTech);
        //$request->session()->put($aloTech);
        return redirect()->back()->with('toast_success', __('Logged to AloTech successfully'));
    }

    public function getCall(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->except('_token');
        if ($request->session()->has('current_call')) {
            return response()->json(array(
                'message' => __('Already on call'),
                'type' => 'danger'
            ), 200);
        }
        // Setup the validator
        $rules = array('phonenumber' => 'required|min:8');
        $validator = Validator::make($data, $rules);

        // Validate the input and return correct response
        if ($validator->fails()) {
            return response()->json(array(
                'message' => __('Please verify your phone number!'),
                'type' => 'danger'
            ), 200);
        } else {
            $aloTech = Session::get('alotech');
            $phoneNumber = $request->phonenumber;
            $click2 = new Click2($aloTech);
            $res = $click2->call([
                'phonenumber' => $phoneNumber,
                'hangup_url' => 'http://crm.hashim.com.tr/',
                'masked' => '1'
            ]);
            Session::put('current_call', $click2);
            return response()->json(array(
                'message' => __('Call started'),
                'type' => 'success'
            ), 200);
        }
    }

    public function getHang(Request $request)
    {
        if ($request->session()->has('current_call')) {
            $aloTech = Session::get('alotech');
            $click2 = Session::get('current_call');
            $click2->hang();
            Session::forget('current_call');
            Session::forget('client_called_id');

            return response()->json(array(
                'message' => __('Call ended'),
                'type' => 'success'
            ), 200);
        } else {
            return response()->json(array(
                'message' => __('There is no call'),
                'type' => 'danger'
            ), 200);
        }
    }
}
