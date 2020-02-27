@extends('frontend.layouts.master')

@section('title', 'Homepage')

@section('content')
<div class="category-container">
  @for ($i =0; $i<10; $i++)
    <div class="category-item card" style="width: 18rem;">
      <img src="..." class="card-img-top" alt="...">
      <div class="card-body">
        <p class="card-text">某商品</p>
      </div>
    </div>
  @endfor
</div>
@endsection
