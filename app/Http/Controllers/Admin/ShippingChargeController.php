<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingCharge;
use Toastr;

class ShippingChargeController extends Controller
{    
    function __construct()
    {
        $this->middleware('permission:shipping-list|shipping-create|shipping-edit|shipping-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:shipping-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:shipping-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:shipping-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $show_data = ShippingCharge::orderBy('id', 'ASC')->get();
        $total_charges = $show_data->count();
        $active_charges = $show_data->where('status', 1)->count();
        $inactive_charges = $show_data->where('status', 0)->count();

        return view('backEnd.shippingcharge.index', compact('show_data', 'total_charges', 'active_charges', 'inactive_charges'));
    }

    public function create()
    {
        return view('backEnd.shippingcharge.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'amount' => 'required|numeric|min:0',
        ]);        

        $shipping = new ShippingCharge();
        $shipping->name = $request->name;
        $shipping->amount = $request->amount;
        $shipping->status = ($request->status == 1 || $request->status == 'on') ? 1 : 0;
        $shipping->save();

        Toastr::success('Success', 'Shipping charge created successfully');
        return redirect()->route('shippingcharges.index');
    }

    public function edit($id)
    {
        $edit_data = ShippingCharge::findOrFail($id);
        return view('backEnd.shippingcharge.edit', compact('edit_data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:shipping_charges,id',
            'name' => 'required|string|max:191',
            'amount' => 'required|numeric|min:0',
        ]);

        $update_data = ShippingCharge::findOrFail($request->id);
        $update_data->name = $request->name;
        $update_data->amount = $request->amount;
        $update_data->status = ($request->status == 1 || $request->status == 'on') ? 1 : 0;
        $update_data->save();

        Toastr::success('Success', 'Shipping charge updated successfully');
        return redirect()->route('shippingcharges.index');
    }

    public function inactive(Request $request)
    {
        $inactive = ShippingCharge::find($request->hidden_id);
        if ($inactive) {
            $inactive->status = 0;
            $inactive->save();
            Toastr::success('Success', 'Shipping charge deactivated successfully');
        } else {
            Toastr::error('Error', 'Shipping charge not found');
        }
        return redirect()->back();
    }

    public function active(Request $request)
    {
        $active = ShippingCharge::find($request->hidden_id);
        if ($active) {
            $active->status = 1;
            $active->save();
            Toastr::success('Success', 'Shipping charge activated successfully');
        } else {
            Toastr::error('Error', 'Shipping charge not found');
        }
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $delete_data = ShippingCharge::find($request->hidden_id);
        if ($delete_data) {
            $delete_data->delete();
            Toastr::success('Success', 'Shipping charge deleted successfully');
        } else {
            Toastr::error('Error', 'Shipping charge not found');
        }
        return redirect()->back();
    }
}
