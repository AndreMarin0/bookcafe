@extends('layouts.app')

@section('page_title','Book List')

@section('content')


@if(Auth::check() && Auth::user()->isAdmin())
<div class="modal-header2">
    <h2>Requests by user to borrow a book</h2>
</div>

<br>
                
    <div class="cardr-wrapper"> 
    @foreach ($collections as $collection)
    @if ($collection->Status == 'Pending')
      <div class="cardr">
        <h3 class="card__title">{{ $collection->Description }}</h3>
        <p class="card__content">{{ $collection->Status }}</p> <br>

        <div class="d-flex justify-content-between">
        
            
            <form action="{{ route('collection.updateStatus', $collection->BookID) }}" method="POST" onsubmit="return confirm('Accept?');">
                @csrf
                @method('PUT')
                <input type="hidden" name="Status" value="Borrowed">
                <button type="submit" class="btn btn-sm btn-info cardbutton accept">
                    Accept
                </button>   
            </form>   
            

            <form action="{{ route('collection.updateStatus', $collection->BookID) }}" method="POST" onsubmit="return confirm('Reject?');">
                @csrf
                @method('PUT')
                <input type="hidden" name="Status" value="Unavailable">
                <button type="submit" class="btn btn-sm btn-info cardbutton reject">
                    Reject
                </button>     
            </form>   


        </div>

        </div>
    
        @endif
    @endforeach
</div>
  @endif

@endsection