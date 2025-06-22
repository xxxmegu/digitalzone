@extends('layouts.app')
@section('content')
    <section class="orders">
        <div class="container">
            <div class="row">
                <div class="order__filters">
                    <a href="?filter=new">Новые</a>
                    <a href="?filter=confirmed">Подтвержденные</a>
                    <a href="?filter=canceled">Отмененные</a>
                    <a href="/orders">Показать все</a>
                </div>

                <table class="order__table container">
                    <thead>
                        <tr>
                            <th>ФИО клиента</th>
                            <th>Товары в заказе</th>
                            <th>Способ оплаты</th>
                            <th>Способ получения</th>
                            <th>Дата создания</th>
                            <th>Итог сумма</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="order__raw">
                                <td>{{ $order->name }}</td>
                                <td>
                                    <div class="order__products">
                                        @foreach ($order->products as $product)
                                            <div class="order__product">
                                                {{ $product->title }} x{{ $product->qty }}:
                                                {{ $product->price * $product->qty }} руб.
                                            </div>
                                        @endforeach
                                        Всего товаров: {{ $order->totalQty }}
                                    </div>
                                </td>
                                <td>
                                    @if($order->payment_method === 'card')
                                        Оплата картой
                                    @else
                                        Оплата наличными
                                    @endif
                                </td>
                                <td>
                                    @if($order->delivery_method === 'pickup')
                                        Самовывоз
                                    @else
                                        Доставка
                                        @if($order->delivery_address)
                                            <br>
                                            <small>Адрес: {{ $order->delivery_address }}</small>
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $order->date }}</td>
                                <td>{{ $order->totalPrice }}</td>
                                <td>{{ $order->status }}</td>
                                <td class="knop_podt">
                                    <form action="/order-status/confirm/{{ $order->number }}" method="post"
                                        style="display:inline;">
                                        @method('patch')
                                        @csrf
                                        <input type="submit" class="btn__confirm" value="Подтвердить">
                                    </form>
                                    <form action="/order-status/cancel/{{ $order->number }}" method="post"
                                        style="display:inline;">
                                        @method('patch')
                                        @csrf
                                        <input type="submit" class="btn__delete" value="Отменить">
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
