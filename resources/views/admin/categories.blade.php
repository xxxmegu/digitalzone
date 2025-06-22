@extends('layouts.app')
@section('content')
<section class="categories">
    <div class="container">
        <div class="row">
            <h2>Категории</h2>
            <table class="cart__table"> 
                <thead> 
                    <tr> 
                        <th>ID</th> 
                        <th>Название</th>
                        <th>Кол-во подкатегорий</th>
                        <th>Действия</th> 
                    </tr> 
                </thead> 
                <tbody> 
                    @foreach ($categories as $category) 
                        <tr class="cart__raw"> 
                            <td data-label="ID">{{ $category->id }}</td> 
                            <td data-label="Название">{{ $category->product_type }}</td>
                            <td data-label="Кол-во подкатегорий">{{ $category->subcategories_count }}</td>
                            <td data-label="Действия"> 
                                <a href="/category-edit/{{ $category->id }}" class="btn__edit">Редактировать</a> 
                                <form action="/category-delete/{{ $category->id }}" method="POST" style="display:inline;"> 
                                    @method('delete') 
                                    @csrf 
                                    <input type="submit" class="btn__delete" value="Удалить"> 
                                </form> 
                            </td> 
                        </tr> 
                    @endforeach 
                </tbody> 
            </table>

            <h2>Подкатегории</h2>
            <table class="cart__table subcategories-table"> 
                <thead> 
                    <tr> 
                        <th>ID</th> 
                        <th>Название</th>
                        <th>Родительская категория</th>
                        <th>Действия</th> 
                    </tr> 
                </thead> 
                <tbody> 
                    @foreach ($subcategories as $subcategory) 
                        <tr class="cart__raw"> 
                            <td data-label="ID">{{ $subcategory->id }}</td> 
                            <td data-label="Название">{{ $subcategory->name }}</td>
                            <td data-label="Родительская категория">{{ $subcategory->parent_name }}</td>
                            <td data-label="Действия"> 
                                <a href="/subcategory-edit/{{ $subcategory->id }}" class="btn__edit">Редактировать</a>
                                <form action="/subcategory-delete/{{ $subcategory->id }}" method="POST" style="display:inline;"> 
                                    @method('delete') 
                                    @csrf 
                                    <input type="submit" class="btn__delete" value="Удалить"> 
                                </form> 
                            </td> 
                        </tr> 
                    @endforeach 
                </tbody> 
            </table>
        </div>
    </div>
</section>
@endsection
