@extends('layouts.app')

@section('page_title','Book List')

@section('content')

@if (session('error'))
    <div class="alert alert-danger rounded-0 alert-dismissible fade show mb-0" role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        <strong>{{ session('error') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success rounded-0 alert-dismissible fade show mb-0" role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        <strong>{{ session('success') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('success2'))
    <div class="alert alert-success rounded-0 alert-dismissible fade show mb-0" role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        <strong>{{ session('success2') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('success3'))
    <div class="alert alert-success rounded-0 alert-dismissible fade show mb-0" role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        <strong>{{ session('success3') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif


<?php use Illuminate\Support\Facades\Auth;?>

<p><b>Book list</b></p>

    <table> 
        <tr>
            <th>Book ID</th>
            <th>Description</th>
            <th>Author</th>
            <th>Publisher</th>
            <th>Genre</th>
            <th> </th>
            @if(Auth::check() && Auth::user()->isAdmin()) <th> </th> @endif
        </tr>
        @foreach($collections as $collection)
            <tr>
                
                <td>{{ $collection->BookID }}</td>
                <td>{{ $collection->Description }}</td>
                <td>{{ $collection->AuthorID }}</td>
                <td>{{ $collection->PubID }}</td>
                <td>{{ $collection->GenID }}</td>
                <td><a class="btn btn-outline-success" href="{{route('collections.edit',$collection->BookID)}}" role="button">Edit</a></td>
                @if(Auth::check() && Auth::user()->isAdmin())
                <td>                   
                    <form action="{{route('collections.destroy', $collection->BookID)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>                  
                </td>
                @endif
            </tr>     
        @endforeach
</table>


<div class="text-center mt-3">
    <a class="btn btn-lg btn-warning" href="{{ route('collections.create') }}" role="button">
        <i class="fas fa-plus-circle mr-2"></i> Add Book
    </a>
</div>



@endsection