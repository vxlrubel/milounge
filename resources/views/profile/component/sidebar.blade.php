<div class="consumerdashboard-linkbg">

    @php
        $current_url = \Illuminate\Support\Facades\Route::getCurrentRoute()->uri() ?? null;
    @endphp

    <div class="profile-image-hold">
        <div class="profile-image">
            @if(session('user')->profile_image ?? null)
                <img src="{{config('api.apiUrl')}}/user/profile-image?_token={{session('api_token')}}" alt="" id="profile_image">
            @elseif(session('user')->property->avatar ?? null)
                <img src="{{session('user')->property->avatar}}" alt="">
            @else
                <img src="/assets/images/profile-image/profile.png" alt="">
            @endif
            @if($current_url == 'profile/details')
                <div class="profileimage-content">
                    <button type="button" class="btn profileimage-changebtn" data-bs-toggle="modal"
                            data-bs-target="#changeProfileImage">
                        <span><i class="fa-solid fa-pen-to-square"></i></span>edit
                    </button>
                </div>
            @endif
        </div>
        <div class="profile-contentdetails">
            <h1>{{session('user')->name ?? '#'}}</h1>
        </div>
    </div>

    <div class="dashboardlink-hold">
        <div class="dashboardlink @if($current_url == 'profile/details') dashboardlink-active @endif">
            <a href="/profile/details"><span><i class="fa-solid fa-pen-to-square"></i></span>Account Details</a>
        </div>
        <div class="dashboardlink @if($current_url == 'profile/order') dashboardlink-active @endif">
            <a href="/profile/order"><span><i class="fa-solid fa-list"></i></span> My Orders</a>
        </div>
        <div class="dashboardlink @if($current_url == 'security') dashboardlink-active @endif">
            <a href="/security"><span><i class="fa-solid fa-lock"></i></span> Login & Security</a>
        </div>
    </div>
</div>
