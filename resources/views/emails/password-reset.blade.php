<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
</head>
<body>
    <img src="{{url('/images/Galgun_logo01.png')}}" alt="Galgun" width="50%" height="50%">
    <hr>
    {{ trans('messages.password_reset_text', ['website' => config('constants.website_name')]) }}
    <br/>
    <a href="{{ config('constants.backend_url') . '/auth/password/recover/'. $token }}">{{ trans('messages.password_reset_link') }}</a>
</body>
</html>
