@extends('layouts.app')

@section('content')
<!-- Section: Design Block -->
<section>
    <!-- Jumbotron -->
    <div class="px-4 py-5 px-md-5 text-center text-lg-start">
      <div class="container">
        <div class="row gx-lg-5 align-items-center">
          <div class="col-lg-6 mb-5 mb-lg-0">
            <h1 class="my-3 display-3 fw-bold ls-tight">
              <span class="text-success">Safe</span>Tagum:</br>
              Notifiable Disease Information System<br />
            </h1>
            <p style="color: hsl(217, 10%, 50.8%)">
              SafeTagum is a comprehensive system designed to enhance disease surveillance, prevention, and control in Tagum City. 
              Leveraging cutting-edge technologies like geo-analysis, forecasting, tokenization, and blockchain, 
              It offers a robust platform for real-time data collection, analysis, and dissemination.
            </p>
          </div>
  
          <div class="col-lg-6 mb-5 mb-lg-0">
            <div class="card">
                <div class="card-body py-5 px-md-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <h2 class="fw-bold mb-2 text-uppercase text-center">Login</h2>
                        <p class="mb-5 text-center">Please enter your Email and password!</p>
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> --}}

                        <div class="row mb-0">
                            <div class="col-4 offset-8">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
        <!-- About Us - Bootstrap Brain Component -->
      <div class="row mt-3 gy-3 gy-md-4 gy-lg-0 align-items-lg-center">
        <div class="col-12 col-lg-6 col-xl-5">
          <img class="img-fluid rounded" loading="lazy" src="/images/CESU Map.png" alt="Cesu Map">
        </div>
        <div class="col-12 col-lg-6 col-xl-7">
          <div class="row justify-content-xl-center">
            <div class="col-12 col-xl-11">
              <h2 class="mb-3">Who Are We?</h2>
              <p class="lead fs-4 text-secondary mb-3"><span class="fs-3 text-dark">The Tagum City Epidemiology and Surveillance Unit (CESU)</span> is a vital public health agency dedicated to safeguarding the health of Tagum City residents. They play a crucial role in monitoring and responding to various health threats and outbreaks within the city. The CESU collects and analyzes data on diseases, conducts epidemiological investigations, and implements public health interventions to protect the community's well-being.</p>
              {{-- <div class="row gy-4 gy-md-0 gx-xxl-5X">
                <div class="col-12 col-md-6">
                  <div class="d-flex">
                    <div class="me-4 text-primary">
                        <i width="40" height="40" class="fa-brands fa-facebook"></i>
                    </div>
                    <div>
                      <h2 class="h4 mb-3">Versatile Brand</h2>
                      <p class="text-secondary mb-0">We are crafting a digital method that subsists life across all mediums.</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="d-flex">
                    <div class="me-4 text-primary">
                      <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-fire" viewBox="0 0 16 16">
                        <path d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16Zm0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15Z" />
                      </svg>
                    </div>
                    <div>
                      <h2 class="h4 mb-3">Digital Agency</h2>
                      <p class="text-secondary mb-0">We believe in innovation by merging primary with elaborate ideas.</p>
                    </div>
                  </div>
                </div>
              </div> --}}
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
    <!-- Jumbotron -->
  </section>
  <!-- Section: Design Block -->
@endsection
