<aside class="sidebar fixed-left navbar-expand-lg navbar-light" id="sidebar">
    <!-- Toggler -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand" href="{{ route('dashboard') }}">
        <img class="logo__img" src="{{ \Settings::getConfigValueUrl('app/logo') ?: asset('images/logo.png') }}" alt="JAY LIM STUDIO">
    </a>

    <div class="login d-lg-none">
        <a href="javascript:void(0);" class="login-link" onclick="event.preventDefault(); document.getElementById('logout-form-asside').submit();">
            <svg class="icon icon-logout"><use xlink:href="#icon-logout"></use></svg>
            {{ __('Log Out') }}
        </a>
        <form id="logout-form-asside" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>

    <!-- collapse  -->
    <div class="collapse navbar-collapse" id="sidebarCollapse">
        <div class="collapse-inner">
            <nav class="main-nav">
                <ul class="main-nav__list">
                    <li class="main-nav__item">
                        <a href="{{ route('customer.account') }}">
                            <svg class="icon icon-dash"><use xlink:href="#icon-dash"></use></svg>
                            <span class="main-nav__item-text">{{ __('Dashboard') }}</span>
                        </a>
                    </li>
                    <li class="main-nav__item">
                        <a href="{{ route('customer.information') }}">
                            <svg class="icon icon-user"><use xlink:href="#icon-user"></use></svg>
                            <span class="main-nav__item-text">{{ __('Personal Information') }}</span>
                        </a>
                    </li>
                    <li class="main-nav__item">
                        <a href="{{ route('customer.contacts') }}">
                            <svg class="icon icon-contacts"><use xlink:href="#icon-contacts"></use></svg>
                            <span class="main-nav__item-text">{{ __('Contacts') }}</span>
                        </a>
                    </li>
                    <li class="main-nav__item">
                        <a href="{{ route('customer.wedding.info') }}">
                            <svg class="icon icon-info"><use xlink:href="#icon-info"></use></svg>
                            <span class="main-nav__item-text">{{ __('Wedding Information') }}</span>
                        </a>
                        <ul class="main-nav__inner-nav">
                            <li class="main-nav__inner-nav-item"><a href="{{ route('customer.details.form') }}">{{ __('Details about You') }}</a></li>
                            <li class="main-nav__inner-nav-item"><a href="{{ route('customer.wedding.schedule') }}">{{ __('Schedule') }}</a></li>
                            <li class="main-nav__inner-nav-item"><a href="{{ route('customer.wedding.checklist') }}">{{ __('Checklist') }}</a></li>
                        </ul>
                    </li>
                    <li class="main-nav__item">
                        <a href="{{ route('paymets.invoice.list') }}">
                            <svg class="icon icon-invoices"><use xlink:href="#icon-invoices"></use></svg>
                            <span class="main-nav__item-text">{{ __('Invoices') }}</span>
                        </a>
                    </li>
                    <li class="main-nav__item">
                        <a href="{{ url('faq') }}" target="_blank">
                            <svg class="icon icon-help"><use xlink:href="#icon-help"></use></svg>
                            <span class="main-nav__item-text">{{ __('FAQ') }}</span>
                        </a>
                    </li>
                </ul>
            </nav>

            {!! \Menu::render('main_menu') !!}
        </div>
    </div>
</aside>
