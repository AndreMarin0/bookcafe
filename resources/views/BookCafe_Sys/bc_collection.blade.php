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

<?php 
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\CollectionController;
?>

<br>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-light-opacity">
                <div class="card-header headings">{{ __('Book List') }}</div>

                <div class="card-body ">
                    <form id="search-form" action="{{ route('collections.index') }}" method="GET" role="search">

                        <div class="form-group col-sm-9">
                          <label for="search">Search books:</label>
                          <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search books">
                            <span class="input-group-btn">
                              <button type="submit" class="btn btn-default">
                                <span class="fas fa-search"></span>
                              </button>
                            </span>
                          </div>
                        </div>
                        
                        <div class="form-group col-sm-3">
                          <label for="filter">Filter by:</label>
                          <select id="filter-select" name="filter" class="form-control">
                            <option value="">All</option>
                            <optgroup label="Genre">
                              <option value="comedy">Comedy</option>
                              <option value="romance">Romance</option>
                            </optgroup>
                            <optgroup label="Author">
                              <option value="andre">Andre</option>
                              <option value="nina">Nina</option>
                            </optgroup>
                            <optgroup label="Publisher">
                              <option value="comics123">Comics123</option>
                              <option value="manga">Manga</option>
                            </optgroup>
                          </select>
                        </div>                                                     
                      </form>
                                         

                    <div class="d-flex justify-content-between headings-cstm">  
                        
                        @if(Auth::check() && Auth::user()->isAdmin())
                            <a class="btn btn-sm btn-info ml-3" href="{{ route('reqs.index') }}" role="button">View Requests</a>
                            @endif
                        <div>{{ $message }}</div>                                             
                    </div>
                    
                    <br>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Book ID</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Publisher</th>
                                <th>Genre</th>
                                @if(Auth::check() && Auth::user()->isAdmin())
                                <th> </th> 
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($collections as $collection)
                            <tr>
                                <td>{{ $collection->BookID }}</td>
                                <td>{{ $collection->Description }}</td>
                                <td>{{ $collection->author->AuthorName }}</td>
                                <td>{{ $collection->publisher->PublisherName }}</td>
                                <td>{{ $collection->genre->Genre }}</td>
                                
                                @if(Auth::check() && Auth::user()->isAdmin())
                                <td class="button-cell edit-delete">
                                    <a class="btn btn-outline-secondary" href="{{route('collections.edit',$collection->BookID)}}" role="button">
                                        Edit
                                    </a>
                                        <p> </p>
                                    <form action="{{route('collections.destroy', $collection->BookID)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn btn-outline-dark">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center">                   
                        {{ $collections->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                    </div>

                    <div class="text-center mt-3">
                        <div class="d-flex justify-content-between">
                            @if(Auth::check() && Auth::user()->isAdmin())
                            <a class="btn btn-sm btn-info ml-3" href="{{ route('collections.create') }}" role="button">
                            Add Book
                            </a>      
                            @else
                            <button class="btn btn-sm btn-info ml-3" onclick="openModal2()">Send Request</button>
                            @endif             
                            
                            <button class="my-button btn-sm btn-info ml-3 headings-cstm" onclick="openModal()">View Graph</button>
                            
                            <form id="pdf-form" action="{{ route('collection.generatePDF') }}" method="GET">
                                @csrf                               
                                <button type="submit" class="btn btn-sm btn-info ml-3">
                                    Generate PDF
                                </button>
                            </form>   
                                                     
                                                                                                                                                                                                                                                                       
                        </div>
                    </div>                       
                </div>
            </div>

        </div>
    </div>
</div>

<br>



    <div id="myModal" class="modal">
        <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-header">
                <h2>Books by Genre</h2>
            </div>
            <div class="modal-body">
                <div class="chart-container">
                <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>


 
  @if(Auth::check() && Auth::user()->isAdmin())
    <div id="btnadmin" class="modal">
        
    </div>
    @else
        <div id="requestbtn" class="modal">
            <div class="modal-content3">
            <span class="close" onclick="closeModal2()">&times;</span>

            <div class="modal-header">
                <h2>Request to send to admin</h2>
            </div>

            <div class="modal-body">
                <form name="reqForm" action="{{ route('reqs.store') }}" method="post">
                    @csrf
                    <label for="requests">Request:</label>
                    <select id="requests" name="requests">
                        <option value="Request to add a book">Add a Book</option>
                        <option value="Request to remove a book">Remove a Book</option>
                    </select><br><br>
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="5" cols="50"></textarea><br><br>
                    <input type="submit" onclick="formSubmit()" value="Send Request!">
                </form>
                
                
            </div>

            </div>
        </div>
    @endif

  
    
  <script>
    const ctx = document.getElementById('myChart').getContext('2d');

    // Group the books by genre and count the number of books in each group
    const genres = {!! json_encode($collections->groupBy('genre.Genre')->map->count()) !!};

    // Create an array of labels and data from the grouped data
    const labels = Object.keys(genres);
    const data = Object.values(genres);

    const backgroundColor = [
        'rgba(255, 99, 132, 0.8)',
        'rgba(54, 162, 235, 0.8)',
        'rgba(255, 206, 86, 0.8)',
        'rgba(75, 192, 192, 0.8)',
        'rgba(153, 102, 255, 0.8)',
        'rgba(255, 159, 64, 0.8)'
    ];

    const chartData = {
        labels: labels,
        datasets: [{
            data: data,
            backgroundColor: backgroundColor
        }]
    };

    const chartConfig = {
        type: 'pie',
        data: chartData,
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: ' ',
                    color: '#000000'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.label || '';
                            var value = context.formattedValue || '';
                            var percentage = context.chart.data.datasets[0].data[context.dataIndex];
                            percentage = '(' + ((percentage / data.reduce((a, b) => a + b, 0)) * 100).toFixed(2) + '%)';
                            return label + ': ' + value + ' ' + percentage;
                        }
                    }
                },
                legend: {
                    display: true,
                    position: 'right',
                    align: 'start',
                    labels: {
                        usePointStyle: true,
                        generateLabels: function(chart) {
                            const labels = chart.data.labels;
                            const datasets = chart.data.datasets;
                            const total = data.reduce((a, b) => a + b, 0);
                            let legendItems = [];

                            labels.forEach(function(label, index) {
                                const backgroundColor = datasets[0].backgroundColor[index];
                                const value = datasets[0].data[index];
                                const percentage = ((value / total) * 100).toFixed(2);

                                legendItems.push({
                                    text: label + ' (' + percentage + '%)',
                                    fillStyle: backgroundColor,
                                    hidden: false,
                                    index: index
                                });
                            });

                            return legendItems;
                        }
                    }
                }
            }
        }
    };

    const myChart = new Chart(ctx, chartConfig);
</script>

<script>
    function formSubmit() {
        document.forms["reqForm"].submit();
    }

    function openModal() {
        document.getElementById('myModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('myModal').style.display = 'none';
    }
    function openModal2() {
        document.getElementById('requestbtn').style.display = 'block';
    }

    function closeModal2() {
        document.getElementById('requestbtn').style.display = 'none';
    }
</script>



    <script>
        const form = document.getElementById('search-form');
        const filterSelect = document.getElementById('filter-select');
        filterSelect.addEventListener('change', (event) => {
        const searchInput = document.getElementsByName('search')[0];
        const searchValue = searchInput.value.trim();
        const filterValue = filterSelect.value.trim();
        const query = `search=${encodeURIComponent(searchValue)}&filter=${encodeURIComponent(filterValue)}`;
        form.action = "{{ route('collections.index') }}?" + query;
        form.submit();
        });
    </script>


@endsection