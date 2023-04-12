@extends('layouts.app')

@section('page_title','Home')

@section('content')

<div class="description bgframe">
   <h1>    Hello! Welcome To My Book Cafe Website
    <p style='color:#F9F6EE; font-size: 20px; width: 50%; line-height: 1.5; text-align:left'>  "One glance at a book and you hear the voice of another person, perhaps someone dead for 1,000 years. To read is to voyage through time." – Carl Sagan
</p>   
 <button class="btn btn-outline-secondary btn-lg">See more</button>   </h1>  
</div>


<!-- Genre -->
<div class="team">
 <div class="container bgframe">
    <h1 class="text-center">Genres</h1>
  <div class="row">
   <div class="col-lg-3 col-md-3 col-sm-12 item">
    <img src="https://w.wallhaven.cc/full/43/wallhaven-43qry3.jpg" class="img-fluid" alt="team">
    <div class="des">
      Fiction
     </div>
    
   </div>
   <div class="col-lg-3 col-md-3 col-sm-12 item">
    <img src="https://w.wallhaven.cc/full/g8/wallhaven-g81xel.jpg" class="img-fluid" alt="team">
    <div class="des">
       Romance
     </div>
    
   </div>
   <div class="col-lg-3 col-md-3 col-sm-12 item">
    <img src="https://w.wallhaven.cc/full/nm/wallhaven-nml57y.jpg" class="img-fluid" alt="team">
    <div class="des">
      Mystery 
     </div>
    
   </div>
   <div class="col-lg-3 col-md-3 col-sm-12 item">
    <img src="https://w.wallhaven.cc/full/4l/wallhaven-4lyg7y.jpg" class="img-fluid" alt="team">
     <div class="des">
      Thriller
     </div>
    
   </div>
  </div>
 </div>
</div>

@endsection