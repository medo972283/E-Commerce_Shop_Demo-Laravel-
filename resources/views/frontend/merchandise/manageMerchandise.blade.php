<!-- 指定繼承 layout.master 母模板 -->
@extends('frontend.layouts.master')

<!-- 傳送資料到母模板，並指定變數為title -->
@section('title', $title)

<!-- 傳送資料到母模板，並指定變數為content -->
@section('content')
<div class="container">
    <h1>{{ $title }}</h1>

    {{-- 錯誤訊息模板元件 --}}
    @include('components.validationErrorMessage')

    <table class="table table-condensed">
        <thead>
            <tr>
                <th>編號</th>
                <th>類別</th>
                <th>名稱</th>
                <th>圖片</th>
                <th>狀態</th>
                <th>價格</th>
                <th>剩餘數量</th>
                <th>編輯</th>
            </tr>
        </thead>
        <tbody>
        @foreach($MerchandisePaginate as $Merchandise)
            <tr>
                <td>{{ $Merchandise->id }}</td>
                <td>{{ $Merchandise->category }}</td>
                <td>{{ $Merchandise->name }}</td>
                <td>
                    <img width="30%" class="img_show" src="{{ $Merchandise->photo = $Merchandise->photo ?? '/img/default-merchandise.jpg' }}"/>
                </td>
                <td>
                    @if($Merchandise->status == 'C')
                        建立中
                    @else
                        可販售
                    @endif
                </td>
                <td>{{ $Merchandise->price }}</td>
                <td>{{ $Merchandise->remain_count }}</td>
                <td>
                    <a href="/merchandise/{{ $Merchandise->id }}/edit">
                        編輯
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- 分頁頁數按鈕 --}}
    {{ $MerchandisePaginate->links() }}
</div>
@endsection