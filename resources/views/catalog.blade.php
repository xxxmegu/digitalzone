@extends('layouts.app')
@section('content')
<div class="catalog-page">
    <div class="catalog-container">
        <div class="catalog-layout">
            <aside class="catalog-sidebar">
                <div class="sidebar-filters">
                    <form action="{{ route('catalog') }}" method="GET" id="filterForm">
                        <div class="filter-section">
                            <h5 class="filter-title">Категории</h5>
                            <div class="categories">
                                @foreach($categories as $category)
                                <div class="filter-item">
                                    <input class="custom-radio category-radio" type="radio" 
                                           name="category" 
                                           id="category{{ $category->id }}" 
                                           value="{{ $category->product_type }}"
                                           data-category-id="{{ $category->id }}"
                                           {{ request()->get('category') == $category->product_type ? 'checked' : '' }}>
                                    <label class="filter-label" for="category{{ $category->id }}">
                                        {{ $category->product_type }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="filter-section">
                            <h5 class="filter-title">Подкатегории</h5>
                            <div class="subcategories">
                                @foreach($subcategories as $subcategory)
                                <div class="filter-item subcategory-item" data-category="{{ $subcategory->category_id }}" style="display: none;">
                                    <input class="custom-radio" type="radio" 
                                           name="subcategory" 
                                           id="subcategory{{ $subcategory->id }}" 
                                           value="{{ $subcategory->name }}"
                                           {{ request()->get('subcategory') == $subcategory->name ? 'checked' : '' }}>
                                    <label class="filter-label" for="subcategory{{ $subcategory->id }}">
                                        {{ $subcategory->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <h5>Страна производитель</h5>
                        <div class="filter-section">
                            <select class="form-select" name="country" id="countrySelect">
                                <option value="">Все страны</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country }}" {{ request()->get('country') == $country ? 'selected' : '' }}>
                                        {{ $country }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <h5>Цена</h5>
                        <div class="filter-section">
                            <div class="mb-2">
                                <label for="priceFrom" class="form-label">От</label>
                                <input type="number" 
                                       class="form-control" 
                                       id="priceFrom" 
                                       name="price_from" 
                                       min="0" 
                                       value="{{ request()->get('price_from') }}"
                                       oninput="this.value = this.value < 0 ? 0 : this.value">
                            </div>
                            <div class="mb-2 mt-2">
                                <label for="priceTo" class="form-label">До</label>
                                <input type="number" 
                                       class="form-control" 
                                       id="priceTo" 
                                       name="price_to"
                                       min="0" 
                                       value="{{ request()->get('price_to') }}"
                                       oninput="this.value = this.value < 0 ? 0 : this.value">
                            </div>
                        </div>

                        <div class="filter-buttons">
                            <button type="submit" class="btn-primary w-100 mb-2">Применить</button>
                            <a href="{{ route('catalog') }}" class="btn-secondary w-100">Сбросить</a>
                        </div>
                    </form>
                </div>
            </aside>

            <main class="catalog-main">
                <div class="sorting-container">
                    <div class="sort-buttons">
                        <button class="sort-btn" data-sort="country">По стране</button>
                        <button class="sort-btn" data-sort="title">По названию</button>
                        <button class="sort-btn" data-sort="price">По цене</button>
                        <button class="sort-btn reset" id="resetSort">Сбросить</button>
                    </div>
                </div>

                <div class="products-grid" id="productsContainer">
                    @foreach($products as $product)
                    <a href="/product/{{ $product->id }}" class="product-card" 
                        data-category="{{ $product->product_type }}"
                        data-subcategory="{{ $product->subcategory_id ?? '' }}"
                        data-price="{{ $product->price }}"
                        data-country="{{ $product->country }}"
                        data-title="{{ $product->title }}">
                        <div class="product-image-container">
                            <img src="{{ Vite::asset('resources/media/images/') . $product->img }}" alt="{{ $product->title }}">
                        </div>
                        <h3>{{ $product->title }}</h3>
                        <p>{{ number_format($product->price, 0, '.', ' ') }} ₽</p>
                    </a>
                    @endforeach
                </div>
            </main>
        </div>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function updateSubcategories(categoryId, keepSelection = false) {
        document.querySelectorAll('.subcategory-item').forEach(item => {
            if (item.dataset.category === categoryId) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
                if (!keepSelection) {
                    const radio = item.querySelector('input[type="radio"]');
                    if (radio) radio.checked = false;
                }
            }
        });
    }

    document.querySelectorAll('.category-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            updateSubcategories(this.dataset.categoryId);
        });
    });

    const selectedCategory = document.querySelector('input[name="category"]:checked');
    if (selectedCategory) {
        updateSubcategories(selectedCategory.dataset.categoryId, true);
    }

    let currentSort = '';
    let isAscending = true;

    document.querySelectorAll('.sort-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const sortBy = this.dataset.sort;
            
            if (currentSort === sortBy) {
                isAscending = !isAscending;
            } else {
                currentSort = sortBy;
                isAscending = true;
            }

            const products = Array.from(document.querySelectorAll('.product-card'));
            const sortedProducts = products.sort((a, b) => {
                let valueA = a.dataset[sortBy];
                let valueB = b.dataset[sortBy];

                if (sortBy === 'price') {
                    valueA = parseFloat(valueA);
                    valueB = parseFloat(valueB);
                }

                if (valueA < valueB) return isAscending ? -1 : 1;
                if (valueA > valueB) return isAscending ? 1 : -1;
                return 0;
            });

            const container = document.getElementById('productsContainer');
            container.innerHTML = '';
            sortedProducts.forEach(product => container.appendChild(product));
        });
    });

    document.getElementById('resetSort').addEventListener('click', function() {
        location.reload();
    });
});
</script>
@endpush
@endsection
