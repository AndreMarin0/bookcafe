@extends('master_layout.layout')

@section('page_title','LOGIN FORM')

@section('content')



<div class="containerLogin">
    <div class="form">
      <div class="btn">
        <button class="signUpBtn">SIGN UP</button>
        <button class="loginBtn">LOG IN</button>
      </div>
      <form class="signUp" action="{{ route('register') }}" method="get">
        @csrf
        <div class="formGroup">
          <input type="text" name="name" id="name" placeholder="User Name" autocomplete="off">
        </div>
        <div class="formGroup">
          <input type="email" name="email" placeholder="Email ID" required autocomplete="off">
        </div>
        <div class="formGroup">
          <input type="password" name="password" id="password" placeholder="Password" required autocomplete="off">
        </div>
        <div class="formGroup">
          <input type="password"  id="confirmPassword" placeholder="Confirm Password" required autocomplete="off">
        </div>
        <div class="checkBox">
          <input type="checkbox" name="checkbox" id="checkbox">
          <span class="text">I agree with term & conditions</span>
        </div>
        <div class="formGroup">
          <button type="submit" class="btn2">REGISTER</button>
        </div>
 
      </form>
        
      <!------ Login Form -------- -->
      {{-- <form class="login" action="" method="get"> --}}
        <form class="login" action="{{ route('login') }}" method="post">
          @csrf
        <div class="formGroup">
          <input type="email" name="email" placeholder="Email ID" required autocomplete="off">
        </div>
        <div class="formGroup">
          <input type="password" name="password" id="password" placeholder="Password" required autocomplete="off">
         
        </div>
        <div class="checkBox">
          <input type="checkbox" name="checkbox" id="checkbox">
          <span class="text">Keep me signed in on this device</span>
        </div>
        <div class="formGroup">
          <button type="submit" class="btn2">LOGIN</button>
        </div>
 
      </form>
 
    </div>
  </div>
  
<!-- java script -->
  
  <script>
    /* Show login form on button click */
 
$('.loginBtn').click(function(){
  $('.login').show();
  $('.signUp').hide();
  /* border bottom on button click */
  $('.loginBtn').css({'border-bottom' : '2px solid rgb(249,115,0)'});
  /* remove border after click */
  $('.signUpBtn').css({'border-style' : 'none'});
});
 
 
/* Show sign Up form on button click */
 
$('.signUpBtn').click(function(){
  $('.login').hide();
  $('.signUp').show();
  /* border bottom on button click */
  $('.signUpBtn').css({'border-bottom' : '2px solid rgb(249,115,0)'});
   /* remove border after click */
   $('.loginBtn').css({'border-style' : 'none'});
});
  </script>

@endsection