@extends('layouts.app')

@section('page_title',' Create Book')

@section('content')


<div class='containerEdit'>
  <form action="{{ route('collections.store') }}" method="POST" class="form">
      @csrf  
      
      <div class="formGroup">
          <label for="Description">Description:</label>
          <input type="text" id="Description" name="Description" required>
      </div>

      <div class="formGroup">
          <label for="AuthorID">Author:</label>
          <select id="AuthorID" name="AuthorID">
              @foreach($authors as $author)
                  <option value = {{ $author->AuthorID }} > {{ $author->AuthorName }}</option>
              @endforeach
          </select>
      </div>

      <div class="formGroup">
          <label for="PubID">Publisher:</label>
          <select id="PubID" name="PubID">
              @foreach($publishers as $publisher)
                  <option value = {{ $publisher->PubID }} > {{ $publisher->PublisherName }}</option>
              @endforeach
          </select>
      </div>

      <div class="formGroup">
          <label for="GenID">Genre:</label>
          <select id="GenID" name="GenID">
              @foreach($genres as $genre)
                  <option value = {{ $genre->GenID }} > {{ $genre->Genre }}</option>
              @endforeach
          </select>
      </div>

      <div class="formGroup">
          <input type="submit" value="Submit" class='btn2'>
      </div>
  </form>
</div>


@endsection