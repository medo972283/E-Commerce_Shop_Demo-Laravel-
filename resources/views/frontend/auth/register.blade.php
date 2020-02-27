<!-- 指定繼承 layout.master 母模板 -->
@extends('frontend.layouts.master')

<!-- 傳送資料到母模板，並指定變數為title -->
@section('title', $title)

<!-- 傳送資料到母模板，並指定變數為content -->
@section('content')
<div class="container">
  <h1>{{ $title }}</h1>
  
  <!-- 錯誤訊息模板元件 -->
  @include('components.validationErrorMessage')

  <form action="{{ route('doRegister') }}" method="post">
      <!-- 手動加入 csrf_token 隱藏欄位，欄位變數名稱為 _token-->
      <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
      
      <label>
          暱稱:
          <input type="text" name="nickname" placeholder="暱稱" value="{{ old('nickname') }}"/>
      </label>

      <label>
          E-mail:
          <input type="text" name="email" placeholder="Email" value="{{ old('email') }}"/>
      </label>
      
      <label>
          帳號:
          <input type="text" name="account" placeholder="帳號" value="{{ old('account') }}"/>
      </label>
      
      <label>
          密碼:
          <input type="password" name="password" placeholder="密碼" value="{{ old('password') }}"/>
      </label>

      <label>
          確認密碼:
          <input type="password" name="password_confirmation" placeholder="確認密碼" value="{{ old('password_confirmation') }}"/>
      </label>

      {{-- <label>
          帳號類型:
          <select name="type">
              <option value="G">一般會員</option>
              <option value="A">管理者</option>
          </select>
      </label> --}}

      <button type="submit">註冊</button>
  </form>
</div>
@endsection