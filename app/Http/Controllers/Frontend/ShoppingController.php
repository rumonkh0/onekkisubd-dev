<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Productprice;
use App\Models\Product;
use App\Models\Productcolor;
use App\Models\Productsize;
use Toastr;
use Cart;
use DB;

class ShoppingController extends Controller
{

    public function addTocartGet($id, Request $request)
    {
        $qty = 1;
        $productInfo = DB::table('products')->where('id', $id)->first();
        $productImage = DB::table('productimages')->where('product_id', $id)->first();
        $cartinfo = Cart::instance('shopping')->add([
            'id' => $productInfo->id,
            'name' => $productInfo->name,
            'qty' => $qty,
            'price' => $productInfo->new_price,
            'options' => [
                'image' => $productImage->image,
                'old_price' => $productInfo->old_price,
                'slug' => $productInfo->slug,
                'purchase_price' => $productInfo->purchase_price,
            ]
        ]);

        // return redirect()->back();
        return response()->json($cartinfo);
    }

    public function cart_store(Request $request)
    {
        $product = Product::where(['id' => $request->id])->first();
        if ($product->type == 0 || (empty($request->product_size) && empty($request->product_color))) {
            Cart::instance('shopping')->add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $request->qty ?? 1,
                'price' => $product->new_price,
                'options' => [
                    'slug' => $product->slug,
                    'image' => $product->image ? $product->image->image : '',
                    'old_price' => $product->old_price,
                    'purchase_price' => $product->purchase_price,
                    'preebooking' => $product->prebooking,
                    'product_size' => $request->product_size,
                    'product_color' => $request->product_color,
                    'pro_unit' => $request->pro_unit,
                ],
            ]);
        } else {
            $size = Productsize::where('product_id', $product->id)->where('size', $request->product_size)->first() ?? Productsize::where('product_id', $product->id)->first();
            $color = Productcolor::where('product_id', $product->id)->where('color', $request->product_color)->first() ?? Productcolor::where('product_id', $product->id)->first();
            $price = $size ? $size->SalePrice : $product->new_price;
            $old_price = $size ? $size->RegularPrice : $product->old_price;
            $img = $color && $color->Image ? $color->Image : ($product->image ? $product->image->image : '');
            Cart::instance('shopping')->add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $request->qty ?? 1,
                'price' => $price,
                'options' => [
                    'slug' => $product->slug,
                    'image' => $img,
                    'old_price' => $old_price,
                    'purchase_price' => $product->purchase_price,
                    'preebooking' => $product->prebooking,
                    'product_size' => $request->product_size,
                    'product_color' => $request->product_color,
                    'pro_unit' => $request->pro_unit,
                ],
            ]);
        }
        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Product successfully added to cart',
                'count' => Cart::instance('shopping')->count(),
            ]);
        }
        Toastr::success('Product successfully add to cart', 'Success!');
        if ($request->has('add_cart')) {
            return redirect()->back();
        }
        return redirect()->route('customer.checkout');
    }
    public function cart_remove(Request $request)
    {
        $remove = Cart::instance('shopping')->update($request->id, 0);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart', compact('data'));
    }
    public function cart_increment(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty + 1;
        $increment = Cart::instance('shopping')->update($request->id, $qty);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart', compact('data'));
    }
    public function cart_decrement(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty - 1;
        $decrement = Cart::instance('shopping')->update($request->id, $qty);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart', compact('data'));
    }
    public function cart_count(Request $request)
    {
        $data = Cart::instance('shopping')->count();
        return view('frontEnd.layouts.ajax.cart_count', compact('data'));
    }
    public function mobilecart_qty(Request $request)
    {
        $data = Cart::instance('shopping')->count();
        return view('frontEnd.layouts.ajax.mobilecart_qty', compact('data'));
    }
    public function cart_show()
    {
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.pages.cart', compact('data'));
    }
}
