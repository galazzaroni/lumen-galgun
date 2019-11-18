<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
</head>
<?php echo Request::url(); ?>
<body>
    <form method="post" action="/games" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group row">
            <label for="password" class="col-sm-3 col-form-label">New Password</label>
            <div class="col-sm-9">
                <input name="password" type="password" class="form-control" id="password" placeholder="Password">
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-sm-3 col-sm-9">
                <button type="submit" class="btn btn-primary">Cambiar Password</button>
            </div>
        </div>
</body>

</html>