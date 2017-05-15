@extends('edutalk-core::admin._master')

@section('css')

@endsection

@section('js')

@endsection

@section('js-init')

@endsection

@section('content')
    <div class="layout-1columns">
        <div class="column main">
            @php
                $curentTab = Request::get('_tab', 'user_profiles');
            @endphp
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs tab-change-url">
                    <li class="{{ $curentTab === 'user_profiles' ? 'active' : '' }}">
                        <a data-target="#user_profiles"
                           data-toggle="tab"
                           href="{{ Request::url() }}?_tab=user_profiles"
                           aria-expanded="false">{{ trans('edutalk-users::base.user_profiles') }}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="user_profiles">
                        {!! Form::open(['class' => 'js-validate-form', 'url' => route('admin::users.create.post')]) !!}
                        {!! Form::hidden('_tab', 'user_profiles') !!}
                        <div class="form-group">
                            <label class="control-label "><b>{{ trans('edutalk-users::base.display_name') }}</b></label>
                            <input type="text" value="{{ old('display_name') }}"
                                   name="display_name"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('edutalk-users::base.username') }}</b></label>
                            <input type="text" value="{{ old('username') }}"
                                   name="username"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('edutalk-users::base.email') }}</b></label>
                            <input type="text" value="{{ old('email') }}"
                                   name="email"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label "><b>{{ trans('edutalk-users::base.password') }}</b></label>
                            <input type="password" value=""
                                   name="password"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label "><b>{{ trans('edutalk-users::base.first_name') }}</b></label>
                            <input type="text" value="{{ old('first_name') }}"
                                   name="first_name"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('edutalk-users::base.last_name') }}</b></label>
                            <input type="text" value="{{ old('last_name') }}"
                                   name="last_name"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('edutalk-users::base.phone') }}</b></label>
                            <input type="text" value="{{ old('phone') }}"
                                   name="phone"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('edutalk-users::base.mobile_phone') }}</b></label>
                            <input type="text" value="{{ old('mobile_phone') }}"
                                   name="mobile_phone"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('edutalk-users::base.sex') }}</b></label>
                            {!! Form::customRadio('sex', [
                                ['male', trans('edutalk-core::base.sex.male')],
                                ['female', trans('edutalk-core::base.sex.female')],
                                ['other', trans('edutalk-core::base.sex.other')],
                            ], old('sex', 'male')) !!}
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('edutalk-users::base.status') }}</b></label>
                            <div class="mt-radio-list">
                                <label class="mt-radio mt-radio-outline">
                                    <input type="radio" name="status" value="activated"
                                        {{ (old('status') == 'activated') ? 'checked' : '' }}>
                                    {{ trans('edutalk-core::base.status.activated') }}
                                    <span></span>
                                </label>
                                <label class="mt-radio mt-radio-outline">
                                    <input type="radio" name="status" value="disabled"
                                        {{ (old('status', 'disabled') == 'disabled') ? 'checked' : '' }}>
                                    {{ trans('edutalk-core::base.status.disabled') }}
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('edutalk-users::base.birthday') }}</b></label>
                            <input type="text"
                                   value="{{ old('birthday') }}"
                                   name="birthday"
                                   data-date-format="yyyy-mm-dd"
                                   autocomplete="off"
                                   readonly
                                   class="form-control js-date-picker input-medium"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>{{ trans('edutalk-users::base.description') }}</b></label>
                            <textarea class="form-control"
                                      name="description"
                                      rows="5">{!! old('description') !!}</textarea>
                        </div>
                        <div class="form-group">
                            {!! Form::selectImageBox('avatar', old('avatar')) !!}
                        </div>
                        <div class="mt10 text-right">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-check"></i> {{ trans('edutalk-core::base.form.save') }}
                            </button>
                            <button class="btn btn-success" type="submit"
                                    name="_continue_edit" value="1">
                                <i class="fa fa-check"></i> {{ trans('edutalk-core::base.form.save_and_continue') }}
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
