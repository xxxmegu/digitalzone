@extends('layouts.app')
@section('content')
<section class="category__edit">
    <h2 class="title">Редактирование категории</h2>
    
    <div class="category-edit">
        <form action="/category-update/{{ $category->id }}" method="POST">
            @method('patch')
            @csrf
            <div class="form-group">
                <label class="form-label">НАЗВАНИЕ КАТЕГОРИИ</label>
                <input type="text" class="form-control" name="title" value="{{ $category->product_type }}" required>
            </div>

            <button type="submit" class="btn-submit">Сохранить изменения</button>
        </form>
    </div>
</section>
@endsection
