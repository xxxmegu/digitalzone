@extends('layouts.app')
@section('content')
<section class="products">
    <div class="container">
        <div class="row">
            <table class="cart_table"> 
            <thead> 
                <tr> 
                    <th>Изображение</th> 
                    <th>Название</th> 
                    <th>Категория</th> 
                    <th>Количество</th> 
                    <th>Цена</th> 
                    <th>Действия</th> 
                </tr> 
            </thead> 
            <tbody> 
                @foreach ($products as $product) 
                    <tr class="cart_raw"> 
                        <td><img src="{{ Vite::asset('resources/media/images/') . $product->img }}" alt="" width="100px"></td> 
                        <td>{{ $product->title }}</td> 
                        <td>{{ $product->product_type }}</td> 
                        <td>{{ $product->qty }}</td> 
                        <td>{{ $product->price }}</td> 
                        <td class="btn-table"> 
                            <a href="/product-edit/{{ $product->id }}" class="btn__edit">Редактировать</a> 
                            <form action="/product-delete/{{ $product->id }}" method="POST" style="display:inline;"> 
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