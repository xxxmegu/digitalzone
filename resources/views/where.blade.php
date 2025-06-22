@extends('layouts.app')
@section('content')
<section class="where-section">
    <div class="where-container">
        <div class="where-content">
            <div class="contact-info">
                <h1 class="section-title">Остались вопросы?</h1>
                <div class="contact-block">
                    <h2 class="contact-subtitle">Свяжитесь с нами</h2>
                    <div class="contact-details">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-text">
                                <span class="contact-label">Телефон</span>
                                <a href="tel:+79999999999" class="contact-value">+7 (902) 549 23-23</a>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-text">
                                <span class="contact-label">Email</span>
                                <a href="mailto:example@mail.ru" class="contact-value">digitalzone@gmail.com</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="map-section">
                <h2 class="section-title">Где нас найти?</h2>
                <div class="map-container">
                    <div class="map-overlay"></div>
                    <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A7938691134de401416f2d992bdf1ea6bf580467d63863d4b77cda8675cd79334&amp;width=100%25&amp;height=500&amp;lang=ru_RU&amp;scroll=true"></script>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
