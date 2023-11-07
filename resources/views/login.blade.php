<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPRAGA | LOGIN</title>
    <link rel="shortcut icon" type="image/jpg" href="{{ asset('images/logos/sipraga.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="container-fluid vh-100 vw-100 d-flex justify-content-center align-items-center"
        style="background-color: #F5F7F8;">
        <div class="card col-md-3 col-10">
            <div class="card-body d-flex flex-column align-items-center gap-3">
                <img class="img-fluid" src="{{ asset('images/logos/sipraga-logo.jpg') }}"
                    style="width: 166px; height: 45px;" alt="">
                <p class="text-center fs-2 m-0">Gunakan akun SIPADU Anda untuk masuk</p>
                <div
                    class="login-sipadu w-100 d-flex align-items-center justify-content-center border border-2 rounded-1 p-1 shadow-sm">
                    <a href="" class="d-flex align-items-center">
                        <img class="me-1" style="width: 25px; height: 25px;"
                            src="{{ asset('images/logos/sipadu-ng.png') }}" alt="">
                        <p class="text-dark m-0">Masuk dengan SIPADU</p>
                    </a>
                </div>
                <div class="or d-flex w-100 justify-content-center align-items-center p-1">
                    <div class="line m-0 w-100"></div>
                    <p class="mx-2 my-0">OR</p>
                    <div class="line m-0 w-100"></div>
                </div>
                <form action="/login" method="POST" class="w-100 d-flex flex-column gap-3">
                    @csrf
                    @error('failed')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <input type="text" id="email" class="form-control" name="email"
                            placeholder="emailanda@example.com" value="{{ old('email') }}">
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" class="form-control" name="password" placeholder="****"
                            required>
                        @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="checkbox">
                        <label class="d-flex align-items-center"><input class="me-2" type="checkbox">Ingat saya di
                            perangkat ini</label>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2 w-100">Masuk</a>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="{{ asset('libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
</body>

</html>
