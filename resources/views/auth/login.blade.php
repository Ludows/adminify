@extends('adminify::layouts.admin.app', ['class' => 'bg-default', 'fullmode' => true])

@section('content')
    @include('adminify::layouts.admin.headers.guest')

    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-header bg-transparent pb-0 border-bottom-0">
                        <div class="text-muted text-center mt-2 mb-0"><small>{{ __('admin.sign_in') }}</small></div>
                        {{-- <div class="btn-wrapper text-center">
                            <a href="#" class="btn btn-neutral btn-icon">
                                <span class="btn-inner--icon"><img src="{{ asset('argon') }}/img/icons/common/github.svg"></span>
                                <span class="btn-inner--text">{{ __('Github') }}</span>
                            </a>
                            <a href="#" class="btn btn-neutral btn-icon">
                                <span class="btn-inner--icon"><img src="{{ asset('argon') }}/img/icons/common/google.svg"></span>
                                <span class="btn-inner--text">{{ __('Google') }}</span>
                            </a>
                        </div> --}}
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        @if (env('APP_ENV') == 'local')
                            <div class="text-center text-muted mb-4">
                                <small>
                                        Create new account OR Sign in with these credentials:
                                        <br>
                                        Username <strong>admin@argon.com</strong> Password: <strong>secret</strong>
                                </small>
                            </div>
                        @endif

                        @isset($form)
                            {!! form_start($form); !!}
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        {!! form_widget($form->email) !!}
                                    </div>
                                    {!! form_error($form->email) !!}
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        {!! form_widget($form->password) !!}
                                    </div>
                                    {!! form_error($form->password) !!}
                                </div>
                            {!! form_end($form, true) !!}
                        @endisset
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-light">
                                <small>{{ __('admin.forgot_password') }}</small>
                            </a>
                        @endif
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('register') }}" class="text-light">
                            <small>{{ __('admin.create_account') }}</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
