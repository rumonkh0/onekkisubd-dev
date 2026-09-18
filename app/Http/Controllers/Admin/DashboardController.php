<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Deposit;
use App\Models\Expense;
use Carbon\Carbon;
use Session;
use Toastr;
use Auth;
use DB;
class DashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth')->except(['locked','unlocked']);
    }
    public function dashboard(Request $request){
        $total_order = Order::count();
        $today_order = Order::where('created_at', '>=', Carbon::today())->count();
        $total_product = Product::count();
        $total_customer = Customer::count();
        $latest_order = Order::latest()->limit(5)->with('customer','product','product.image')->get();
        $latest_customer = Customer::latest()->limit(5)->get();
        $today_delivery = Order::where(['order_status'=>'5'])->where('created_at', '>=', Carbon::today())->count();
        $total_delivery = Order::where(['order_status'=>'5'])->count();
        $last_week = Order::where(['order_status'=>'5'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $last_month = Order::where(['order_status'=>'5'])->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count();
        $monthly_sale = Order::select(DB::raw('DATE(created_at) as date','created_at'))->selectRaw("SUM(amount) as amount")->where(['order_status'=>'5'])->groupBy('date')->limit(30)->get();

        // order
        $pending_order = Order::where(['order_status' => '1'])->count();
        $confirm_order = Order::where(['order_status' => '2'])->count();
        $pre_order = Order::where(['order_status' => '3'])->count();
        $shipped_courier = Order::where(['order_status' => '5'])->count();
        $return_order = Order::where(['order_status' => '8'])->count();
        $delivery_done_order = Order::where(['order_status' => '6'])->count();
        $total_cancel_order = Order::where(['order_status' => '4'])->count();

        // inventory
        $categories = Category::where('status',1)->get();

        // accounts
        // deposit
        $courier_payment = Deposit::where(['status' => 1, 'deposit_type' => 1])->sum('amount');
        $officesale_payment = Deposit::where(['status' => 1, 'deposit_type' => 2])->sum('amount');
        $expense_others = Deposit::where(['status' => 1, 'deposit_type' => 3])->sum('amount');
        $total_payment = Deposit::where(['status' => 1])->sum('amount');
        // expense
        $boost_cost = Expense::where(['status' => 1, 'expense_type' => 1])->sum('amount');
        $office_cost = Expense::where(['status' => 1, 'expense_type' => 2])->sum('amount');
        $bank_deposit = Expense::where(['status' => 1, 'expense_type' => 3])->sum('amount');
        $packaging_cost = Expense::where(['status' => 1, 'expense_type' => 4])->sum('amount');
        $transport_cost = Expense::where(['status' => 1, 'expense_type' => 5])->sum('amount');
        $others_expense_cost = Expense::where(['status' => 1, 'expense_type' => 6])->sum('amount');
        $total_cost = Expense::where(['status' => 1])->sum('amount');

        $account_balance = $total_payment - $total_cost;


        // account filtering
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        if (!$startDate || !$endDate) {
            $startDate = now()->startOfMonth()->toDateString();
            $endDate = now()->endOfMonth()->toDateString();
        }

        // accounts
        // deposit
        $courier_payment = Deposit::where(['status'=>1,'deposit_type' => 1])->whereBetween('date', [$startDate, $endDate])->sum('amount');
        $officesale_payment = Deposit::where(['status' => 1, 'deposit_type' => 2])->whereBetween('date', [$startDate, $endDate])->sum('amount');
        $expense_others = Deposit::where(['status' => 1, 'deposit_type' => 3])->whereBetween('date', [$startDate, $endDate])->sum('amount');
        $total_payment = Deposit::where(['status' => 1])->whereBetween('date', [$startDate, $endDate])->sum('amount');
        // expense
        $boost_cost = Expense::where(['status' => 1, 'expense_type' => 1])->whereBetween('date', [$startDate, $endDate])->sum('amount');
        $office_cost = Expense::where(['status' => 1, 'expense_type' => 2])->whereBetween('date', [$startDate, $endDate])->sum('amount');
        $bank_deposit = Expense::where(['status' => 1, 'expense_type' => 3])->whereBetween('date', [$startDate, $endDate])->sum('amount');
        $packaging_cost = Expense::where(['status' => 1, 'expense_type' => 4])->whereBetween('date', [$startDate, $endDate])->sum('amount');
        $transport_cost = Expense::where(['status' => 1, 'expense_type' => 5])->whereBetween('date', [$startDate, $endDate])->sum('amount');
        $others_expense_cost = Expense::where(['status' => 1, 'expense_type' => 6])->whereBetween('date', [$startDate, $endDate])->sum('amount');
        $total_cost = Expense::where(['status' => 1])->whereBetween('date', [$startDate, $endDate])->sum('amount');

        return view('backEnd.admin.dashboard',compact('total_order','today_order','total_product','total_customer','latest_order','latest_customer','today_delivery','total_delivery','last_week','last_month','monthly_sale', 'pending_order', 'pre_order', 'confirm_order', 'shipped_courier', 'return_order', 'delivery_done_order', 'total_cancel_order','categories', 'courier_payment', 'officesale_payment', 'expense_others', 'total_payment', 'boost_cost', 'office_cost', 'bank_deposit', 'packaging_cost', 'transport_cost', 'others_expense_cost', 'total_cost', 'account_balance'));
    }
    public function changepassword(){
        return view('backEnd.admin.changepassword');
    }
     public function newpassword(Request $request)
    {
        $this->validate($request, [
            'old_password'=>'required',
            'new_password'=>'required',
            'confirm_password' => 'required_with:new_password|same:new_password|'
        ]);

        $user = User::find(Auth::id());
        $hashPass = $user->password;

        if (Hash::check($request->old_password, $hashPass)) {

            $user->fill([
                'password' => Hash::make($request->new_password)
            ])->save();

            Toastr::success('Success', 'Password changed successfully!');
            return redirect()->route('dashboard');
        }else{
            Toastr::error('Failed', 'Old password not match!');
            return back();
        }
    }
    public function locked(){
        // only if user is logged in

            Session::put('locked', true);
            return view('backEnd.auth.locked');


        return redirect()->route('login');
    }

    public function unlocked(Request $request)
    {
        if(!Auth::check())
            return redirect()->route('login');
        $password = $request->password;
        if(Hash::check($password,Auth::user()->password)){
            Session::forget('locked');
            Toastr::success('Success', 'You are logged in successfully!');
            return redirect()->route('dashboard');
        }
        Toastr::error('Failed', 'Your password not match!');
        return back();
    }
}
