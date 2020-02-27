<!-- 指定繼承 frontend.layouts.master 母模板 -->
@extends('frontend.layouts.master')


<!-- 傳送資料到母模板，並指定變數為title -->
@section('title', $title)

<!-- 傳送資料到母模板，並指定變數為content -->
@section('content')
<h1>{{ $title }}</h1>

    <!-- 錯誤訊息模板元件 -->
    @include('components.validationErrorMessage')

    <table class="table table-condensed">
        <thead>
            <tr>
                <th>類別</th>
                <th>名稱</th>
                <th>照片</th>
                <th>價格</th>
                <th>剩餘數量</th>
            </tr>
        </thead>
        <tbody>
        @foreach($MerchandisePaginate as $Merchandise)
        <tr>
            <td>{{ $Merchandise->category }}</td>
            <td>
                <a href="/merchandise/{{ $Merchandise->id }}">
                    {{ $Merchandise->name }}
                </a>
            </td>
            <td>
                <a href="/merchandise/{{ $Merchandise->id }}">
                    <img width="30%" class="img_show" src="{{ $Merchandise->photo = $Merchandise->photo ?? '/img/default-merchandise.jpg' }}"/>
                </a>
            </td>
            <td>{{ $Merchandise->price }}</td>
            <td>{{ $Merchandise->remain_count }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>

    {{-- 分頁頁數按鈕 --}}
    {{ $MerchandisePaginate->links() }}

@endsection