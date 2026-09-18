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
        $product->stock = $request->stock;
        $product->pro_unit = $request->pro_unit;
        $product->pro_video = $request->pro_video;
        $product->description = $request->description;
        $product->short_des = $request->short_des;
        $product->prebooking = $request->prebooking;
        $product->status = $request->status;
        $product->topsale = $request->topsale;
        $product->feature_product = $request->feature_product;
        $product->deal_of_theday = $request->deal_of_theday;
        $product->type = $request->type;

        if ($request->hasFile('PostImage')) {
            foreach ($request->file('PostImage') as $imgfiles) {
                $name = time() . "_" . $imgfiles->getClientOriginalName();
                $name = strtolower(preg_replace('/\s+/', '-', $name));
                $imgfiles->move(public_path() . '/images/product/slider/', $name);
                $imageData[] = $name;
            }
            $product->PostImage = json_encode($imageData);
        }

        $result = $product->save();

        if ($request->variant) {
            $variants = $request->variant;
        }
        if ($request->size) {
            $sizes = $request->size;
        }


        $time = microtime('.') * 10000;

        $image = $request->file('image');

        $name =  time() . '-' . $image->getClientOriginalName();
        $name = strtolower(preg_replace('/\s+/', '-', $name));
        $name = strtolower(preg_replace('/\s+/', '-', $name));
        $uploadPath = 'public/uploads/product/';
        $image->move($uploadPath, $name);
        $imageUrl = $uploadPath . $name;

        $pimage             = new Productimage();
        $pimage->product_id = $product->id;
        $pimage->image      = $imageUrl;
        $pimage->save();

        if ($result) {
            if (!empty($variants)) {
                foreach ($variants as $vr) {
                    $variant = new Productcolor();
                    $variant->product_id = $product->id;
                    $variant->color_id = $vr['mediaID'];
                    $variant->color = $vr['color'];
                    $variantImg = $vr['image'];
                    if ($variantImg) {
                        $imgnamev = $time . $variantImg->getClientOriginalName();
                        $imgnamev = strtolower(preg_replace('/\s+/', '-', $imgnamev));
                        $imguploadPathv = ('public/images/variant/');
                        $variantImg->move($imguploadPathv, $imgnamev);
                        $variantImgUrl = $imguploadPathv . $imgnamev;
                        $variant->Image = $variantImgUrl;
                    }
                    $variant->save();
                }
            }
            if (!empty($sizes)) {
                foreach ($sizes as $si) {
                    $size = new Productsize();
                    $size->product_id = $product->id;
                    $size->size_id = $si['sizeID'];
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
        $variant->delete();
        $response['status'] = 'success';
        $response['message'] = 'Colour Varient Remove Sucessfully';
        return json_encode($response);
        die();
    }
    public function removesize($id)
    {
        $size = Productsize::where('id', $id)->first();
        $size->delete();
        $response['status'] = 'success';
        $response['message'] = 'Size /Weight Remove Sucessfully';
        return json_encode($response);
        die();
    }


    public function price_edit()
    {
        $products = DB::table('products')->select('id', 'name', 'status', 'old_price', 'new_price', 'stock')->where('status', 1)->get();;
        return view('backEnd.product.price_edit', compact('products'));
    }
    public function price_update(Request $request)
    {
        $ids = $request->ids;
        $oldPrices = $request->old_price;
        $newPrices = $request->new_price;
        $stocks = $request->stock;
        foreach ($ids as $key => $id) {
            $product = Product::select('id', 'name', 'status', 'old_price', 'new_price', 'stock')->find($id);

            if ($product) {
                $product->update([
                    'old_price' => $oldPrices[$key],
                    'new_price' => $newPrices[$key],
                    'stock' => $stocks[$key],
                ]);
            }
        }
        Toastr::success('Success', 'Price update successfully');
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
        $product->stock = $request->stock;
        $product->pro_unit = $request->pro_unit;
        $product->pro_video = $request->pro_video;
        $product->description = $request->description;
        $product->short_des = $request->short_des;
        $product->prebooking = $request->prebooking;
        $product->status = $request->status ;
        $product->topsale = $request->topsale ? 1:0;
        $product->feature_product = $request->feature_product ? 1:0;
        $product->deal_of_theday = $request->deal_of_theday ? 1:0;
        $product->type = $request->type;
        $product->updated_at = Carbon::now();

        if ($request->hasFile('PostImage')) {
            foreach ($request->file('PostImage') as $imgfiles) {
                $name = time() . "_" . $imgfiles->getClientOriginalName();
                $name = strtolower(preg_replace('/\s+/', '-', $name));
                $imgfiles->move(public_path() . '/images/product/slider/', $name);
                $imageData[] = $name;
            }
            $product->PostImage = json_encode($imageData);
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

        if ($request->hasFile('image')) {
            Productimage::where('product_id', $product->id)->delete();
            $name =  time() . '-' . $image->getClientOriginalName();
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadPath = 'public/uploads/product/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;
            $pimage             = new Productimage();
            $pimage->product_id = $product->id;
            $pimage->image      = $imageUrl;
            $pimage->save();
        } else {
        }

        if ($result) {
            if (!empty($variants)) {
                foreach ($variants as $vr) {
                    if (isset($vr['mID'])) {
                        $variant = Productcolor::where('id', $vr['mID'])->first();
                        $variant->product_id = $product->id;
                        $variant->color_id = $vr['mediaID'];
                        $variant->color = $vr['color'];
                        $variantImg = $vr['image'];
                        if ($variantImg != 'undefined') {
                            $imgnamev = $time . $variantImg->getClientOriginalName();
                            $imgnamev = strtolower(preg_replace('/\s+/', '-', $imgnamev));
                            $imguploadPathv = ('public/images/variant/');
                            $variantImg->move($imguploadPathv, $imgnamev);
                            $variantImgUrl = $imguploadPathv . $imgnamev;
                            $variant->Image = $variantImgUrl;
                        }
                        $variant->update();
                    } else {
                        $variant = new Productcolor();
                        $variant->product_id = $product->id;
                        $variant->color_id = $vr['mediaID'];
                        $variant->color = $vr['color'];
                        $variantImg = $vr['image'];
                        if ($variantImg) {
                            $imgnamev = $time . $variantImg->getClientOriginalName();
                            $imgnamev = strtolower(preg_replace('/\s+/', '-', $imgnamev));
                            $imguploadPathv = ('public/images/variant/');
                            $variantImg->move($imguploadPathv, $imgnamev);
                            $variantImgUrl = $imguploadPathv . $imgnamev;
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
                        $size->size_id = $si['sizeID'];
                        $size->size = $si['size'];
                        $size->quantity = $si['quantity'];
                        $size->RegularPrice = $si['RegularPrice'];
                        $size->Discount = $si['Discount'];
                        $size->SalePrice = $si['RegularPrice'] - $si['Discount'];
                        $size->update();
                    } else {
                        $size = new Productsize();
                        $size->product_id = $product->id;
                        $size->size_id = $si['sizeID'];
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
        $products = Product::whereIn('id', $request->input('product_ids'))->update(['topsale' => $request->status]);
        return response()->json(['status' => 'success', 'message' => 'Hot deals product status change']);
    }
    // public function update_feature(Request $request)
    // {
    //     $products = Product::whereIn('id', $request->input('product_ids'))->update(['feature_product' => $request->status]);
    //     return response()->json(['status' => 'success', 'message' => 'Feature product status change']);
    // }
    public function update_status(Request $request)
    {
        $products = Product::whereIn('id', $request->input('product_ids'))->update(['status' => $request->status]);
        return response()->json(['status' => 'success', 'message' => 'Product status change successfully']);
    }
}
