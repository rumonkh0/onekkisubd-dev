<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Product;
use App\Models\Review;
use App\Models\Customer;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class ReviewController extends Controller
{
    protected function ensureUploadDirectory(): string
    {
        $imagePath = 'public/uploads/review/';
        if (!File::isDirectory(base_path($imagePath)) && !File::isDirectory(public_path('uploads/review'))) {
            File::makeDirectory(public_path('uploads/review'), 0777, true, true);
        }
        return $imagePath;
    }

    protected function removeStoredFile(?string $filePath): void
    {
        if (empty($filePath)) {
            return;
        }
        $cleanPath = public_path(str_replace('public/', '', $filePath));
        if (file_exists($cleanPath) && is_file($cleanPath)) {
            @unlink($cleanPath);
        } elseif (file_exists($filePath) && is_file($filePath)) {
            @unlink($filePath);
        }
    }

    protected function extractAttachmentFiles(Request $request): array
    {
        $files = [];
        foreach (['image', 'review_images', 'attachment'] as $field) {
            if ($request->hasFile($field)) {
                $uploaded = $request->file($field);
                if (is_array($uploaded)) {
                    foreach ($uploaded as $file) {
                        if ($file) {
                            $files[] = $file;
                        }
                    }
                } elseif ($uploaded) {
                    $files[] = $uploaded;
                }
            }
        }
        return $files;
    }

    protected function buildAttachmentValidationRules(Request $request): array
    {
        $rules = [
            'reviewer_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ];

        foreach (['image', 'review_images', 'attachment'] as $field) {
            if (is_array($request->file($field))) {
                $rules[$field] = 'nullable|array';
                $rules[$field . '.*'] = 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048';
            } else {
                $rules[$field] = 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048';
            }
        }

        return $rules;
    }
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

    public function create(Request $request)
    {
        $products = Product::where('status', 1)->select('id', 'name')->orderBy('name')->get();
        $customers = Customer::where('status', 'active')->select('id', 'name', 'email', 'phone')->get();
        $selected_product_id = $request->get('product_id');
        return view('backEnd.review.create', compact('products', 'customers', 'selected_product_id'));
    }

    public function store(Request $request)
    {
        $request->validate(array_merge([
            'product_id' => 'required|exists:products,id',
            'name' => 'nullable|string|max:191',
            'customer_name' => 'nullable|string|max:191',
            'email' => 'nullable|string|max:191',
            'customer_email' => 'nullable|string|max:191',
            'ratting' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
            'created_at' => 'nullable|date',
        ], $this->buildAttachmentValidationRules($request)));

        $name = $request->name ?: ($request->customer_name ?: 'Verified Customer');
        $email = $request->email ?: ($request->customer_email ?: 'N/A');

        $review = new Review();
        $review->name = $name;
        $review->email = $email;
        $review->ratting = $request->ratting;
        $review->review = $request->review;
        $review->product_id = $request->product_id;
        $review->customer_id = $request->customer_id ?: null;

        $imagePath = $this->ensureUploadDirectory();

        if ($request->hasFile('reviewer_image')) {
            $reviewerImg = $request->file('reviewer_image');
            $reviewerImgName = 'reviewer_' . time() . '_' . uniqid() . '.' . $reviewerImg->getClientOriginalExtension();
            $reviewerImg->move($imagePath, $reviewerImgName);
            if (Schema::hasColumn('reviews', 'reviewer_image')) {
                $review->reviewer_image = $imagePath . $reviewerImgName;
            }
        }

        $attachmentFiles = $this->extractAttachmentFiles($request);
        if (count($attachmentFiles) > 0) {
            $storedPaths = [];
            foreach ($attachmentFiles as $idx => $file) {
                $fileName = 'review_' . time() . '_' . uniqid() . '_' . $idx . '.' . $file->getClientOriginalExtension();
                $file->move($imagePath, $fileName);
                $storedPaths[] = $imagePath . $fileName;
            }
            $review->image = $storedPaths[0];
            if (Schema::hasColumn('reviews', 'review_images')) {
                $review->review_images = json_encode($storedPaths);
            }
        }

        $review->status = ($request->status == 1 || $request->status === 'active' || !isset($request->status)) ? 'active' : 'pending';

        if ($request->filled('created_at')) {
            $review->created_at = \Carbon\Carbon::parse($request->created_at);
        }

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
        $request->validate(array_merge([
            'name' => 'required|string|max:191',
            'email' => 'nullable|string|max:191',
            'ratting' => 'required|integer|min:1|max:5',
            'product_id' => 'required|exists:products,id',
            'review' => 'required|string',
            'created_at' => 'nullable|date',
        ], $this->buildAttachmentValidationRules($request)));

        $review = Review::findOrFail($id);
        $review->name = $request->name;
        $review->email = $request->email ?: 'N/A';
        $review->ratting = $request->ratting;
        $review->review = $request->review;
        $review->product_id = $request->product_id;

        $imagePath = $this->ensureUploadDirectory();

        if ($request->hasFile('reviewer_image')) {
            $this->removeStoredFile($review->reviewer_image);
            $reviewerImg = $request->file('reviewer_image');
            $reviewerImgName = 'reviewer_' . time() . '_' . uniqid() . '.' . $reviewerImg->getClientOriginalExtension();
            $reviewerImg->move($imagePath, $reviewerImgName);
            if (Schema::hasColumn('reviews', 'reviewer_image')) {
                $review->reviewer_image = $imagePath . $reviewerImgName;
            }
        }

        $attachmentFiles = $this->extractAttachmentFiles($request);
        if (count($attachmentFiles) > 0) {
            foreach ($review->attachment_images as $oldPath) {
                $this->removeStoredFile($oldPath);
            }
            $storedPaths = [];
            foreach ($attachmentFiles as $idx => $file) {
                $fileName = 'review_' . time() . '_' . uniqid() . '_' . $idx . '.' . $file->getClientOriginalExtension();
                $file->move($imagePath, $fileName);
                $storedPaths[] = $imagePath . $fileName;
            }
            $review->image = $storedPaths[0];
            if (Schema::hasColumn('reviews', 'review_images')) {
                $review->review_images = json_encode($storedPaths);
            }
        }

        $review->status = ($request->status == 1 || $request->status === 'active') ? 'active' : 'pending';

        if ($request->filled('created_at')) {
            $review->created_at = \Carbon\Carbon::parse($request->created_at);
        }

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
            $this->removeStoredFile($delete_data->reviewer_image);
            foreach ($delete_data->attachment_images as $attPath) {
                $this->removeStoredFile($attPath);
            }
            $delete_data->delete();
            Toastr::success('Success', 'Review deleted successfully');
        } else {
            Toastr::error('Error', 'Review not found');
        }
        return redirect()->back();
    }
}
