<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
</head>
<body>
    {{ trans('messages.password_reset_text', ['website' => config('constants.website_name')]) }}
    <br/>
    <a href="{{ config('constants.backend_url') . '/auth/password/recover/'. $token }}">{{ trans('messages.password_reset_link') }}</a>
</body>
</html>
