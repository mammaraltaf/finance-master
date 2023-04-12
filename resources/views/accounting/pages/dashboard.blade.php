@php use App\Classes\Enums\UserTypesEnum; @endphp
@extends('admin.admin.app')
@section('pageTitle')
@endsection
@section('content')
    <!--begin::Header-->

    <div class="card-header pt-5">

        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1">Dashboard</span>
        </h3>
    </div>

    <!--begin::Body-->


    <div class="container-fluid">

    
      <!-- Document List -->
      <div class="row">
      <div class="container">
      <div class="overflow-auto">
      <form id="frm-example" action="{{route('accounting.payments')}}" method="POST"  enctype="multipart/form-data">
        @csrf 
        <table name="accounting" id="accounting" class=" display table table-striped table-bordered " style="width:100%">
        <thead>
            <tr>
              <th><input type="checkbox" id="select-all"></th>
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
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
          <tbody>
            @foreach($requests as $request)
                <tr>
                  <td>
                    <input type="checkbox" name="id[]" value="<?php  echo $request->id ?>">
                  </td>
                    <td>{{$request->initiator ?? ''}}</td>
                    <td>{{$request->company->name ?? ''}}</td>
                    <td>{{$request->department->name ?? ''}}</td>
                    <td>{{$request->supplier->supplier_name ?? ''}}</td>
                    <td>{{$request->typeOfExpense->name ?? ''}}</td>
                    <td>{{$request->currency ?? ''}}</td>
                    <td>{{$request->amount_in_gel ?? ''}}</td>
                    <td>{{$request->description ?? ''}}</td>
                    <td><?php if(isset($request->basis)){
                                    $files=explode(',',$request->basis);
                                    foreach($files as $file){ ?>
                                    <a href="{{asset('basis/'.$file)}}" target="_blank">{{$file}}</a>

                                <?php  }   }else{
                                   echo "No document available";
                                }
                                ?></td>
                    <td>{{$request->payment_date ?? ''}}</td>
                    <td>{{$request->submission_date ?? ''}}</td>
                    <td>{{$request->status ?? ''}}</td>
                    <td><button type="button review-selected" id="reviewBtn" class="btn btn-primary" data-toggle="modal" data-target="#document-modal"  data-document-id="1" data-id="{{$request->id}}">Review</button></td>
                </tr>
            @endforeach
          </tbody>
          </table>
        </div>
      </div> 
      <p><button class="btn btn-primary">Review</button></p>
      </form>
      <div class="modal fade" id="document-modal" tabindex="-1" role="dialog" aria-labelledby="document-modal-label" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h2 class="modal-title" id="document-modal-label">Review Document</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="directorAcceptRejectForm" method="post" action="">

@csrf
  <input type="hidden" name="id" id="id">

                  <div class="form-group">
                    <label for="document-comments">Amount In Gel:</label>
                    <input type="text" class="form-control" id="amount" name="amount" readonly>
                  </div>

                  <div class="modal-footer">
                  <button type="submit" class="btn btn-danger" id="reject-button" value="reject" name="button">Reject</button>
                <button type="submit" class="btn btn-success" id="approve-button" value="pay" name="button">Pay</button>
              </div>
                </form>
              </div>

            </div>
          </div>
      </div>
  </div>

    
  </div>


@endsection
@section('script')

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  
    
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


       $(document).ready(function () {
   
            $('#accounting').DataTable({
              dom: 'Blfrtip',
          lengthChange: true,
          buttons: [

            {
extend: 'copy',
exportOptions: {
columns: [0,1,2,3,4, 5, 6, 7, 8,9,10,11]
}
},
{
extend: 'excel',
orientation : 'landscape',
                pageSize : 'LEGAL',
exportOptions: {
columns: [0,1,2,3,4, 5, 6, 7, 8,9,10,11]
}
},
{
extend: 'pdf',
orientation : 'landscape',
                pageSize : 'LEGAL',
exportOptions: {
columns: [0,1,2,3,4, 5, 6, 7, 8,9,10,11]
}
},
'colvis'
           ]
            });
        });

      $(document).ready(function () {

        $("#all").click(function(){
              var id = '1';
	var url = "{{ route('accounting.filter', ':id') }}";
	url = url.replace(':id', id);
	location.href = url;
});
$("#accept").click(function(){
              var id = '2';
	var url = "{{ route('accounting.filter', ':id') }}";
	url = url.replace(':id', id);
	location.href = url;
});
$("#reject").click(function(){
              var id = '3';
	var url = "{{ route('accounting.filter', ':id') }}";
	url = url.replace(':id', id);
	location.href = url;
});
            });
            $('body').on('click', '#reviewBtn', function () {
              var request_id = $(this).data('id');
              console.log(request_id);
              $.ajax({
                  type: "GET",
                  url: "{{url('accounting/payment/')}}" + '/' + request_id,
                  success: function (response) {
                      console.log(response);
                      $('#id').val(response.id);
                      $('#amount').val(response.amount_in_gel);
                      $('#directorAcceptRejectForm').attr('action', "{{url('accounting/payment/')}}" + '/' + request_id);
                  }

              });
        });


    $(document).ready(function() {
        $('#select-all').click(function() {
            $('input[type="checkbox"]').prop('checked', this.checked);
         
        });
    });
    
    

    </script>

@endsection
