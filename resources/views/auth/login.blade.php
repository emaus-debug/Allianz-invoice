@extends('home.layout')

@section('title')
    Connexion
@endsection

@section('content')

    <section class="vh-100">
        <div class="container py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-8 col-lg-7 col-xl-6">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
                class="img-fluid" alt="Phone image">
            </div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Email input -->
                <div class="form-outline mb-4">
                    <input type="email" id="email" class="form-control form-control-lg" placeholder="Email" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus/>
                    <label class="form-label" for="form1Example13">Adresse Email</label>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
    
                <!-- Password input -->
                <div class="form-outline mb-4">
                    <input type="password" id="password" class="form-control form-control-lg" placeholder="Mot de passe" @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"/>
                    <label class="form-label" for="form1Example23">Password</label>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
    
                <div class="d-flex justify-content-around align-items-center mb-4">
                <!-- Checkbox -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
                    <label class="form-check-label" for="form1Example3"> Remember me </label>
                </div>
                <a href="#!">Forgot password?</a>
                </div>
    
                <!-- Submit button -->
                <button type="submit" style="width: 100%" class="btn btn-primary btn-lg btn-block">Connexion</button>
    
            </form>
            </div>
        </div>
        </div>
    </section>
    
@endsection