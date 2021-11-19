<header class="header">
    <div class="header__container">
        <div class="user-acc">Account ID: {{ Auth::user()->account_id }}</div>

        <div class="header-user">
            <div class="header-user__icon">
                <svg class="icon icon-rings"><use xlink:href="#icon-rings"></use></svg>
            </div>
            <span class="header-user__name">{{ __('Welcome,') }} <strong class="d-block d-lg-inline">{{ sprintf('%s & %s', Auth::user()->getNewlywedAttribute('first', 'first_name'), Auth::user()->getNewlywedAttribute('second', 'first_name')) }}</strong></span>
        </div>

        <div class="login d-none d-lg-flex">
            <a href="javascript:void(0);" class="login-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <svg class="icon icon-logout"><use xlink:href="#icon-logout"></use></svg>
                {{ __('Log Out') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    </div>
</header>
