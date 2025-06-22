@extends('layouts.app')
@section('content')
<section class="category__edit">
    <h2 class="title">Редактирование подкатегории</h2>
    
    <div class="category-edit">
        <form action="/subcategory-update/{{ $subcategory->id }}" method="POST">
            @method('patch')
            @csrf
            <div class="form-group">
                <label class="form-label">НАЗВАНИЕ ПОДКАТЕГОРИИ</label>
                <input type="text" class="form-control" name="name" value="{{ $subcategory->name }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">РОДИТЕЛЬСКАЯ КАТЕГОРИЯ</label>
                <select class="form-control" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $subcategory->category_id ? 'selected' : '' }}>
                            {{ $category->product_type }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-submit">Сохранить изменения</button>
        </form>
    </div>
</section>
@endsection 