<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
</head>
<body>
    <img src="{{url('/images/Galgun_logo01.png')}}" alt="Galgun" width="50%" height="50%">
    <h2>
        {{ trans('messages.welcome_header', ['website' => config('constants.website_name'), 'name' => $name]) }}.
    </h2>
    <br/>
    {{ trans('messages.welcome_text') }}
    <br/><br/>
    <a href="{{ config('constants.backend_url') . '/auth/verify/'. $token }}">{{ trans('messages.welcome_link') }}</a>
</body>
</html>
