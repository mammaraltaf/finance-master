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
            <span class="card-label fw-bolder fs-3 mb-1">Pending Documents Requests</span>
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
                <th>Amount</th>
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
                    <td>{{$request->initiator ?? ''}}</td>
                    <td>{{$request->company->name ?? ''}}</td>
                    <td>{{$request->department->name ?? ''}}</td>
                    <td>{{$request->supplier->supplier_name ?? ''}}</td>
                    <td>{{$request->expense_type->name ?? ''}}</td>
                    <td>{{$request->currency ?? ''}}</td>
                    <td>{{$request->amount ?? ''}}</td>
                    <td>{{$request->description ?? ''}}</td>
                    <td>{{$request->basis ?? ''}}</td>
                    <td>{{$request->payment_date ?? ''}}</td>
                    <td>{{$request->submission_date ?? ''}}</td>
                    <td>{{$request->status ?? ''}}</td>
                    <td><button type="button" id="reviewBtn" class="btn btn-primary" data-toggle="modal" data-target="#document-modal"  data-document-id="1" data-id="{{$request->id}}">Review</button></td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>

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
{{--                  <div class="form-group">--}}
@csrf
  <input type="hidden" name="id" id="id">
{{--                    <label for="document-id">Document ID:</label>--}}
{{--                    <input type="text" class="form-control" id="document-id" name="document_id" readonly>--}}
{{--                  </div>--}}
{{--                  <div class="form-group">--}}
{{--                    <label for="document-description">Description:</label>--}}
{{--                    <input type="text" class="form-control" id="document-description" name="document_description" readonly>--}}
{{--                  </div>--}}
{{--                  <div class="form-group">--}}
{{--                    <label for="document-amount">Amount:</label>--}}
{{--                    <input type="text" class="form-control" id="document-amount" name="document_amount" readonly>--}}
{{--                  </div>--}}

                  <div class="form-group">
                    <label for="document-comments">Comments:</label>
                    <textarea class="form-control" id="document-comments" name="comment" rows="3"></textarea>
                  </div>
                  <!-- <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="amount-verification" name="amount_verification">
                    <label class="form-check-label" for="amount-verification">Verify amount manually</label>
                  </div> -->
                  <div class="modal-footer">
                <button type="submit" class="btn btn-danger" id="reject-button" name="reject" disabled>Reject</button>
                <button type="submit" class="btn btn-success" id="approve-button" name="approve">Approve</button>
              </div>
                </form>
              </div>
              
            </div>
          </div>
      </div>
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
      

      const commentTextarea = document.getElementById("document-comments");
        const rejectButton = document.getElementById("reject-button");

        rejectButton.setAttribute("disabled", "");

        commentTextarea.addEventListener("input", function() {
            if (commentTextarea.value.length > 0) {
            rejectButton.removeAttribute("disabled");
            rejectButton.style.display = "inline-block";
            } else {
            rejectButton.setAttribute("disabled", "");
            rejectButton.style.display = "none";
            }
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

        $('body').on('click', '#reviewBtn', function () {
            var req_id = $(this).data('id');
            $('#id').val(req_id);
        });
        $('body').on('click', '#reject-button', function () {
            $('#directorAcceptRejectForm').attr('action', "{{url('director/reject')}}");
        });
        $('body').on('click', '#approve-button', function () {
            $('#directorAcceptRejectForm').attr('action', "{{url('director/accept')}}");
        });
    </script>

@endsection
