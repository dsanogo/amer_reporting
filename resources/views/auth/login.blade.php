@extends('layouts.app')

@section('content')
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


      <form action="{{route('login')}}" method="POST">
        @csrf
        <div class="col s6 box">
          <div class="row">
            <div class="col s12 boxs">
              <div class="row m-b-r">
                <div class="input-field col s12 m-r-0">
                  <input id="username" type="text" class="validate" name="username" value="{{ old('username') }}" autocomplete="off">
                  <label for="username">اسم المستخدم</label>
                </div>
                   @error('username')
                    <span class="invalid-feedback" role="alert" style="color: red">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
              </div>
              <div class="row m-b-r">
                <div class="input-field col s12">
                  <input id="password" type="password" class="validate" name="password" autocomplete="off">
                  <label for="password">كلمه المرور</label>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert" style="color: red">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
            </div>
            <button type="submit" class="waves-effect waves-light btn-large btn-login">تسجيل الدخول</button>

            @error('role')
            <div class="alert alert-danger">
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            </div>
            @enderror
          </div>
      </form>
           

      </div>
    </div>
  </div>
@endsection
  

