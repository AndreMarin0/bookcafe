@extends('layouts.app')

@section('page_title','Book List')

@section('content')


@if(Auth::check() && Auth::user()->isAdmin())
<div class="modal-header2">
    <h2>Requests by user</h2>
</div>

<br>

<div class="cardr-wrapper">
    @foreach ($requests as $request)
      <div class="cardr">
        <h3 class="card__title">{{ $request->Requests }}</h3>
        <p class="card__content">{{ $request->Message }}</p> <br>

        <div class="d-flex justify-content-between">
        <form action="{{route('reqs.destroy', $request->id)}}" method="POST" onsubmit="return confirm('Accept request?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-info cardbutton accept">
            Accept
        </button>
        </form>

            <form action="{{route('reqs.destroy', $request->id)}}" method="POST" onsubmit="return confirm('Remove request?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-info cardbutton reject">
                Reject
            </button>
            </form>
        </div>

        </div>
      
    @endforeach
</div>
  @endif

@endsection