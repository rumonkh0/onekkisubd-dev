<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\CustomerProfit;
use App\Models\Customer;
use App\Models\IpBlock;
use Toastr;
use Image;
use File;
use Auth;
use Hash;
class CustomerManageController extends Controller
{
    public function index(Request $request){
        if($request->keyword){
            $show_data = Customer::orWhere('phone',$request->keyword)->orWhere('name',$request->keyword)->paginate(20);
        }else{
             $show_data = Customer::paginate(20);
        }
       
        return view('backEnd.customer.index',compact('show_data'));
    }

    public function edit($id){
        $edit_data = Customer::find($id);
        return view('backEnd.customer.edit',compact('edit_data'));
    }
    
    public function update(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        $input = $request->except('hidden_id');
        $update_data = Customer::find($request->hidden_id);
        // new password
        
        
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }

        // new image
        $image = $request->file('image');
        if($image){
            // image with intervention 
            $name =  time().'-'.$image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name);
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadpath = 'public/uploads/customer/';
            $imageUrl = $uploadpath.$name; 
            $img=Image::make($image->getRealPath());
            $img->encode('webp', 90);
            $width = 100;
            $height = 100;
            $img->height() > $img->width() ? $width=null : $height=null;
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($imageUrl);
            $input['image'] = $imageUrl;
            File::delete($update_data->image);
        }else{
            $input['image'] = $update_data->image;
        }
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('customers.index');
    }
 
    public function inactive(Request $request){
        $inactive = Customer::find($request->hidden_id);
        $inactive->status = 'inactive';
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request){
        $active = Customer::find($request->hidden_id);
        $active->status = 'active';
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function profile(Request $request){
        $profile = Customer::with('orders')->find($request->id);
        if (!$profile) {
            Toastr::error('Customer not found');
            return redirect()->route('customers.index');
        }
        return view('backEnd.customer.profile',compact('profile'));
    }
    public function adminlog(Request $request){
        $customer = Customer::find($request->hidden_id);
        Auth::guard('customer')->loginUsingId($customer->id);
        return redirect()->route('customer.account');
    }
    public function ip_block(Request $request){
        $data = IpBlock::latest()->get();
        return view('backEnd.reports.ipblock',compact('data'));
    }
    public function ipblock_store(Request $request){
        $request->validate([
            'ip_no' => 'required|string|max:45|unique:ip_blocks,ip_no',
            'reason' => 'required|string|max:255',
        ]);

        $store_data = new IpBlock();
        $store_data->ip_no = $request->ip_no;
        $store_data->reason = $request->reason;
        $store_data->save();
        Toastr::success('Success','IP address added successfully');
        return redirect()->back();
    }
    public function ipblock_update(Request $request){
        $request->validate([
            'id' => 'required|exists:ip_blocks,id',
            'ip_no' => 'required|string|max:45|unique:ip_blocks,ip_no,' . $request->id,
            'reason' => 'required|string|max:255',
        ]);

        $update_data = IpBlock::find($request->id);
        if ($update_data) {
            $update_data->ip_no = $request->ip_no;
            $update_data->reason = $request->reason;
            $update_data->save();
            Toastr::success('Success','IP address updated successfully');
        } else {
            Toastr::error('Error', 'IP record not found');
        }
        return redirect()->back();
    }
    public function ipblock_destroy(Request $request){
        $delete_data = IpBlock::find($request->id);
        if ($delete_data) {
            $delete_data->delete();
            Toastr::success('Success','IP address deleted successfully');
        } else {
            Toastr::error('Error', 'IP record not found');
        }
        return redirect()->back();
    }
}
