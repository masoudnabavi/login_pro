<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form id="form" method="post" action="{{ route('loginUserPost') }}"
      enctype="multipart/form-data">
    @csrf

    <input id="mobile" name="mobile" type="text" value="09331902390"
           placeholder="شماره موبایل" />

    <input id="email" name="email" type="text" value="masoudn401@gmail.com"
           placeholder="ایمیل" />

    <input id="username" name="username" type="text" value="masoudnbv"
           placeholder="نام کاربری" />

    <input id="national_code" name="national_code" type="text" value="4271270482"
           placeholder="کد ملی" />

    <input id="password" name="password" type="password" value="123456789"
           placeholder="رمزعبور" />
    <input type="submit" value="Enter"/>


</form>
</body>
</html>
