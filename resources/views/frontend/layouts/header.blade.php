<div class="container-fluid site-header">
    <div class="row">
        <h1 class="col-10 text-left text-white d-none d-lg-block">
            <span class="header-design mb-3">E-Commerce Shop</span>        
        </h1>
        
        <div class="col text-right align-self-center justify-content-end">
            @if(session()->has('customer_id'))
                <span><a class="btn btn-design" href="/user/auth/sign-out">登出</a></li>
            @else
                <span><a class="btn btn-design" href="{{route('loginPage')}}">登入</a></li>
                <span><a class="btn btn-design" href="{{route('registerPage')}}">註冊</a></li>
            @endif
        </div>
    </div>
</div>
    