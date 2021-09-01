<ul class="nav">
    <li class="nav-item">
        <a class="nav-link" href="#" id="dropdownProfile" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class="rounded-circle" src="{{ Storage::url(Auth::user()->profile->image) }}" alt="profile-iamge" width="35" height="35">
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" aria-labelledby="dropdownProfile">
            <a class="dropdown-item {{ (request()->is('profile')) ? 'active' : '' }}" href="{{url('/profile')}}">Profile</a>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form-profile').submit();">
                {{ __('Logout') }}
            </a>
        </div>
        <form id="logout-form-profile" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>
</ul>