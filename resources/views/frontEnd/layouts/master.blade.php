<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') - {{$generalsetting->name}}</title>
    <!-- App favicon -->

    <link rel="shortcut icon" href="{{asset($generalsetting->favicon)}}" alt="Super Ecommerce Favicon" />
    <meta name="author" content="Super Ecommerce" />
    <link rel="canonical" href="" />
    @stack('seo')
    @stack('css')
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;500;600;700&family=Hind+Siliguri:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/js/all.min.js"
        integrity="sha512-8pHNiqTlsrRjVD4A/3va++W1sMbUHwWxxRPWNyVlql3T+Hgfd81Qc6FC5WMXDC+tSauxxzp1tgiAvSKFu1qIlA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.css"
        integrity="sha512-phGxLIsvHFArdI7IyLjv14dchvbVkEDaH95efvAae/y2exeWBQCQDpNFbOTdV1p4/pIa/XtbuDCnfhDEIXhvGQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- toastr css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{asset('public/frontEnd/css/mobile-menu.css')}}" />
    <link rel="stylesheet" href="{{asset('public/frontEnd/css/wsit-menu.css')}}" />
    <link rel="stylesheet" href="{{asset('public/frontEnd/css/style.css')}}" />
    <link rel="stylesheet" href="{{asset('public/frontEnd/css/responsive.css')}}" />
    <link rel="stylesheet" href="{{asset('public/frontEnd/css/theme.css')}}?v={{ time() }}" />


    @foreach($pixels as $pixel)
        <!-- Facebook Pixel Code -->
        <!-- <script>
            !(function (f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function () {
                    n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments);
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = "2.0";
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s);
            })(window, document, "script", "https://connect.facebook.net/en_US/fbevents.js");
            fbq("init", "{{{$pixel->code}}}");
            fbq("track", "PageView");
        </script>
        <noscript>
            <img height="1" width="1" style="display: none;"
                src="https://www.facebook.com/tr?id={{{$pixel->code}}}&ev=PageView&noscript=1" />
        </noscript> -->
        <!-- End Facebook Pixel Code -->
    @endforeach

    @if(count($gtm_code) > 0)
        @foreach($gtm_code as $gtm)
            <!-- Google Tag Manager -->
            <script>(function (w, d, s, l, i) {
                    w[l] = w[l] || []; w[l].push({
                        'gtm.start':
                            new Date().getTime(), event: 'gtm.js'
                    }); var f = d.getElementsByTagName(s)[0],
                        j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                            'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
                })(window, document, 'script', 'dataLayer', 'GTM-{{ $gtm->code }}');</script>
            <!-- End Google Tag Manager -->
        @endforeach
    @else
        <!-- Google Tag Manager -->
        <script>(function (w, d, s, l, i) {
                w[l] = w[l] || []; w[l].push({
                    'gtm.start':
                        new Date().getTime(), event: 'gtm.js'
                }); var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                        'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-KGRF7VNK');</script>
        <!-- End Google Tag Manager -->
    @endif

    <style>
        @media only screen and (min-width: 320px) and (max-width: 767px) {
            #google_translate_element {
                left: 55% !important;
            }
        }

        .background_color {
            background: #006400;
        }

        #mainskiky {
            margin-top: 56px;
        }

        #content {
            padding-top: 0 !important;
        }

        /* Fixed Header Styles */
        #claude-header {
            width: 100%;
            transition: box-shadow 0.25s ease, background-color 0.25s ease;
        }

        #claude-header.is-fixed {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            z-index: 1050 !important;
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            box-shadow: 0 6px 24px -6px rgba(10, 33, 27, 0.2) !important;
            border-bottom: 1px solid rgba(216, 183, 124, 0.25) !important;
        }

        #claude-header-spacer {
            display: none;
            width: 100%;
            height: 75px;
        }

        #claude-header-spacer.active {
            display: block;
        }
    </style>

</head>

