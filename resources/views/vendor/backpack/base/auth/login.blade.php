@extends('auth.left-image')

@section('content')
    <div class="row justify-content-center ">
        <div class="col-12">
            <h3 class="text-center mb-4">{!! config('backpack.base.project_logo') !!}</h3>

            <h3 class="col-md-12 p-t-10 mt-4"><b>{{ trans('backpack::base.login') }}</b></h3>

            <form class="col-md-12 p-t-10" role="form" method="POST"
                action="{{ route('backpack.auth.login') }}">
                {!! csrf_field() !!}

                <div class="form-group">
                    <div>
                        <input type="text"
                            class="form-control{{ $errors->has($username) ? ' is-invalid' : '' }}"
                            name="{{ $username }}" value="{{ old($username) }}"
                            id="{{ $username }}"
                            placeholder="{{ config('backpack.base.authentication_column_name') }}">

                        @if ($errors->has($username))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first($username) }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <input type="password"
                            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                            name="password" id="password"
                            placeholder="{{ trans('backpack::base.password') }}">

                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember">
                                {{ trans('backpack::base.remember_me') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <button type="submit" class="btn btn-block btn-primary">
                            {{ trans('backpack::base.login') }}
                        </button>
                    </div>
                </div>
            </form>

            @if (backpack_users_have_email() && config('backpack.base.setup_password_recovery_routes', true))
                <div class="text-center"><a
                        href="{{ route('backpack.auth.password.reset') }}">{{ trans('backpack::base.forgot_your_password') }}</a>
                </div>
            @endif
            @if (config('backpack.base.registration_open'))
                <div class="text-center"><a
                        href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a>
                </div>
            @endif
        </div>
    </div>
@endsection
