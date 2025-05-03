@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/details.css') }}" />
@endsection

@section('content')
  <div class="details__content">
    <div class="details__heading">
      <a class="details__link" href="/products">商品一覧</a> > {{ $product->name }}
    </div>
    <form class="form" action="{{ route('products.update', ['id' => $product->id]) }}" method="post" enctype="multipart/form-data" style="display:inline;">
    @csrf
    @method('PATCH')
      <div class="flex">
        <div class="flex__img">
          <div class="form__group">
            <div class="form__input--text">
              <img id="image-preview" src="{{ asset('storage/img/'.$product->image) }}" style="max-width: 100%;">
              <input type="file" name="image" id="upload-image" accept="image/*" style="display: none;">
              <button type="button" id="upload-button" class="upload-btn">ファイルを選択</button>
            </div>
            <div class="form__error">
              @error('image')
              {{ $message }}
              @enderror
            </div>
          </div>
        </div>
        <div class="flex__content">
          <div class="form__group">
            <div class="form__group-title">
              <span class="form__label--item">商品名</span>
            </div>
            <div class="form__group-content">
              <div class="form__input--text">
                <input type="text" name="name" placeholder="商品名を入力" value="{{ $product->name }}"/>
              </div>
              <div class="form__error">
                @error('name')
                {{ $message }}
                @enderror
              </div>
            </div>
          </div>
          <div class="form__group">
            <div class="form__group-title">
              <span class="form__label--item">値段</span>
            </div>
            <div class="form__group-content">
              <div class="form__input--text">
                <input type="text" name="price" placeholder="値段を入力" value="{{ $product->price }}"/>
              </div>
              <div class="form__error">
                @error('price')
                {{ $message }}
                @enderror
              </div>
            </div>
          </div>
          <div class="form__group">
            <div class="form__group-title">
              <span class="form__label--item">季節</span>
            </div>
            <div class="form__group-checkbox">
              <div class="form__input--checkbox">
                <div class="input__checkbox">
                  @foreach ($seasons as $season)
                  <div>
                    <input type="checkbox" name="seasons[]" value="{{ $season->id }}" {{ in_array($season->id, $selectedSeasons ?? []) ? 'checked' : '' }}>
                    <label>{{ $season->name }}</label>
                  </div>
                  @endforeach
                </div>
                <div class="form__error">
                  @error('season_id')
                  {{ $message }}
                  @enderror
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="form__group">
        <div class="form__group-title">
          <span class="form__label--item">商品説明</span>
        </div>
        <div class="form__group-content">
          <div class="form__input--textarea">
            <textarea name="description" placeholder="商品の説明を入力">{{ $product->description }}</textarea>
          </div>
          <div class="form__error">
            @error('description')
            {{ $message }}
            @enderror
          </div>
        </div>
      </div>
      <div class="form__button">
        <a class="details__back-btn" href="/products">戻る</a>
        <button class="form__button-submit" type="submit">変更を保存</button>
      </div>
    </form>
    <form action="{{ route('products.destroy', ['id' => $product->id]) }}" method="post" style="display:inline;">
      @csrf
      @method('DELETE')
      <div class="form__delete">
        <button class="form__button-delete" type="submit" style="background:none; border:none; padding:0; cursor:pointer;">
          <img src="{{ asset('storage/img/icons8-trash-can.svg') }}" alt="ゴミ箱アイコン" style="width:24px;">
        </button>
      </div>
    </form>
    <script>
      document.getElementById('upload-button').addEventListener('click', function() {
        document.getElementById('upload-image').click();
      });

      document.getElementById('upload-image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(e) {
            document.getElementById('image-preview').src = e.target.result;
          }
          reader.readAsDataURL(file);
        }
      });
    </script>
  </div>
@endsection