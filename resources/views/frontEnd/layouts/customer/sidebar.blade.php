<style>
    /* ========================================================
       TEA LUXURY CUSTOMER SIDEBAR STYLES
       ======================================================== */
    .tea-cust-sidebar-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 12px 32px -10px rgba(10, 33, 27, 0.06);
        overflow: hidden;
        margin-bottom: 24px;
    }
    .tea-cust-top-strip {
        height: 4px;
        background: linear-gradient(90deg, #173f2c 0%, #cdb06a 50%, #245a2d 100%);
    }
    .tea-cust-profile-box {
        padding: 24px 20px 20px;
        text-align: center;
        background: linear-gradient(180deg, #fafbf9 0%, #ffffff 100%);
        border-bottom: 1px solid #f1ede6;
    }
    .tea-cust-avatar-wrapper {
        position: relative;
        width: 76px;
        height: 76px;
        margin: 0 auto 12px;
    }
    .tea-cust-avatar {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e2cf9c;
        box-shadow: 0 4px 14px rgba(23, 63, 44, 0.1);
        background: #f4f8f2;
    }
    .tea-cust-avatar-fallback {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: #f4f8f2;
        border: 3px solid #e2cf9c;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #173f2c;
        font-size: 28px;
        box-shadow: 0 4px 14px rgba(23, 63, 44, 0.1);
    }
    .tea-cust-greeting {
        font-size: 12px;
        color: #cdb06a;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 2px;
    }
    .tea-cust-name {
        font-family: 'Playfair Display', 'Hind Siliguri', serif;
        font-size: 18px;
        font-weight: 700;
        color: #0a211b;
        margin: 0 0 4px;
        line-height: 1.3;
    }
    .tea-cust-phone {
        font-size: 13px;
        color: #6b7280;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .tea-cust-phone i {
        font-size: 11px;
        color: #245a2d;
    }

    /* Menu List */
    .tea-cust-menu {
        list-style: none;
        padding: 12px;
        margin: 0;
    }
    .tea-cust-menu-item {
        margin-bottom: 4px;
    }
    .tea-cust-menu-item:last-child {
        margin-bottom: 0;
    }
    .tea-cust-menu-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 16px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        color: #4b5563;
        text-decoration: none;
        transition: all 0.22s ease;
    }
    .tea-cust-menu-link i {
        font-size: 16px;
        width: 20px;
        text-align: center;
        color: #9ca3af;
        transition: color 0.2s ease;
    }
    .tea-cust-menu-link:hover {
        background: #f4f6f3;
        color: #173f2c;
    }
    .tea-cust-menu-link:hover i {
        color: #173f2c;
    }
    .tea-cust-menu-link.active {
        background: #173f2c;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(23, 63, 44, 0.22);
    }
    .tea-cust-menu-link.active i {
        color: #cdb06a;
    }

    /* Logout button */
    .tea-cust-logout-link {
        color: #dc2626 !important;
    }
    .tea-cust-logout-link i {
        color: #ef4444 !important;
    }
    .tea-cust-logout-link:hover {
        background: #fef2f2 !important;
        color: #b91c1c !important;
    }
</style>

@php
    $authCustomer = Auth::guard('customer')->user();
@endphp

<div class="tea-cust-sidebar-card">
    <div class="tea-cust-top-strip"></div>

    <div class="tea-cust-profile-box">
        <div class="tea-cust-avatar-wrapper">
            @if(!empty($authCustomer->image) && file_exists(public_path($authCustomer->image)))
                <img src="{{ asset($authCustomer->image) }}" alt="{{ $authCustomer->name }}" class="tea-cust-avatar">
            @else
                <div class="tea-cust-avatar-fallback">
                    <i class="fa-solid fa-user"></i>
                </div>
            @endif
        </div>
        <div class="tea-cust-greeting">স্বাগতম</div>
        <h4 class="tea-cust-name">{{ $authCustomer->name }}</h4>
        <div class="tea-cust-phone">
            <i class="fa-solid fa-phone"></i> {{ $authCustomer->phone }}
        </div>
    </div>

    <ul class="tea-cust-menu">
        <li class="tea-cust-menu-item">
            <a href="{{ route('customer.account') }}" class="tea-cust-menu-link {{ request()->routeIs('customer.account') ? 'active' : '' }}">
                <i class="fa-solid fa-id-card"></i>
                <span>আমার অ্যাকাউন্ট (My Account)</span>
            </a>
        </li>
        <li class="tea-cust-menu-item">
            <a href="{{ route('customer.orders') }}" class="tea-cust-menu-link {{ request()->routeIs('customer.orders') ? 'active' : '' }}">
                <i class="fa-solid fa-box-archive"></i>
                <span>আমার অর্ডারসমূহ (My Orders)</span>
            </a>
        </li>
        <li class="tea-cust-menu-item">
            <a href="{{ route('customer.profile_edit') }}" class="tea-cust-menu-link {{ request()->routeIs('customer.profile_edit') ? 'active' : '' }}">
                <i class="fa-solid fa-user-pen"></i>
                <span>প্রোফাইল পরিবর্তন (Edit Profile)</span>
            </a>
        </li>
        <li class="tea-cust-menu-item">
            <a href="{{ route('customer.change_pass') }}" class="tea-cust-menu-link {{ request()->routeIs('customer.change_pass') ? 'active' : '' }}">
                <i class="fa-solid fa-key"></i>
                <span>পাসওয়ার্ড পরিবর্তন (Password)</span>
            </a>
        </li>
        <li class="tea-cust-menu-item">
            <a href="{{ route('customer.order_track') }}" class="tea-cust-menu-link">
                <i class="fa-solid fa-truck-fast"></i>
                <span>অর্ডার ট্র্যাকিং (Order Track)</span>
            </a>
        </li>
        <li class="tea-cust-menu-item">
            <a href="{{ route('customer.logout') }}" 
               class="tea-cust-menu-link tea-cust-logout-link"
               onclick="event.preventDefault(); document.getElementById('customer-logout-form').submit();">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>লগআউট (Logout)</span>
            </a>
            <form id="customer-logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</div>