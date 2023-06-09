@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Домашняя страница</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @guest
                    @if (Route::has('register'))
                        Вы не вошли в аккаунт
                    @endif
                    @else
                        Вы вошли как {{ Auth::user()->name }}
                        <a class="nav-link" href="/user/{{ Auth::user()->name }}">Мой профиль</a>
                    @endguest
                    <a class="nav-link" href="/userlist">Список пользователей</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
