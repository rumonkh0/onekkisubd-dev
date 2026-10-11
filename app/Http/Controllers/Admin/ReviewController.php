<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Product;
use App\Models\Review;
use App\Models\Customer;
use Illuminate\Support\Facades\File;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with('product.image');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('ratting')) {
            $query->where('ratting', $request->ratting);
        }

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%")
                  ->orWhere('review', 'like', "%{$keyword}%");
            });
        }

        $show_data = $query->orderBy('id', 'DESC')->get();

        // Calculate statistics
        $total_reviews = Review::count();
        $active_reviews = Review::where('status', 'active')->count();
        $pending_reviews = Review::where('status', 'pending')->count();
        $avg_rating = Review::where('status', 'active')->avg('ratting') ?: 0;
        $products = Product::where('status', 1)->select('id', 'name')->orderBy('name')->get();

        return view('backEnd.review.index', compact('show_data', 'total_reviews', 'active_reviews', 'pending_reviews', 'avg_rating', 'products'));
    }

    public function create()
    {
        $products = Product::where('status', 1)->select('id', 'name')->orderBy('name')->get();
        $customers = Customer::where('status', 'active')->select('id', 'name', 'email', 'phone')->get();
        return view('backEnd.review.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'nullable|string|max:191',
            'customer_name' => 'nullable|string|max:191',
            'email' => 'nullable|string|max:191',
            'customer_email' => 'nullable|string|max:191',
            'ratting' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $name = $request->name ?: ($request->customer_name ?: 'Anonymous Customer');
        $email = $request->email ?: ($request->customer_email ?: 'N/A');

        $review = new Review();
        $review->name = $name;
        $review->email = $email;
        $review->ratting = $request->ratting;
        $review->review = $request->review;
        $review->product_id = $request->product_id;
        $review->customer_id = $request->customer_id ?: null;

        if ($request->file('image')) {
            $image = $request->file('image');
            $imageName = microtime('.') . '.' . $image->getClientOriginalExtension();
            $imagePath = 'public/uploads/review/';
            if (!File::isDirectory(base_path($imagePath)) && !File::isDirectory(public_path('uploads/review'))) {
                File::makeDirectory(public_path('uploads/review'), 0777, true, true);
            }
            $image->move($imagePath, $imageName);
            $review->image = $imagePath . $imageName;
        }

        $review->status = ($request->status == 1 || $request->status === 'active') ? 'active' : 'pending';
        $review->save();

        Toastr::success('Success', 'Review created successfully');
        return redirect()->route('reviews.index');
    }

    public function edit($id)
    {
        $edit_data = Review::findOrFail($id);
        $products = Product::where('status', 1)->select('id', 'name')->orderBy('name')->get();
        return view('backEnd.review.edit', compact('edit_data', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'nullable|string|max:191',
            'ratting' => 'required|integer|min:1|max:5',
            'product_id' => 'required|exists:products,id',
            'review' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $review = Review::findOrFail($id);
        $review->name = $request->name;
        $review->email = $request->email ?: 'N/A';
        $review->ratting = $request->ratting;
        $review->review = $request->review;
        $review->product_id = $request->product_id;

        if ($request->file('image')) {
            $image = $request->file('image');

            // Remove old image safely
            if (!empty($review->image)) {
                $cleanPath = public_path(str_replace('public/', '', $review->image));
                if (file_exists($cleanPath)) {
                    @unlink($cleanPath);
                } elseif (file_exists($review->image)) {
                    @unlink($review->image);
                }
            }

            $imageName = microtime('.') . '.' . $image->getClientOriginalExtension();
            $imagePath = 'public/uploads/review/';
            if (!File::isDirectory(base_path($imagePath)) && !File::isDirectory(public_path('uploads/review'))) {
                File::makeDirectory(public_path('uploads/review'), 0777, true, true);
            }
            $image->move($imagePath, $imageName);
            $review->image = $imagePath . $imageName;
        }

        $review->status = ($request->status == 1 || $request->status === 'active') ? 'active' : 'pending';
        $review->save();

        Toastr::success('Success', 'Review updated successfully');
        return redirect()->route('reviews.index');
    }

    public function pending()
    {
        $data = Review::with('product.image')->where('status', 'pending')->orderBy('id', 'DESC')->get();
        return view('backEnd.review.pending', compact('data'));
    }

    public function inactive(Request $request)
    {
        $inactive = Review::find($request->hidden_id);
        if ($inactive) {
            $inactive->status = 'pending';
            $inactive->save();
            Toastr::success('Success', 'Review moved to pending successfully');
        } else {
            Toastr::error('Error', 'Review not found');
        }
        return redirect()->back();
    }

    public function active(Request $request)
    {
        $active = Review::find($request->hidden_id);
        if ($active) {
            $active->status = 'active';
            $active->save();
            Toastr::success('Success', 'Review approved and activated successfully');
        } else {
            Toastr::error('Error', 'Review not found');
        }
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $delete_data = Review::find($request->hidden_id);
        if ($delete_data) {
            if (!empty($delete_data->image)) {
                $cleanPath = public_path(str_replace('public/', '', $delete_data->image));
                if (file_exists($cleanPath)) {
                    @unlink($cleanPath);
                } elseif (file_exists($delete_data->image)) {
                    @unlink($delete_data->image);
                }
            }
            $delete_data->delete();
            Toastr::success('Success', 'Review deleted successfully');
        } else {
            Toastr::error('Error', 'Review not found');
        }
        return redirect()->back();
    }
}
