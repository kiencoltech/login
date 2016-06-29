@extends('common.bootstrap-layout')
@include('common.header')
@section('content')
    <title>PAG | ログイン</title>
</header>
<body>
<div class="text-center" style="padding:50px 0">
    <div class="logo">{{ HTML::image('img/logo_pag.gif', 'logo') }}</div>
    <div id="messages">

        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span>
                {{{ $error }}}
            </div>
        @endforeach
    </div>
    <!-- Main Form -->
    <div class="login-form-1">
        {{ Form::open(['method' => 'POST', 'url' => '/admin/login', 'id' => 'login-form', 'class' => 'text-left']) }}
            {{-- Form::token() --}}
            <div class="login-form-main-message"></div>
            <div class="main-login-form">
                <div class="login-group">
                    <div class="form-group">
                        {{ Form::label('lg_username', 'ユーザー名', ['class' => 'sr-only']) }}
                        {{ Form::text('username', $username, ['class' => 'form-control', 'id' => 'lg_username', 'placeholder' => 'ユーザー名']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('lg_password', 'パスワード', ['class' => 'sr-only']) }}
                        {{ Form::password('password', ['class' => 'form-control', 'id' => 'lg_password', 'placeholder' => 'パスワード']) }}
                    </div>
                    <div class="form-group login-group-checkbox">
                        {{Form::checkbox('remember', '1', null !== $remember, ['id' => 'lg_remember'])}}
                        {{ Form::label('lg_remember', 'この情報をブラウザに保存する') }}
                    </div>
                </div>
                <button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
            </div>
        {{ Form::close() }}
    </div>
    <!-- end:Main Form -->
</div>
<style type="text/css">
    html,
    body {
        /* background: #efefef; */
        background: #EDF7FF;
        padding: 10px;
    }
    /*=== 2. Anchor Link ===*/
    a {
        color: #aaaaaa;
        transition: all ease-in-out 200ms;
    }
    a:hover {
        color: #333333;
        text-decoration: none;
    }
    /*=== 3. Text Outside the Box ===*/
    .etc-login-form {
        color: #919191;
        padding: 10px 20px;
    }
    .etc-login-form p {
        margin-bottom: 5px;
    }
    /*=== 4. Main Form ===*/
    .login-form-1 {
        max-width: 500px;
        min-width: 350px;
        border-radius: 5px;
        display: inline-block;
    }
    .main-login-form {
        position: relative;
    }
    .login-form-1 .form-control {
        border: 0;
        box-shadow: 0 0 0;
        border-radius: 0;
        background: transparent;
        color: #555555;
        padding: 7px 0;
        font-weight: bold;
        height:auto;
    }
    .login-form-1 .form-control::-webkit-input-placeholder {
        color: #999999;
    }
    .login-form-1 .form-control:-moz-placeholder,
    .login-form-1 .form-control::-moz-placeholder,
    .login-form-1 .form-control:-ms-input-placeholder {
        color: #999999;
    }
    .login-form-1 .form-group {
        margin-bottom: 0;
        border-bottom: 2px solid #efefef;
        padding-right: 20px;
        position: relative;
    }
    .login-form-1 .form-group:last-child {
        border-bottom: 0;
    }
    .login-group {
        background: #ffffff;
        color: #999999;
        border-radius: 8px;
        padding: 10px 20px;
    }
    .login-group-checkbox {
        padding: 5px 0;
    }
    /*=== 5. Login Button ===*/
    .login-form-1 .login-button {
        position: absolute;
        right: -25px;
        top: 50%;
        background: #ffffff;
        color: #999999;
        padding: 11px 0;
        width: 50px;
        height: 50px;
        margin-top: -25px;
        border: 5px solid #6699FF;
        border-radius: 50%;
        transition: all ease-in-out 500ms;
    }
    .login-form-1 .login-button:hover {
        color: #555555;
        transform: rotate(450deg);
    }
    .login-form-1 .login-button.clicked {
        color: #555555;
    }
    .login-form-1 .login-button.clicked:hover {
        transform: none;
    }
    .login-form-1 .login-button.clicked.success {
        color: #2ecc71;
    }
    .login-form-1 .login-button.clicked.error {
        color: #e74c3c;
    }
    /*=== 6. Form Invalid ===*/
    label.form-invalid {
        position: absolute;
        top: 0;
        right: 0;
        z-index: 5;
        display: block;
        margin-top: -25px;
        padding: 7px 9px;
        background: #777777;
        color: #ffffff;
        border-radius: 5px;
        font-weight: bold;
        font-size: 11px;
    }
    label.form-invalid:after {
        top: 100%;
        right: 10px;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-color: transparent;
        border-top-color: #777777;
        border-width: 6px;
    }
    /*=== 7. Form - Main Message ===*/
    .login-form-main-message {
        background: #ffffff;
        color: #999999;
        border-left: 3px solid transparent;
        border-radius: 3px;
        margin-bottom: 8px;
        font-weight: bold;
        height: 0;
        padding: 0 20px 0 17px;
        opacity: 0;
        transition: all ease-in-out 200ms;
    }
    .login-form-main-message.show {
        height: auto;
        opacity: 1;
        padding: 10px 20px 10px 17px;
    }
    .login-form-main-message.success {
        border-left-color: #2ecc71;
    }
    .login-form-main-message.error {
        border-left-color: #e74c3c;
    }
    /*=== 8. Custom Checkbox & Radio ===*/
    /* Base for label styling */
    [type="checkbox"]:not(:checked),
    [type="checkbox"]:checked {
        position: absolute;
        left: -9999px;
    }
    [type="checkbox"]:not(:checked) + label,
    [type="checkbox"]:checked + label {
        position: relative;
        padding-left: 25px;
        padding-top: 1px;
        cursor: pointer;
    }
    /* checkbox aspect */
    [type="checkbox"]:not(:checked) + label:before,
    [type="checkbox"]:checked + label:before {
        content: '';
        position: absolute;
        left: 0;
        top: 2px;
        width: 17px;
        height: 17px;
        border: 0px solid #aaa;
        background: #f0f0f0;
        border-radius: 3px;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3);
    }
    /* checked mark aspect */
    [type="checkbox"]:not(:checked) + label:after,
    [type="checkbox"]:checked + label:after {
        position: absolute;
        color: #555555;
        transition: all .2s;
    }
    /* checked mark aspect changes */
    [type="checkbox"]:not(:checked) + label:after {
        opacity: 0;
        transform: scale(0);
    }
    [type="checkbox"]:checked + label:after {
        opacity: 1;
        transform: scale(1);
    }
    /* disabled checkbox */
    [type="checkbox"]:disabled:not(:checked) + label:before,
    [type="checkbox"]:disabled:checked + label:before {
        box-shadow: none;
        border-color: #8c8c8c;
        background-color: #878787;
    }
    [type="checkbox"]:disabled:checked + label:after {
        color: #555555;
    }
    [type="checkbox"]:disabled + label {
        color: #8c8c8c;
    }
    /* accessibility */
    [type="checkbox"]:checked:focus + label:before,
    [type="checkbox"]:not(:checked):focus + label:before,
    [type="checkbox"]:checked:focus + label:before,
    [type="checkbox"]:not(:checked):focus + label:before {
        border: 1px dotted #f6f6f6;
    }
    /* hover style just for information */
    label:hover:before {
        border: 1px solid #f6f6f6 !important;
    }
    /*=== Customization ===*/
    /* radio aspect */
    [type="checkbox"]:not(:checked) + label:before,
    [type="checkbox"]:checked + label:before {
        border-radius: 3px;
    }
    /* selected mark aspect */
    [type="checkbox"]:not(:checked) + label:after,
    [type="checkbox"]:checked + label:after {
        content: '✔';
        top: 0;
        left: 2px;
        font-size: 14px;
    }
    /*=== 9. Misc ===*/
    .logo {
        padding: 10px 5px;
        /* color: #aaaaaa; */
        color: #FFFFFF;
        background-color: #ffffff;
        max-width: 200px;
        margin: 15px auto;
        border-radius: 10px;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
    }
    #messages {
        min-width: 350px;
        max-width: 500px;
        margin: 0 auto;
    }
</style>
@stop
@include('common.footer')