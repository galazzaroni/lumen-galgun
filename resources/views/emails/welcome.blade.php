<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
</head>
<body>
    <img src="images/Galgun_logo05.png" height="100" width="100" alt="Galgun">
    <h2>
        {{ trans('messages.welcome_header', ['website' => config('constants.website_name'), 'name' => $name]) }}.
    </h2>
    <br/>
    {{ trans('messages.welcome_text') }}
    <br/><br/>
    <a href="{{ config('constants.backend_url') . '/auth/verify/'. $token }}">{{ trans('messages.welcome_link') }}</a>
</body>
</html>