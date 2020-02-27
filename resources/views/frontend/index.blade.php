<!-- 指定繼承 layout.master 母模板 -->
@extends('frontend.layouts.master')

<!-- 傳送資料到母模板，並指定變數為title -->
@section('title', $title)

<!-- 傳送資料到母模板，並指定變數為content -->
@section('content')
<div class="category-container">
  <!-- 錯誤訊息模板元件 -->
  @include('components.validationErrorMessage')

  @foreach($MerchandisePaginate as $Merchandise)
  
      <div class="category-item card" style="width: 18rem;">
        <a href="/merchandise/{{ $Merchandise->id }}">
          <img width="50%"  class="img_show" src="{{ $Merchandise->photo = $Merchandise->photo ?? '/img/default-merchandise.jpg' }}"/>
          <div class="card-body">
            
            <p class="card-text">{{ $Merchandise->name }}</p>
          </div>
        </a>
      </div>
    
  @endforeach
  {{-- 分頁頁數按鈕 --}}
  {{ $MerchandisePaginate->links() }}
</div>

@endsection
