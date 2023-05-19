@extends('layouts.app')

@section('page_title','Book List')

@section('content')


@if(Auth::check() && Auth::user()->isAdmin())
<div class="modal-header2">
    <h2>Application</h2>
</div>

<br>

<div class="cardr-wrapper">
    @foreach ($requests as $request)
    @if ($request->Stat == 'false')
      <div class="cardr">
        <h3 class="card__title">{{ $request->Requests }}</h3>
        <p class="card__content">{{ $request->Message }}</p> <br>

        <div class="d-flex justify-content-between">

            <form action="{{ route('req.updateStatus', $request->id) }}" method="POST" onsubmit="return confirm('Accept?');">
                @csrf
                @method('PUT')
                <input type="hidden" name="Stat" value="true">
                <button type="submit" class="btn btn-sm btn-info cardbutton accept">
                    Accept
                </button>   
            </form>   

            <form action="{{ route('req.updateStatus', $request->id) }}" method="POST" onsubmit="return confirm('Reject?');">
                @csrf
                @method('PUT')
                <input type="hidden" name="Stat" value="false">
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