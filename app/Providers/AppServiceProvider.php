<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\GeneralSetting;
use App\Models\Category;
use App\Models\Brand;
use App\Models\SocialMedia;
use App\Models\Contact;
use App\Models\CreatePage;
use App\Models\OrderStatus;
use App\Models\EcomPixel;
use App\Models\GoogleTagManager;
use App\Models\Order;
use App\Models\PaymentGateway;
use App\Models\ShippingCharge;
use Config;
use Session;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Paginator::useBootstrap();

        try {
            $shurjopay = \Illuminate\Support\Facades\Cache::remember('global_shurjopay', 3600, function () {
                return PaymentGateway::where(['status' => 1, 'type' => 'shurjopay'])->first();
            });
            if ($shurjopay) {
                Config::set(['shurjopay.apiCredentials.username' => $shurjopay->username]);
                Config::set(['shurjopay.apiCredentials.password' => $shurjopay->password]);
                Config::set(['shurjopay.apiCredentials.prefix' => $shurjopay->prefix]);
                Config::set(['shurjopay.apiCredentials.return_url' => $shurjopay->success_url]);
                Config::set(['shurjopay.apiCredentials.cancel_url' => $shurjopay->return_url]);
                Config::set(['shurjopay.apiCredentials.base_url' => $shurjopay->base_url]);
            }

            $generalsetting = \Illuminate\Support\Facades\Cache::remember('global_generalsetting', 3600, function () {
                return GeneralSetting::where('status', 1)->limit(1)->first();
            });
            view()->share('generalsetting', $generalsetting);

            $sidecategories = \Illuminate\Support\Facades\Cache::remember('global_sidecategories', 3600, function () {
                return Category::where('parent_id', '=', '0')->where('status', 1)->select('id', 'name', 'slug', 'status', 'image')->get();
            });
            view()->share('sidecategories', $sidecategories);

            $menucategories = \Illuminate\Support\Facades\Cache::remember('global_menucategories', 3600, function () {
                return Category::where('status', 1)->select('id', 'name', 'slug', 'status', 'image')->get();
            });
            view()->share('menucategories', $menucategories);

            $contact = \Illuminate\Support\Facades\Cache::remember('global_contact', 3600, function () {
                return Contact::where('status', 1)->first();
            });
            view()->share('contact', $contact);

            $socialicons = \Illuminate\Support\Facades\Cache::remember('global_socialicons', 3600, function () {
                return SocialMedia::where('status', 1)->get();
            });
            view()->share('socialicons', $socialicons);

            $pages = \Illuminate\Support\Facades\Cache::remember('global_pages_top', 3600, function () {
                return CreatePage::where('status', 1)->limit(3)->get();
            });
            view()->share('pages', $pages);

            $pagesright = \Illuminate\Support\Facades\Cache::remember('global_pages_right', 3600, function () {
                return CreatePage::where('status', 1)->skip(3)->limit(10)->get();
            });
            view()->share('pagesright', $pagesright);

            $cmnmenu = \Illuminate\Support\Facades\Cache::remember('global_cmnmenu', 3600, function () {
                return CreatePage::where('status', 1)->get();
            });
            view()->share('cmnmenu', $cmnmenu);

            $brands = \Illuminate\Support\Facades\Cache::remember('global_brands', 3600, function () {
                return Brand::where('status', 1)->get();
            });
            view()->share('brands', $brands);

            $neworder = \Illuminate\Support\Facades\Cache::remember('global_neworder_count', 120, function () {
                return Order::where('order_status', '1')->count();
            });
            view()->share('neworder', $neworder);

            $pendingorder = \Illuminate\Support\Facades\Cache::remember('global_pendingorders', 120, function () {
                return Order::where('order_status', '1')->latest()->limit(9)->get();
            });
            view()->share('pendingorder', $pendingorder);

            $orderstatus = \Illuminate\Support\Facades\Cache::remember('global_orderstatus', 3600, function () {
                return OrderStatus::get();
            });
            view()->share('orderstatus', $orderstatus);

            $pixels = \Illuminate\Support\Facades\Cache::remember('global_pixels', 3600, function () {
                return EcomPixel::where('status', 1)->get();
            });
            view()->share('pixels', $pixels);

            $gtm_code = \Illuminate\Support\Facades\Cache::remember('global_gtm_code', 3600, function () {
                return GoogleTagManager::where('status', 1)->get();
            });
            view()->share('gtm_code', $gtm_code);

            $shippingcharge = \Illuminate\Support\Facades\Cache::remember('global_shippingcharge', 3600, function () {
                return ShippingCharge::where('status', 1)->get();
            });
            view()->share('shippingcharge', $shippingcharge);
        } catch (\Throwable $e) {
            // Database not connected or tables not yet migrated
        }
    }
}
