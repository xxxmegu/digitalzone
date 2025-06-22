@extends('layouts.app')
@section('content')
<section class="category__edit">
    <h2 class="title">Редактирование товара</h2>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <form action="/product-update/{{ $product->id }}" method="POST" class="edit-form">
                        @method('patch')
                        @csrf
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="title" class="form-label">Название</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $product->title }}" required>
                            </div>

                            <div class="form-group full-width">
                                <label for="description" class="form-label">Описание товара</label>
                                <textarea class="form-control" id="description" name="description" rows="4">{{ $product->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="price" class="form-label">Цена</label>
                                <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" min="0" required>
                            </div>

                            <div class="form-group">
                                <label for="qty" class="form-label">Количество</label>
                                <input type="number" class="form-control" id="qty" name="qty" value="{{ $product->qty }}" min="0" required>
                            </div>

                            <div class="form-group">
                                <label for="color" class="form-label">Цвет</label>
                                <input type="text" class="form-control" id="color" name="color" value="{{ $product->color }}" required>
                            </div>

                            <div class="form-group">
                                <label for="country" class="form-label">Страна-производитель</label>
                                <input type="text" class="form-control" id="country" name="country" value="{{ $product->country }}" required>
                            </div>

                            <div class="form-group">
                                <label for="category" class="form-label">Категория</label>
                                <select name="category" id="category" class="form-control" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected($category->product_type == $product->product_type)>
                                            {{ $category->product_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="subcategory" class="form-label">Подкатегория</label>
                                <select name="subcategory" id="subcategory" class="form-control">
                                    <option value="">Выберите подкатегорию</option>
                                    @foreach ($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}" 
                                                data-category="{{ $subcategory->category_id }}"
                                                @selected($subcategory->id == $product->subcategory_id)>
                                            {{ $subcategory->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group full-width">
                                <label for="img" class="form-label">Изображение</label>
                                <input type="text" class="form-control" id="img" name="img" 
                                       value="{{ $product->img }}"
                                       placeholder="Введите название изображения с расширением файла из resources/media/images" required>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-submit">Сохранить изменения</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category');
    const subcategorySelect = document.getElementById('subcategory');
    
    function updateSubcategories() {
        const selectedCategory = categorySelect.value;
        const options = subcategorySelect.getElementsByTagName('option');
        
        for(let option of options) {
            if(option.value === '') {
                option.style.display = '';
                continue;
            }
            
            if(option.dataset.category === selectedCategory) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        }
    }

    categorySelect.addEventListener('change', updateSubcategories);
    updateSubcategories();
});
</script>
@endpush
@endsection
