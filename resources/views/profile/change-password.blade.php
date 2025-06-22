@extends('layouts.app')
@section('content')
<div class="password-change mt-4">
    <h2 class="password-change__title">Смена пароля</h2>
    @if (session('status') === 'password-updated')
        <div class="alert alert-success">
            Пароль успешно обновлен!
        </div>
    @endif
    <form method="POST" action="{{ route('profile.password.update') }}" class="password-change__form">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="current_password">Текущий пароль:</label>
            <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
            @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Новый пароль:</label>
            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Подтвердите новый пароль:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
        </div>

        <div class="form-buttons mt-3">
            <button type="submit" class="btn btn-primary">
                Сменить пароль
            </button>
            <a href="{{ route('user') }}" class="btn btn-secondary">
                Назад
            </a>
        </div>
    </form>
</div>
@endsection 