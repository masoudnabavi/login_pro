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
<form id="form" method="post" action="{{ route('editUserPost') }}"
      enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{$user->id}}">

    <input id="mobile" name="mobile" type="text" value="{{$user->mobile}}"
           placeholder="شماره موبایل" />

    <input id="email" name="email" type="text" value="{{$user->email}}"
           placeholder="ایمیل" />

    <input id="username" name="username" type="text" value="{{$user->username}}"
           placeholder="نام کاربری" />

    <input id="national_code" name="national_code" type="text" value="{{$user->national_code}}"
           placeholder="کد ملی" />

    <input id="password" name="password" type="password"
           placeholder="رمزعبور" />

    <input id="birth_date" name="birth_date" type="text" autocomplete="off">

    <input type="submit" value="Enter"/>


</form>
</body>
</html>
