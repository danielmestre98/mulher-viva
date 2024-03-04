<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mulher Viva - Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
</head>

<body>
    <section class="container login">
        <div class="card mb-3">
            <div class="login-card">
                <div class="info">
                    <h1>PROGRAMA MULHER VIVA</h1>
                </div>
                <div class="form">
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <h5 class="card-title display-5 text-center">Acesso</h5>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" name="email" required id="floatingInput"
                                    placeholder="name@example.com">
                                <label for="floatingInput">E-Mail</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" name="password" required class="form-control"
                                    id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Senha</label>
                            </div>
                            @if (isset($error))
                                <div class="alert alert-danger mt-3" role="alert">
                                    {{ $error }}
                                </div>
                            @endif
                            <div class="d-grid gap-2 mt-3">
                                <button class="btn btn-primary btn-lg" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
