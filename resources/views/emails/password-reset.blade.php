<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
</head>
<body>
    <img src="http://18.223.118.94/docs/images/logo.png" alt="Galgun">
    <hr>
    {{ trans('messages.password_reset_text', ['website' => config('constants.website_name')]) }}
    <br/>
    <a href="{{ config('constants.backend_url') . '/auth/password/recover/'. $token }}">{{ trans('messages.password_reset_link') }}</a>
</body>
</html>
