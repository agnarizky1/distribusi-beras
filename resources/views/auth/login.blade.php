<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="generator" content="Hugo 0.115.4">
    <title>Login page</title>

    <!-- Custom styles for this template -->
    <link href="{{ asset('assets/css/login.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-12">
                <div class="form">

                    <form action="{{ route('do.login') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h2>SISTEM INFORMASI <br> UD. SUMBER REJEKI SEJATI</h2>
                        <div class="input-group col-md-8 col-md-offset-2">
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="input email @error('email') is-invalid @enderror">
                            <label>Email</label>
                            <div class="text-danger">
                                @error('email')
                                    Email tidak boleh kosong.
                                @enderror
                            </div>
                        </div>

                        <div class="input-group col-md-8 col-md-offset-2">
                            <input type="password" name="password" value="{{ old('password') }}"
                                class="input password @error('password') is-invalid @enderror">
                            <label>Password</label>
                            <div class="text-danger">
                                @error('password')
                                    Password tidak boleh kosong.
                                @enderror
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="col-md-4 col-md-offset-4">
                                <button type="submit">
                                    LOGIN
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('assets/js/login.js') }}"></script>

</html>
