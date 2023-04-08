@extends('layouts.app')
@section('content')
    <div class="container">
        <h2>Select a company to redirect to the dashboard:</h2>
        <div class="list-group">
            <?php
            foreach ($companies as $company){ ?>
            <a id="url-company" data-url={{$company->slug}}  href="{{url('user/'.$company->slug.'/dashboard/')}}"
               class="list-group-item active">{{ $company->name}}</a>
            <?php }

            ?>
                <!-- <a href="#" class="list-group-item active">Account 1</a>
      <a href="#" class="list-group-item">Account 2</a>
      <a href="#" class="list-group-item">Account 3</a> -->
        </div>
    </div>
@endsection

@section('script')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.list-group-item').click(function () {
                $('.list-group-item').removeClass('active');
                $(this).addClass('active');
            });

            // Add a click event listener to the button
            $('#url-company').click(function (e) {
                e.preventDefault();
                // Get the button value
                // var buttonValue = $(this).attr('href');
                var buttonValue = $(this).attr('data-url');

                // Send an AJAX request to the Laravel route
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '/store-button-value/' + buttonValue, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        // Redirect to the URL returned by the server
                        window.location.href = buttonValue+'/dashboard/';
                    }
                };
                xhr.send();
            });
        });
    </script>
@endsection
