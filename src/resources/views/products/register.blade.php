@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}" />
@endsection

@section('content')
    <div class="registration__content">
        <div class="registration__heading">
            <h2>商品登録</h2>
        </div>
        <form class="form" action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
        @csrf
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">商品名</span>
                    <span class="form__label--required">必須</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="name" placeholder="商品名を入力" value="{{ old('name') }}"/>
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
                    <span class="form__label--required">必須</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="price" placeholder="値段を入力" value="{{ old('price') }}"/>
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
                    <span class="form__label--item">商品画像</span>
                    <span class="form__label--required">必須</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="file" name="image" id="image" accept="image/*" style="display: none;">
                        <img id="image-preview" src="{{ isset($filename) ? asset('storage/'. $filename) : '' }}" style="margin-top: 10px; max-width: 380px; display: {{ isset($filename) ? 'block' : 'none' }};">
                        <button type="button" id="upload-button" class="upload-btn">ファイルを選択</button>
                    </div>
                    <div class="form__error">
                        @error('image')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">季節</span>
                    <span class="form__label--required">必須</span>
                    <span class="form__label--selection">複数選択可</span>
                </div>
                <div class="form__group-checkbox">
                    @foreach ($seasons as $season)
                    <div>
                        <input type="checkbox" name="seasons[]" value="{{ $season->id }}" id="season_{{ $season->id }}" {{ in_array($season->id, old('seasons', [])) ? 'checked' : '' }}>
                        <label for="season_{{ $season->id }}">{{ $season->name }}</label>
                    </div>
                    @endforeach
                    <div class="form__error">
                        @error('season_id')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">商品説明</span>
                    <span class="form__label--required">必須</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--textarea">
                        <textarea name="description" placeholder="商品の説明を入力"></textarea>
                    </div>
                    <div class="form__error">
                        @error('description')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__button">
                <a class="registration__back-btn" href="/products">戻る</a>
                <button class="form__button-submit" type="submit">登録</button>
            </div>
        </form>
        <script>
            const fileInput = document.getElementById('image');
            const preview = document.getElementById('image-preview');
            const button = document.getElementById('upload-button');

            button.addEventListener('click', () => {
                fileInput.click();
            });

            fileInput.addEventListener('change', () => {
                if (fileInput.files && fileInput.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            });
        </script>
    </div>
@endsection
