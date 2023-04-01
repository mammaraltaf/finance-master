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
        <table id="suppliertable" name="suppliertable" class="ui celled table allTable" style="width:100%">
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

                <tr>
                    <td>Initiator</td>
                    <td>Company</td>
                    <td>Department</td>
                    <td>Supplier</td>
                    <td>Type of Expense</td>
                    <td>Currency</td>
                    <td>Amount</td>
                    <td>Description</td>
                    <td>Basis</td>
                    <td>Due Date of Payment</td>
                    <td>Due Date</td>
                    <td>Status</td>
                    <td>
                        <div class="d-flex">
                            <button class="mr-2 btn btn-success" id="acceptBtn">Accept</button>
                            <button class="ml-2 btn btn-danger" id="rejectBtn">Reject</button>
                        </div>
                    </td>

                </tr>
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
<div class="modal fade" id="acceptConfirmationModal" tabindex="-1" aria-labelledby="acceptConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="acceptConfirmationModalLabel">Accept Request</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to accept this request?</p>
          <form>
            <div class="form-group">
              <label for="acceptComment">Comment (optional)</label>
              <textarea class="form-control" id="acceptComment" rows="3"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="confirmAcceptBtn">Accept</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Rejection Modal -->
  <div class="modal fade" id="rejectConfirmationModal" tabindex="-1" aria-labelledby="rejectConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="rejectConfirmationModalLabel">Reject Request</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to reject this request?</p>
          <form>
            <div class="form-group">
              <label for="rejectComment">Comment (compulsory)</label>
              <textarea class="form-control" id="rejectComment" rows="3" required></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmRejectBtn">Reject</button>
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
    $('#suppliertable').DataTable({

    });

  $('#acceptBtn').click(function() {
    $('#acceptConfirmationModal').modal('show');
  });
  $('#confirmAcceptBtn').click(function() {
    var comment = $('#acceptComment').val();
    $('#acceptConfirmationModal').modal('hide');
  });
  $('#rejectBtn').click(function() {
    $('#rejectConfirmationModal').modal('show');
  });
  $('#confirmRejectBtn').click(function() {
    var comment = $('#rejectComment').val();
    $('#rejectConfirmationModal').modal('hide');
  });
});

    </script>

@endsection
