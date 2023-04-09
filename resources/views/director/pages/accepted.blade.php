@php use App\Classes\Enums\UserTypesEnum; @endphp
@extends('admin.admin.app')
@section('pageTitle')
@endsection
@section('content')
    <!--begin::Header-->
    <div class="btn-group my-4">
      <button class="btn btn-info active" id="all">All</button>
      <button class="btn btn-info" id="accept">Accepted </button>
      <button class="btn btn-info" id="reject">Rejected </button>
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
        <table id="reviewDocument" name="reviewDocument" class="table table-striped table-bordered" cellspacing="0">
          <thead>
            <tr>
                <th>Initiator</th>
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
                <tr>
                    <td>{{$request['initiator'] ?? ''}}</td>
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>
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
      

        $(document).ready(function () {
            $("#all").click(function(){
              var id = '1';
	var url = "{{ route('director.filter', ':id') }}";
	url = url.replace(':id', id);
	location.href = url;
});
$("#accept").click(function(){
              var id = '2';
	var url = "{{ route('director.filter', ':id') }}";
	url = url.replace(':id', id);
	location.href = url;
});
$("#reject").click(function(){
              var id = '3';
	var url = "{{ route('director.filter', ':id') }}";
	url = url.replace(':id', id);
	location.href = url;
});
        });


    </script>

@endsection
