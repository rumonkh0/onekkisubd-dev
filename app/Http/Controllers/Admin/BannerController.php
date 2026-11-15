<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BannerCategory;
use App\Models\Banner;
use Toastr;
use Image;
use File;
class BannerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:banner-list|banner-create|banner-edit|banner-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:banner-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:banner-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:banner-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = Banner::orderBy('id', 'DESC')->with('category')->get();
        return view('backEnd.banner.index', compact('data'));
    }
    public function create()
    {
        $categories = BannerCategory::orderByRaw("FIELD(placement, 'hero_slider', 'hero_right_top', 'hero_right_bottom_left', 'hero_right_bottom_right', 'footer_top') = 0, FIELD(placement, 'hero_slider', 'hero_right_top', 'hero_right_bottom_left', 'hero_right_bottom_right', 'footer_top'), id ASC")
            ->select('id', 'name', 'placement')
            ->get();
        return view('backEnd.banner.create', compact('categories'));
    }
    private function saveBannerUpload($file, string $prefix, ?string $oldPath = null): string
    {
        $uploadPath = 'public/uploads/banner/';
        if (!File::isDirectory($uploadPath)) {
            File::makeDirectory($uploadPath, 0775, true);
        }
        $name = time() . '-' . $prefix . '-' . preg_replace('/\s+/', '-', $file->getClientOriginalName());
        $file->move($uploadPath, $name);
        if ($oldPath) {
            File::delete($oldPath);
        }
        return $uploadPath . $name;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'link' => 'required',
            'image' => 'required',
            'status' => 'required',
        ]);

        $input = $request->except(['image', 'tablet_image', 'mobile_image']);
        $input['status'] = $request->status ? 1 : 0;
        $input['image'] = $this->saveBannerUpload($request->file('image'), 'pc');
        $input['tablet_image'] = $request->hasFile('tablet_image')
            ? $this->saveBannerUpload($request->file('tablet_image'), 'tab')
            : null;
        $input['mobile_image'] = $request->hasFile('mobile_image')
            ? $this->saveBannerUpload($request->file('mobile_image'), 'mob')
            : null;

        Banner::create($input);
        Toastr::success('Success', 'Data insert successfully');
        return redirect()->route('banners.index');
    }

    public function edit($id)
    {
        $edit_data = Banner::find($id);
        $categories = BannerCategory::orderByRaw("FIELD(placement, 'hero_slider', 'hero_right_top', 'hero_right_bottom_left', 'hero_right_bottom_right', 'footer_top') = 0, FIELD(placement, 'hero_slider', 'hero_right_top', 'hero_right_bottom_left', 'hero_right_bottom_right', 'footer_top'), id ASC")
            ->select('id', 'name', 'placement')
            ->get();
        return view('backEnd.banner.edit', compact('edit_data', 'categories'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'link' => 'required',
        ]);
        $update_data = Banner::find($request->id);
        $input = $request->except(['image', 'tablet_image', 'mobile_image']);

        $input['image'] = $request->hasFile('image')
            ? $this->saveBannerUpload($request->file('image'), 'pc', $update_data->image)
            : $update_data->image;

        $input['tablet_image'] = $request->hasFile('tablet_image')
            ? $this->saveBannerUpload($request->file('tablet_image'), 'tab', $update_data->tablet_image)
            : $update_data->tablet_image;

        $input['mobile_image'] = $request->hasFile('mobile_image')
            ? $this->saveBannerUpload($request->file('mobile_image'), 'mob', $update_data->mobile_image)
            : $update_data->mobile_image;

        $input['status'] = $request->status ? 1 : 0;
        $update_data->update($input);

        Toastr::success('Success', 'Data update successfully');
        return redirect()->route('banners.index');
    }

    public function inactive(Request $request)
    {
        $inactive = Banner::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success', 'Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Banner::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success', 'Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Banner::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success', 'Data delete successfully');
        return redirect()->back();
    }
}
