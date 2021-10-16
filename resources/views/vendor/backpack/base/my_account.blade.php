@extends(backpack_view('blank'))

@section('after_styles')
    <style media="screen">
        .backpack-profile-form .required::after {
            content: ' *';
            color: red;
        }

    </style>
@endsection

@php
$breadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    trans('backpack::base.my_account') => false,
];
@endphp

@section('header')
    <section class="content-header">
        <div class="container-fluid mb-3">
            <h1>{{ trans('backpack::base.my_account') }}</h1>
        </div>
    </section>
@endsection

@section('content')
    <div class="row">

        @if (session('success'))
            <div class="col-lg-8">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if ($errors->count())
            <div class="col-lg-8">
                <div class="alert alert-danger">
                    <ul class="mb-1">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header text-center">
                    <img class="img-avatar"
                        src="{{ backpack_avatar_url(backpack_auth()->user()) }}"
                        alt="{{ backpack_auth()->user()->name }}" onerror="this.style.display='none'">
                    {{-- <span class="backpack-avatar-menu-container"
                        style="position: absolute;left: 0;width: 100%;background-color: #ffffff;border-radius: 50%;color: #FFF;line-height: 35px;">
                        {{ backpack_user()->getAttribute('name') ? mb_substr(backpack_user()->name, 0, 1, 'UTF-8') : 'A' }}
                    </span> --}}
                </div>
                <div class="card-body">
                    {{-- <p class="text-center">
                        <b>{{ backpack_user()->name }}</b>
                        </br>
                        <b>{{ backpack_user()->email }}</b>
                    </p> --}}
                    <p class="text-muted text-center">
                        <b>
                            @foreach (backpack_user()->getRoleNames() as $role)
                                {{ $role }}
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </b>
                        @if (isset(backpack_user()->kelas))
                            <b>
                                @foreach (backpack_user()->kelas as $kelas)
                                    @if ($loop->first)
                                        di

                                    @endif
                                    {{ $kelas->nama }}
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </b>
                        @endif
                        @if (isset(backpack_user()->sekolah))
                            di
                            <b>
                                {{ backpack_user()->sekolah->nama }}
                            </b>
                        @endif
                    </p>
                    <p class="text-muted text-center">
                        @if (backpack_user()->ortu != null)
                            <b>
                                Anak
                            </b>
                            dari
                            <b>
                                {{ backpack_user()->ortu->name }}
                            </b>
                        @endif
                        @if (backpack_user()->anak != null)
                            <b>
                                Orang Tua
                            </b>
                            dari
                            <b>
                                @foreach (backpack_user()->anak as $anak)
                                    {{ $anak->name }}
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </b>
                        @endif

                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-8 p-0">
            {{-- UPDATE INFO FORM --}}
            <div class="col-12">
                <form class="form" action="{{ route('backpack.account.info.store') }}"
                    method="post">

                    {!! csrf_field() !!}

                    <div class="card padding-10">

                        <div class="card-header">
                            {{ trans('backpack::base.update_account_info') }}
                        </div>

                        <div class="card-body backpack-profile-form bold-labels">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    @php
                                        $label = trans('backpack::base.name');
                                        $field = 'name';
                                    @endphp
                                    <label class="required">{{ $label }}</label>
                                    <input required class="form-control" type="text"
                                        name="{{ $field }}"
                                        value="{{ old($field) ? old($field) : $user->$field }}">
                                </div>

                                <div class="col-md-6 form-group">
                                    @php
                                        $label = config('backpack.base.authentication_column_name');
                                        $field = backpack_authentication_column();
                                    @endphp
                                    <label class="required">{{ $label }}</label>
                                    <input required class="form-control"
                                        type="{{ backpack_authentication_column() == 'email' ? 'email' : 'text' }}"
                                        name="{{ $field }}"
                                        value="{{ old($field) ? old($field) : $user->$field }}">
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="la la-save"></i>
                                {{ trans('backpack::base.save') }}</button>
                            <a href="{{ backpack_url() }}"
                                class="btn">{{ trans('backpack::base.cancel') }}</a>
                        </div>
                    </div>

                </form>
            </div>

            {{-- CHANGE PASSWORD FORM --}}
            <div class="col-12">
                <form class="form" action="{{ route('backpack.account.password') }}"
                    method="post">

                    {!! csrf_field() !!}

                    <div class="card padding-10">

                        <div class="card-header">
                            {{ trans('backpack::base.change_password') }}
                        </div>

                        <div class="card-body backpack-profile-form bold-labels">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    @php
                                        $label = trans('backpack::base.old_password');
                                        $field = 'old_password';
                                    @endphp
                                    <label class="required">{{ $label }}</label>
                                    <input autocomplete="new-password" required class="form-control"
                                        type="password" name="{{ $field }}"
                                        id="{{ $field }}" value="">
                                </div>

                                <div class="col-md-4 form-group">
                                    @php
                                        $label = trans('backpack::base.new_password');
                                        $field = 'new_password';
                                    @endphp
                                    <label class="required">{{ $label }}</label>
                                    <input autocomplete="new-password" required class="form-control"
                                        type="password" name="{{ $field }}"
                                        id="{{ $field }}" value="">
                                </div>

                                <div class="col-md-4 form-group">
                                    @php
                                        $label = trans('backpack::base.confirm_password');
                                        $field = 'confirm_password';
                                    @endphp
                                    <label class="required">{{ $label }}</label>
                                    <input autocomplete="new-password" required class="form-control"
                                        type="password" name="{{ $field }}"
                                        id="{{ $field }}" value="">
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="la la-save"></i>
                                {{ trans('backpack::base.change_password') }}</button>
                            <a href="{{ backpack_url() }}"
                                class="btn">{{ trans('backpack::base.cancel') }}</a>
                        </div>

                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
