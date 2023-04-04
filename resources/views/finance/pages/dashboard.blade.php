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
    <div class="overflow-auto">
        <table id="suppliertable" name="suppliertable" class="ui celled table allTable dt-responsive" cellspacing="0">
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
                    <td>{{$request->initiator ?? ''}}</td>
                    <td>{{$request->company_id ?? ''}}</td>
                    <td>{{$request->department_id ?? ''}}</td>
                    <td>{{$request->supplier_id ?? ''}}</td>
                    <td>{{$request->expense_type_id ?? ''}}</td>
                    <td>{{$request->currency ?? ''}}</td>
                    <td>{{$request->amount ?? ''}}</td>
                    <td>{{$request->description ?? ''}}</td>
                    <td>{{$request->basis ?? ''}}</td>
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
            <tfoot>
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
                <th>Actions</th>

            </tr>
            </tfoot>

        </table>
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
                <form action="{{route(UserTypesEnum::Finance.'.approve-request')}}" method="POST">
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
                <form action="{{route(UserTypesEnum::Finance.'.reject-request')}}" method="POST">
                    @csrf
                <div class="modal-body">
                    <p>Are you sure you want to reject this request?</p>
                    <input type="hidden" name="id" class="reject-request-id" value=""/>
                    <form>
                        <div class="form-group">
                            <label for="rejectComment">Comment (compulsory)</label>
                            <textarea class="form-control" name="comment" id="rejectComment" rows="3" required></textarea>
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#suppliertable').DataTable({
                responsive: true,
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

    </script>

@endsection
