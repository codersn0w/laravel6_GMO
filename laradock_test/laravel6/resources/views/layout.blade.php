<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ToDo App</title>
  @yield('styles')
  <link rel="stylesheet" href="/css/styles.css">
  <script src="https://kit.fontawesome.com/9f0b2823d7.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="dark_hover">
<header>
  <nav class="my-navbar">
    <a class="my-navbar-brand" href="/">ToDo App <i class="fas fa-list-ul"></i></a>
    <div class="my-navbar-control">
      @if(Auth::check())
        <a href="{{ route('folders.create') }}"  class="btn btn-primary">
              フォルダを新規作成
        </a>
        ｜
        <span class="my-navbar-item">ようこそ, {{ Auth::user()->name }}さん</span>
        ｜
        <a href="#" id="logout" class="my-navbar-item">ログアウト</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      @else
        <a class="my-navbar-item" href="{{ route('login') }}">ログイン</a>
        ｜
        <a class="my-navbar-item" href="{{ route('register') }}">会員登録</a>
      @endif
    </div>
  </nav>
</header>
<main>
  @yield('content')
</main>
@if(Auth::check())
  <script>
    document.getElementById('logout').addEventListener('click', function(event) {
      event.preventDefault();
      document.getElementById('logout-form').submit();
    });
  </script>
@endif
@yield('scripts')
</div>
</body>
</html>