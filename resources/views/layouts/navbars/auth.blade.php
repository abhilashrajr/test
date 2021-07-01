 @php
 $restaurant = App\Models\Settings::first();
 @endphp 
<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="#" class="simple-text logo-mini">
            <div class="logo-image-small">
                <img src="{{ url('storage/images/'.$restaurant->logo)}}">
            </div>
        </a>
        <a href="{{ route('home') }}" target="_blank" class="simple-text logo-normal">
            {{$restaurant->name }}
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ $elementActive == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="nc-icon nc-bank"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>

            <li class="{{ $elementActive == 'stats' ? 'active' : '' }}">
                <a href="{{ route('stats') }}">
                    <i class="nc-icon nc-chart-bar-32"></i>
                    <p>{{ __('Stats') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'order' ? 'active' : '' }}">
                <a href="{{ route('orders') }}">
                    <i class="nc-icon nc-bag-16"></i>
                    <p>{{ __('Orders') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'dinein' ? 'active' : '' }}">
                <a href="{{ route('dineinorders') }}">
                    <i class="nc-icon nc-cart-simple"></i>
                    <p>{{ __('Dine In') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'paynow' ? 'active' : '' }}">
                <a href="{{ route('paynoworders') }}">
                    <i class="nc-icon nc-credit-card"></i>
                    <p>{{ __('Pay Now') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'bookings' ? 'active' : '' }}">
                <a href="{{ route('bookings') }}">
                    <i class="nc-icon nc-tap-01"></i>
                    <p>{{ __('Bookings') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'voucherorders' ? 'active' : '' }}">
                <a href="{{ route('voucherorders') }}">
                    <i class="nc-icon nc-badge"></i>
                    <p>{{ __('Voucher Orders') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'category' ? 'active' : '' }}">
                <a href="{{ route('category.index') }}">
                    <i class="nc-icon nc-tile-56"></i>
                    <p>{{ __('Categories') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'menu' ? 'active' : '' }}">
                <a href="{{ route('menu.index') }}">
                    <i class="nc-icon nc-bullet-list-67"></i>
                    <p>{{ __('Menu') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'addoncategory' ? 'active' : '' }}">
                <a href="{{ route('addoncategory.index') }}">
                    <i class="nc-icon nc-align-left-2"></i>
                    <p>{{ __('Addon Categories') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'addonitem' ? 'active' : '' }}">
                <a href="{{ route('addonitem.index') }}">
                    <i class="nc-icon nc-paper"></i>
                    <p>{{ __('Addon Items') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'size' ? 'active' : '' }}">
                <a href="{{ route('size.index') }}">
                    <i class="nc-icon nc-app"></i>
                    <p>{{ __('Food Sizes') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'voucher' ? 'active' : '' }}">
                <a href="{{ route('voucher.index') }}">
                    <i class="nc-icon nc-badge"></i>
                    <p>{{ __('Vouchers') }}</p>
                </a>
            </li>
           <li class="{{ $elementActive == 'coupon' ? 'active' : '' }}">
                <a href="{{ route('coupon.index') }}">
                    <i class="nc-icon nc-tag-content"></i>
                    <p>{{ __('Coupons') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'settings' ? 'active' : '' }}">
                <a href="{{ route('settings.index') }}">
                    <i class="nc-icon nc-settings-gear-65"></i>
                    <p>{{ __('Settings') }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
