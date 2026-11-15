<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Banner;
use App\Models\BannerCategory;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Toastr;
use Image;
use File;
use DB;
class GeneralSettingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:setting-list|setting-create|setting-edit|setting-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:setting-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:setting-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:setting-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $show_data = GeneralSetting::orderBy('id', 'DESC')->get();
        return view('backEnd.settings.index', compact('show_data'));
    }
    public function create()
    {
        return view('backEnd.settings.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'white_logo' => 'required',
            'favicon' => 'required',
            'status' => 'required',
        ]);

        // image with intervention 
        $image = $request->file('white_logo');
        $name = time() . '-' . $image->getClientOriginalName();
        $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name);
        $name = strtolower(preg_replace('/\s+/', '-', $name));
        $uploadpath = 'public/uploads/settings/';
        $imageUrl = $uploadpath . $name;
        $img = Image::make($image->getRealPath());
        $img->encode('webp', 90);
        $width = '';
        $height = '';
        $img->height() > $img->width() ? $width = null : $height = null;
        $img->resize($width, $height);
        $img->save($imageUrl);

        // dark logo
        $image2 = $request->file('dark_logo');
        $name2 = time() . '-' . $image2->getClientOriginalName();
        $name2 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name2);
        $name2 = strtolower(preg_replace('/\s+/', '-', $name2));
        $uploadpath2 = 'public/uploads/settings/';
        $image2Url = $uploadpath2 . $name2;
        $img2 = Image::make($image2->getRealPath());
        $img2->encode('webp', 90);
        $width2 = '';
        $height2 = '';
        $img2->height() > $img2->width() ? $width2 = null : $height2 = null;
        $img2->resize($width2, $height2);
        $img2->save($image2Url);

        // image with intervention 
        $image3 = $request->file('favicon');
        $name3 = time() . '-' . $image3->getClientOriginalName();
        $name3 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name3);
        $name3 = strtolower(preg_replace('/\s+/', '-', $name3));
        $uploadpath3 = 'public/uploads/settings/';
        $image3Url = $uploadpath3 . $name3;
        $img3 = Image::make($image3->getRealPath());
        $img3->encode('webp', 90);
        $width3 = 32;
        $height3 = 32;
        $img3->height() > $img3->width() ? $width3 = null : $height3 = null;
        $img3->resize($width3, $height3);
        $img3->save($image3Url);

        $input = $request->all();
        $input['white_logo'] = $imageUrl;
        $input['dark_logo'] = $image2Url;
        $input['favicon'] = $image3Url;
        GeneralSetting::create($input);
        Toastr::success('Success', 'Data insert successfully');
        return redirect()->route('settings.index');
    }

    private function getCategoryIdByPlacement(string $placement): int
    {
        $cat = BannerCategory::where('placement', $placement)->first();
        if ($cat) {
            return (int) $cat->id;
        }
        $created = BannerCategory::create([
            'name' => BannerCategory::PLACEMENTS[$placement] ?? $placement,
            'placement' => $placement,
            'status' => 1,
        ]);
        return (int) $created->id;
    }

    public function edit($id)
    {
        $edit_data = GeneralSetting::find($id);
        $heroSlides = Banner::whereHas('category', function ($q) {
            $q->where('placement', 'hero_slider');
        })->orWhere('category_id', 1)->orderBy('id', 'ASC')->get();

        $promoTop = Banner::whereHas('category', fn($q) => $q->where('placement', 'hero_right_top'))->latest('id')->first();
        $promoBottomLeft = Banner::whereHas('category', fn($q) => $q->where('placement', 'hero_right_bottom_left'))->latest('id')->first();
        $promoBottomRight = Banner::whereHas('category', fn($q) => $q->where('placement', 'hero_right_bottom_right'))->latest('id')->first();
        $heroPromos = collect([$promoTop, $promoBottomLeft, $promoBottomRight]);

        return view('backEnd.settings.edit', compact('edit_data', 'heroSlides', 'heroPromos'));
    }

    private function uploadHeroBannerFile($file, string $prefix, ?string $oldPath = null): string
    {
        $bannerPath = 'public/uploads/banner/';
        if (!File::isDirectory($bannerPath)) {
            File::makeDirectory($bannerPath, 0775, true);
        }
        $name = time() . '-' . $prefix . '-' . preg_replace('/\s+/', '-', $file->getClientOriginalName());
        $file->move($bannerPath, $name);
        if ($oldPath) {
            File::delete($oldPath);
        }
        return $bannerPath . $name;
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $update_data = GeneralSetting::find($request->id);
        $input = $request->except(['hero_slides', 'new_hero_slides', 'hero_promos']);
        // new white logo
        $image = $request->file('white_logo');
        if ($image) {
            // image with intervention 
            $image = $request->file('white_logo');
            $name = time() . '-' . $image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name);
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadpath = 'public/uploads/settings/';
            $imageUrl = $uploadpath . $name;
            $img = Image::make($image->getRealPath());
            $img->encode('webp', 90);
            $width = '';
            $height = '';
            $img->height() > $img->width() ? $width = null : $height = null;
            $img->resize($width, $height);
            $img->save($imageUrl);
            $input['white_logo'] = $imageUrl;
        } else {
            $input['white_logo'] = $update_data->white_logo;
        }
        // new dark logo
        $image2 = $request->file('dark_logo');
        if ($image2) {
            // image with intervention 
            $image2 = $request->file('dark_logo');
            $name2 = time() . '-' . $image2->getClientOriginalName();
            $name2 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name2);
            $name2 = strtolower(preg_replace('/\s+/', '-', $name2));
            $uploadpath2 = 'public/uploads/settings/';
            $image2Url = $uploadpath2 . $name2;
            $img2 = Image::make($image2->getRealPath());
            $img2->encode('webp', 90);
            $width2 = '';
            $height2 = '';
            $img2->height() > $img2->width() ? $width2 = null : $height2 = null;
            $img2->resize($width2, $height2);
            $img2->save($image2Url);
            $input['dark_logo'] = $image2Url;
        } else {
            $input['dark_logo'] = $update_data->dark_logo;
        }

        // new favicon image
        $image3 = $request->file('favicon');
        if ($image3) {
            $image3 = $request->file('favicon');
            $name3 = time() . '-' . $image3->getClientOriginalName();
            $name3 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name3);
            $name3 = strtolower(preg_replace('/\s+/', '-', $name3));
            $uploadpath3 = 'public/uploads/settings/';
            $image3Url = $uploadpath3 . $name3;
            $img3 = Image::make($image3->getRealPath());
            $img3->encode('webp', 90);
            $width3 = 32;
            $height3 = 32;
            $img3->height() > $img3->width() ? $width3 = null : $height3 = null;
            $img3->resize($width3, $height3);
            $img3->save($image3Url);
            $input['favicon'] = $image3Url;
        } else {
            $input['favicon'] = $update_data->favicon;
        }
        $input['status'] = $request->status ? 1 : 0;
        $update_data->update($input);

        $heroSliderCategoryId = $this->getCategoryIdByPlacement('hero_slider');

        // 1. Update / Delete existing Hero Main Slider Slides
        if ($request->has('hero_slides') && is_array($request->hero_slides)) {
            foreach ($request->hero_slides as $slideId => $slideData) {
                $banner = Banner::find($slideId);
                if (!$banner) {
                    continue;
                }
                if (!empty($slideData['delete'])) {
                    if ($banner->image) File::delete($banner->image);
                    if ($banner->tablet_image) File::delete($banner->tablet_image);
                    if ($banner->mobile_image) File::delete($banner->mobile_image);
                    $banner->delete();
                    continue;
                }
                $banner->category_id = $heroSliderCategoryId;
                $banner->link = $slideData['link'] ?? $banner->link;
                $banner->status = !empty($slideData['status']) ? 1 : 0;

                if ($request->hasFile("hero_slides.$slideId.image")) {
                    $banner->image = $this->uploadHeroBannerFile($request->file("hero_slides.$slideId.image"), "slide-$slideId-pc", $banner->image);
                }
                if ($request->hasFile("hero_slides.$slideId.tablet_image")) {
                    $banner->tablet_image = $this->uploadHeroBannerFile($request->file("hero_slides.$slideId.tablet_image"), "slide-$slideId-tab", $banner->tablet_image);
                }
                if ($request->hasFile("hero_slides.$slideId.mobile_image")) {
                    $banner->mobile_image = $this->uploadHeroBannerFile($request->file("hero_slides.$slideId.mobile_image"), "slide-$slideId-mob", $banner->mobile_image);
                }
                $banner->save();
            }
        }

        // 2. Create new Hero Main Slider Slides
        if ($request->has('new_hero_slides') && is_array($request->new_hero_slides)) {
            foreach ($request->new_hero_slides as $idx => $newSlide) {
                if (!$request->hasFile("new_hero_slides.$idx.image")) {
                    continue;
                }
                Banner::create([
                    'category_id' => $heroSliderCategoryId,
                    'link' => !empty($newSlide['link']) ? $newSlide['link'] : url('/shop'),
                    'image' => $this->uploadHeroBannerFile($request->file("new_hero_slides.$idx.image"), "newslide-$idx-pc"),
                    'tablet_image' => $request->hasFile("new_hero_slides.$idx.tablet_image")
                        ? $this->uploadHeroBannerFile($request->file("new_hero_slides.$idx.tablet_image"), "newslide-$idx-tab")
                        : null,
                    'mobile_image' => $request->hasFile("new_hero_slides.$idx.mobile_image")
                        ? $this->uploadHeroBannerFile($request->file("new_hero_slides.$idx.mobile_image"), "newslide-$idx-mob")
                        : null,
                    'status' => !empty($newSlide['status']) ? 1 : 0,
                ]);
            }
        }

        // 3. Update / Create 3 Right-Side Promo Image Banners by their distinct placement categories
        $promoPlacementBySlot = [
            0 => 'hero_right_top',
            1 => 'hero_right_bottom_left',
            2 => 'hero_right_bottom_right',
        ];
        if ($request->has('hero_promos') && is_array($request->hero_promos)) {
            foreach ($request->hero_promos as $slotIdx => $promoData) {
                $placementKey = $promoPlacementBySlot[$slotIdx] ?? 'hero_right_top';
                $targetCategoryId = $this->getCategoryIdByPlacement($placementKey);

                $bannerId = $promoData['id'] ?? null;
                $banner = $bannerId ? Banner::find($bannerId) : null;

                $hasPc = $request->hasFile("hero_promos.$slotIdx.image");
                $hasTab = $request->hasFile("hero_promos.$slotIdx.tablet_image");
                $hasMob = $request->hasFile("hero_promos.$slotIdx.mobile_image");

                if (!$banner && !$hasPc) {
                    continue;
                }

                if (!$banner) {
                    $banner = new Banner();
                }

                $banner->category_id = $targetCategoryId;
                $banner->link = !empty($promoData['link']) ? $promoData['link'] : url('/shop');
                $banner->status = !empty($promoData['status']) ? 1 : 0;

                if ($hasPc) {
                    $banner->image = $this->uploadHeroBannerFile($request->file("hero_promos.$slotIdx.image"), "promo-$slotIdx-pc", $banner->image);
                }
                if ($hasTab) {
                    $banner->tablet_image = $this->uploadHeroBannerFile($request->file("hero_promos.$slotIdx.tablet_image"), "promo-$slotIdx-tab", $banner->tablet_image);
                }
                if ($hasMob) {
                    $banner->mobile_image = $this->uploadHeroBannerFile($request->file("hero_promos.$slotIdx.mobile_image"), "promo-$slotIdx-mob", $banner->mobile_image);
                }
                $banner->save();
            }
        }

        Toastr::success('Success', 'Data update successfully');
        return redirect()->route('settings.index');
    }

    public function inactive(Request $request)
    {
        $inactive = GeneralSetting::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success', 'Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = GeneralSetting::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success', 'Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = GeneralSetting::find($request->hidden_id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success', 'Data delete successfully');
        return redirect()->back();
    }
}
