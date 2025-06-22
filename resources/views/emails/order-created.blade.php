<!DOCTYPE html>
<html>
<head>
    <title>Заказ успешно сформирован</title>
</head>
<body>
    <h2>Здравствуйте!</h2>
    <p>Ваш заказ успешно сформирован.</p>
    
    <h3>Детали заказа:</h3>
    <p><strong>Номер заказа:</strong> {{ $order->number }}</p>
    <p><strong>Статус:</strong> {{ $order->status }}</p>
    <p><strong>Способ оплаты:</strong> {{ $order->payment_method }}</p>
    <p><strong>Способ доставки:</strong> {{ $order->delivery_method }}</p>
    <p><strong>Контактный телефон:</strong> {{ $order->phone }}</p>
    @if($order->delivery_method === 'delivery')
    <p><strong>Адрес доставки:</strong> {{ $order->delivery_address }}</p>
    @endif

    <h3>Товары в заказе:</h3>
    <ul>
    @foreach($products as $product)
        <li>{{ $product->name }} - {{ $product->qty }} шт.</li>
    @endforeach
    </ul>

    <p>Спасибо за ваш заказ!</p>
</body>
</html> 