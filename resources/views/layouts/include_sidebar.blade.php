<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- dashboard -->
        <li class="nav-item">
            @if (Route::currentRouteName() === 'dashboard')
            <a class="nav-link" href="{{ url('/dashboard') }}">
            @else
            <a class="nav-link collapsed" href="{{ url('/dashboard') }}">
            @endif
                <i class="bi bi-grid"></i>
                <span>Overview</span>
            </a>
        </li>

        {{--
        <!-- api calls -->
        <li class="nav-item">
            @if (Route::currentRouteName() !== 'apicalls')
            <a class="nav-link collapsed" href="{{ route('apicalls.index') }}">
                <i class="bi bi-menu-button-wide"></i>
                <span>API Calls</span>
            </a>
            @else
            <a class="nav-link" href="#">
                <i class="bi bi-menu-button-wide"></i>
                <span>API Calls</span>
            </a>
            @endif
        </li>
        --}}

        <!-- transaction history -->
        <li class="nav-item">
            @if (Route::currentRouteName() !== 'transactions')
            <a class="nav-link collapsed" href="{{ route('transactions') }}">
                <i class="bi bi-menu-button-wide"></i>
                <span>Transaction History</span>
            </a>
            @else
            <a class="nav-link" href="#">
                <i class="bi bi-menu-button-wide"></i>
                <span>Transaction History</span>
            </a>
            @endif
        </li>

        <!-- api test -->
        @if ((Auth::user()->enc_key === 1) || (Auth::user()->enc_key === 0))
        <!-- telco v01 -->
        <li class="nav-item">
            @if (Route::currentRouteName() !== 'telco_v01')
            <a class="nav-link collapsed" href="{{ route('telco_v01') }}">
                <i class="bi bi-menu-button-wide"></i>
                <span>Telco API Test</span>
            </a>
            @else
            <a class="nav-link" href="#">
                <i class="bi bi-menu-button-wide"></i>
                <span>Telco API Test</span>
            </a>
            @endif
        </li>
        @endif
        
        @if ((Auth::user()->enc_key === 2) || (Auth::user()->enc_key === 0))
        <!-- telco v02-->
        <li class="nav-item">
            @if (Route::currentRouteName() !== 'telco_v02')
            <a class="nav-link collapsed" href="{{ route('telco_v02') }}">
                <i class="bi bi-menu-button-wide"></i>
                <span>Telco SA API Test</span>
            </a>
            @else
            <a class="nav-link" href="#">
                <i class="bi bi-menu-button-wide"></i>
                <span>Telco SA API Test</span>
            </a>
            @endif
        </li>
        @endif

        <!-- sign out -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" onclick="submitLogout(event)">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                {{ csrf_field() }}
            </form>
        </li>
        
    </ul>
</aside>