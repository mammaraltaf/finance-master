@php use App\Classes\Enums\UserTypesEnum; @endphp
@extends('admin.admin.app')
@section('pageTitle')
@endsection
@section('content')
    
    <div class="card-header pt-5">

        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1">Requests</span>
        </h3>
        </div>
        <div class="ml-5 mt-3">
        <form action="{{route('manager.payments')}}" method="post"  >
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
         
    <!--begin::Body-->


    <div class="container-fluid">

    
      <!-- Document List -->
     
      <div class="container">
      <div class="overflow-auto">
     
     
      <table name="suppliertable" id="suppliertable" class="table table-striped table-bordered dt-responsive nowrap"
               style="width:100%">

            {{-- <table id="suppliertable" name="suppliertable" class="ui celled table allTable dt-responsive" cellspacing="0"> --}}
            <thead>
            <tr>
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
                <th>Basis</th>
                <th>Due Date of Payment</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($requests as $request)
                <tr>
                    <td>{{$request->id ?? ''}}</td>
                    <td>{{$request->initiator ?? ''}}</td>
                    <td>{{\Carbon\Carbon::parse($request['created_at']) ?? ''}}</td>
                    <td>{{$request->company->name ?? ''}}</td>
                    <td>{{$request->department->name ?? ''}}</td>
                    <td>{{$request->supplier->supplier_name ?? ''}}</td>
                    <td>{{$request->typeOfExpense->name ?? ''}}</td>
                    <td>{{$request->currency ?? ''}}</td>
                    <td>{{$request->amount_in_gel ?? ''}}</td>
                    <td>{{$request->description ?? ''}}</td>
                    <td><?php if (isset($request->basis)){
                            $files = explode(',', $request->basis);
                        foreach ($files as $file){ ?>
                        <a href="{{asset('basis/'.$file)}}" target="_blank">{{$file}}</a>

                        <?php }
                        } else {
                            echo "No document available";
                        }
                            ?></td>
                    <td>{{$request->payment_date ?? ''}}</td>
                    <td>{{$request->submission_date ?? ''}}</td>
                    <td>{{$request->status ?? ''}}</td>
                    <td>
                        <div class="d-flex">
                            <button class="mr-2 btn btn-success" id="acceptBtn" data-id="{{$request->id}}">Accept
                            </button>
                            <button class="ml-2 btn btn-danger" id="rejectBtn" data-id="{{$request->id}}">Reject
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>


        </table>
        </div>
      </div> 
      
     
         <!-- Confirmation Modal -->
    <div class="modal fade" id="acceptConfirmationModal" tabindex="-1" aria-labelledby="acceptConfirmationModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="acceptConfirmationModalLabel">Accept Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route(UserTypesEnum::Manager.'.approve-request')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Are you sure you want to accept this request?</p>
                        <input type="hidden" name="id" class="approve-request-id" value=""/>
                        <div class="form-group">
                            <label for="acceptComment">Comment (optional)</label>
                            <textarea class="form-control" name="comment" id="acceptComment" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="confirmAcceptBtn">Accept</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
 <!-- Rejection Modal -->
 <div class="modal fade" id="rejectConfirmationModal" tabindex="-1" aria-labelledby="rejectConfirmationModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectConfirmationModalLabel">Reject Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route(UserTypesEnum::Manager.'.reject-request')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Are you sure you want to reject this request?</p>
                        <input type="hidden" name="id" class="reject-request-id" value=""/>
                        <form>
                            <div class="form-group">
                                <label for="rejectComment">Comment (compulsory)</label>
                                <textarea class="form-control" name="comment" id="rejectComment" rows="3"
                                          required></textarea>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" id="confirmRejectBtn">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
  </div>


@endsection
@section('script')
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap4.min.css"/>
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
            $('#suppliertable').DataTable({
                dom: 'Blfrtip',
                lengthChange: true,
                buttons: [

                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },
                    {
                        extend: 'excel',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },
                    'colvis'
                ]
            });

            $('#acceptBtn').click(function () {
                let a = $(this).data('id');
                $('.approve-request-id').val(a);
                $('#acceptConfirmationModal').modal('show');
            });
            $('#confirmAcceptBtn').click(function () {
                var comment = $('#acceptComment').val();
                $('#acceptConfirmationModal').modal('hide');
            });
            $('#rejectBtn').click(function () {
                let a = $(this).data('id');
                $('.reject-request-id').val(a);
                $('#rejectConfirmationModal').modal('show');
            });
            $('#confirmRejectBtn').click(function () {
                var comment = $('#rejectComment').val();
                $('#rejectConfirmationModal').modal('hide');
            });
        });
        // Disable reject button if comment is empty
        const commentTextarea = document.getElementById("rejectComment");
        const rejectButton = document.getElementById("confirmRejectBtn");

        rejectButton.setAttribute("disabled", "");

        commentTextarea.addEventListener("input", function () {
            if (commentTextarea.value.length > 0) {
                rejectButton.removeAttribute("disabled");
                rejectButton.style.display = "inline-block";
            } else {
                rejectButton.setAttribute("disabled", "");
                rejectButton.style.display = "none";
            }
        });

    </script>

@endsection
