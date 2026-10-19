<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Productimage;
use App\Models\Productprice;
use App\Models\Productcolor;
use App\Models\Productsize;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Childcategory;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use Carbon\Carbon;
use Toastr;
use File;
use Str;
use Image;
use DB;

class ProductController extends Controller
{
    public function getSubcategory(Request $request)
    {
        $subcategory = DB::table("subcategories")
            ->where("category_id", $request->category_id)
            ->pluck('subcategoryName', 'id');
        return response()->json($subcategory);
    }
    public function getChildcategory(Request $request)
    {
        $childcategory = DB::table("childcategories")
            ->where("subcategory_id", $request->subcategory_id)
            ->pluck('childcategoryName', 'id');
        return response()->json($childcategory);
    }


    function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }


    public function index(Request $request)
    {
        if ($request->keyword) {
            $data = Product::orderBy('id', 'DESC')->where('name', 'LIKE', '%' . $request->keyword . "%")->with('image', 'category')->paginate(50);
        } else {
            $data = Product::orderBy('id', 'DESC')->with('image', 'category')->paginate(50);
        }
        return view('backEnd.product.index', compact('data'));
    }
    public function create()
    {
        $categories = Category::where('parent_id', '=', '0')->where('status', 1)->select('id', 'name', 'status')->with('childrenCategories')->get();
        $brands = Brand::where('status', '1')->select('id', 'name', 'status')->get();
        $colors = Color::where('status', '1')->get();
        $sizes = Size::where('status', '1')->get();
        return view('backEnd.product.create', compact('categories', 'brands', 'colors', 'sizes'));
    }
    public function store(Request $request)
    {
        // return $request;
        $last_id = Product::orderBy('id', 'desc')->select('id')->first();
        $last_id = $last_id ? $last_id->id + 1 : 1;
        $input['slug'] = strtolower(preg_replace('/[\/\s]+/', '-', $request->name . '-' . $last_id));
        $product = new Product();
        $product->name = $request->name;
        $product->slug = $input['slug'];
        $product->product_code = $request->product_code;
        $product->brand_id = $request->brand_id;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->childcategory_id = $request->childcategory_id;
        $product->purchase_price = $request->purchase_price;
        $product->old_price = $request->old_price;
        $product->new_price = $request->new_price;
        if ($request->size && is_array($request->size) && count($request->size) > 0) {
            $product->stock = collect($request->size)->sum('quantity');
        } else {
            $product->stock = $request->stock ?? 0;
        }
        $product->pro_unit = $request->pro_unit;
        $product->pro_video = $request->pro_video;
        $product->description = $request->description;
        $product->short_des = $request->short_des;
        $product->prebooking = $request->prebooking;
        $product->status = $request->status ? 1 : 0;
        $product->topsale = $request->topsale ? 1 : 0;
        $product->feature_product = $request->feature_product ? 1 : 0;
        $product->deal_of_theday = $request->deal_of_theday ? 1 : 0;
        $product->type = $request->type;

        if ($request->hasFile('PostImage')) {
            $imageData = [];
            $targetDirS = public_path('images/product/slider');
            if (!File::isDirectory($targetDirS)) {
                File::makeDirectory($targetDirS, 0775, true, true);
            }
            foreach ($request->file('PostImage') as $imgfiles) {
                if ($imgfiles && $imgfiles instanceof \Illuminate\Http\UploadedFile) {
                    $name = time() . "_" . $imgfiles->getClientOriginalName();
                    $name = strtolower(preg_replace('/\s+/', '-', $name));
                    $imgfiles->move($targetDirS, $name);
                    $imageData[] = $name;
                }
            }
            if (!empty($imageData)) {
                $product->PostImage = json_encode($imageData);
            }
        }

        $result = $product->save();

        if ($request->variant) {
            $variants = $request->variant;
        }
        if ($request->size) {
            $sizes = $request->size;
        }


        $time = microtime('.') * 10000;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image && $image instanceof \Illuminate\Http\UploadedFile) {
                $name =  time() . '-' . $image->getClientOriginalName();
                $name = strtolower(preg_replace('/\s+/', '-', $name));
                $targetDir = public_path('uploads/product');
                if (!File::isDirectory($targetDir)) {
                    File::makeDirectory($targetDir, 0775, true, true);
                }
                $image->move($targetDir, $name);
                $imageUrl = 'public/uploads/product/' . $name;

                $pimage             = new Productimage();
                $pimage->product_id = $product->id;
                $pimage->image      = $imageUrl;
                $pimage->save();
            }
        } elseif (!empty($imageData) && isset($imageData[0])) {
            $pimage             = new Productimage();
            $pimage->product_id = $product->id;
            $pimage->image      = 'public/images/product/slider/' . $imageData[0];
            $pimage->save();
        }

        if ($result) {
            if (!empty($variants)) {
                foreach ($variants as $vr) {
                    $variant = new Productcolor();
                    $variant->product_id = $product->id;
                    $variant->color_id = $vr['mediaID'] ?? null;
                    $variant->color = $vr['color'] ?? null;
                    $variantImg = $vr['image'] ?? null;
                    if ($variantImg && $variantImg instanceof \Illuminate\Http\UploadedFile) {
                        $imgnamev = $time . $variantImg->getClientOriginalName();
                        $imgnamev = strtolower(preg_replace('/\s+/', '-', $imgnamev));
                        $targetDirV = public_path('images/variant');
                        if (!File::isDirectory($targetDirV)) {
                            File::makeDirectory($targetDirV, 0775, true, true);
                        }
                        $variantImg->move($targetDirV, $imgnamev);
                        $variantImgUrl = 'public/images/variant/' . $imgnamev;
                        $variant->Image = $variantImgUrl;
                    }
                    $variant->save();
                }
            }
            if (!empty($sizes)) {
                foreach ($sizes as $si) {
                    $size = new Productsize();
                    $size->product_id = $product->id;
                    // $size->size_id = $si['sizeID'];
                    $size->size_id = !empty($si['sizeID']) ? $si['sizeID'] : 0;
                    $size->size = $si['size'];
                    $size->quantity = $si['quantity'];
                    $size->RegularPrice = $si['RegularPrice'];
                    $size->Discount = $si['Discount'];
                    $size->SalePrice = $si['RegularPrice'] - $si['Discount'];
                    $size->save();
                }
            }
        }

        $response['status'] = 'success';
        $response['message'] = 'Product Create Sucessfully';
        return json_encode($response);
        die();
    }

    public function edit($id)
    {
        $edit_data = Product::with('images')->find($id);
        $categories = Category::where('parent_id', '=', '0')->where('status', 1)->select('id', 'name', 'status')->get();
        $categoryId = Product::find($id)->category_id;
        $subcategoryId = Product::find($id)->subcategory_id;
        $subcategory = Subcategory::where('category_id', '=', $categoryId)->select('id', 'subcategoryName', 'status')->get();
        $childcategory = Childcategory::where('subcategory_id', '=', $subcategoryId)->select('id', 'childcategoryName', 'status')->get();
        $brands = Brand::where('status', '1')->select('id', 'name', 'status')->get();
        $totalsizes = Size::where('status', 1)->get();
        $totalcolors = Color::where('status', 1)->get();
        $varients = Productcolor::where('product_id', $id)->get();
        $sizes = Productsize::where('product_id', $id)->get();
        return view('backEnd.product.edit', compact('edit_data', 'categories', 'subcategory', 'childcategory', 'brands', 'varients', 'sizes', 'totalsizes', 'totalcolors'));
    }


    public function removevarient($id)
    {
        $variant = Productcolor::where('id', $id)->first();
        if ($variant) {
            $variant->delete();
        }
        $response['status'] = 'success';
        $response['message'] = 'Colour Varient Remove Sucessfully';
        return json_encode($response);
        die();
    }
    public function removesize($id)
    {
        $size = Productsize::where('id', $id)->first();
        if ($size) {
            $size->delete();
        }
        $response['status'] = 'success';
        $response['message'] = 'Size /Weight Remove Sucessfully';
        return json_encode($response);
        die();
    }


    public function price_edit(Request $request)
    {
        $query = Product::where('status', 1)->with('prosizes');

        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                  ->orWhere('pro_unit', 'LIKE', "%{$keyword}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->orderBy('id', 'desc')->paginate(30)->withQueryString();
        $categories = Category::where('status', 1)->select('id', 'name')->get();

        return view('backEnd.product.price_edit', compact('products', 'categories'));
    }

    public function price_update(Request $request)
    {
        // 1. Update simple product prices & stock
        if ($request->has('ids') && is_array($request->ids)) {
            $oldPrices = $request->old_price ?? [];
            $newPrices = $request->new_price ?? [];
            $stocks = $request->stock ?? [];

            foreach ($request->ids as $key => $id) {
                $product = Product::find($id);
                if ($product) {
                    $updateData = [];
                    if (isset($oldPrices[$key])) {
                        $updateData['old_price'] = (float) $oldPrices[$key];
                    }
                    if (isset($newPrices[$key])) {
                        $updateData['new_price'] = (float) $newPrices[$key];
                    }
                    if (isset($stocks[$key])) {
                        $updateData['stock'] = (int) $stocks[$key];
                    }
                    if (!empty($updateData)) {
                        $product->update($updateData);
                    }
                }
            }
        }

        // 2. Update variant / size prices & stock
        if ($request->has('size_ids') && is_array($request->size_ids)) {
            $sizeRegularPrices = $request->size_regular_price ?? [];
            $sizeSalePrices = $request->size_sale_price ?? [];
            $sizeQuantities = $request->size_quantity ?? [];

            foreach ($request->size_ids as $key => $sizeId) {
                $size = Productsize::find($sizeId);
                if ($size) {
                    $size->update([
                        'RegularPrice' => isset($sizeRegularPrices[$key]) ? (float) $sizeRegularPrices[$key] : $size->RegularPrice,
                        'SalePrice' => isset($sizeSalePrices[$key]) ? (float) $sizeSalePrices[$key] : $size->SalePrice,
                        'quantity' => isset($sizeQuantities[$key]) ? (int) $sizeQuantities[$key] : $size->quantity,
                    ]);
                }
            }

            // Sync lowest prices and total stock from sizes back to parent products
            $parentProductIds = Productsize::whereIn('id', $request->size_ids)->pluck('product_id')->unique();
            foreach ($parentProductIds as $parentId) {
                $parent = Product::find($parentId);
                if ($parent) {
                    $minSalePrice = Productsize::where('product_id', $parentId)->min('SalePrice');
                    $minRegularPrice = Productsize::where('product_id', $parentId)->min('RegularPrice');
                    $totalStock = Productsize::where('product_id', $parentId)->sum('quantity');

                    $syncData = [];
                    if ($minSalePrice !== null) {
                        $syncData['new_price'] = $minSalePrice;
                    }
                    if ($minRegularPrice !== null) {
                        $syncData['old_price'] = $minRegularPrice;
                    }
                    if ($totalStock !== null && $totalStock > 0) {
                        $syncData['stock'] = $totalStock;
                    }

                    if (!empty($syncData)) {
                        $parent->update($syncData);
                    }
                }
            }
        }

        Toastr::success('Product prices & stock updated successfully!', 'Success');
        return redirect()->back();
    }


    public function variant(Request $request)
    {
        if (isset($request['q'])) {
            $variants = Color::query()->where('colorName', 'like', '%' . $request['q'] . '%')->where('status', 1)->get();
        } else {
            $variants = Color::where('status', '1')->get();
        }
        $variant = array();
        foreach ($variants as $item) {
            $variant[] = array(
                "id" => $item['id'],
                "text" => $item['colorName']
            );
        }
        $data['data'] = $variant;
        return json_encode($data);
        die();
    }

    public function sizeweight(Request $request)
    {
        if (isset($request['q'])) {
            $variants = Size::query()->where('sizeName', 'like', '%' . $request['q'] . '%')->where('status', 1)->get();
        } else {
            $variants = Size::where('status', 1)->get();
        }
        $variant = array();
        foreach ($variants as $item) {
            $variant[] = array(
                "id" => $item['id'],
                "text" => $item['sizeName']
            );
        }
        $data['data'] = $variant;
        return json_encode($data);
        die();
    }


    public function update(Request $request)
    {
        $product = Product::find($request->product_id);
        $product->name = $request->name;
        $product->product_code = $request->product_code;
        $product->brand_id = $request->brand_id;
        $product->category_id = $request->category_id;
        if ($request->subcategory_id == 'null') {
        } else {
            $product->subcategory_id = $request->subcategory_id;
        }
        if ($request->childcategory_id == 'null') {
        } else {
            $product->childcategory_id = $request->childcategory_id;
        }
        $product->purchase_price = $request->purchase_price;
        $product->old_price = $request->old_price;
        $product->new_price = $request->new_price;
        if ($request->size && is_array($request->size) && count($request->size) > 0) {
            $product->stock = collect($request->size)->sum('quantity');
        } else {
            $product->stock = $request->stock ?? 0;
        }
        $product->pro_unit = $request->pro_unit;
        $product->pro_video = $request->pro_video;
        $product->description = $request->description;
        $product->short_des = $request->short_des;
        $product->prebooking = $request->prebooking;
        $product->status = $request->status ? 1 : 0;
        $product->topsale = $request->topsale ? 1 : 0;
        $product->feature_product = $request->feature_product ? 1 : 0;
        $product->deal_of_theday = $request->deal_of_theday ? 1 : 0;
        $product->type = $request->type;
        $product->updated_at = Carbon::now();

        if ($request->hasFile('PostImage')) {
            $imageData = [];
            $targetDirS = public_path('images/product/slider');
            if (!File::isDirectory($targetDirS)) {
                File::makeDirectory($targetDirS, 0775, true, true);
            }
            foreach ($request->file('PostImage') as $imgfiles) {
                if ($imgfiles && $imgfiles instanceof \Illuminate\Http\UploadedFile) {
                    $name = time() . "_" . $imgfiles->getClientOriginalName();
                    $name = strtolower(preg_replace('/\s+/', '-', $name));
                    $imgfiles->move($targetDirS, $name);
                    $imageData[] = $name;
                }
            }
            if (!empty($imageData)) {
                $product->PostImage = json_encode($imageData);
            }
        };


        $result = $product->update();

        if ($request->variant) {
            $variants = $request->variant;
        }
        if ($request->size) {
            $sizes = $request->size;
        }
        $time = microtime('.') * 10000;

        $image = $request->file('image');

        if ($request->hasFile('image') && $image instanceof \Illuminate\Http\UploadedFile) {
            Productimage::where('product_id', $product->id)->delete();
            $name =  time() . '-' . $image->getClientOriginalName();
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $targetDir = public_path('uploads/product');
            if (!File::isDirectory($targetDir)) {
                File::makeDirectory($targetDir, 0775, true, true);
            }
            $image->move($targetDir, $name);
            $imageUrl = 'public/uploads/product/' . $name;
            $pimage             = new Productimage();
            $pimage->product_id = $product->id;
            $pimage->image      = $imageUrl;
            $pimage->save();
        } elseif (!Productimage::where('product_id', $product->id)->exists() && !empty($imageData) && isset($imageData[0])) {
            $pimage             = new Productimage();
            $pimage->product_id = $product->id;
            $pimage->image      = 'public/images/product/slider/' . $imageData[0];
            $pimage->save();
        }

        if ($result) {
            if (!empty($variants)) {
                foreach ($variants as $vr) {
                    if (!empty($vr['mID']) && ($variant = Productcolor::where('id', $vr['mID'])->first())) {
                        $variant->product_id = $product->id;
                        $variant->color_id = $vr['mediaID'] ?? null;
                        $variant->color = $vr['color'] ?? null;
                        $variantImg = $vr['image'] ?? null;
                        if ($variantImg && $variantImg instanceof \Illuminate\Http\UploadedFile) {
                            $imgnamev = $time . $variantImg->getClientOriginalName();
                            $imgnamev = strtolower(preg_replace('/\s+/', '-', $imgnamev));
                            $targetDirV = public_path('images/variant');
                            if (!File::isDirectory($targetDirV)) {
                                File::makeDirectory($targetDirV, 0775, true, true);
                            }
                            $variantImg->move($targetDirV, $imgnamev);
                            $variantImgUrl = 'public/images/variant/' . $imgnamev;
                            $variant->Image = $variantImgUrl;
                        }
                        $variant->update();
                    } else {
                        $variant = new Productcolor();
                        $variant->product_id = $product->id;
                        $variant->color_id = $vr['mediaID'] ?? null;
                        $variant->color = $vr['color'] ?? null;
                        $variantImg = $vr['image'] ?? null;
                        if ($variantImg && $variantImg instanceof \Illuminate\Http\UploadedFile) {
                            $imgnamev = $time . $variantImg->getClientOriginalName();
                            $imgnamev = strtolower(preg_replace('/\s+/', '-', $imgnamev));
                            $targetDirV = public_path('images/variant');
                            if (!File::isDirectory($targetDirV)) {
                                File::makeDirectory($targetDirV, 0775, true, true);
                            }
                            $variantImg->move($targetDirV, $imgnamev);
                            $variantImgUrl = 'public/images/variant/' . $imgnamev;
                            $variant->Image = $variantImgUrl;
                        }
                        $variant->save();
                    }
                }
            }
            if (!empty($sizes)) {
                foreach ($sizes as $si) {
                    if (isset($si['sID'])) {
                        $size = Productsize::where('id', $si['sID'])->first();
                        $size->product_id = $product->id;
                        // $size->size_id = $si['sizeID'];
                        $size->size_id = !empty($si['sizeID']) ? $si['sizeID'] : 0;
                        $size->size = $si['size'];
                        $size->quantity = $si['quantity'];
                        $size->RegularPrice = $si['RegularPrice'];
                        $size->Discount = $si['Discount'];
                        $size->SalePrice = $si['RegularPrice'] - $si['Discount'];
                        $size->update();
                    } else {
                        $size = new Productsize();
                        $size->product_id = $product->id;
                        // $size->size_id = $si['sizeID'];
                        $size->size_id = !empty($si['sizeID']) ? $si['sizeID'] : 0;
                        $size->size = $si['size'];
                        $size->quantity = $si['quantity'];
                        $size->RegularPrice = $si['RegularPrice'];
                        $size->Discount = $si['Discount'];
                        $size->SalePrice = $si['RegularPrice'] - $si['Discount'];
                        $size->save();
                    }
                }
            }
        }

        $response['status'] = 'success';
        $response['message'] = 'Product Updated Sucessfully';
        return json_encode($response);
        die();
    }

    public function inactive(Request $request)
    {
        $inactive = Product::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success', 'Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Product::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success', 'Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Product::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success', 'Data delete successfully');
        return redirect()->back();
    }
    public function imgdestroy(Request $request)
    {
        $delete_data = Productimage::find($request->id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success', 'Data delete successfully');
        return redirect()->back();
    }
    public function pricedestroy(Request $request)
    {
        $delete_data = Productprice::find($request->id);
        $delete_data->delete();
        Toastr::success('Success', 'Product price delete successfully');
        return redirect()->back();
    }
    public function update_deals(Request $request)
    {
        $ids = (array) $request->input('product_ids', []);
        if (empty($ids)) {
            return response()->json(['status' => 'error', 'message' => 'Please select at least one product']);
        }
        Product::whereIn('id', $ids)->update(['topsale' => $request->status]);
        return response()->json(['status' => 'success', 'message' => 'Hot deals product status change']);
    }
    public function update_feature(Request $request)
    {
        $ids = (array) $request->input('product_ids', []);
        if (empty($ids)) {
            return response()->json(['status' => 'error', 'message' => 'Please select at least one product']);
        }
        Product::whereIn('id', $ids)->update(['feature_product' => $request->status]);
        return response()->json(['status' => 'success', 'message' => 'Feature product status change']);
    }
    public function update_status(Request $request)
    {
        $ids = (array) $request->input('product_ids', []);
        if (empty($ids)) {
            return response()->json(['status' => 'error', 'message' => 'Please select at least one product']);
        }
        Product::whereIn('id', $ids)->update(['status' => $request->status]);
        return response()->json(['status' => 'success', 'message' => 'Product status change successfully']);
    }
}
