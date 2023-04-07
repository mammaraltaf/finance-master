@php use App\Classes\Enums\UserTypesEnum; @endphp
@extends('admin.admin.app')
@section('pageTitle')
@endsection
@section('content')
    <!--begin::Header-->
    <br>
    <div class="card-header pt-5">

        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1">Pending Documents Reuqests</span>
        </h3>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="btn-group my-4">
      <button class="btn btn-info active" data-filter="all">All</button>
      <button class="btn btn-info" data-filter="accepted">Accepted Requested</button>
      <button class="btn btn-info" data-filter="rejected">Rejected Requests</button>
  </div>

    <div class="container">
      <div class="overflow-auto">
        <table id="reviewDocument" name="reviewDocument" class="ui celled table allTable dt-responsive" cellspacing="0">
          <thead>
            <tr class="text-center text-nowrap">
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
            <tr>
            @foreach($requests as $request)
                <tr>
                    <td>{{$request->initiator ?? ''}}</td>
                    <td>{{$request->company ?? ''}}</td>
                    <td>{{$request->department ?? ''}}</td>
                    <td>{{$request->supplier ?? ''}}</td>
                    <td>{{$request->expense_type ?? ''}}</td>
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
                <form id="directorAcceptRejectForm">
{{--                  <div class="form-group">--}}
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
                    <textarea class="form-control" id="document-comments" name="comments" rows="3"></textarea>
                  </div>
                  <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="amount-verification" name="amount_verification">
                    <label class="form-check-label" for="amount-verification">Verify amount manually</label>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="reject-button" disabled>Reject</button>
                <button type="button" class="btn btn-success" id="approve-button">Approve</button>
              </div>
            </div>
          </div>
      </div>
  </div>
 

@endsection
@section('script')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>

    <script>
      $(document).ready(function() {
        $('#reviewDocument').DataTable();
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

        // Data Filter
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
