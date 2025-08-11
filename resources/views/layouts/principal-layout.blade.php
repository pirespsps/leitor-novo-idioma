<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/mainStyle.css') }}" rel="stylesheet">
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    <title>Leitor</title>
</head>
<body>

    <header class="container-fluid">
        <ul>
            <a href="/leitor"><li class="itemMenu">Menu</li></a>
            <a href="/biblioteca"><li class="itemMenu">Salvos</li></a>
            <a href="form"><li class="itemMenu">Novo</li></a>
            <a href="/palavras"><li class="itemMenu">Palavras</li></a>
        </ul>
    </header>

    <section class="conteudo">
        @yield('conteudo')
    </section>

    @yield('script')

</body>
</html>