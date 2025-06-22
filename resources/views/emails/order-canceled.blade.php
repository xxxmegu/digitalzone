<!DOCTYPE html>
<html>
<head>
    <title>Заказ отменен</title>
</head>
<body>
    <h2>Здравствуйте!</h2>
    <p>К сожалению, ваш заказ №{{ $order->number }} был отменен.</p>
    
    <h3>Детали отмененного заказа:</h3>
    <ul>
    @foreach($products as $product)
        <li>{{ $product->title }} - {{ $product->qty }} шт. - {{ $product->price }} руб.</li>
    @endforeach
    </ul>

    <p><strong>Способ оплаты:</strong> {{ $order->payment_method }}</p>
    <p><strong>Способ получения:</strong> {{ $order->delivery_method }}</p>
    <p><strong>Общая сумма:</strong> {{ $totalPrice }} руб.</p>

    <p>Если у вас возникли вопросы, пожалуйста, свяжитесь с нами.</p>
</body>
</html> 