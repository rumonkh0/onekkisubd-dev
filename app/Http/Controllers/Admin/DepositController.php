<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Toastr;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Deposit::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        if ($request->filled('deposit_type')) {
            $query->where('deposit_type', $request->deposit_type);
        }

        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->orderBy('date', 'desc')->orderBy('id', 'desc')->get();

        $total_amount = $data->sum('amount');
        $active_amount = $data->where('status', 1)->sum('amount');
        $active_count = $data->where('status', 1)->count();
        $total_count = $data->count();

        return view('backEnd.deposit.index', compact('data', 'total_amount', 'active_amount', 'active_count', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backEnd.deposit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'amount' => 'required|numeric',
            'deposit_type' => 'required',
            'payment_type' => 'required',
        ]);

        $deposit = new Deposit();
        $deposit->title = $request->title;
        $deposit->amount = $request->amount;
        $deposit->deposit_type = $request->deposit_type;
        $deposit->payment_type = $request->payment_type;
        $deposit->date = $request->date ? $request->date : Carbon::now()->toDateString();
        $deposit->status = $request->status ? 1 : 0;

        if ($request->file('file')) {
            $image = $request->file('file');

            $imageName          = microtime('.') . '.' . $image->getClientOriginalExtension();
            $imagePath          = 'public/backEnd/images/deposit/';
            $image->move($imagePath, $imageName);

            $deposit->file   = $imagePath . $imageName;
        }
        $deposit->save();
        Toastr::success('Success', 'Data insert successfully');
        return redirect()->route('deposit.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $deposit = Deposit::find($id);
        if (!$deposit) {
            Toastr::error('Error', 'Deposit not found');
            return redirect()->route('deposit.index');
        }
        return view('backEnd.deposit.edit', compact('deposit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'amount' => 'required|numeric',
            'deposit_type' => 'required',
            'payment_type' => 'required',
        ]);

        $deposit = Deposit::find($id);
        if (!$deposit) {
            Toastr::error('Error', 'Deposit not found');
            return redirect()->route('deposit.index');
        }

        $deposit->title = $request->title;
        $deposit->amount = $request->amount;
        $deposit->deposit_type = $request->deposit_type;
        $deposit->payment_type = $request->payment_type;
        $deposit->date = $request->date ? $request->date : ($deposit->date ?? Carbon::now()->toDateString());
        $deposit->status = $request->status ? 1 : 0;

        if ($request->file('file')) {
            $image = $request->file('file');

            if (!is_null($deposit->file) && file_exists($deposit->file)) {
                unlink($deposit->file);
            }

            $imageName          = microtime('.') . '.' . $image->getClientOriginalExtension();
            $imagePath          = 'public/backEnd/images/deposit/';
            $image->move($imagePath, $imageName);

            $deposit->file   = $imagePath . $imageName;
        }
        $deposit->save();
        Toastr::success('Success', 'Data update successfully');
        return redirect()->route('deposit.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deposit = Deposit::find($id);
        if ($deposit) {
            if (!is_null($deposit->file) && file_exists($deposit->file)) {
                unlink($deposit->file);
            }

            $deposit->delete();
            Toastr::success('Success', 'Data delete successfully');
        } else {
            Toastr::error('Error', 'Deposit not found');
        }
        return redirect()->route('deposit.index');
    }
}
