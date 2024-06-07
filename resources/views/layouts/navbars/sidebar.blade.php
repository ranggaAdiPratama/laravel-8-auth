<div class="sidebar" data-color="rose" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
      <a href="https://daengkurir.online/" class="simple-text logo-mini">
      <i><img style="width:25px" src="{{ asset('dkm.png') }}"></i>
        </a>
    <a href=https://daengkurir.online/" class="simple-text logo-normal">
      {{ __('Daeng Kurir M') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
          <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link collapsed" data-toggle="collapse" href="#laravelExample" aria-expanded="false">
          <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
          <p>{{ __('Users') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' show' : '' }}" id="laravelExample">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('profile.edit') }}">
                <span class="sidebar-mini"> UP </span>
                <span class="sidebar-normal">{{ __('User profile') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user.index') }}">
                <span class="sidebar-mini"> UM </span>
                <span class="sidebar-normal"> {{ __('User Management') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item {{ ($activePage == 'reguler' || $activePage == 'express') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#orders" aria-expanded="false">
          <i><img style="width:25px" src="{{ asset('dkm.png') }}"></i>
          <p>{{ __('Orders') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($activePage == 'reguler' || $activePage == 'express') ? ' show' : '' }}" id="orders">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'reguler' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('reguler.index') }}">
                <span class="sidebar-mini"> REG </span>
                <span class="sidebar-normal">{{ __('Reguler') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'express' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('express.index') }}">
                <span class="sidebar-mini"> EXP </span>
                <span class="sidebar-normal"> {{ __('Express') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item {{ ($activePage == 'driver-reguler' || $activePage == 'driver-express') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#drivers" aria-expanded="false">
        <i class="material-icons">two_wheeler</i>
          <p>{{ __('Drivers') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($activePage == 'driver-reguler' || $activePage == 'driver-express') ? ' show' : '' }}" id="drivers">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'driver-reguler' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('driver.index', 'reguler') }}">
                <span class="sidebar-mini"> D-R </span>
                <span class="sidebar-normal">{{ __('Driver Reguler') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'driver-express' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('driver.index', 'express') }}">
                <span class="sidebar-mini"> D-E </span>
                <span class="sidebar-normal"> {{ __('Driver Express') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item{{ $activePage == 'wallet' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('driver.wallet') }}">
          <i class="material-icons">account_balance_wallet</i>
          <p>{{ __('Wallet Driver') }}</p>
        </a>
      </li>
      {{--
      <li class="nav-item{{ $activePage == 'table' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('table') }}">
          <i class="material-icons">content_paste</i>
          <p>{{ __('Table List') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'typography' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('typography') }}">
          <i class="material-icons">library_books</i>
          <p>{{ __('Typography') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'icons' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('icons') }}">
          <i class="material-icons">bubble_chart</i>
          <p>{{ __('Icons') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'map' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('map') }}">
          <i class="material-icons">location_ons</i>
          <p>{{ __('Maps') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'notifications' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('notifications') }}">
          <i class="material-icons">notifications</i>
          <p>{{ __('Notifications') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('language') }}">
          <i class="material-icons">language</i>
          <p>{{ __('RTL Support') }}</p>
        </a>
      </li>
      <li class="nav-item active-pro{{ $activePage == 'upgrade' ? ' active' : '' }}">
        <a class="nav-link text-white bg-danger" href="{{ route('upgrade') }}">
          <i class="material-icons text-white">unarchive</i>
          <p>{{ __('Upgrade to PRO') }}</p>
        </a>
      </li>
      --}}
    </ul>
  </div>
</div>