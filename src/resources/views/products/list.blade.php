@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/list.css') }}" />
@endsection

@section('content')
    <div class="list__content">
        <div class="heading">
            <div class="list__heading">
                <h2>{{ $title ?? '商品一覧' }}</h2>
            </div>
            <nav>
                <ul class="list-nav">
                    @if(!isset($isSearching) || !$isSearching)
                    <li class="list-nav__item">
                        <a class="list-nav__link" href="{{ route('products.register') }}">+ 商品を追加</a>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>
        <div class="form__group">
            <form class="form__group--search" action="/products/search" method="get">
                <div class="form__input--text">
                    <input type="text" name="name" placeholder="商品名で検索" value="{{ request('name') }}"/>
                </div>
                <div class="form__button">
                    <input class="form__button-search" type="submit" value="検索">
                </div>
                <div class="form__group-title">
                    <span class="form__label--item">価格順で表示</span>
                    <select name="order" onchange="this.form.submit()">
                        <option value="">価格で並べ替え</option>
                        <option value="high" {{ request('order') == 'high' ? 'selected' : '' }}>高い順に表示</option>
                        <option value="low" {{ request('order') == 'low' ? 'selected' : '' }}>低い順に表示</option>
                    </select>
                    @if(request('order') == 'high' || request('order') == 'low')
                        <div class="selected-order">
                            <span>
                                {{ request('order') == 'high' ? '高い順に表示' : '低い順に表示' }}
                            </span>
                            <a href="{{ url()->current() }}?{{ http_build_query(request()->except('order')) }}" class="remove-order">×</a>
                        </div>
                    @endif
                </div>
            </form>
            <div class="form__group--card">
                <div class="form_flex">
                    @foreach($products as $product)
                        <a class="practice__card" href="{{ route('products.details', $product->id) }}">
                            <div class="card__img">
                                <img src="{{ asset('storage/img/' . $product->image) }}" alt="{{ $product->name }}">
                            </div>
                            <div class="card__content">
                                <p class="card__name">{{$product->name}}</p>
                                <p class="card__price">￥{{ number_format($product->price) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="card_pagination">
                    {{ $products->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection