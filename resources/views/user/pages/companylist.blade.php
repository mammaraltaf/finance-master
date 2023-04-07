@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Select a company to redirect to the dashboard:</h2>
    <div class="list-group">
      <?php
foreach($companies as $company){ ?>
  <a href="{{url('company.dashboard/'.$company->id)}}" class="list-group-item active">{{ $company->name}}</a>
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
    $('.list-group-item').click(function(){
        $('.list-group-item').removeClass('active');
        $(this).addClass('active');
      });

    </script>
@endsection
