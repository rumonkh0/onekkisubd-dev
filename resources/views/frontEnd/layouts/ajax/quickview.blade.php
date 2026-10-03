@php
    $discount = 0;
    if ($data->old_price && $data->old_price > $data->new_price) {
        $discount = (($data->old_price - $data->new_price) * 100) / $data->old_price;
    }
@endphp

<div class="tea-quickview-overlay">
    <div class="tea-quickview-modal">
        <!-- Close Button -->
        <button type="button" class="tea-quickview-close" aria-label="Close Modal">
            <i class="fas fa-times"></i>
        </button>

        <div class="tea-quickview-grid">
            <!-- Left: Product Image -->
            <div class="tea-quickview-media">
                @if($discount > 0)
                    <span class="tea-quickview-discount-badge">{{ number_format($discount, 0) }}% ছাড়</span>
                @endif
                <div class="tea-quickview-img-box">
                    <img src="{{ asset($data->image ? $data->image->image : 'public/uploads/default.png') }}"
                         alt="{{ $data->name }}" />
                </div>
            </div>

            <!-- Right: Product Information -->
            <div class="tea-quickview-content">
                <!-- Meta tags -->
                <div class="tea-quickview-tags">
                    @if($data->category)
                        <span class="tea-quickview-cat-badge">
                            <i class="fas fa-leaf"></i> {{ $data->category->name }}
                        </span>
                    @endif
                    @if($data->brand)
                        <span class="tea-quickview-brand-badge">
                            <i class="fas fa-certificate"></i> {{ $data->brand->name }}
                        </span>
                    @endif
                </div>

                <!-- Product Name -->
                <h2 class="tea-quickview-title">
                    <a href="{{ route('product', $data->slug) }}">
                        {{ $data->name }}
                    </a>
                </h2>

                <!-- Rating if available -->
                @if($data->reviews_count > 0)
                    <div class="tea-quickview-reviews">
                        <span class="tea-stars text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </span>
                        <span class="tea-reviews-text">({{ $data->reviews_count }}টি রিভিউ)</span>
                    </div>
                @endif

                <!-- Pricing -->
                <div class="tea-quickview-pricing">
                    <span class="tea-quickview-new-price">৳ {{ number_format($data->new_price, 0) }}</span>
                    @if($data->old_price && $data->old_price > $data->new_price)
                        <span class="tea-quickview-old-price">৳ {{ number_format($data->old_price, 0) }}</span>
                    @endif
                </div>

                <!-- Short Description -->
                @if(!empty($data->short_description))
                    <div class="tea-quickview-desc">
                        {!! $data->short_description !!}
                    </div>
                @endif

                <!-- Cart Form -->
                <form action="{{ route('cart.store') }}" method="POST" class="tea-quickview-form m-0">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id }}" />

                    <div class="tea-quickview-actions">
                        <!-- Stepper -->
                        <div class="tea-quickview-stepper">
                            <button type="button" class="tea-stepper-btn tea-stepper-minus">-</button>
                            <input type="number" name="qty" class="tea-stepper-input" value="1" min="1" readonly />
                            <button type="button" class="tea-stepper-btn tea-stepper-plus">+</button>
                        </div>

                        <!-- Add to Cart CTA -->
                        <button type="button" class="tea-quickview-add-btn cart_store" data-id="{{ $data->id }}">
                            <i class="fas fa-shopping-bag"></i> কার্ট-এ যোগ করুন
                        </button>
                    </div>
                </form>

                <!-- Full Details Link -->
                <div class="tea-quickview-footer">
                    <a href="{{ route('product', $data->slug) }}" class="tea-quickview-details-link">
                        সম্পূর্ণ বিস্তারিত দেখুন <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ========================================================
       LUXURY DARK TEA QUICKVIEW MODAL STYLES
       ======================================================== */
    .tea-quickview-overlay {
        position: fixed;
        inset: 0;
        z-index: 100000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        background: rgba(10, 33, 27, 0.65);
        backdrop-filter: blur(4px);
    }
    .tea-quickview-modal {
        position: relative;
        width: 100%;
        max-width: 780px;
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 24px 60px -12px rgba(10, 33, 27, 0.4);
        overflow: hidden;
        animation: quickviewSlideIn 0.25s ease-out;
    }
    @keyframes quickviewSlideIn {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(12px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .tea-quickview-close {
        position: absolute;
        top: 14px;
        right: 14px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        color: #4b5563;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.2s ease;
    }
    .tea-quickview-close:hover {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
        transform: rotate(90deg);
    }

    .tea-quickview-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        min-height: 400px;
    }

    /* Left Media */
    .tea-quickview-media {
        background: #fbf9f5;
        padding: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        border-right: 1px solid #f0ece3;
    }
    .tea-quickview-discount-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%);
        color: #ffffff;
        font-size: 11.5px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(220, 38, 38, 0.25);
    }
    .tea-quickview-img-box {
        width: 100%;
        max-width: 280px;
        aspect-ratio: 1 / 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .tea-quickview-img-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }
    .tea-quickview-img-box:hover img {
        transform: scale(1.05);
    }

    /* Right Content */
    .tea-quickview-content {
        padding: 32px 28px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .tea-quickview-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 12px;
    }
    .tea-quickview-cat-badge,
    .tea-quickview-brand-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11.5px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 10px;
        background: #f4f8f2;
        color: #173f2c;
        border: 1px solid #c9dec4;
    }

    .tea-quickview-title {
        font-family: 'Playfair Display', 'Hind Siliguri', serif;
        font-size: 21px;
        font-weight: 700;
        color: #0a211b;
        margin: 0 0 10px 0;
        line-height: 1.35;
    }
    .tea-quickview-title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .tea-quickview-title a:hover {
        color: #cdb06a;
    }

    .tea-quickview-reviews {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        margin-bottom: 12px;
    }
    .tea-reviews-text {
        color: #6b7280;
    }

    .tea-quickview-pricing {
        display: flex;
        align-items: baseline;
        gap: 12px;
        margin-bottom: 16px;
    }
    .tea-quickview-new-price {
        font-size: 24px;
        font-weight: 800;
        color: #173f2c;
    }
    .tea-quickview-old-price {
        font-size: 15px;
        color: #9ca3af;
        text-decoration: line-through;
    }

    .tea-quickview-desc {
        font-size: 13.5px;
        color: #4b5563;
        line-height: 1.6;
        margin-bottom: 20px;
        max-height: 90px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    /* Actions */
    .tea-quickview-actions {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 18px;
    }
    .tea-quickview-stepper {
        display: inline-flex;
        align-items: center;
        border: 1.5px solid #d1d5db;
        border-radius: 20px;
        overflow: hidden;
        background: #ffffff;
        height: 42px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
    }
    .tea-stepper-btn {
        width: 36px;
        height: 100%;
        background: #f9fafb;
        border: none;
        font-size: 18px;
        font-weight: 700;
        color: #374151;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.15s ease;
    }
    .tea-stepper-btn:hover {
        background: #e5e7eb;
        color: #111827;
    }
    .tea-stepper-input {
        width: 44px;
        height: 100%;
        border: none;
        text-align: center;
        font-size: 15px;
        font-weight: 700;
        color: #111827;
        background: transparent;
        outline: none;
    }

    .tea-quickview-add-btn {
        flex-grow: 1;
        height: 42px;
        background: #173f2c;
        color: #ffffff;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(23, 63, 44, 0.18);
    }
    .tea-quickview-add-btn:hover {
        background: #245a2d;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(36, 90, 45, 0.25);
    }

    .tea-quickview-footer {
        padding-top: 12px;
        border-top: 1px solid #f3f4f6;
    }
    .tea-quickview-details-link {
        font-size: 13.5px;
        font-weight: 600;
        color: #173f2c;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: color 0.2s ease;
    }
    .tea-quickview-details-link:hover {
        color: #cdb06a;
    }
    .tea-quickview-details-link i {
        font-size: 11px;
        transition: transform 0.2s ease;
    }
    .tea-quickview-details-link:hover i {
        transform: translateX(4px);
    }

    @media (max-width: 680px) {
        .tea-quickview-grid {
            grid-template-columns: 1fr;
        }
        .tea-quickview-media {
            padding: 20px;
            border-right: none;
            border-bottom: 1px solid #f0ece3;
        }
        .tea-quickview-img-box {
            max-width: 180px;
        }
        .tea-quickview-content {
            padding: 20px 18px;
        }
        .tea-quickview-title {
            font-size: 18px;
        }
        .tea-quickview-new-price {
            font-size: 20px;
        }
        .tea-quickview-actions {
            flex-direction: column;
            gap: 10px;
        }
        .tea-quickview-stepper {
            width: 100%;
            justify-content: space-between;
        }
        .tea-stepper-btn {
            width: 48px;
        }
        .tea-quickview-add-btn {
            width: 100%;
        }
    }
</style>

<script>
    (function() {
        // Modal Close triggers
        $('.tea-quickview-close, .tea-quickview-overlay').on('click', function(e) {
            if ($(e.target).closest('.tea-quickview-modal').length && !$(e.target).closest('.tea-quickview-close').length) {
                return;
            }
            $('#custom-modal').hide();
            $('#page-overlay').hide();
        });

        // Quantity Stepper
        $('.tea-stepper-minus').on('click', function() {
            var $input = $(this).siblings('.tea-stepper-input');
            var val = parseInt($input.val()) || 1;
            if (val > 1) {
                $input.val(val - 1).trigger('change');
            }
        });

        $('.tea-stepper-plus').on('click', function() {
            var $input = $(this).siblings('.tea-stepper-input');
            var val = parseInt($input.val()) || 1;
            $input.val(val + 1).trigger('change');
        });
    })();
</script>