<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>login</title>
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="{{asset('public/assets/css/login.css')}}">
</head>
<style>
::placeholder{
    background: transparent !important;
}
</style>
<body>

  <div class="container col s7">
    <div class="color col s7 center-align">
      <div style="width: 23%;margin: auto;" class="col s12 right-align">
        <div class="dropdown brop">
          <a href="#" class="dropdown-toggle brop" data-toggle="dropdown" role="button" aria-haspopup="true"
            aria-expanded="false"><span class="caret"> </span>العربيه</a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>

          </ul>
        </div>
      </div>
      <img class="log" src="{{asset('public/assets/img/logo-fafic.svg')}}" alt="">
      <p class="line p-d-20">النظام الالي لمتابعه خدمات امر</p>
      <p class="line">@evolutions system</p>
      <form action=""  autocomplete="off">
      <div class="col s6 box">
        <div class="row">
          <div class="col s12 boxs">
            <div class="row m-b-r">
              <div class="input-field col s12 m-r-0">
                <input id="email" type="email" class="validate" autocomplete="off">
                <label for="email">اسم المستخدم</label>
              </div>
            </div>
            <div class="row m-b-r">
              <div class="input-field col s12">
                <input id="password" type="password" class="validate">
                <label for="password">كلمه المرور</label>
              </div>
            </div>
          </div>
          <a class="waves-effect waves-light btn-large btn-login">تسجيل الدخول</a>
          <a class="btn-forget" href="">نسيت كلمه المرور؟</a>
        </div>
    </form>
      </div>
    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
    integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script>
    $('.dropdown-trigger').dropdown();</script>
</body>

</html>