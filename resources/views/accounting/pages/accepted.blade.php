@php use App\Classes\Enums\UserTypesEnum; @endphp
@extends('admin.admin.app')
@section('pageTitle')
@endsection
@section('content')


<style>
  .overflow-auto::-webkit-scrollbar {
            height: 12px;
        }

        .overflow-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .overflow-auto::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .overflow-auto::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        .overflow-auto {
            max-height: 400px;
        }
</style>


<div class="ml-5 mt-3">
        <form action="{{route('accounting.logfilters')}}" method="post"  >
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
      <button class="btn btn-info" data-filter="accounting-accept">Accepted </button>
      <button class="btn btn-info" data-filter="accounting-reject">Rejected </button>
  </div>
    <div class="card-header pt-5">

        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1">Logs</span>
        </h3>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="modal fade" id="rowModal" tabindex="-1" role="dialog" aria-labelledby="rowModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="rowModalLabel">Row Information</h5>
            <button type="button" class="close close-pop-up" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <p id="rowId"></p>
              <p id="rowAction"></p>
              <p id="rowActionDate"></p>
              <p id="rowInitiator"></p>
              <p id="rowCreated"></p>
              <p id="rowCompany"></p>
              <p id="rowDepartment"></p>
              <p id="rowSupplier"></p>
              <p id="rowTypeofExpense"></p>
              <p id="rowCurrency"></p>
              <p id="rowAmountInGel"></p>
              <p id="rowDescription"></p>
              <p id="rowLink"></p>
              <p id="rowBasis"></p>
              <p id="rowDueDatePayment"></p>
              <p id="rowDueDate"></p>
              <p id="rowAmount"></p>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-pop-up" >Close</button>
          </div>
        </div>
      </div>
  </div>
    <div class="container">
      <div class="overflow-auto">
        <table id="reviewDocument" name="reviewDocument" class="table table-striped table-bordered dt-responsive nowrap"
        style="width:100%">
          <thead>
            <tr class="text-nowrap">
                <th>ID</th>
                <th>Action</th>
                <th>Print</th>
                <th>Action Date</th>
                <th>Initiator</th>
                <th> Created At</th>
                <th>Company</th>
                <th>Department</th>
                <th>Supplier</th>
                <th>Accounting UID of Supplier</th>
                <th>Type of Expense</th>
                <th>Accounting UID of Type of Expense</th>
                <th>Currency</th>
                <th>Amount In Gel</th>
                <th>Description</th>
                <th>Link</th>
                <th>Basis (file attachment title)</th>
                <th>Due Date of Payment</th>
                <th>Due Date</th>
                <th>Amount</th>
            </tr>
          </thead>
          <tbody>
            @foreach($requests as $request)
                <tr class="text-nowrap text-center" data-status="{{$request['action']}}">
                  <td class="cursor-pointer bg-primary" style="color: #FFFFFF; font-weight: bold; padding: 8px; border-radius: 5px;">{{$request['id'] ?? ''}}</td>

                    <td>{{$request['action'] ?? ''}}</td>
{{--                    <td>--}}
{{--                            <a href="{{ route('accounting.print', $request['id']) }}" target="_blank">Print</a>--}}
{{--                        </td>--}}
                    <td>{{formatDate($request['log_date']) ?? ''}}</td>

                    <td>{{$request['initiator'] ?? ''}}</td>
                    <td>{{formatDate($request['log_date']) ?? ''}}</td>
                    <td>{{$request['compname'] ?? ''}}</td>
                    <td>{{$request['depname'] ?? ''}}</td>
                    <td>{{$request['supname'] ?? ''}}</td>
                    <td>{{$request['supacc'] ?? ''}}</td>
                    <td>{{$request['expname'] ?? ''}}</td>
                    <td>{{$request['expacc'] ?? ''}}</td>
                    <td>{{$request['currency'] ?? ''}}</td>
                    <td>{{$request['amount_in_gel'] ?? ''}}</td>
                    <td>{{$request['description'] ?? ''}}</td>
                    <td> <a href="{{URL::to($request['request_link'])}}" target="_blank">{{$request['request_link'] ?? ''}}</a> </td>
                    <td> <?php if(isset($request['basis'])){
                                    $files=explode(',',$request['basis']);
                                    foreach($files as $file){ ?>
                                    <a href="{{asset('basis/'.$file)}}" target="_blank">{{$file}}</a>

                                <?php  }   }else{
                                   echo "No document available";
                                }
                                ?></td>
                    <td>{{formatDate($request['payment_date']) ?? ''}}</td>
                    <td>{{formatDate($request['submission_date']) ?? ''}}</td>
                   <td>{{$request['amount'] ?? ''}}</td>
                            </tr>
            @endforeach
          </tbody>
        </table>
      </div>




