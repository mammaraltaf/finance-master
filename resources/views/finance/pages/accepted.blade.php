@php use App\Classes\Enums\UserTypesEnum; @endphp
@extends('admin.admin.app')
@section('pageTitle')
@endsection
@section('content')
<div class="ml-5 mt-3">
        <form action="{{route('finance.logfilters')}}" method="post"  >
   @csrf
        <div class="form-row">
              <div class="form-group col-md-3">
                <label for="start-date">Start Date</label>
                <input type="date" class="form-control" id="start-date" name="start-date" required>
              </div>
              <div class="form-group col-md-3">
                <label for="end-date">End Date</label>
                <input type="date" class="form-control" id="end-date" name="end-date" required>
              </div>
              <div class="form-group col-md-3 mt-7">
              <input type="submit" class="btn btn-sm btn-primary" id="dates" value="Generate">
            </div>
            </div>
          </form> </div>
    <!--begin::Header-->
    <div class="btn-group my-4">
      <button class="btn btn-info active" data-filter="all">All</button>
      <button class="btn btn-info" data-filter="finance-accept">Accepted </button>
      <button class="btn btn-info" data-filter="finance-reject">Rejected </button>
  </div>
    <div class="card-header pt-5">

        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1"> Documents Requests</span>
        </h3>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
   

    <div class="container">
      <div class="overflow-auto">
        <table id="reviewDocument" name="reviewDocument" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%" >
          <thead>
            <tr class="text-nowrap">
              <th>ID</th>
                <th>Initiator</th>
                <th>Created At</th>
                <th>Company</th>
                <th>Department</th>
                <th>Supplier</th>
                <th>Type of Expense</th>
                <th>Currency</th>
                <th>Amount In Gel</th>
                <th>Description</th>
                <th>Basis (file attachment title)</th>
                <th>Due Date of Payment</th>
                <th>Due Date</th>
                <th>Action</th>
            </tr>
          </thead>
          <tbody>
            
            @foreach($requests as $request)
                <tr class="text-nowrap" data-status="{{$request['action']}}">
                  <td>{{$request['id']}}</td>
                    <td>{{$request['initiator'] ?? ''}}</td>
                    <td>{{\Carbon\Carbon::parse($request['created_at']) ?? ''}}</td>
                    <td>{{$request['compname'] ?? ''}}</td>
                    <td>{{$request['depname'] ?? ''}}</td>
                    <td>{{$request['supname'] ?? ''}}</td>
                    <td>{{$request['expname'] ?? ''}}</td>
                    <td>{{$request['currency'] ?? ''}}</td>
                    <td>{{$request['amount_in_gel'] ?? ''}}</td>
                    <td>{{$request['description'] ?? ''}}</td>
                    <td> <?php if(isset($request['basis'])){
                                    $files=explode(',',$request['basis']);
                                    foreach($files as $file){ ?>
                                    <a href="{{asset('basis/'.$file)}}" target="_blank">{{$file}}</a>

                                <?php  }   }else{
                                   echo "No document available";
                                }
                                ?></td>
                    <td>{{$request['payment_date'] ?? ''}}</td>
                    <td>{{$request['submission_date'] ?? ''}}</td>
                    <td>{{$request['action'] ?? ''}}</td>
                            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      


@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" type="text/css"
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap4.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
 
 <script>
      $(document).ready(function() {
        $('#reviewDocument').DataTable({
          'order':[[2,'desc']],
          dom: 'Blfrtip',
          lengthChange: true,
          buttons: [ 

            {
extend: 'copy',
exportOptions: {
columns: [0,1, 5, 6, 7, 8,9,10,11]
}
},
{
extend: 'excel',
orientation : 'landscape',
                pageSize : 'LEGAL',
exportOptions: {
columns: [0,1, 5, 6, 7, 8,9,10,11]
}
},
{
extend: 'pdf',
orientation : 'landscape',
                pageSize : 'LEGAL',
exportOptions: {
columns: [0,1, 5, 6, 7, 8,9,10,11]
}
},
'colvis'
           ]
    } );
        });
      

         // Data Filter Start
         $(document).ready(function () {
            $(".btn-group button").click(function () {
                var filterValue = $(this).attr('data-filter');
                console.log("filterValue", filterValue)
                $("#reviewDocument tbody tr").hide();
                $("#reviewDocument tbody tr[data-status='" + filterValue + "']").show();
                if (filterValue === "all") {
                    $("#reviewDocument tbody tr").show();
                } else {
                    $("#reviewDocument tbody tr").hide();
                    $("#reviewDocument tbody tr[data-status='" + filterValue + "']").show();
                }
                $(".btn-group button").removeClass("active");
                $(this).addClass("active");
            });
        });


    </script>

@endsection
