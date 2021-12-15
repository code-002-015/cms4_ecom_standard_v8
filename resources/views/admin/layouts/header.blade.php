
<div class="content-search content-company">
    <h3 class="tx-15 mg-b-0">{{ Setting::info()->company_name }}</h3>
</div>

<div class="dropdown dropdown-profile">
    <a href="" class="dropdown-link" data-toggle="dropdown" data-display="static">
        @if(Auth::user()->avatar == '')
            <div class="avatar avatar-sm"><img src="{{ asset('images/user.png') }}" class="rounded-circle" alt=""></div>
        @else
            <div class="avatar avatar-sm"><img src="{{ Auth::user()->avatar }}" class="rounded-circle" alt=""></div>
        @endif
    </a>
    <!-- dropdown-link -->
    <div class="dropdown-menu dropdown-menu-right tx-13">
        <h6 class="tx-semibold mg-b-5">{{ Auth::user()->fullname }}</h6>
        <p class="tx-12 tx-color-03">{{ Auth::user()->role }}</p>
        <div class="dropdown-divider"></div>

        <a href="{{ route('account.edit', Auth::user()->id ) }}" class="dropdown-item"><i data-feather="edit-3"></i> Account Settings</a>
        <a href="{{ URL::asset('user-manual/TheVanguardAcademyUserGuideOct2021.pdf') }}" target="_blank" class="dropdown-item"><i data-feather="help-circle"></i> Help</a>
        <a href="{{route('logout')}}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i data-feather="log-out"></i>Log Out</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="roleid" value="{{Auth::user()->role_id }}">
        </form>
    </div>
    <!-- dropdown-menu -->
</div>
<!-- dropdown -->