@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />

<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" />
<script type="text/javascript"
    src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script type="text/javascript"
    src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script type="text/javascript"
    src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

 <script>
   //zoom in and out
   $(document).ready(function() {
            var initialZoom = 100; 

            function setTableZoom(zoomLevel) {
            $('#reviewDocument').css('zoom', zoomLevel + '%');
            }

        
            $('#reviewDocument').on('wheel', function(event) {
            if (event.ctrlKey) {
                event.preventDefault();
                var delta = event.originalEvent.deltaY;
                if (delta > 0) {
                initialZoom -= 10; 
                } else {
                initialZoom += 10;
                }
                setTableZoom(initialZoom);
            }
            });
        });
      $(document).ready(function() {
        $('table#reviewDocument tbody tr td:first-child').on('click', function() {
          var row = $(this).closest('tr');
            var id = row.find('td:nth-child(1)').text().trim();
            var action = row.find('td:nth-child(2)').text().trim();
            var actionDate = row.find('td:nth-child(3)').text().trim();
            var initiator = row.find('td:nth-child(4)').text().trim();
            var createdAt = row.find('td:nth-child(5)').text().trim();
            var company = row.find('td:nth-child(6)').text().trim();
            var department = row.find('td:nth-child(7)').text().trim();
            var supplier = row.find('td:nth-child(8)').text().trim();
            var typeOfExpense = row.find('td:nth-child(9)').text().trim();
            var currency = row.find('td:nth-child(10)').text().trim();
            var amount = row.find('td:nth-child(11)').text().trim();
            var description = row.find('td:nth-child(12)').text().trim();
            var link = row.find('td:nth-child(13)').text().trim();
            var basis = row.find('td:nth-child(14)').text().trim();
            var dueDatePayment = row.find('td:nth-child(15)').text().trim();
            var dueDate = row.find('td:nth-child(16)').text().trim();
            var amount = row.find('td:nth-child(17)').text().trim();


            $('#rowId').text('Id: ' + id);
            $('#rowAction').text('Action: ' + action);
            $('#rowActionDate').text('Action Date: ' + actionDate);
            $('#rowInitiator').text('Initiator: ' + initiator);
            $('#rowCreatedAt').text('Created At: ' + createdAt);
            $('#rowCompany').text('Company: ' + company);
            $('#rowDepartment').text('Department: ' + department);
            $('#rowSupplier').text('Supplier: ' + supplier);
            $('#rowTypeofExpense').text('Type Of Expense: ' + typeOfExpense);
            $('#rowCurrency').text('Currency: ' + currency);
            $('#rowAmountInGel').text('Amount In Gel: ' + amount);
            $('#rowDescription').text('Description: ' + description);
            $('#rowLink').html('Link: <a href="' + link + '" target="_blank">' + link + '</a>');
                        $('#rowBasis').html('Basis: <a href="' + window.location.origin + '/basis/' + basis + '" target="_blank">' + basis + '</a>');;
            $('#rowDueDatePayment').text('Due Date Payment: ' + dueDatePayment);
            $('#rowDueDate').text('Due Date: ' + dueDate);
            $('#rowAmount').text('Amount: ' + amount);

            $('#rowModal').modal('show');
            $('.close-pop-up').click(function () {
                $('#rowModal').modal('hide');
            });
        });
    });
      $(document).ready(function() {
          $('#reviewDocument').DataTable({
            'order':[[3,'desc']],
            dom: 'Blfrtip',
            lengthChange: true,
            buttons: [

              {
              extend: 'copy',
              exportOptions: {
                columns: ':visible'
              }
              },
              {
              extend: 'excel',
              orientation : 'landscape',
                              pageSize : 'LEGAL',
              exportOptions: {
                columns: ':visible'
              }
              },
              {
              extend: 'pdf',
              orientation : 'landscape',
                              pageSize : 'LEGAL',
              exportOptions: {
                columns: ':visible'
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
                // console.log("filterValue", filterValue)
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
