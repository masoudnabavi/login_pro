<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form id="form" method="post" action="{{ route('addUserPost') }}"
      enctype="multipart/form-data">
    @csrf

    <input id="new_password" name="new_password" type="password" value="123456789"
           placeholder="رمزعبور" />

    <input id="re_new_password" name="re_new_password" type="password" value="123456789"
           placeholder="تکرار رمزعبور" />

    <input type="submit" value="Enter"/>


</form>
</body>
</html>