<body class="gotop">
    <!-- Google Tag Manager (noscript) -->
    @if(count($gtm_code) > 0)
        @foreach($gtm_code as $gtm)
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-{{ $gtm->code }}" height="0" width="0"
                    style="display:none;visibility:hidden"></iframe></noscript>
        @endforeach
    @else
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KGRF7VNK" height="0" width="0"
                style="display:none;visibility:hidden"></iframe></noscript>
    @endif
    <!-- End Google Tag Manager (noscript) -->

    @php $subtotal = Cart::instance('shopping')->subtotal(); @endphp

    <div class="mobile-menu" style="background:">
        <div class="mobile-menu-logo">
            <div class="logo-image ">
                <img src="{{asset($generalsetting->white_logo)}}" alt="" style="width:120px" />
            </div>
            <div class="mobile-menu-close">
                <i class="fa fa-times"></i>
            </div>
        </div>
        <ul class="first-nav text-white">
            @foreach($menucategories as $scategory)
                <li class="parent-category">
                    <a href="{{url('category/' . $scategory->slug)}}" class="menu-category-name" style="font-size: 20px">
                        <img class="rounded" src="{{asset($scategory->image)}}" alt="" class="side_cat_img"
                            style="width:40px" />
                        {{$scategory->name}}
                    </a>
                    @if($scategory->subcategories->count() > 0)
                        <span class="menu-category-toggle">
                            <i class="fa fa-chevron-down"></i>
                        </span>
                    @endif
                    <ul class="second-nav" style="display: none;">
                        @foreach($scategory->subcategories as $subcategory)
                            <li class="parent-subcategory ">
                                <a href="{{url('subcategory/' . $subcategory->slug)}}"
                                    class="menu-subcategory-name">{{$subcategory->subcategoryName}}</a>
                                @if($subcategory->childcategories->count() > 0)
                                    <span class="menu-subcategory-toggle"><i class="fa fa-chevron-down"></i></span>
                                @endif
                                <ul class="third-nav" style="display: none;">
                                    @foreach($subcategory->childcategories as $childcat)
                                        <li class="childcategory"><a href="{{url('products/' . $childcat->slug)}}"
                                                class="menu-childcategory-name">{{$childcat->childcategoryName}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
    <!-- ==================== TOPBAR & NAVBAR (CLAUDE DESIGN) ==================== -->
    <div class="claude-theme">
        <!-- TopBar -->
        <div class="bg-tea-800 text-white text-xs">
            <div class="mx-auto flex max-w-[1400px] items-center justify-between gap-4 px-4 py-2 sm:px-6">
                <ul class="flex items-center gap-3 sm:gap-5 overflow-hidden">
                    <li class="flex items-center gap-1.5 whitespace-nowrap">
                        <svg class="h-3.5 w-3.5 text-gold-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z" />
                            <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12" />
                        </svg>
                        <span>100% Natural &amp; Organic</span>
                    </li>
                    <li
                        class="hidden md:flex items-center gap-1.5 whitespace-nowrap md:border-l md:border-white/20 md:pl-5">
                        <svg class="h-3.5 w-3.5 text-gold-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2" />
                            <path d="M15 18H9" />
                            <path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14" />
                            <circle cx="17" cy="18" r="2" />
                            <circle cx="7" cy="18" r="2" />
                        </svg>
                        <span>Nationwide Delivery Available</span>
                    </li>
                    <li
                        class="hidden md:flex items-center gap-1.5 whitespace-nowrap md:border-l md:border-white/20 md:pl-5">
                        <svg class="h-3.5 w-3.5 text-gold-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="8" width="18" height="4" rx="1" />
                            <path d="M12 8v13" />
                            <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7" />
                            <path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5" />
                        </svg>
                        <span>Exclusive Offers for Tea Lovers</span>
                    </li>
                </ul>

                <div class="flex items-center gap-5">
                    <a href="tel:{{ $contact->phone ?? ($contact->hotline ?? '01850945080') }}"
                        class="hidden items-center gap-1.5 hover:text-gold-300 sm:flex text-white">
                        <svg class="h-3.5 w-3.5 text-gold-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                        </svg>
                        <span>{{ $contact->phone ?? ($contact->hotline ?? '01850945080') }}</span>
                    </a>
                    <div class="flex items-center gap-3">
                        <span class="hidden text-white/80 lg:inline">Follow Us:</span>
                        <span class="hidden h-3.5 w-px bg-white/20 lg:inline"></span>
                        @if(isset($socialicons) && $socialicons->count() > 0)
                            @foreach($socialicons as $sicon)
                                <a href="{{ $sicon->link }}" target="_blank" aria-label="Social Link"
                                    class="text-white transition-colors hover:text-gold-300">
                                    <i class="{{ $sicon->icon }} text-xs"></i>
                                </a>
                            @endforeach
                        @else
                            <a href="#" aria-label="Facebook" class="text-white transition-colors hover:text-gold-300">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <a href="#" aria-label="Instagram" class="text-white transition-colors hover:text-gold-300">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="5" />
                                    <circle cx="12" cy="12" r="4" />
                                    <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                                </svg>
                            </a>
                            <a href="#" aria-label="YouTube" class="text-white transition-colors hover:text-gold-300">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Header Navbar -->
        <header id="claude-header"
            class="sticky top-0 z-50 bg-white/95 backdrop-blur transition-shadow shadow-[0_6px_24px_-12px_rgba(18,48,27,0.35)]">
            <div class="mx-auto flex max-w-[1400px] items-center justify-between gap-4 px-4 py-3 sm:px-6">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 select-none"
                    aria-label="OnekkisuBD home">
                    <span class="relative inline-flex h-12 w-12 shrink-0 items-center justify-center">
                        <svg viewBox="0 0 48 48" class="h-12 w-12" fill="none">
                            <circle cx="24" cy="24" r="22" fill="#245a2d" />
                            <circle cx="24" cy="24" r="22" stroke="#cdb06a" stroke-width="1.5" stroke-dasharray="4 3" />
                            <path d="M14 30c0-9 7-15 18-16-1 11-7 17-16 17 4-5 7-8 11-11" stroke="#e2cf9c"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="#468a47" />
                        </svg>
                    </span>
                    <span class="leading-none">
                        <span class="block font-serif text-[22px] font-bold tracking-tight text-tea-800">
                            Onekkisu<span class="text-gold-500">BD</span>
                        </span>
                        <span class="mt-1 block text-[10px] font-medium tracking-[0.12em] uppercase text-tea-600">
                            Pure Taste, Better Life
                        </span>
                    </span>
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden items-center gap-5 xl:flex 2xl:gap-7">
                    <div class="group relative">
                        <a href="{{ route('home') }}"
                            class="relative flex items-center gap-1 whitespace-nowrap py-2 text-[13px] font-medium transition-colors hover:text-tea-600 2xl:text-[13.5px] {{ request()->is('/') ? 'text-tea-700' : 'text-tea-900' }}">
                            Home
                            <span
                                class="absolute -bottom-0.5 left-0 h-0.5 rounded-full bg-gold-500 transition-all duration-300 {{ request()->is('/') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                        </a>
                    </div>
                    <div class="group relative">
                        <a href="{{ url('shop') }}"
                            class="relative flex items-center gap-1 whitespace-nowrap py-2 text-[13px] font-medium transition-colors hover:text-tea-600 2xl:text-[13.5px] {{ request()->is('shop') ? 'text-tea-700' : 'text-tea-900' }}">
                            Shop
                            <span
                                class="absolute -bottom-0.5 left-0 h-0.5 rounded-full bg-gold-500 transition-all duration-300 {{ request()->is('shop') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                        </a>
                    </div>
                    <div class="group relative">
                        <a href="{{ url('shop') }}"
                            class="relative flex items-center gap-1 whitespace-nowrap py-2 text-[13px] font-medium text-tea-900 transition-colors hover:text-tea-600 2xl:text-[13.5px]">
                            Tea Collection
                            <svg class="h-3.5 w-3.5 transition-transform group-hover:rotate-180" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                            <span
                                class="absolute -bottom-0.5 left-0 h-0.5 rounded-full bg-gold-500 transition-all duration-300 w-0 group-hover:w-full"></span>
                        </a>
                        <div
                            class="invisible absolute left-0 top-full z-50 w-56 translate-y-2 rounded-xl border border-tea-100 bg-white p-2 opacity-0 shadow-card-hover transition-all duration-200 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100">
                            @foreach($menucategories as $cat)
                                <a href="{{ route('category', $cat->slug) }}"
                                    class="block rounded-lg px-3 py-2 text-sm text-tea-900 transition-colors hover:bg-tea-50 hover:text-tea-700">
                                    {{ $cat->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="group relative">
                        <a href="{{ url('/') }}#features"
                            class="relative flex items-center gap-1 whitespace-nowrap py-2 text-[13px] font-medium text-tea-900 transition-colors hover:text-tea-600 2xl:text-[13.5px]">
                            Health Benefits
                            <span
                                class="absolute -bottom-0.5 left-0 h-0.5 rounded-full bg-gold-500 transition-all duration-300 w-0 group-hover:w-full"></span>
                        </a>
                    </div>
                    <div class="group relative">
                        <a href="{{ url('page/about-us') }}"
                            class="relative flex items-center gap-1 whitespace-nowrap py-2 text-[13px] font-medium transition-colors hover:text-tea-600 2xl:text-[13.5px] {{ request()->is('page/about-us') ? 'text-tea-700' : 'text-tea-900' }}">
                            About Us
                            <span
                                class="absolute -bottom-0.5 left-0 h-0.5 rounded-full bg-gold-500 transition-all duration-300 {{ request()->is('page/about-us') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                        </a>
                    </div>
                    <div class="group relative">
                        <a href="{{ url('blog-list') }}"
                            class="relative flex items-center gap-1 whitespace-nowrap py-2 text-[13px] font-medium transition-colors hover:text-tea-600 2xl:text-[13.5px] {{ request()->is('blog*') ? 'text-tea-700' : 'text-tea-900' }}">
                            Blog
                            <span
                                class="absolute -bottom-0.5 left-0 h-0.5 rounded-full bg-gold-500 transition-all duration-300 {{ request()->is('blog*') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                        </a>
                    </div>
                    <div class="group relative">
                        <a href="{{ url('page/contact-us') }}"
                            class="relative flex items-center gap-1 whitespace-nowrap py-2 text-[13px] font-medium transition-colors hover:text-tea-600 2xl:text-[13.5px] {{ request()->is('page/contact-us') ? 'text-tea-700' : 'text-tea-900' }}">
                            Contact
                            <span
                                class="absolute -bottom-0.5 left-0 h-0.5 rounded-full bg-gold-500 transition-all duration-300 {{ request()->is('page/contact-us') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                        </a>
                    </div>
                </nav>

                <!-- Right Side Actions -->
                <div class="flex shrink-0 items-center gap-2 sm:gap-3 2xl:gap-4">
                    <!-- Search input -->
                    <form action="{{ route('search') }}" method="GET"
                        class="hidden items-center rounded-full border border-tea-200 bg-tea-50/60 pl-4 pr-1.5 py-1 lg:flex focus-within:border-tea-400 focus-within:ring-2 focus-within:ring-tea-100 position-relative">
                        <input type="text" name="keyword" placeholder="Search for tea, herbs, products..."
                            class="search_keyword search_click w-44 bg-transparent text-xs text-tea-900 outline-none placeholder:text-tea-900/50 xl:w-36 2xl:w-48"
                            autocomplete="off" />
                        <button type="submit" aria-label="Search"
                            class="ml-1 flex h-7 w-7 items-center justify-center rounded-full text-tea-700 hover:bg-white">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </button>
                        <div class="search_result position-absolute w-100" style="top: 48px; left: 0; z-index: 9999;">
                        </div>
                    </form>

                    <!-- Wishlist -->
                    <a href="{{ route('wishlist') }}" aria-label="Wishlist"
                        class="relative rounded-full p-2 text-tea-800 transition-colors hover:bg-tea-50">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                        </svg>
                        <span
                            class="absolute -right-0.5 -top-0.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-gold-500 px-1 text-[10px] font-semibold text-white"
                            id="wishlistCount">{{ Cart::instance('wishlist')->count() }}</span>
                    </a>

                    <!-- Cart with Dropdown -->
                    <div class="relative group cart-dialog" id="cart-qty">
                        <a href="{{ route('customer.checkout') }}" aria-label="Cart"
                            class="relative block rounded-full p-2 text-tea-800 transition-colors hover:bg-tea-50">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="8" cy="21" r="1" />
                                <circle cx="19" cy="21" r="1" />
                                <path
                                    d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                            </svg>
                            <span
                                class="absolute -right-0.5 -top-0.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-gold-500 px-1 text-[10px] font-semibold text-white">{{ Cart::instance('shopping')->count() }}</span>
                        </a>
                        <div class="cshort-summary">
                            <ul>
                                @foreach(Cart::instance('shopping')->content() as $key => $value)
                                    <li>
                                        <a href=""><img src="{{ asset($value->options->image) }}" alt="" /></a>
                                    </li>
                                    <li><a href="">{{ Str::limit($value->name, 28) }}</a></li>
                                    <li>Qty: {{ $value->qty }}</li>
                                    <li>
                                        <p>৳{{ $value->price }}</p>
                                        <button class="remove-cart cart_remove" data-id="{{ $value->rowId }}"><i
                                                data-feather="x"></i></button>
                                    </li>
                                @endforeach
                            </ul>
                            <p><strong>TOTAL : ৳{{ $subtotal }}</strong></p>
                            <a href="{{ route('customer.checkout') }}" class="go_cart">PROCEED TO CHECKOUT</a>
                        </div>
                    </div>

                    <!-- Auth button -->
                    @if (Auth::guard('customer')->check())
                        <a href="{{ route('customer.account') }}"
                            class="hidden items-center gap-1.5 whitespace-nowrap text-[13px] font-medium text-tea-900 transition-colors hover:text-tea-600 md:flex">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            Account
                        </a>
                    @else
                        <a href="{{ url('customer/login') }}"
                            class="hidden items-center gap-1.5 whitespace-nowrap text-[13px] font-medium text-tea-900 transition-colors hover:text-tea-600 md:flex">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            Login / Register
                        </a>
                    @endif

                    <!-- Mobile Menu Hamburger -->
                    <button type="button" id="claude-mobile-toggle" aria-label="Toggle menu"
                        class="rounded-lg p-2 text-tea-800 hover:bg-tea-50 xl:hidden">
                        <svg class="h-6 w-6" id="claude-hamburger-icon" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="4" x2="20" y1="12" y2="12" />
                            <line x1="4" x2="20" y1="6" y2="6" />
                            <line x1="4" x2="20" y1="18" y2="18" />
                        </svg>
                        <svg class="h-6 w-6 hidden" id="claude-close-icon" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Drawer Menu -->
            <div id="claude-mobile-menu" class="hidden overflow-hidden border-t border-tea-100 bg-white xl:hidden">
                <div class="space-y-1 px-4 py-4 sm:px-6">
                    <form action="{{ route('search') }}" method="GET"
                        class="mb-3 flex items-center rounded-full border border-tea-200 bg-tea-50/60 px-4 py-2 lg:hidden">
                        <svg class="h-4 w-4 text-tea-700" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                        <input type="text" name="keyword" placeholder="Search for tea, herbs, products..."
                            class="ml-2 w-full bg-transparent text-sm outline-none placeholder:text-tea-900/50"
                            autocomplete="off" />
                    </form>
                    <a href="{{ route('home') }}"
                        class="block rounded-lg px-3 py-2.5 text-sm font-medium text-tea-900 hover:bg-tea-50">Home</a>
                    <a href="{{ url('shop') }}"
                        class="block rounded-lg px-3 py-2.5 text-sm font-medium text-tea-900 hover:bg-tea-50">Shop</a>
                    <a href="{{ url('/') }}#categories"
                        class="block rounded-lg px-3 py-2.5 text-sm font-medium text-tea-900 hover:bg-tea-50">Tea
                        Collection</a>
                    <a href="{{ url('/') }}#features"
                        class="block rounded-lg px-3 py-2.5 text-sm font-medium text-tea-900 hover:bg-tea-50">Health
                        Benefits</a>
                    <a href="{{ url('page/about-us') }}"
                        class="block rounded-lg px-3 py-2.5 text-sm font-medium text-tea-900 hover:bg-tea-50">About
                        Us</a>
                    <a href="{{ url('blog-list') }}"
                        class="block rounded-lg px-3 py-2.5 text-sm font-medium text-tea-900 hover:bg-tea-50">Blog</a>
                    <a href="{{ url('page/contact-us') }}"
                        class="block rounded-lg px-3 py-2.5 text-sm font-medium text-tea-900 hover:bg-tea-50">Contact</a>
                    @if (Auth::guard('customer')->check())
                        <a href="{{ route('customer.account') }}"
                            class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-sm font-medium text-tea-900 hover:bg-tea-50 md:hidden">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg> Account
                        </a>
                    @else
                        <a href="{{ url('customer/login') }}"
                            class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-sm font-medium text-tea-900 hover:bg-tea-50 md:hidden">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg> Login / Register
                        </a>
                    @endif
                </div>
            </div>
        </header>
        <div id="claude-header-spacer"></div>
    </div>
    <!-- ==================== END NAVBAR (CLAUDE DESIGN) ==================== -->

    <div id="content">
        @yield('content')
    </div>
    <!-- content end -->
    <!--    <footer>-->
    <!--    <div class="footer-top">-->
    <!--        <div class="container">-->
    <!--            <div class="row">-->
    <!--                <div class="col-sm-4 mb-3 mb-sm-0">-->
    <!--                    <div class="footer-about">-->
    <!--                        <a href="{{route('home')}}">-->
    <!--                            <img src="{{asset($generalsetting->dark_logo)}}" alt="" />-->
    <!--                        </a>-->
    <!--                        <p>{{$contact->address}}</p>-->
    <!--                        <a href="tel:{{$contact->hotline}}" class="footer-hotlint">{{$contact->hotline}}</a>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!-- col end -->
    <!--                <div class="col-sm-3 mb-3 mb-sm-0 col-6">-->
    <!--                    <div class="footer-menu">-->
    <!--                        <ul>-->
    <!--                            <li class="title"><a>Useful Link</a></li>-->
    <!--                            <li>-->
    <!--                                <a href="{{route('contact')}}"> <a href="{{route('contact')}}">Contact Us</a></a>-->
    <!--                            </li>-->
    <!--                            @foreach($pages as $page)-->
    <!--                            <li><a href="{{route('page',['slug'=>$page->slug])}}">{{$page->name}}</a></li>-->
    <!--                            @endforeach-->
    <!--                        </ul>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!-- col end -->
    <!--                <div class="col-sm-2 mb-3 mb-sm-0 col-6">-->
    <!--                    <div class="footer-menu">-->
    <!--                        <ul>-->
    <!--                            <li class="title"><a>Link</a></li>-->
    <!--                            @foreach($pagesright as $key=>$value)-->
    <!--                            <li>-->
    <!--                                <a href="{{route('page',['slug'=>$value->slug])}}">{{$value->name}}</a>-->
    <!--                            </li>-->
    <!--                            @endforeach-->
    <!--                        </ul>-->
    <!--                    </div>-->
    <!--                </div>-->

    <!-- col end -->
    <!--                <div class="col-sm-3 mb-3 mb-sm-0">-->
    <!--                    <div class="footer-menu">-->
    <!--                        <ul>-->
    <!--                            <li class="title stay_conn"><a>Stay Connected</a></li>-->
    <!--                        </ul>-->
    <!--                        <ul class="social_link">-->
    <!--                            @foreach($socialicons as $value)-->
    <!--                            <li class="social_list">-->
    <!--                                <a class="mobile-social-link" href="{{$value->link}}"><i class="{{$value->icon}}"></i></a>-->
    <!--                            </li>-->
    <!--                            @endforeach-->
    <!--                        </ul>-->
    <!--<div class="d_app">-->
    <!--    <h2>Download App</h2>-->
    <!--    <a href="">-->
    <!--        <img src="{{asset('public/frontEnd/images/app-download.png')}}" alt="" />-->
    <!--    </a>-->
    <!--</div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!-- col end -->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--    <div class="footer-bottom background_color">-->
    <!--        <div class="container">-->
    <!--            <div class="row">-->
    <!--                <div class="col-sm-12">-->
    <!--                    <div class="copyright">-->
    <!--                        <p>Copyright © {{ date('Y') }} {{$generalsetting->name}} | All rights reserved | Developed by <a href="https://www.facebook.com/profile.php?id=61574269515844" target="_blank" class="text-light text-decoration-underline">QuadPixel Labs</a></p>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</footer>-->



    <!-- ==================== LUXURY FOOTER (OPENAI DESIGN) ==================== -->
    <footer id="contact" class="claude-theme site-footer relative overflow-hidden"
        style="background-image: linear-gradient(90deg, rgba(9, 31, 25, 0.9) 0%, rgba(9, 31, 25, 0.92) 68%, rgba(9, 31, 25, 0.42) 100%), url('{{ asset('images/footer-bg.jpg') }}'); background-position: right center !important;">
        <!-- Decorative leaves (retained as requested) -->
        <svg viewBox="0 0 64 64"
            class="pointer-events-none absolute right-[26%] top-6 h-24 w-24 -rotate-12 opacity-40 animate-float-slow"
            fill="none" aria-hidden="true">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#leafGradFoot1)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <path d="M22 42c6-1 10-2 14-5M30 34c6-2 9-4 12-8M18 46c3-5 5-7 8-10" stroke="#e5efe2" stroke-width="1"
                stroke-linecap="round" opacity=".7" />
            <defs>
                <linearGradient id="leafGradFoot1" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#2f6f37" />
                    <stop offset="1" stop-color="#6ba367" />
                </linearGradient>
            </defs>
        </svg>

        <svg viewBox="0 0 64 64"
            class="pointer-events-none absolute right-[18%] top-24 h-14 w-14 rotate-[30deg] opacity-30 animate-float"
            style="animation-delay: 1.5s;" fill="none" aria-hidden="true">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#leafGradFoot2)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <path d="M22 42c6-1 10-2 14-5M30 34c6-2 9-4 12-8M18 46c3-5 5-7 8-10" stroke="#e5efe2" stroke-width="1"
                stroke-linecap="round" opacity=".7" />
            <defs>
                <linearGradient id="leafGradFoot2" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#2f6f37" />
                    <stop offset="1" stop-color="#6ba367" />
                </linearGradient>
            </defs>
        </svg>

        <svg viewBox="0 0 64 64"
            class="pointer-events-none absolute left-[30%] -bottom-6 h-24 w-24 rotate-[200deg] opacity-20 animate-float-slow"
            style="animation-delay: 2.5s;" fill="none" aria-hidden="true">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#leafGradFoot3)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <path d="M22 42c6-1 10-2 14-5M30 34c6-2 9-4 12-8M18 46c3-5 5-7 8-10" stroke="#e5efe2" stroke-width="1"
                stroke-linecap="round" opacity=".7" />
            <defs>
                <linearGradient id="leafGradFoot3" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#2f6f37" />
                    <stop offset="1" stop-color="#6ba367" />
                </linearGradient>
            </defs>
        </svg>

        <div class="footer-inner">
            <div class="footer-columns">
                <!-- Brand Column -->
                <div class="footer-brand-column" id="about">
                    <div class="brand-logo brand-logo-footer">
                        <svg class="brand-mark" viewBox="0 0 82 82" aria-hidden="true">
                            <defs>
                                <linearGradient id="brandGreenFooter" x1="0" y1="0" x2="1" y2="1">
                                    <stop offset="0" stop-color="#78a729" />
                                    <stop offset="0.55" stop-color="#235d2e" />
                                    <stop offset="1" stop-color="#0c432e" />
                                </linearGradient>
                            </defs>
                            <path d="M57 12A32 32 0 1 0 64 69" fill="none" stroke="url(#brandGreenFooter)"
                                stroke-width="12" stroke-linecap="round" />
                            <path d="M44 17C50 4 62 2 76 3c-6 14-14 21-29 22-3-2-4-5-3-8Z" fill="#5d972b" />
                            <path d="M46 55c-2-13 8-23 22-25-1 13-8 24-21 27Z" fill="#77a83b" />
                            <path d="M45 57c6-9 12-14 21-21" fill="none" stroke="#e0e9a6" stroke-width="1.8"
                                stroke-linecap="round" />
                            <circle cx="57" cy="70" r="5" fill="#c9a343" />
                        </svg>
                        <span class="brand-words">
                            <strong>অনেককিছু</strong>
                            <small>Purity With Price &amp; Trust</small>
                        </span>
                    </div>

                    <h2>Good Tea<br /><em>Better Living</em></h2>
                    <div class="gold-line"></div>
                    <p>Bringing you the finest teas, herbs and<br /> natural flavours for a healthier, happier you.</p>

                    <address>
                        <span>
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 0 1 0-5 2.5 2.5 0 0 1 0 5z" />
                            </svg>
                            {{ $contact->address ?? 'Najir Shankorpur, Jashore' }}
                        </span>
                        <a href="mailto:{{ $contact->email ?? 'onnekkisuponno@gmail.com' }}">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                            </svg>
                            {{ $contact->email ?? 'onnekkisuponno@gmail.com' }}
                        </a>
                        <a href="tel:{{ $contact->phone ?? ($contact->hotline ?? '01850945080') }}">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" />
                            </svg>
                            {{ $contact->phone ?? ($contact->hotline ?? '01850945080') }}
                        </a>
                    </address>

                    <div class="footer-socials">
                        @if(isset($socialicons) && $socialicons->count() > 0)
                            @foreach($socialicons as $value)
                                <a href="{{ $value->link }}" target="_blank" rel="noreferrer" aria-label="Social Link">
                                    <i class="{{ $value->icon }}"></i>
                                </a>
                            @endforeach
                        @else
                            <a href="https://www.facebook.com/" target="_blank" rel="noreferrer" aria-label="Facebook">
                                <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <a href="https://www.instagram.com/" target="_blank" rel="noreferrer" aria-label="Instagram">
                                <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="5" />
                                    <circle cx="12" cy="12" r="4" />
                                    <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                                </svg>
                            </a>
                            <a href="https://www.youtube.com/" target="_blank" rel="noreferrer" aria-label="YouTube">
                                <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Popular Links -->
                <div class="footer-link-column">
                    <h3>Popular Links</h3>
                    <div class="gold-line"></div>
                    <nav class="flex flex-col space-y-3">
                        <a href="{{ url('/') }}">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14" />
                                <path d="m12 5 7 7-7 7" />
                            </svg>
                            Home
                        </a>
                        <a href="{{ url('page/about-us') }}">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14" />
                                <path d="m12 5 7 7-7 7" />
                            </svg>
                            About Us
                        </a>
                        <a href="{{ url('page/contact-us') }}">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14" />
                                <path d="m12 5 7 7-7 7" />
                            </svg>
                            Contact Us
                        </a>
                        <a href="{{ url('page/order-procedure') }}">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14" />
                                <path d="m12 5 7 7-7 7" />
                            </svg>
                            Order Procedure
                        </a>
                    </nav>
                </div>

                <!-- Quick Links -->
                <div class="footer-link-column">
                    <h3>Quick Links</h3>
                    <div class="gold-line"></div>
                    <nav class="flex flex-col space-y-3">
                        @php
                            $quick_links = App\Models\CreatePage::where('status', 1)->whereNotIn('slug', ['contact-us', 'about-us', 'order-procedure'])->get();
                        @endphp
                        @if($quick_links && $quick_links->count() > 0)
                            @foreach($quick_links as $page)
                                <a href="{{ route('page', ['slug' => $page->slug]) }}">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14" />
                                        <path d="m12 5 7 7-7 7" />
                                    </svg>
                                    {{ $page->name }}
                                </a>
                            @endforeach
                        @else
                            <a href="{{ url('page/delivery-rules') }}">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14" />
                                    <path d="m12 5 7 7-7 7" />
                                </svg>
                                Delivery Rules
                            </a>
                            <a href="{{ url('page/return-policy') }}">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14" />
                                    <path d="m12 5 7 7-7 7" />
                                </svg>
                                Return Policy
                            </a>
                            <a href="{{ url('page/terms-conditions') }}">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14" />
                                    <path d="m12 5 7 7-7 7" />
                                </svg>
                                Terms &amp; Conditions
                            </a>
                            <a href="{{ url('page/privacy-policy') }}">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14" />
                                    <path d="m12 5 7 7-7 7" />
                                </svg>
                                Privacy Policy
                            </a>
                        @endif
                    </nav>
                </div>

                <!-- Stay Connected -->
                <div class="footer-connect-column">
                    <h3>Stay Connected</h3>
                    <div class="gold-line"></div>
                    <p>Subscribe to get latest offers, new arrivals<br /> and tea tips.</p>
                    <form class="newsletter-form" action="#" method="POST"
                        onsubmit="event.preventDefault(); toastr.success('Thank you for subscribing!');">
                        <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="16" x="2" y="4" rx="2" />
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                        </svg>
                        <input type="email" placeholder="Your email address" required aria-label="Email address" />
                        <button type="submit">Subscribe</button>
                    </form>

                    <ul class="footer-benefits">
                        <li>
                            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z" />
                                <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12" />
                            </svg>
                            <span>100%<br />Natural</span>
                        </li>
                        <li>
                            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2" />
                                <path d="M15 18H9" />
                                <path
                                    d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14" />
                                <circle cx="17" cy="18" r="2" />
                                <circle cx="7" cy="18" r="2" />
                            </svg>
                            <span>Fast<br />Delivery</span>
                        </li>
                        <li>
                            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                                <path d="m9 12 2 2 4-4" />
                            </svg>
                            <span>Secure<br />Payment</span>
                        </li>
                        <li>
                            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                            </svg>
                            <span>Loved by<br />Tea Lovers</span>
                        </li>
                    </ul>

                    <span class="footer-script">
                        A Cup<br />A Better<br />You
                    </span>
                </div>
            </div>

            <!-- Bottom bar -->
            <div class="footer-bottom" style="background: transparent !important;">
                <span>
                    © {{ date('Y') }} {{ $generalsetting->name ?? 'OnekkisuBD' }} | All rights reserved | Developed by
                    <strong>
                        <a href="https://www.facebook.com/profile.php?id=61574269515844" target="_blank">QuadPixel
                            Labs</a>
                    </strong>
                </span>
                <span>
                    Drink Good Tea
                    <svg class="h-4.5 w-4.5 inline-block text-[#418b50]" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M7 20h10" />
                        <path d="M10 20c5.5-2.5.8-6.4 3-10" />
                        <path
                            d="M9.5 9.4c1.1.8 1.8 2.2 2.3 3.7-2 .4-3.5.4-4.8-.3-1.2-.6-2.3-1.9-3-4.2 2.8-.5 4.4 0 5.5.8z" />
                        <path d="M14.1 6a7 7 0 0 0-1.1 4c1.9-.1 3.3-.6 4.3-1.4 1-1 1.6-2.3 1.7-4.6-2.7.1-4 1-4.9 2z" />
                    </svg>
                    Live a Better Life
                </span>
            </div>
        </div>
    </footer>
    <!-- ==================== END LUXURY FOOTER (OPENAI DESIGN) ==================== -->

    <!-- Floating ScrollTop button -->
    <button id="claude-scroll-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" aria-label="Back to top"
        class="fixed bottom-6 right-6 z-[90] flex h-11 w-11 items-center justify-center rounded-full bg-tea-700 text-white shadow-lg shadow-tea-950/30 transition-all hover:bg-tea-800 opacity-0 translate-y-4 pointer-events-none">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="m18 15-6-6-6 6" />
        </svg>
    </button>

    <script>
        (function () {
            const btn = document.getElementById('claude-scroll-top');
            const mobileToggle = document.getElementById('claude-mobile-toggle');
            const mobileMenu = document.getElementById('claude-mobile-menu');
            const burgerIcon = document.getElementById('claude-hamburger-icon');
            const closeIcon = document.getElementById('claude-close-icon');

            if (mobileToggle && mobileMenu) {
                mobileToggle.addEventListener('click', function (e) {
                    e.preventDefault();
                    const isHidden = mobileMenu.classList.contains('hidden');
                    if (isHidden) {
                        mobileMenu.classList.remove('hidden');
                        if (burgerIcon) burgerIcon.classList.add('hidden');
                        if (closeIcon) closeIcon.classList.remove('hidden');
                    } else {
                        mobileMenu.classList.add('hidden');
                        if (burgerIcon) burgerIcon.classList.remove('hidden');
                        if (closeIcon) closeIcon.classList.add('hidden');
                    }
                });
            }

            // Sticky / Fixed Header Handler
            const header = document.getElementById('claude-header');
            const spacer = document.getElementById('claude-header-spacer');
            const topbar = document.querySelector('.bg-tea-800');

            function updateFixedHeader() {
                if (!header) return;
                const topbarHeight = topbar ? topbar.offsetHeight : 38;
                if (window.scrollY > topbarHeight) {
                    header.classList.add('is-fixed');
                    if (spacer) spacer.classList.add('active');
                } else {
                    header.classList.remove('is-fixed');
                    if (spacer) spacer.classList.remove('active');
                }
            }

            window.addEventListener('scroll', function () {
                updateFixedHeader();
                if (btn) {
                    if (window.scrollY > 400) {
                        btn.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
                        btn.classList.add('opacity-100', 'translate-y-0');
                    } else {
                        btn.classList.remove('opacity-100', 'translate-y-0');
                        btn.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
                    }
                }
            }, { passive: true });

            updateFixedHeader();
        })();
    </script>




    <div class="footer_nav">
        <ul>
            <li>
                <a href="{{ url('/') }}">
                    <span>
                        {{-- <i class="fa-solid fa-bars"></i> --}}
                        <img src="{{ asset('public/home.png') }}" alt="" width="30">
                    </span>

                </a>
            </li>

            <li>
                <a class="toggle">
                    <span>
                        {{-- <i class="fa-regular fa-heart" style=" width: 20px; height: 20px;"></i> --}}
                        <img src="{{ asset('public/menu.png') }}" alt="" width="30">

                    </span>

                </a>
            </li>

            <li class="mobile_home">
                <a href="https://wa.me/+88{{App\Models\Contact::first()->phone}}?text={{ request()->fullUrl() }}">
                    <span>
                        <img src="{{ asset('public/live-chat.png') }}" alt="" width="50">

                    </span>
                    {{-- <span class="text-dark"><i class="fa-solid fa-shop"></i></span> <span
                        class="text-dark">Shop</span> --}}
                </a>
            </li>

            <li>
                <a href="{{route('customer.order_track')}}">
                    <span>
                        {{-- <i class="fa-solid fa-cart-shopping" style=" width: 20px; height: 20px;"></i> --}}
                        <img src="{{ asset('public/truck.png') }}" alt="" width="30">

                    </span>
                </a>
            </li>
            @if(Auth::guard('customer')->user())
                <li>
                    <a href="{{url('/')}}">
                        <span>
                            {{-- <i class="fa-solid fa-user"></i> --}}
                            <img src="{{ asset('public/truck.png') }}" alt="" width="30">
                        </span>

                    </a>
                </li>
            @else
                <li>
                    <a href="{{url('/')}}">
                        <span>
                            {{-- <i class="fa-solid fa-user" style=" width: 20px; height: 20px;"></i> --}}
                            <img src="{{ asset('public/back.png') }}" alt="" width="30">
                        </span>

                    </a>
                </li>
            @endif
        </ul>
    </div>
    {{-- <div class="footer_nav">
        <ul>
            <li>
                <a class="toggle">
                    <span>

                        <img src="https://rashifashionbd.com/public/ihome.png" alt="" width="30">
                    </span>

                </a>
            </li>

            <li>
                <a href="{{ route('wishlist') }}">
                    <span>
                        <i class="fa-regular fa-heart" style=" width: 20px; height: 20px;"></i>
                    </span>

                </a>
            </li>

            <li class="mobile_home">
                <a href="{{route('shop')}}">
                    <span class="text-dark"><i class="fa-solid fa-shop"></i></span> <span class="text-dark">Shop</span>
                </a>
            </li>

            <li>
                <a href="{{route('customer.checkout')}}">
                    <span>
                        <i class="fa-solid fa-cart-shopping" style=" width: 20px; height: 20px;"></i>
                    </span>
                </a>
            </li>
            @if(Auth::guard('customer')->user())
            <li>
                <a href="{{route('customer.account')}}">
                    <span>
                        <i class="fa-solid fa-user"></i>
                    </span>

                </a>
            </li>
            @else
            <li>
                <a href="{{route('customer.login')}}">
                    <span>
                        <i class="fa-solid fa-user" style=" width: 20px; height: 20px;"></i>
                    </span>

                </a>
            </li>
            @endif
        </ul>
    </div> --}}

    <style>
        @media only screen and (min-width:320px) and (max-width:767px) {
            .footer_mobile_margin {
                margin-bottom: 60px
            }
        }

        .footer {
            background-color: #0b2341;
            padding-top: 50px;
        }

        .footer h5 {
            font-weight: bold;
        }

        .footer a {
            color: white;
            text-decoration: none;
        }

        .footer a:hover {
            color: #ff4081;
        }

        .footer-icons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .footer-icons a {
            display: flex;
            width: 40px;
            height: 40px;
            background: #78037a;
            color: white;
            border-radius: 5px;
            align-items: center;
            justify-content: center;
        }

        .divider {
            width: 50px;
            height: 3px;
            background: #ff4081;
            margin-bottom: 10px;
        }

        .whats-app-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            margin-bottom: 50px;
            z-index: 1000;
            cursor: pointer;
            background-color: transparent;
            background: rgb(45, 183, 66);
            height: 56px;
            width: 56px;
            border-radius: 50%;
            transition: all .4s linear !important;

            & svg {
                color: white;
                width: 36px;
                height: 36px;
            }

            & .fa-whatsapp {
                transition: all .4s linear !important;
                position: absolute;
                top: calc(50% - 18px);
                left: calc(50% - 18px);
            }

            & .fa-x {
                transition: all .4s linear !important;
                position: absolute;
                width: 0px;
                height: 0px;
            }
        }

        /* .all-categories {
                background: red;
                color: white;
                text-align: center;
                padding: 10px;
            } */
        .modal.show .modal-dialog {
            transform: none;
            position: absolute;
            top: 50%;
            left: 50%;
        }

        .wa__popup_chat_box {
            font-family: cardo !important;
            border-radius: 5px 5px 8px 8px;
            -webkit-border-radius: 5px 5px 8px 8px;
            -moz-border-radius: 5px 5px 8px 8px;
            bottom: 132px;
            box-shadow: 0 10px 10px 4px rgba(0, 0, 0, .04);
            -webkit-box-shadow: 0 10px 10px 4px rgba(0, 0, 0, .04);
            -moz-box-shadow: 0 10px 10px 4px rgba(0, 0, 0, .04);
            font-family: Arial, Helvetica, sans-serif;
            max-width: calc(100% - 50px);
            opacity: 0;
            overflow: hidden;
            position: fixed;
            right: 25px;
            -ms-transform: translateY(50px);
            transform: translateY(50px);
            -webkit-transform: translateY(50px);
            -moz-transform: translateY(50px);
            transition: all .4s ease;
            -webkit-transition: all .4s ease;
            -moz-transition: all .4s ease;
            visibility: hidden;
            width: 351px;
            will-change: transform, visibility, opacity;
            z-index: 999999998;
            background-color: white;

            & .modal-header {
                background: #2db742;
                padding: 16px 16px;
                column-gap: 20px;

                & h3 {
                    color: white;
                    font-size: 18px;
                    font-family: cardo !important;
                }

                & p {
                    font-size: 12px;
                    color: rgb(217, 235, 198);
                }

                & strong {
                    font-size: 15px;
                }
            }

            & .modal-body {
                padding: 13px 20px 12px 19px;
                background-color: #ffffff;

                & strong {
                    color: #a5abb7;
                    font-size: 15px;
                    font-weight: 500;
                    padding: 0 3px;
                }

                & a {
                    background: #f5f7f9;
                    border-left: 2px solid #2db742;
                    border-radius: 2px 4px 2px 4px;
                    -webkit-border-radius: 2px 4px 2px 4px;
                    -moz-border-radius: 2px 4px 2px 4px;
                    display: table;
                    padding: 13px 22px 14px 12px;
                    position: relative;
                    text-decoration: none;
                    width: 100%;
                    margin-top: 14px;
                    transition: all .4s ease !important;

                    & div p {
                        & span:first-child {
                            color: #363c47;
                            font-size: 14px;
                            line-height: 1.188em !important;
                        }

                        & span:last-child {
                            color: #989b9f;
                            font-size: 11px;
                            line-height: 1.125em !important;
                            padding: 2px 0 0;
                        }
                    }

                    &:hover {
                        background: #fff;
                        box-shadow: 0 7px 15px 1px rgba(55, 62, 70, .07);
                        -webkit-box-shadow: 0 7px 15px 1px rgba(55, 62, 70, .07);
                        -moz-box-shadow: 0 7px 15px 1px rgba(55, 62, 70, .07);
                    }
                }
            }
        }

        .wa__popup_chat_box:active,
        .wa__popup_chat_box:focus,
        .wa__popup_chat_box:hover {
            box-shadow: 0 10px 10px 4px rgba(32, 32, 37, .23);
            -webkit-box-shadow: 0 10px 10px 4px rgba(32, 32, 37, .23);
            -moz-box-shadow: 0 10px 10px 4px rgba(32, 32, 37, .23);
        }

        .wa__popup_chat_box.wa__active {
            opacity: 1;
            -ms-transform: translate(0);
            transform: translate(0);
            -webkit-transform: translate(0);
            -moz-transform: translate(0);
            visibility: visible;
        }

        .wa__btn_popup_txt {
            background-color: #f5f7f9;
            border-radius: 4px;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            color: #43474e;
            font-size: 16px;
            letter-spacing: -.03em;
            line-height: 1.5;
            margin-right: 7px;
            padding: 8px 12px;
            position: absolute;
            right: 100%;
            top: 50%;
            -webkit-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
            transition: all .4s ease;
            -webkit-transition: all .4s ease;
            -moz-transition: all .4s ease;
            width: 85px;
            display: flex;
            opacity: 1;
            visibility: visible;
            font-family: "cardo" !important;
        }

        .popup_txt_hide {
            transform: translateY(50%);
            visibility: hidden;
            opacity: 0;
        }
    </style>

    <!-- Button trigger modal -->
    <button type="button" class="whats-app-btn">
        <i class="fa-brands fa-whatsapp"></i>
        <i class="fa-solid fa-x"></i>
        <!-- <div class="wa__btn_popup_txt "><span>Need <br> Help?</span></div> -->
    </button>

    <!-- Modal -->
    <div class=" wa__popup_chat_box ">
        <div class="modal-header">
            <div><img src="{{ asset('public/frontEnd/images/whatsapp-svgrepo-com.svg') }}" alt="WhatsApp Chat"
                    width="45px"></div>
            <div>
                <h3 class="modal-title" id="exampleModalLabel">Start a chat with <span
                        class="text-capitalize">{{ env('APP_NAME') }}</span>! </h3>
                <p>Hi! Click one of our member below to chat on <strong> WhatsApp</strong></p>
            </div>
        </div>
        <div class="modal-body">
            <strong>We Will Reply shortly</strong>
            <a href="https://wa.me/+88{{App\Models\Contact::first()->phone}}?text={{ request()->fullUrl() }}"
                class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center" style="column-gap: 8px">
                    <img src="{{ asset('public/frontEnd/images/whatsapp-white-border.png') }}" alt="WhatsApp Chat"
                        width="40px">
                    <p class="d-flex flex-column"><span>live chat</span><span
                            class="text-capitalize">{{ env('APP_NAME') }}</span></p>
                </div>
                <div>
                    <img src="{{ asset('public/frontEnd/images/whatsapp.png') }}" alt="WhatsApp Chat" width="20px">
                </div>
            </a>
        </div>
        <div class="modal-footer justify-content-center pb-3">
            <a href=""><i color="#a9a9a9" class="fa-solid fa-bolt"></i></a>
        </div>
    </div>

    <script>
        var btn = document.querySelector('.whats-app-btn');
        if (btn) {
            btn.addEventListener('click', function () {
                var popup = document.querySelector('.wa__popup_chat_box');
                var whatsapp = document.querySelector('.fa-whatsapp');
                var need_help = document.querySelector('.wa__btn_popup_txt');
                var fa_x = document.querySelector('.fa-x');
                if (popup && whatsapp) {
                    popup.classList.toggle('wa__active');
                    need_help.classList.toggle('popup_txt_hide');

                    if (popup.classList.contains('wa__active')) {
                        // Add rotation animation
                        whatsapp.style.transform = 'rotate(360deg)'; // One full rotation
                        whatsapp.style.width = '0px';
                        whatsapp.style.height = '0px';
                        whatsapp.style.top = '50%';
                        whatsapp.style.left = '50%';

                        fa_x.style.transform = 'rotate(-360deg)'; // One full rotation
                        fa_x.style.width = '26px';
                        fa_x.style.height = '26px';
                        fa_x.style.top = 'calc(50% - 13px)';
                        fa_x.style.left = 'calc(50% - 13px)';
                    }
                    else {
                        whatsapp.style.transform = 'rotate(-360deg)'; // One full rotation
                        whatsapp.style.width = '36px';
                        whatsapp.style.height = '36px';
                        whatsapp.style.top = 'calc(50% - 18px)';
                        whatsapp.style.left = 'calc(50% - 18px)';

                        fa_x.style.transform = 'rotate(360deg)'; // One full rotation
                        fa_x.style.width = '0px';
                        fa_x.style.height = '0px';
                        fa_x.style.top = '50%';
                        fa_x.style.left = '50%';
                    }
                }
            });
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset('public/frontEnd/js/mobile-menu.js')}}"></script>
    <script src="{{asset('public/frontEnd/js/wsit-menu.js')}}"></script>
    <script src="{{asset('public/frontEnd/js/mobile-menu-init.js')}}"></script>
    <script src="{{asset('public/frontEnd/js/wow.min.js')}}"></script>
    <script>
        new WOW().init();
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        window.dataLayer = window.dataLayer || [];

        dataLayer.push({
            'event': 'Pageview',
            'pagePath': window.location.href,
            'pageTitle': document.title,
            'visitorType': 'customer',
            'client_ip_address': '{{ request()->ip() }}',
            'client_user_agent': navigator.userAgent
        });
    </script>

    <!-- feather icon -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js"></script>
    <script>
        feather.replace();
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {!! Toastr::message() !!} @stack('script')
    <script>
        $(window).scroll(function () {
            if ($(window).scrollTop() > 2) {
                $('#mainskiky').css('margin-top', '0px');
            } else {
                $('#mainskiky').css('margin-top', '56px');
            }

        });
        $(".quick_view").on("click", function () {
            var id = $(this).data("id");
            $("#loading").show();
            if (id) {
                $.ajax({
                    type: "GET",
                    data: { id: id },
                    url: "{{route('quickview')}}",
                    success: function (data) {
                        if (data) {
                            $("#custom-modal").html(data);
                            $("#custom-modal").show();
                            $("#loading").hide();
                            $("#page-overlay").show();
                        }
                    },
                });
            }
        });
    </script>
    <!-- quick view end -->
    <!-- cart js start -->
    <script>
        $(".addcartbutton").on("click", function () {
            var id = $(this).data("id");
            var qty = 1;
            if (id) {
                $.ajax({
                    cache: "false",
                    type: "GET",
                    url: "{{url('add-to-cart')}}/" + id + "/" + qty,
                    dataType: "json",
                    success: function (data) {
                        if (data) {
                            toastr.success('Success', 'Product add to cart successfully');
                            return cart_count() + mobile_cart();
                        }
                    },
                });
            }
        });
        $(".cart_store").on("click", function () {
            var id = $(this).data("id");
            var qty = $(this).parent().find("input").val();
            if (id) {
                $.ajax({
                    type: "GET",
                    data: { id: id, qty: qty ? qty : 1 },
                    url: "{{route('cart.store')}}",
                    success: function (data) {
                        if (data) {
                            toastr.success('Success', 'Product add to cart succfully');
                            return cart_count() + mobile_cart();
                        }
                    },
                });
            }
        });

        $(document).on("click", ".cart_remove", function () {
            var id = $(this).data("id");
            if (id) {
                $.ajax({
                    type: "GET",
                    data: { id: id },
                    url: "{{route('cart.remove')}}",
                    success: function (data) {
                        if (data) {
                            $(".cartlist").html(data);
                            cart_count();
                            mobile_cart();
                            if (typeof cart_summary === 'function') { cart_summary(); }
                            if (typeof checkStockState === 'function') { checkStockState(); }
                        }
                    },
                });
            }
        });

        $(document).on("click", ".cart_increment", function () {
            var id = $(this).data("id");
            if (id) {
                $.ajax({
                    type: "GET",
                    data: { id: id },
                    url: "{{ route('cart.increment') }}",
                    success: function (data) {
                        if (data) {
                            $(".cartlist").html(data);
                            cart_count();
                            mobile_cart();
                            if (typeof checkStockState === 'function') { checkStockState(); }
                        }
                    },
                });
            }
        });

        $(document).on("click", ".cart_decrement", function () {
            var id = $(this).data("id");
            if (id) {
                $.ajax({
                    type: "GET",
                    data: { id: id },
                    url: "{{ route('cart.decrement') }}",
                    success: function (data) {
                        if (data) {
                            $(".cartlist").html(data);
                            cart_count();
                            mobile_cart();
                            if (typeof checkStockState === 'function') { checkStockState(); }
                        }
                    },
                });
            }
        });

        function cart_count() {
            $.ajax({
                type: "GET",
                url: "{{route('cart.count')}}",
                success: function (data) {
                    if (data) {
                        $("#cart-qty").html(data);
                        var countVal = $('<div>').html(data).find('a span').first().text().trim();
                        if (countVal) {
                            $("#order_summary_items_count").text(countVal);
                        }
                    } else {
                        $("#cart-qty").empty();
                        $("#order_summary_items_count").text(0);
                    }
                },
            });
        }
        function mobile_cart() {
            $.ajax({
                type: "GET",
                url: "{{route('mobile.cart.count')}}",
                success: function (data) {
                    if (data) {
                        $(".mobilecart-qty").html(data);
                    } else {
                        $(".mobilecart-qty").empty();
                    }
                },
            });
        }
        function cart_summary() {
            $.ajax({
                type: "GET",
                url: "{{route('shipping.charge')}}",
                dataType: "html",
                success: function (response) {
                    $(".cart-summary").html(response);
                },
            });
        }
    </script>
    <!-- cart js end -->
    <script>
        $(".search_click").on("keyup change", function () {
            var keyword = $(".search_keyword").val();
            $.ajax({
                type: "GET",
                data: { keyword: keyword },
                url: "{{route('livesearch')}}",
                success: function (products) {
                    if (products) {
                        $(".search_result").html(products);
                    } else {
                        $(".search_result").empty();
                    }
                },
            });
        });
        $(".msearch_click").on("keyup change", function () {
            var keyword = $(".msearch_keyword").val();
            $.ajax({
                type: "GET",
                data: { keyword: keyword },
                url: "{{route('livesearch')}}",
                success: function (products) {
                    if (products) {
                        $("#loading").hide();
                        $(".search_result").html(products);
                    } else {
                        $(".search_result").empty();
                    }
                },
            });
        });
    </script>
    <!-- search js start -->
    <script>
        $(document).ready(function () {
            // Set up CSRF token globally for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
        function addTowishlist(id) {
            $.ajax({
                url: "{{ route('addToWishlist') }}",
                method: "POST",
                data: {
                    id: id,
                },
                success: function (response) {
                    $('#wishlistCount').html(response.count);
                    toastr.success('Success', response.message);
                },
                error: function (xhr) {
                    toastr.error(xhr.responseText);
                }
            });
        }


        function remove_wishlist(id) {
            $.ajax({
                type: "GET",
                data: { id: id },
                url: "{{route('delete.wishlist')}}",
                success: function (data) {
                    if (data) {
                        $('#wishlistCount').html(data.count);
                        $('#item' + id).remove();
                        toastr.success('Success', 'Product remove from wishlist successfully');
                    }
                },
            });
        }

        function cart_remove(id) {
            $.ajax({
                type: "GET",
                data: { id: id },
                url: "{{route('cart.remove')}}",
                success: function (data) {
                    $('#cart' + id).remove();
                    toastr.success('Success', 'Product removed from cart successfully');
                    loadCartItems();
                    cartCount();

                    if (window.location.href.includes("checkout")) {
                        if (data && $(".cartlist").length) {
                            $(".cartlist").html(data);
                        }
                    }
                },
            });
        }
    </script>
    <script>
        $(".district").on("change", function () {
            var id = $(this).val();
            $.ajax({
                type: "GET",
                data: { id: id },
                url: "{{route('districts')}}",
                success: function (res) {
                    if (res) {
                        $(".area").empty();
                        $(".area").append('<option value="">Select..</option>');
                        $.each(res, function (key, value) {
                            $(".area").append('<option value="' + key + '" >' + value + "</option>");
                        });
                    } else {
                        $(".area").empty();
                    }
                },
            });
        });
    </script>
    <script>
        $(".toggle").on("click", function () {
            $("#page-overlay").show();
            $(".mobile-menu").addClass("active");
        });

        $("#page-overlay").on("click", function () {
            $("#page-overlay").hide();
            $(".mobile-menu").removeClass("active");
            $(".feature-products").removeClass("active");
        });

        $(".mobile-menu-close").on("click", function () {
            $("#page-overlay").hide();
            $(".mobile-menu").removeClass("active");
        });

        $(".mobile-filter-toggle").on("click", function () {
            $("#page-overlay").show();
            $(".feature-products").addClass("active");
        });
    </script>
    <script>
        $(document).ready(function () {
            $(".parent-category").each(function () {
                const menuCatToggle = $(this).find(".menu-category-toggle");
                const secondNav = $(this).find(".second-nav");

                menuCatToggle.on("click", function () {
                    menuCatToggle.toggleClass("active");
                    secondNav.slideToggle("fast");
                    $(this).closest(".parent-category").toggleClass("active");
                });
            });
            $(".parent-subcategory").each(function () {
                const menuSubcatToggle = $(this).find(".menu-subcategory-toggle");
                const thirdNav = $(this).find(".third-nav");

                menuSubcatToggle.on("click", function () {
                    menuSubcatToggle.toggleClass("active");
                    thirdNav.slideToggle("fast");
                    $(this).closest(".parent-subcategory").toggleClass("active");
                });
            });
        });
    </script>

    <script>
        var menuEl = document.querySelector("#menu");
        if (menuEl && typeof MmenuLight !== 'undefined') {
            var menu = new MmenuLight(menuEl, "all");

            var navigator = menu.navigation({
                selectedClass: "Selected",
                slidingSubmenus: true,
                title: "ক্যাটাগরি",
            });

            var drawer = menu.offcanvas({});

            var menuTrigger = document.querySelector('a[href="#menu"]');
            if (menuTrigger) {
                menuTrigger.addEventListener("click", (evnt) => {
                    evnt.preventDefault();
                    drawer.open();
                });
            }
        }
    </script>

    <script>

        $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $(".scrolltop:hidden").stop(true, true).fadeIn();
            } else {
                $(".scrolltop").stop(true, true).fadeOut();
            }
        });
        $(function () {
            $(".scroll").click(function () {
                $("html,body").animate({ scrollTop: $(".gotop").offset().top }, "1000");
                return false;
            });
        });
    </script>
    <script>
        $(".filter_btn").click(function () {
            $(".filter_sidebar").addClass('active');
            $("body").css("overflow-y", "hidden");
        })
        $(".filter_close").click(function () {
            $(".filter_sidebar").removeClass('active');
            $("body").css("overflow-y", "auto");
        })
    </script>

    <script>
        window.addEventListener('load', function () {
            const inputs = document.querySelectorAll('input[type="text"]');

            inputs.forEach(input => {
                const originalPlaceholder = input.placeholder;

                input.addEventListener('focus', () => {
                    input.placeholder = '';
                });

                input.addEventListener('blur', () => {
                    input.placeholder = originalPlaceholder;
                });
            });
        });
    </script>
</body>

</html>