<ul class="quicklinks ul-none no-padding mb-3">
    <li @if(Route::current()->getName() == 'my-account.manage-account') class="active" @endif><a href="{{ route('my-account.manage-account') }}">Manage Account</a></li>
    <li @if(Route::current()->getName() == 'profile.sales') class="active" @endif><a href="{{ route('profile.sales') }}">My Orders</a></li>
    <li @if(Route::current()->getName() == 'profile.favorites') class="active" @endif><a href="{{ route('profile.favorites') }}">My Favorites</a></li>
    <li @if(Route::current()->getName() == 'profile.wishlist') class="active" @endif><a href="{{ route('profile.wishlist') }}">My Wishlist <span style="background-color: white; height: 23px; width: 20px;" class="badge">{{ \App\EcommerceModel\CustomerWishlist::wishlist_available() }}</span></a></li>
    <li @if(Route::current()->getName() == 'coupons-claimed') class="active" @endif><a href="{{ route('coupons-claimed') }}">Claimed Coupons</span></a></li>
</ul>