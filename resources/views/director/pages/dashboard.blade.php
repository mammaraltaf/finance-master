@php use App\Classes\Enums\UserTypesEnum; @endphp
@extends('admin.admin.app')
@section('pageTitle')
@endsection
@section('content')
    <!--begin::Header-->
    <br>
    <div class="card-header pt-5">

        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1">Dashboard</span>
        </h3>
    </div>
    <div class="container">
        <h1>Director Portal</h1>
        <h2>Pending Documents</h2>
        <table class="table">
          <thead>
            <tr>
              <th>Document ID</th>
              <th>Description</th>
              <th>Amount</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Document 1 description</td>
              <td>$5000</td>
              <td><a href="#" class="btn btn-primary">Review and Approve</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Document 2 description</td>
              <td>$10000</td>
              <td><a href="#" class="btn btn-primary">Review and Approve</a></td>
            </tr>
          </tbody>
        </table>
        <h2>Review Document</h2>
        <p>Selected Document: Document 1 description</p>
        <p>Amount: $5000</p>
        <div class="form-group">
          <label for="document-comments">Comments:</label>
          <textarea class="form-control" id="document-comments" rows="3"></textarea>
        </div>
        <div class="form-group form-check">
          <input type="checkbox" class="form-check-input" id="amount-verification">
          <label class="form-check-label" for="amount-verification">Verify amount manually</label>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-success">Approve</button>
          <button type="submit" class="btn btn-danger">Reject</button>
        </div>
      </div>
  

@endsection
@section('script')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>

    <script>
      

    </script>

@endsection
