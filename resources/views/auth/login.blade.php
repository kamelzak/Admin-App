<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>AdminApp - Login</title>

        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!------ Include the above in your HEAD tag ---------->

        <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
        <script src="{{ asset('js/login.js') }}"></script>
    </head>

    <body>
        
        <div class="container">
            <div class="row">
                <div class="col-md-5 mx-auto">
                <div id="first">
                    <div class="myform form ">
                         <div class="logo mb-3">
                             <div class="col-md-12 text-center">
                                <h1>Login</h1>
                             </div>
                        </div>
                       <form action="{{ route('login') }}" method="POST" name="login">
                        @csrf
                               <div class="form-group">
                                  <label for="exampleInputEmail1">Email address</label>
                                  <input type="email" name="email"  class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="email" aria-describedby="emailHelp" placeholder="Enter email" required autofocus> 
                                  @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                               <div class="form-group">
                                  <label for="exampleInputEmail1">Password</label>
                                  <input type="password" name="password" id="password"  class="form-control @error('password') is-invalid @enderror" aria-describedby="emailHelp" placeholder="Enter Password" required>
                                  @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                               <div class="form-group">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        
                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                               </div>
                               <div class="col-md-12 text-center ">
                                  <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Login</button>
                               </div>
                               <div class="col-md-12 ">
                                  <div class="login-or">
                                     <hr class="hr-or">
                                     <span class="span-or">or</span>
                                  </div>
                               </div>
                               <div class="col-md-12 mb-3">
                                  <p class="text-center">
                                     <a href="/auth/redirect" class="google btn mybtn"><i class="fa fa-github">
                                     </i> Login with Github
                                     </a>
                                  </p>
                               </div>
                               <div class="form-group">
                                  <p class="text-center">Don't have account? <a href="{{ route('register') }}" id="signup">Sign up here</a></p>
                               </div>
                            </form>
                     
                    </div>
                </div>
                 
                </div>
            </div>
          </div>   

    </body>
</html>