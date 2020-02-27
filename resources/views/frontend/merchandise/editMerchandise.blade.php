<!-- 指定繼承 frontend.layouts.master 母模板 -->
@extends('frontend.layouts.master')


<!-- 傳送資料到母模板，並指定變數為title -->
@section('title', $title)

<!-- 傳送資料到母模板，並指定變數為content -->
@section('content')
<div class="container">
    <span class="hightlight-text">{{ session()->get('message') }}</span>
    <h1 class="">{{ $title }}</h1>

    <!-- 錯誤訊息模板元件 -->
    @include('components.validationErrorMessage')

    {{-- 表單沒有PUT、DELETE，借助Laravel的method_field方法實行之 --}}
    <form action="/merchandise/{{ $Merchandise->id }}"
        method="post"
        enctype="multipart/form-data">
        <!-- 隱藏方法欄位 -->
        {{ method_field('PUT') }}
        <div>
            商品狀態：
            <select name="status">
                <option value="C" 
                    @if(old('status', $Merchandise->status) == 'C') 
                        selected 
                    @endif
                >建立中</option>
                <option value="S" 
                    @if(old('status', $Merchandise->status) == 'S') 
                        selected 
                    @endif
                >可販售</option>
            </select>
        </div>

        <div>
            商品類別：
            <input type="text" name="category" placeholder="商品類鼻" value="{{ old('category', $Merchandise->category) }}" />
        </div>

        <div>
            商品名稱：
            <input type="text" name="name" placeholder="商品名稱" value="{{ old('name', $Merchandise->name) }}" />
        </div>


        <div>
            商品介紹：
            <input type="text" name="introduction" placeholder="商品介紹" value="{{ old('introduction', $Merchandise->introduction) }}" />
        </div>

        <div>
            商品照片：
            <input type="file" name="photo" placeholder="商品照片">
            <img width="30%" src="{{ $Merchandise->photo = $Merchandise->photo ?? '/img/default-merchandise.jpg' }}" />
        </div>

        <div>
            商品價格：
            <input type="text" name="price" placeholder="商品價格" value="{{ old('price', $Merchandise->price) }}" />
        </div>

        <div>
            商品剩餘數量：
            <input type="text" name="remain_count" placeholder="商品剩餘數量" value="{{ old('remain_count', $Merchandise->remain_count) }}" />
        </div>
        <div>
            <button type="submit" class="btn btn-design">更新商品資訊</button>
        </div>

        <!-- 自動產生 csrf_token 隱藏欄位-->
        {!! csrf_field() !!}
    </form>
</div>

@endsection