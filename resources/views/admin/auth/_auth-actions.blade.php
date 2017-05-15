<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <base href="{{ asset('') }}">
    <meta charset="utf-8"/>
    <title>{{ $pageTitle or 'Dashboard' }} | Edutalk</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Admin dashboard - Edutalk" name="description"/>

    {!! \Assets::renderStylesheets() !!}

    <link rel="stylesheet" href="{{ asset('admin/theme/lte/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/theme/lte/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">

    @yield('css')

    <link rel="shortcut icon" href="{{ asset(get_setting('favicon', 'favicon.png')) }}"/>

    <script type="text/javascript">
        var BASE_URL = '{{ asset('') }}',
            FILE_MANAGER_URL = '{{ route('admin::elfinder.popup.get') }}';
    </script>

    {{--BEGIN plugins--}}
    {!! \Assets::renderScripts('top') !!}
    {{--END plugins--}}
</head>

<body class="{{ $bodyClass or '' }} skin-purple sidebar-mini on-loading">

<div class="auth-actions-bar">
    <div class="text-right">
        <div class="dropdown">
            <a href="javascript:;"
               class="dropdown-toggle"
               data-toggle="dropdown"
               data-hover="dropdown"
               data-close-others="true">
                {{ trans('edutalk-core::languages.' . dashboard_language()->getDashboardLanguage()) }}
                <span class="fa fa-angle-down"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                @foreach(config('Edutalk.languages', []) as $slug => $language)
                    <li class="{{ $slug == dashboard_language()->getDashboardLanguage() ? 'active' : '' }}">
                        <a href="{{ route('admin::dashboard-language.get', [$slug]) }}">
                            {{ trans('edutalk-core::languages.' . $slug) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<!-- Loading state -->
<div class="page-spinner-bar">
    <div class="bounce1"></div>
    <div class="bounce2"></div>
    <div class="bounce3"></div>
</div>
<!-- Loading state -->

@yield('content')

{{--Modals--}}
@include('edutalk-core::admin._partials.modals')

<!--[if lt IE 9]>
<script src="{{ asset('admin/plugins/respond.min.js') }}"></script>
<script src="{{ asset('admin/plugins/excanvas.min.js') }}"></script>
<![endif]-->

{{--BEGIN plugins--}}
<script src="{{ asset('admin/theme/lte/js/app.js') }}"></script>
<script src="{{ asset('admin/js/edutalk-core.js') }}"></script>
<script src="{{ asset('admin/theme/lte/js/demo.js') }}"></script>
<script src="{{ asset('admin/js/script.js') }}"></script>
{!! \Assets::renderScripts('bottom') !!}
{{--END plugins--}}

@yield('js')

@yield('js-init')

</body>

</html>
