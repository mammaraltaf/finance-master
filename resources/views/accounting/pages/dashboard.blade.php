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

    <!--begin::Body-->
    <div class="btn-group my-4">
      <button class="btn btn-info active" data-filter="all">All</button>
      <button class="btn btn-info" data-filter="accepted">Accepted Requested</button>
      <button class="btn btn-info" data-filter="rejected">Rejected Requests</button>
  </div>

    <div class="container-fluid">

      <!-- Filter -->
      <div class="row">
        <div class="col-12">
          <h2>Filter</h2>
          <form>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="status">Status</label>
                <select id="status" class="form-control">
                  <option selected>All</option>
                  <option>Confirmed</option>
                  <option>Paid</option>
                </select>
              </div>
              <div class="form-group col-md-4">
                <label for="directory">Directory</label>
                <input type="text" class="form-control" id="directory">
              </div>
              <div class="form-group col-md-4">
                <label for="project">Project</label>
                <input type="text" class="form-control" id="project">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="initiator">Initiator</label>
                <input type="text" class="form-control" id="initiator">
              </div>
              <div class="form-group col-md-4">
                <label for="supplier">Supplier</label>
                <input type="text" class="form-control" id="supplier">
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
          </form>
        </div>
      </div>
      <!-- Document List -->
      <div class="row">
        <div class="col-12">
          <h2>Document List</h2>
          <table id="accounting" name="accounting" class="ui celled table allTable" style="width:100%">
            <thead>
              <tr>
                <th>Status</th>
                <th>Directory</th>
                <th>Project</th>
                <th>Initiator</th>
                <th>Supplier</th>
              </tr>
            </thead>
            <tbody>
              <!-- Sample data for document list -->
              <tr>
                <td>Confirmed</td>
                <td>Directory A</td>
                <td>Project X</td>
                <td>John Doe</td>
                <td>Supplier Y</td>
              </tr>
              <tr>
                <td>Paid</td>
                <td>Directory B</td>
                <td>Project Y</td>
                <td>Jane Smith</td>
                <td>Supplier Z</td>
              </tr>
              <!-- End of sample data -->
            </tbody>
          </table>
        </div>
      </div>
      
      
      
      <!-- Weekly Paid Report -->
      <div class="row">
        <div class="col-12">
          <h2>Weekly Paid Report</h2>
          <form>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="start-date">Start Date</label>
                <input type="date" class="form-control" id="start-date">
              </div>
              <div class="form-group col-md-6">
                <label for="end-date">End Date</label>
                <input type="date" class="form-control" id="end-date">
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Generate Report</button>
          </form>
        </div>
    </div>
  </div>
  

@endsection
@section('script')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>

    <script>
      $(document).ready(function () {
            $(".btn-group button").click(function () {
                var filterValue = $(this).attr('data-filter');
                console.log("filterValue", filterValue)
                $("#suppliertable tbody tr").hide();
                $("#suppliertable tbody tr[data-status='" + filterValue + "']").show();
                if (filterValue === "all") {
                    $("#suppliertable tbody tr").show();
                } else {
                    $("#suppliertable tbody tr").hide();
                    $("#suppliertable tbody tr[data-status='" + filterValue + "']").show();
                }
                $(".btn-group button").removeClass("active");
                $(this).addClass("active");
            });
        });
    </script>

@endsection
