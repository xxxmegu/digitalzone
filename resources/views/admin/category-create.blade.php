@extends('layouts.app')
@section('content')
<section class="category__create">
    <h2>Создание категории</h2>
    
    <div class="category-create">
        <form action="/category-create" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">НАЗВАНИЕ КАТЕГОРИИ</label>
                <input type="text" class="form-control" name="title" required>
            </div>

            <button type="submit" class="btn-submit">Создать категорию</button>
        </form>

        <form action="/subcategory-create" method="POST" class="subcategory-form">
            @csrf
            <div class="form-group">
                <label class="form-label">РОДИТЕЛЬСКАЯ КАТЕГОРИЯ</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Выберите категорию</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->product_type }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">НАЗВАНИЕ ПОДКАТЕГОРИИ</label>
                <input type="text" class="form-control" name="title" required>
            </div>

            <button type="submit" class="btn-submit">Создать подкатегорию</button>
        </form>
    </div>
</section>
@endsection
