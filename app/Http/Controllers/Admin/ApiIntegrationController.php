<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\SmsGateway;
use App\Models\Courierapi;
use Toastr;
use File;
use Str;
use Image;
use DB;

class ApiIntegrationController extends Controller
{
    
     
    public function pay_manage ()
    {
        $bkash = PaymentGateway::where('type','=','bkash')->first();
        $shurjopay = PaymentGateway::where('type','=','shurjopay')->first();
        return view('backEnd.apiintegration.pay_manage',compact('bkash','shurjopay'));
    }
    
    public function pay_update(Request $request)
    {
      
        $update_data = PaymentGateway::find($request->id);
        $input = $request->all();
        $input['status'] = $request->status?1:0;
        $update_data->update($input);
        
        Toastr::success('Success','Data update successfully');
        return redirect()->back();
    }
    
    public function sms_manage ()
    {  
        $sms = SmsGateway::first();
        return view('backEnd.apiintegration.sms_manage',compact('sms'));
    }
    
    public function sms_update(Request $request)
    {
      
        $update_data = SmsGateway::find($request->id);
        $input = $request->all();
        $input['status'] = $request->status?1:0;
        $input['order'] = $request->order?1:0;
        $input['forget_pass'] = $request->forget_pass?1:0;
        $input['password_g'] = $request->password_g?1:0;
        $update_data->update($input);
        
        Toastr::success('Success','Data update successfully');
        return redirect()->back();
    }
    
    public function courier_manage()
    {
        $steadfast = Courierapi::where('type', '=', 'steadfast')->first();
        $pathao = Courierapi::where('type', '=', 'pathao')->first();
        $pathaoService = new \App\Services\PathaoService();
        $pathaoTokenStatus = $pathaoService->getTokenStatus();
        return view('backEnd.apiintegration.courier_manage', compact('steadfast', 'pathao', 'pathaoTokenStatus'));
    }
    
    public function courier_update(Request $request)
    {
        $update_data = Courierapi::find($request->id);
        $input = $request->all();
        $input['status'] = $request->status ? 1 : 0;
        
        if (isset($input['token'])) {
            $input['token'] = trim($input['token']);
        }
        
        // Preserve password for Pathao if left blank
        if ($update_data && $update_data->type === 'pathao' && empty($input['password'])) {
            unset($input['password']);
        }

        $update_data->update($input);
        
        \Illuminate\Support\Facades\Cache::flush();
        
        Toastr::success('Success', 'Courier API configuration updated successfully');
        return redirect()->back();
    }

    public function pathao_issue_token(Request $request)
    {
        $pathaoService = new \App\Services\PathaoService();

        // If credentials are submitted via form, persist them first
        $clientId = trim($request->input('client_id') ?? $request->input('api_key') ?? '');
        $clientSecret = trim($request->input('client_secret') ?? $request->input('secret_key') ?? '');
        $username = trim($request->input('username') ?? '');
        $password = trim($request->input('password') ?? '');
        $url = trim($request->input('url') ?? '');

        $updateData = [];
        if (!empty($clientId)) $updateData['api_key'] = $clientId;
        if (!empty($clientSecret)) $updateData['secret_key'] = $clientSecret;
        if (!empty($username)) $updateData['username'] = $username;
        if (!empty($password)) $updateData['password'] = $password;
        if (!empty($url)) $updateData['url'] = $url;

        if (!empty($updateData)) {
            Courierapi::where('type', 'pathao')->update($updateData);
            $pathaoService->reloadConfig();
        }

        $res = $pathaoService->issueToken($clientId, $clientSecret, $username, $password);

        if ($request->ajax()) {
            return response()->json($res);
        }

        if ($res['status']) {
            Toastr::success($res['message'], 'Pathao Connected');
        } else {
            Toastr::error($res['message'], 'Token Generation Failed');
        }

        return redirect()->back();
    }
}