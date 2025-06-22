<!DOCTYPE html>
<html>
<head>
    <title>Заказ подтвержден</title>
</head>
<body>
    <h2>Здравствуйте!</h2>
    <p>Ваш заказ №{{ $order->number }} подтвержден.</p>
    
    @if($order->delivery_method === 'Самовывоз')
    <p><strong>Вы можете забрать ваш заказ по адресу:</strong> улица Энтузиастов, 1Б в течение 7 дней.</p>
    @else
    <p><strong>Доставка:</strong> Курьер доставит ваш заказ по адресу {{ $order->delivery_address }} в течение 3-х дней и предварительно позвонит для согласования времени доставки.</p>
    @endif

    <h3>Детали заказа:</h3>
    <p><strong>Контактный телефон:</strong> {{ $order->phone }}</p>
    <p><strong>Способ оплаты:</strong> {{ $order->payment_method }}</p>
    <p><strong>Общая сумма:</strong> {{ $totalPrice }} руб.</p>

    <h3>Товары в заказе:</h3>
    <ul>
    @foreach($products as $product)
        <li>{{ $product->title }} - {{ $product->qty }} шт. - {{ $product->price }} руб.</li>
    @endforeach
    </ul>

    <p>Спасибо за ваш заказ!</p>
</body>
</html> 