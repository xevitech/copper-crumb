<!-- Top Bar Start -->
<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <a href="{{ route('customer.dashboard') }}" class="logo">
            <span>
                <img src={{ site_logo() }} class="ic-logo-height" alt="logo">
            </span>
            <i>
                <img src={{ site_logo() }} class="ic-logo-small" alt="logo">
            </i>
        </a>
        <div class="float-right">
            <button class="button-menu-mobile ic-collapsed-btn mobile-device-arrow open-left">
                <div class="ic-medi-menu">
                    <div class="ic-bar"></div>
                    <div class="ic-bar"></div>
                    <div class="ic-bar"></div>
                </div>
            </button>
        </div>
    </div>
    <nav class="navbar-custom">
        <ul class="navbar-right d-flex list-inline float-right mb-0 align-items-center">
            <!-- sync-->
            <!-- language-->
{{--           <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">--}}
{{--                <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button"--}}
{{--                   aria-haspopup="false" aria-expanded="false">--}}
{{--                    @if(app()->getLocale() == 'en')--}}
{{--                        <img src="/admin/images/us_flag.jpg" class="mr-2" height="12" alt=""/> English <span--}}
{{--                            class="mdi mdi-chevron-down"></span>--}}
{{--                    @else--}}
{{--                        <img src="/admin/images/bd_flag.png" class="mr-2" height="12" alt=""/> বাংলা <span--}}
{{--                            class="mdi mdi-chevron-down"></span>--}}
{{--                    @endif--}}
{{--                </a>--}}
{{--                <div class="dropdown-menu dropdown-menu-right language-switch">--}}
{{--                    <a class="dropdown-item d-flex align-items-center justify-content-between flex-row-reverse"--}}
{{--                       href="{{ route('admin.set-lang') }}?lang=bn">--}}
{{--                        <img src="/admin/images/bd_flag.png" alt="" height="16"/><span> বাংলা </span>--}}
{{--                    </a>--}}
{{--                    <a class="dropdown-item d-flex align-items-center justify-content-between flex-row-reverse"--}}
{{--                       href="{{ route('admin.set-lang') }}?lang=en">--}}
{{--                        <img src="/admin/images/us_flag.jpg" alt="" height="16"/><span> English </span>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </li>--}}

            <!-- sync-->
{{--            <li class="dropdown notification-list list-inline-item d-md-inline-block">--}}
{{--                <a class="btn btn-outline-primary ic-pos-button-header" href="{{ route('admin.invoices.create') }}">--}}
{{--                    <i class="mdi mdi-cart-outline"></i> {{ __('custom.pos') }}--}}
{{--                </a>--}}
{{--            </li>--}}
            <!-- notification -->
{{--            <li class="dropdown notification-list list-inline-item">--}}
{{--                <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button"--}}
{{--                   aria-haspopup="false" aria-expanded="false">--}}
{{--                    <i class="ion ion-md-notifications noti-icon"></i>--}}
{{--                    <span--}}
{{--                        class="badge badge-pill badge-danger noti-icon-badge">{{ $lowStockProduct['total_product'] }}</span>--}}
{{--                </a>--}}
{{--                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">--}}
{{--                    <!-- item-->--}}
{{--                    <h6 class="dropdown-item-text">--}}
{{--                        {{ __('custom.low_notifications') }} ({{ $lowStockProduct['total_product'] }})--}}
{{--                    </h6>--}}
{{--                    <div class="slimscroll notification-item-list">--}}
{{--                    @foreach($lowStockProduct['productStockList'] as $product)--}}
{{--                        <!-- item-->--}}
{{--                            <a href="{{ route('admin.low-stock-products') }}" class="dropdown-item notify-item active">--}}
{{--                                <div class="notify-icon bg-success">--}}
{{--                                    <img src="{{ $product['image'] }}"--}}
{{--                                         class="img-fluid rounded-circle"--}}
{{--                                         alt="{{ $product['name'] }}">--}}
{{--                                </div>--}}
{{--                                <p class="notify-details">{{ $product['name'] }}--}}
{{--                                    <span class="text-muted">{{ __('custom.sku').': '.$product['sku'].', '.__('custom.price').': '.$product['price'] }}</span></p>--}}
{{--                                <div class="ic-badge-base">--}}
{{--                                        <span class="badge badge-danger" title="{{ __('custom.stock') }}">--}}
{{--                                             {{ $product['stock'] }}--}}
{{--                                        </span>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                    @endforeach--}}
{{--                    </div>--}}
{{--                    <!-- All-->--}}
{{--                    <a href="{{ route('admin.low-stock-products') }}" class="dropdown-item text-center notify-all text-primary">--}}
{{--                        View all <i class="fi-arrow-right"></i>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </li>--}}
            <!-- sync-->
{{--            <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">--}}
{{--                <a class="nav-link" href="/change-layout">--}}
{{--                    <i class="fas fa-align-justify"></i>--}}
{{--                </a>--}}
{{--            </li>--}}
            <!-- full screen -->
            <li class="dropdown notification-list d-none d-md-block">
                <a class="nav-link" href="#" id="btn-fullscreen">
                    <i class="mdi mdi-fullscreen noti-icon"></i>
                </a>
            </li>

            <!-- Profile-->
            <li class="dropdown notification-list">
                <div class="dropdown notification-list nav-pro-img">
                    <a class="dropdown-toggle nav-link arrow-none nav-user" data-toggle="dropdown" href="#"
                       role="button" aria-haspopup="false" aria-expanded="false">
                        @if(Auth::guard('customer')->user()->avatar)
                            <img src="{{ Auth::guard('customer')->user()->avatar_url }}" alt="user" class="rounded-circle">
                        @else
                            <img src="{{ Auth::guard('customer')->user()->avatar_url }}" alt="user" class="rounded-circle">
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">

                        <a href="/customer/profile" class="dropdown-item">
                            {{ \Illuminate\Support\Str::limit(Auth::guard('customer')->user()->full_name, 15) ?? '' }}<br>
                            <small>{{ Auth::guard('customer')->user()->email ?? '' }}</small>
                        </a>

                        <a class="dropdown-item logout-btn" href="#">
                            <i class="mdi mdi-power text-danger"></i>
                            {{ __('logout') }}</a>

                        <form id="logout-form" action="{{ route('customer.auth.logout') }}" method="POST">
                            @csrf
                        </form>
                    </div>
                </div>
            </li>
        </ul>

        <ul class="list-inline menu-left mb-0 ic-left-content">
            <li class="float-left ic-larged-deviced">
                <button class="button-menu-mobile">
                    <i class="mdi mdi-arrow-right open-left ic-mobile-arrow"></i>
                    <div class="ic-medi-menu ic-humbarger-bar">
                        <div class="ic-bar"></div>
                        <div class="ic-bar"></div>
                        <div class="ic-bar"></div>
                    </div>
                </button>
            </li>
        </ul>
    </nav>
</div>
<!-- Top Bar End -->
