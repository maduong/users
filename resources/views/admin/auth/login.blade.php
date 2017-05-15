@extends('edutalk-users::admin.auth._auth-actions')

@section('css')

@endsection

@section('js-init')

@endsection

@section('content')
    <!-- BEGIN LOGIN FORM -->
    <?php
    $errors = Session::get('errorMessages');
    if (!$errors) {
        $errors = Session::get('errors');
        if ($errors) {
            $errors = $errors->all();
        }
    }
    ?>
    <div class="login-box">
        <div class="login-logo">
            <a href="/"><b>Edutalk</b></a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">{{ trans('edutalk-users::auth.intro_message') }}</p>
            @if($errors) @foreach($errors as $key => $row)
                <div class="note note-danger">
                    <p>{{ $row }}</p>
                </div>
            @endforeach @endif
            {!! Form::open() !!}
            <div class="form-group has-feedback">
                {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => trans('edutalk-users::auth.username')]) !!}
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('edutalk-users::auth.password')]) !!}
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    {!! form()->customCheckbox([
                        ['remember', 1, trans('edutalk-users::auth.remember_me')]
                    ]) !!}
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    {!! Form::button(trans('edutalk-users::auth.sign_in'), ['class' => 'btn btn-primary btn-block btn-flat', 'type' => 'submit']) !!}
                </div>
                <!-- /.col -->
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <!-- END LOGIN FORM -->
@endsection
