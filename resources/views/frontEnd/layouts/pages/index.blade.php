@extends('frontEnd.layouts.master')

@section('title', 'Pure Taste of Nature - ' . ($generalsetting->name ?? 'OnekkisuBD'))

@push('seo')
    <meta name="app-url" content="{{ url('/') }}" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="Handcrafted premium tea, collected from authentic sources to bring you a healthier and happier life. 100% Organic & Natural." />
    <meta name="keywords" content="tea, organic tea, green tea, roselle tea, orthodox black tea, bangladesh tea" />
    <meta property="og:title" content="OnekkisuBD - Experience The Pure Taste Of Nature" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:image" content="{{ asset('frontEnd/images/theme/hero-banner.png') }}" />
    <meta property="og:description" content="Handcrafted premium tea, collected from authentic sources to bring you a healthier and happier life." />
@endpush

@section('content')
<div class="figma-theme">

    <!-- ==========================================================================
         SECTION 1: HERO SECTION (Node 9:5 - 1440x657)
         ========================================================================== -->
    <section class="figma-hero-section">
        <!-- Desktop Hero Exact Artwork Canvas -->
        <div class="figma-hero-exact-canvas d-none d-md-block">
            <img src="{{ asset('frontEnd/images/theme/hero-banner.png') }}" alt="Experience The Pure Taste Of Nature - OnekkisuBD" class="figma-hero-exact-img" />
            
            <!-- Accessible SEO Semantics for Search Engines & Screen Readers -->
            <div class="visually-hidden">
                <h1>Experience The Pure Taste Of Nature</h1>
                <p>Handcrafted premium tea, collected from authentic sources to bring you a healthier and happier life.</p>
                <ul>
                    <li>100% Natural</li>
                    <li>Premium Quality</li>
                    <li>Fast Delivery</li>
                    <li>Trusted By Thousands</li>
                </ul>
            </div>

            <!-- Clickable Interactive Hotspots Exactly Over Visual Buttons -->
            <a href="{{ url('shop') }}" class="figma-hero-hotspot figma-hotspot-shop" title="Shop Collection" aria-label="Shop Collection"></a>
            <a href="{{ url('page/about-us') }}" class="figma-hero-hotspot figma-hotspot-benefits" title="Explore Benefits" aria-label="Explore Benefits"></a>
        </div>

        <!-- Mobile Hero Content (for screens < 768px where 1440px banner text would be tiny) -->
        <div class="figma-hero-mobile-wrap d-md-none">
            <div class="figma-container">
                <div class="hero-pill-tag">
                    <i class="fas fa-leaf"></i> &mdash; BANGLADESH'S TRUSTED TEA BRAND &mdash;
                </div>
                <h1 class="hero-main-title">
                    Experience <br>
                    <span class="gold-accent">The Pure Taste</span> <br>
                    Of Nature
                </h1>
                <p class="hero-description">
                    Handcrafted premium tea, collected from authentic sources to bring you a healthier and happier life.
                </p>
                <div class="hero-cta-group">
                    <a href="{{ url('shop') }}" class="btn-figma-primary">
                        Shop Collection <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="{{ url('page/about-us') }}" class="btn-figma-outline">
                        <i class="fas fa-leaf"></i> Explore Benefits
                    </a>
                </div>
                <div class="hero-trust-strip">
                    <div class="hero-trust-item"><i class="fas fa-seedling"></i> 100% Natural</div>
                    <div class="hero-trust-item"><i class="fas fa-shield-halved"></i> Premium Quality</div>
                    <div class="hero-trust-item"><i class="fas fa-truck-fast"></i> Fast Delivery</div>
                    <div class="hero-trust-item"><i class="fas fa-users"></i> Trusted By Thousands</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================================
         SECTION 2: FLASH SALES (Node 10:6)
         ========================================================================== -->
    <section class="figma-section figma-section-flash" style="background-color: #f8faf8; padding: 24px 0 28px 0;">
        <div class="figma-container">
            <!-- Section Header + Countdown Timer -->
            <div class="figma-section-header">
                <div>
                    <h2 class="sec-main-title">
                        FLASH <span class="text-brand-green">SALES</span> <i class="fas fa-bolt text-brand-green sec-bolt-icon"></i>
                    </h2>
                    <p class="sec-description">Premium Teas at Special Prices &nbsp;|&nbsp; Limited Time Offer</p>
                </div>

                <div class="figma-header-right">
                    <!-- Live Countdown Timer -->
                    <div class="deal-countdown-box">
                        <div class="deal-label">
                            <span class="deal-clock-svg" style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="13" r="8" fill="#1e6833"/>
                                    <path d="M12 9.5V13L14.5 15" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M5 5.5L7.5 7.5" stroke="#1e6833" stroke-width="2.2" stroke-linecap="round"/>
                                    <path d="M19 5.5L16.5 7.5" stroke="#1e6833" stroke-width="2.2" stroke-linecap="round"/>
                                    <path d="M7 20.5L5.5 22" stroke="#1e6833" stroke-width="2.2" stroke-linecap="round"/>
                                    <path d="M17 20.5L18.5 22" stroke="#1e6833" stroke-width="2.2" stroke-linecap="round"/>
                                </svg>
                            </span>
                            <span>Deal Ends In</span>
                        </div>
                        <div class="countdown-digits-wrapper">
                            <div class="cd-item">
                                <span class="cd-digit-block" id="flash-hours">11</span>
                                <span class="cd-digit-label">Hours</span>
                            </div>
                            <div class="cd-item">
                                <span class="cd-digit-block" id="flash-mins">56</span>
                                <span class="cd-digit-label">Minutes</span>
                            </div>
                            <div class="cd-item">
                                <span class="cd-digit-block" id="flash-secs">23</span>
                                <span class="cd-digit-label">Seconds</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ url('shop') }}" class="btn-figma-view-all">
                        View All <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Product Grid (6 Items matching Figma) -->
            <div class="figma-product-grid">
                @php
                    $flashItems = $hotdeal_top && $hotdeal_top->count() > 0 ? $hotdeal_top->take(6) : \App\Models\Product::with('image')->take(6)->get();
                @endphp

                @foreach($flashItems as $prod)
                    @php
                        $hasOldPrice = !empty($prod->old_price);
                        $discountPct = (!empty($prod->old_price) && $prod->old_price > $prod->new_price) 
                            ? round((($prod->old_price - $prod->new_price) / $prod->old_price) * 100) 
                            : 0;
                        
                        $figmaCardImages = [
                            29 => 'frontEnd/images/theme/flash_prod_1.png',
                            11 => 'frontEnd/images/theme/flash_prod_2.png',
                            10 => 'frontEnd/images/theme/flash_prod_3.png',
                            9  => 'frontEnd/images/theme/flash_prod_4.png',
                            6  => 'frontEnd/images/theme/flash_prod_5.png',
                            43 => 'frontEnd/images/theme/flash_prod_6.png',
                        ];
                        $isFigmaImage = isset($figmaCardImages[$prod->id]) && file_exists(public_path($figmaCardImages[$prod->id]));
                        $prodImg = $isFigmaImage ? asset($figmaCardImages[$prod->id]) : ($prod->image ? asset($prod->image->image) : asset('frontEnd/images/theme/cat_arch_1.png'));
                        
                        // Parse English Name and Bengali Subtitle if contained in parentheses
                        $rawName = $prod->name;
                        if (str_contains($rawName, '80gm')) {
                            $engName = 'Pahari Red Roselle Net Weight';
                            $bnName = '80gm (পাহাড়ি রোজেলা)';
                        } elseif (preg_match('/^([^(]+)\s*\((.+)\)$/u', $rawName, $matches)) {
                            $engName = trim($matches[1]);
                            $bnName = '(' . trim($matches[2]) . ')';
                        } else {
                            $engName = $rawName;
                            $bnName = '';
                        }
                    @endphp
                    <div class="figma-card">
                        @if(!$isFigmaImage)
                            <span class="card-badge-sale">{{ $discountPct }}% OFF</span>

                            <div class="card-badge-brand">
                                <img src="{{ asset('frontEnd/images/theme/brand_logo_card.png') }}" alt="অনেককিছু" />
                            </div>
                        @endif

                        <div class="figma-card-img-wrap">
                            <a href="{{ route('product', $prod->slug) }}">
                                <img src="{{ $prodImg }}" alt="{{ $prod->name }}" loading="lazy" />
                            </a>
                        </div>

                        <h4 class="figma-card-title">
                            <a href="{{ route('product', $prod->slug) }}" title="{{ $engName }}">{{ $engName }}</a>
                        </h4>
                        @if($bnName)
                            <div class="figma-card-subtitle" title="{{ $bnName }}">
                                {{ $bnName }}
                            </div>
                        @endif

                        <div class="figma-card-price">
                            @if($hasOldPrice)
                                <span class="old-price">৳ {{ number_format($prod->old_price, 0) }}</span>
                            @endif
                            <span class="current-price">৳ {{ number_format($prod->new_price, 0) }}</span>
                        </div>

                        <div class="figma-card-actions">
                            <div class="figma-btn-cart-row">
                                <button type="button" class="btn-card-addcart cart_store" data-id="{{ $prod->id }}">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                                <button type="button" class="btn-card-wishlist" onclick="addTowishlist('{{ $prod->id }}')" title="Add to Wishlist">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                            @if (!$prod->prosizes->isEmpty() || !$prod->procolors->isEmpty())
                                <a href="{{ route('product', $prod->slug) }}" class="btn-card-buynow">Buy Now</a>
                            @else
                                <form action="{{ route('cart.store') }}" method="POST" class="m-0 p-0 w-100">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $prod->id }}" />
                                    <input type="hidden" name="qty" value="1" />
                                    <button type="submit" class="btn-card-buynow">Buy Now</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Guarantee Pillar Bar -->
            <div class="figma-trust-bar">
                <div class="trust-pillar">
                    <div class="trust-pillar-icon circle-icon"><i class="fas fa-leaf"></i></div>
                    <div class="trust-pillar-text">
                        <h5>100% Natural &amp; Organic</h5>
                        <p>Pure goodness in every cup</p>
                    </div>
                </div>
                <div class="trust-pillar">
                    <div class="trust-pillar-icon plain-icon"><i class="fas fa-truck-fast"></i></div>
                    <div class="trust-pillar-text">
                        <h5>Fast &amp; Reliable Delivery</h5>
                        <p>Across Bangladesh</p>
                    </div>
                </div>
                <div class="trust-pillar">
                    <div class="trust-pillar-icon shield-icon">
                        <svg width="24" height="26" viewBox="0 0 24 28" fill="none">
                            <path d="M12 1L2 5V13C2 20 6.5 25.5 12 27C17.5 25.5 22 20 22 13V5L12 1Z" fill="#1e6833"/>
                            <path d="M8.5 13.5L11 16L15.5 10.5" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="trust-pillar-text">
                        <h5>Secure Payment</h5>
                        <p>Your data is safe with us</p>
                    </div>
                </div>
                <div class="trust-pillar">
                    <div class="trust-pillar-icon circle-icon"><i class="fas fa-leaf"></i></div>
                    <div class="trust-pillar-text">
                        <h5>Trusted by Tea Lovers</h5>
                        <p>Quality you can count on</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================================
         SECTION 3: NEW ARRIVALS (Node 10:7)
         ========================================================================== -->
    <section class="figma-section" style="background-color: #f8f9f7;">
        <div class="figma-container">
            <!-- Header -->
            <div class="figma-section-header">
                <div>
                    <div class="sec-subtitle-pill">DISCOVER OUR LATEST</div>
                    <h2 class="sec-main-title">
                        NEW ARRIVALS <i class="fas fa-leaf text-success" style="font-size: 24px;"></i>
                    </h2>
                    <p class="sec-description">Fresh Teas. New Flavours. A Healthier You.</p>
                </div>

                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="d-none d-md-flex align-items-center gap-3 text-muted small fw-semibold">
                        <span><i class="fas fa-truck text-success me-1"></i> Fast Delivery Across Bangladesh</span>
                        <span>&bull;</span>
                        <span><i class="fas fa-seedling text-success me-1"></i> 100% Organic Pure &amp; Natural</span>
                        <span>&bull;</span>
                        <span><i class="fas fa-certificate text-success me-1"></i> Loved by Tea Lovers</span>
                    </div>
                    <a href="{{ url('shop') }}" class="btn-figma-view-all">
                        View All <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- 6 Product Cards Grid -->
            <div class="figma-product-grid">
                @php
                    $newArrivalItems = $new_products && $new_products->count() > 0 ? $new_products->take(6) : \App\Models\Product::with('image')->latest()->take(6)->get();
                @endphp

                @foreach($newArrivalItems as $nprod)
                    @php
                        $hasOldPrice = !empty($nprod->old_price) && $nprod->old_price > $nprod->new_price;
                        $discountPct = $hasOldPrice ? round((($nprod->old_price - $nprod->new_price) / $nprod->old_price) * 100) : 0;
                        $nprodImg = $nprod->image ? asset($nprod->image->image) : asset('frontEnd/images/theme/cat_arch_2.png');
                        
                        $rawName = $nprod->name;
                        $engName = $rawName;
                        $bnName = '';
                        if (preg_match('/^([^(]+)\s*\((.+)\)$/u', $rawName, $matches)) {
                            $engName = trim($matches[1]);
                            $bnName = '(' . trim($matches[2]) . ')';
                        }
                    @endphp
                    <div class="figma-card">
                        @if($discountPct > 0)
                            <span class="card-badge-sale" style="background: #2b7a4b;">{{ $discountPct }}% OFF</span>
                        @endif

                        <button type="button" class="card-badge-wishlist" onclick="addTowishlist('{{ $nprod->id }}')" title="Add to Wishlist">
                            <i class="far fa-heart"></i>
                        </button>

                        <div class="figma-card-img-wrap">
                            <a href="{{ route('product', $nprod->slug) }}">
                                <img src="{{ $nprodImg }}" alt="{{ $nprod->name }}" loading="lazy" />
                            </a>
                        </div>

                        <h4 class="figma-card-title">
                            <a href="{{ route('product', $nprod->slug) }}">{{ $engName }}</a>
                        </h4>
                        @if($bnName)
                            <div class="text-muted small text-center mb-1" style="font-family: var(--fk-font-bengali); font-size: 12px; color: #526759;">
                                {{ $bnName }}
                            </div>
                        @endif

                        <div class="figma-card-rating justify-content-center">
                            <span>★★★★★</span>
                            <span class="review-count">({{ rand(20, 50) }})</span>
                        </div>

                        <div class="figma-card-price justify-content-center">
                            @if($hasOldPrice)
                                <span class="old-price">৳ {{ number_format($nprod->old_price, 0) }}</span>
                            @endif
                            <span class="current-price">৳ {{ number_format($nprod->new_price, 0) }}</span>
                        </div>

                        <div class="figma-card-actions">
                            <button type="button" class="btn-card-addcart cart_store w-100" data-id="{{ $nprod->id }}">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                            @if (!$nprod->prosizes->isEmpty() || !$nprod->procolors->isEmpty())
                                <a href="{{ route('product', $nprod->slug) }}" class="btn-card-buynow">Buy Now</a>
                            @else
                                <form action="{{ route('cart.store') }}" method="POST" class="m-0 p-0">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $nprod->id }}" />
                                    <input type="hidden" name="qty" value="1" />
                                    <button type="submit" class="btn-card-buynow">Buy Now</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Bottom Guarantee Bar -->
            <div class="figma-trust-bar">
                <div class="trust-pillar">
                    <div class="trust-pillar-icon"><i class="fas fa-leaf"></i></div>
                    <div class="trust-pillar-text">
                        <h5>100% Natural Ingredients</h5>
                        <p>Pure goodness in every cup</p>
                    </div>
                </div>
                <div class="trust-pillar">
                    <div class="trust-pillar-icon"><i class="fas fa-truck-fast"></i></div>
                    <div class="trust-pillar-text">
                        <h5>Fast &amp; Reliable Delivery</h5>
                        <p>All over Bangladesh</p>
                    </div>
                </div>
                <div class="trust-pillar">
                    <div class="trust-pillar-icon"><i class="fas fa-shield-halved"></i></div>
                    <div class="trust-pillar-text">
                        <h5>Secure Payment</h5>
                        <p>Your information is safe with us</p>
                    </div>
                </div>
                <div class="trust-pillar">
                    <div class="trust-pillar-icon"><i class="fas fa-users"></i></div>
                    <div class="trust-pillar-text">
                        <h5>Happy Customers</h5>
                        <p>Trusted by thousands</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================================
         SECTION 4: TOP CATEGORIES (Node 10:8)
         ========================================================================== -->
    <section class="figma-section" style="background-color: #f8f6f3;">
        <div class="figma-container text-center">
            <!-- Header with side flourishes -->
            <div class="position-relative mb-5">
                <div class="d-none d-lg-block position-absolute start-0 top-50 translate-middle-y text-start">
                    <span class="sec-side-accent-text">NATURAL &bull; PURE &bull; PREMIUM</span>
                </div>

                <div>
                    <div class="sec-subtitle-pill">&mdash; EXPLORE OUR &mdash;</div>
                    <h2 class="sec-main-title" style="font-size: 42px;">
                        Top <span style="color: var(--fk-gold); font-style: italic;">Categories</span>
                    </h2>
                    <p class="sec-description mt-2">PREMIUM TEAS FOR A HEALTHIER, HAPPIER YOU</p>
                    <div class="d-flex align-items-center justify-content-center gap-2 mt-2 text-muted">
                        <i class="fas fa-leaf text-success" style="font-size: 13px;"></i>
                    </div>
                </div>

                <div class="d-none d-lg-block position-absolute end-0 top-50 translate-middle-y text-end">
                    <span class="sec-side-script-text">Good Tea Better Days</span>
                </div>
            </div>

            <!-- 6 Exact Arch-Top Category Cards -->
            <div class="figma-cat-grid">
                @php
                    $catSpecs = [
                        ['name' => 'Fruit & Flower Tea', 'count' => '24 Products', 'slug' => 'fruit-&-flower-(চা)'],
                        ['name' => 'Black Tea', 'count' => '16 Products', 'slug' => 'black-tea(দুধ-চালাল-চা)'],
                        ['name' => 'Green Tea', 'count' => '20 Products', 'slug' => 'green-tea-(গ্রিন-টি-)'],
                        ['name' => 'Roselle Tea', 'count' => '18 Products', 'slug' => 'roselle-tea(চাশরবত)'],
                        ['name' => 'Masala', 'count' => '12 Products', 'slug' => 'masala(মসলা)'],
                        ['name' => 'Tea Jar & Accessories', 'count' => '10 Products', 'slug' => 'tea-jar-500ml-(সেল🔥)'],
                    ];
                @endphp

                @foreach($catSpecs as $i => $cs)
                    @php
                        $catNum = $i + 1;
                        $dbCat = isset($frontcategory) ? $frontcategory->firstWhere('slug', $cs['slug']) : null;
                        $catUrl = $dbCat ? route('category', $dbCat->slug) : url('category/' . $cs['slug']);
                    @endphp
                    <a href="{{ $catUrl }}" class="figma-cat-arch-card" title="{{ $cs['name'] }}">
                        <img src="{{ asset('frontEnd/images/theme/cat_card_' . $catNum . '.png') }}" alt="{{ $cs['name'] }}" loading="lazy" />
                    </a>
                @endforeach
            </div>

            <!-- Bottom Button -->
            <div class="mt-5">
                <a href="{{ url('shop') }}" class="btn-figma-primary" style="padding: 14px 34px;">
                    View All Categories <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ==========================================================================
         SECTION 5: TEA STORIES & KNOWLEDGE BLOG (Node 10:9)
         ========================================================================== -->
    <section class="figma-section" style="background-color: #f7f3ee;">
        <div class="figma-container">
            <!-- Header -->
            <div class="figma-section-header">
                <div>
                    <div class="sec-subtitle-pill">FROM OUR BLOG &mdash;</div>
                    <h2 class="sec-main-title">
                        Tea Stories &amp; Knowledge <i class="fas fa-leaf text-success" style="font-size: 24px;"></i>
                    </h2>
                    <p class="sec-description">Discover health benefits, brewing tips, history and more about your favourite teas.</p>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <span class="d-none d-md-block" style="font-family: var(--fk-font-script); font-size: 24px; color: var(--fk-primary);">
                        Good Tea Good Life
                    </span>
                    <a href="{{ url('blog-list') }}" class="btn-figma-view-all">
                        View All Articles <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- 5 Editorial Blog Cards Grid -->
            <div class="figma-blog-grid">
                @php
                    $blogCategories = ['HEALTH', 'LIFESTYLE', 'HISTORY', 'HEALTH', 'GUIDE'];
                    $blogItems = isset($blog) && $blog->count() > 0 ? $blog->take(5) : \App\Models\Blog::take(5)->get();
                @endphp

                @foreach($blogItems as $idx => $b)
                    @php
                        $chipText = $blogCategories[$idx % count($blogCategories)];
                        $thumbImg = file_exists(public_path('frontEnd/images/theme/blog_thumb_' . ($idx + 1) . '.png'))
                            ? asset('frontEnd/images/theme/blog_thumb_' . ($idx + 1) . '.png')
                            : ($b->b_image ? asset($b->b_image) : asset('frontEnd/images/theme/cat_arch_1.png'));
                        $bTitle = !empty($b->b_title) ? $b->b_title : 'রোজেল চায়ের স্বাস্থ্য উপকারিতা (Health Benefits of Hibiscus Roselle)';
                        $bExcerpt = !empty($b->b_short_des) ? Str::limit(strip_tags($b->b_short_des), 90) : (!empty($b->b_long_des) ? Str::limit(strip_tags($b->b_long_des), 90) : 'রোজেলা চা শুধু সুস্বাদু নয়, এটি স্বাস্থ্যের জন্যও অত্যন্ত উপকারী। এতে রয়েছে প্রাকৃতিক অ্যান্টিঅক্সিডেন্ট...');
                        $bDate = !empty($b->b_date) ? date('d M Y', strtotime($b->b_date)) : '12 Sep 2026';
                    @endphp
                    <a href="{{ url('blog-details/' . ($b->b_slug ?? $b->id)) }}" class="figma-blog-card">
                        <div class="blog-img-wrap">
                            <img src="{{ $thumbImg }}" alt="{{ $bTitle }}" loading="lazy" />
                            <span class="blog-category-chip">{{ $chipText }}</span>
                        </div>
                        <div class="blog-content-wrap">
                            <h4 class="blog-card-title">{{ $bTitle }}</h4>
                            <p class="blog-card-excerpt">{{ $bExcerpt }}</p>
                            <div class="blog-card-footer">
                                <span class="blog-card-author">
                                    <i class="fas fa-user-circle text-muted"></i> Admin &bull; {{ $bDate }}
                                </span>
                                <span class="blog-card-readmore">Read More &rarr;</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

</div>

<!-- Countdown Timer JavaScript -->
<script>
    (function() {
        const now = new Date();
        const target = new Date();
        target.setHours(23, 59, 59, 999);

        function updateTimer() {
            const current = new Date();
            let diff = Math.max(0, target - current);

            const hours = Math.floor(diff / (1000 * 60 * 60));
            diff -= hours * (1000 * 60 * 60);

            const mins = Math.floor(diff / (1000 * 60));
            diff -= mins * (1000 * 60);

            const secs = Math.floor(diff / 1000);

            const elH = document.getElementById('flash-hours');
            const elM = document.getElementById('flash-mins');
            const elS = document.getElementById('flash-secs');

            if (elH) elH.textContent = String(hours).padStart(2, '0');
            if (elM) elM.textContent = String(mins).padStart(2, '0');
            if (elS) elS.textContent = String(secs).padStart(2, '0');
        }

        updateTimer();
        setInterval(updateTimer, 1000);
    })();
</script>
@endsection
