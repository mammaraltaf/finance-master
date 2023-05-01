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
        <form action="{{route('accounting.payments')}}" method="post"  >
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
        </form>
    </div>

    <!--begin::Body-->


    <div class="container-fluid">

        <!-- Document List -->
      <div class="row overflow-auto">
        <form id="submit-btn" action="" method=""  >
            <table name="accounting" id="accounting" class="table table-striped table-bordered dt-responsive nowrap"
            style="width:100%">
              <thead>
                <tr class="text-nowrap">
                  <th><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
                      <th>ids</th>
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
                      <th>Status</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($requests as $request)
                      <tr class="text-center">
                        <td><input type="checkbox" name="id[]" value="{{ $request->id }}"></td>
                        <td>{{ $request->id }}</td>
                          <td>{{$request->initiator ?? ''}}</td>
                        <td>{{\Carbon\Carbon::parse($request['created_at']) ?? ''}}</td>
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
                          <td><button type="button" id="reviewBtn" class="btn btn-primary" data-toggle="modal" data-target="#document-modal"  data-document-id="1" data-id="{{$request->id}}">Review</button></td>
                      </tr>
                  @endforeach

              </tbody>

            </table>
            <button  type="button" id="rejectBtn" class="btn btn-danger rejectall">Reject Selected</button>
            <button  type="button" id="payBtn" class="btn btn-success payall">Pay Selected</button>
        </form>
      </div>
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

                  @csrf
                    <input type="hidden" name="id" id="id">

                  <div class="form-group">
                    <label for="document-comments">Amount In Gel:</label>
                    <input type="text" class="form-control" id="amount" name="amount" readonly>
                  </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-danger reject-button" id="" value="reject" name="button">Reject</button>
                    <button type="submit" class="btn btn-success approve-button" id="" value="pay" name="button">Pay</button>
                  </div>
                </form>
              </div>

            </div>
          </div>
      </div>
    <div id="loader" style="display:none;">
        <iframe src="https://gifer.com/embed/1amw" width=480 height=480.000 frameBorder="0" allowFullScreen></iframe><p><a href="https://gifer.com">via GIFER</a></p>
    </div>


@endsection
@section('script')

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
{{-- <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script> --}}

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>

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
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
    <script type="text/javascript">
      $('body').on('click', '#reviewBtn', function () {
        var request_id = $(this).data('id');
        $.ajax({
        type: "GET",
        url: "{{url('accounting/payment/')}}" + '/' + request_id,
        success: function (response) {
          // console.log(response);
          $('#id').val(response.id);
          $('#amount').val(response.amount_in_gel);
          $('#directorAcceptRejectForm').attr('action', "{{url('accounting/payment/')}}" + '/' + request_id);
        }

      });
    });

    // $(document).ready(function () {
    //   var selectedCheckboxes = [];
    //   var table = $('#accounting').DataTable({
    //     'columnDefs': [
    //       {
    //         'targets': [0],
    //         'checkboxes': {
    //           'selectRow': true,
    //           'selectCallback': function (nodes, selected) {
    //             console.log("selected",nodes);
    //             if (selected) {
    //               $('#payBtn').removeAttr('disabled');
    //               $('#rejectBtn').removeAttr('disabled');
    //             } else {
    //               $('#payBtn').attr('disabled', 'disabled');
    //               $('#rejectBtn').attr('disabled', 'disabled');
    //             }
    //           },


    //           'selectAllCallback': function (nodes, selected, indeterminate) {
    //             if (selected) {
    //               $('#payBtn').removeAttr('disabled');
    //               $('#rejectBtn').removeAttr('disabled');
    //             } else {
    //               $('#payBtn').attr('disabled', 'disabled');
    //               $('#rejectBtn').attr('disabled', 'disabled');
    //             }
    //           }
    //         }
    //       }
    //     ],
    //     'select': {
    //       'style': 'multi'
    //     },
    //     'order': [[1, 'asc']],
    //     dom: 'Blfrtip',
    //     lengthChange: true,
    //     buttons: [
    //       {
    //         extend: 'copy',
    //         exportOptions: {
    //           columns: [0,1,2,3,4, 5, 6, 7, 8,9,10,11]
    //         }
    //       },
    //       {
    //         extend: 'excel',
    //         orientation : 'landscape',
    //         pageSize : 'LEGAL',
    //         exportOptions: {
    //           columns: [0,1,2,3,4, 5, 6, 7, 8,9,10,11]
    //         }
    //       },
    //       {
    //         extend: 'pdf',
    //         orientation : 'landscape',
    //         pageSize : 'LEGAL',
    //         exportOptions: {
    //           columns: [0,1,2,3,4, 5, 6, 7, 8,9,10,11]
    //         }
    //       },
    //       'colvis'
    //     ]
    //   });

    //   $('#rejectBtn').on('click', function () {

    //     console.log("aaaaaa",table);
    //     var selectedRows = table.rows({selected: true}).data();
    //     if (selectedRows.length > 0) {
    //       var ids = selectedRows.toArray().map(function (row) {
    //         return row[1];
    //       });
    //       // var url = "{{url('accounting/payment/')}}" + '/' + ids.join(',');
    //       // $('#submit-btn').attr('action', url);
    //       // $('#submit-btn').submit();
    //       console.log("ids",ids);
    //     }
    //   });

    //   $('#payBtn').on('click', function () {
    //     var selectedRows = table.rows({selected: true}).data();
    //     console.log("selectedRows>>>>>",selectedRows)
    //     if (selectedRows.length > 0) {
    //       var ids = selectedRows.toArray().map(function (row) {
    //         return row[1];
    //       });
    //       console.log(ids);
    //       // var url = "{{url('accounting/payment/')}}" + '/' + ids.join(',');
    //       // $('#submit-btn').attr('action', url);
    //       // $('#submit-btn').submit();
    //       // console.log("url",url);
    //     }
    //   });


    // });
    $(document).ready(function() {
      var table = $('#accounting').DataTable({
        'columnDefs': [{
          'targets': 0,
          'searchable': false,
          'orderable': false,
          'className': 'dt-body-center',
          'render': function(data, type, full, meta) {
            return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html().replace(/"/g, '&quot;') + '" data-rowid="' + meta.row + '">';
          }
        }],

        'order': [3, 'desc'],
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

      // Handle click on "Select all" control
      $('#example-select-all').on('click', function() {
        // Check/uncheck all checkboxes in the table
        var rows = table.rows({
          'search': 'applied'
        }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
      });

      // Handle click on checkbox to set state of "Select all" control
      $('#accounting tbody').on('change', 'input[type="checkbox"]', function() {
        // If checkbox is not checked
        if (!this.checked) {
          var el = $('#example-select-all').get(0);
          if (el && el.checked && ('indeterminate' in el)) {
            el.indeterminate = true;
          }
        }
      });

      // Handle click on "Reject All" button
      $('#rejectBtn').on('click', function() {
        var selectedIds = [];
        $('input[name="id[]"]:checked').each(function() {
          selectedIds.push($(this).attr('value'));
        });
        var ids=selectedIds.map(input=>{
          return $(input).attr('value');
        })
        {{--var url = "{{url('accounting/payment/')}}" + '/' + ids.join(',');--}}
          var bulkIds = ids.join(',');
          var url = "{{url('accounting/bulk-pay-or-reject/')}}";
          $.ajax({
              type: "POST",
              url: url,
              data: {
                  bulkIds:bulkIds,
                  action:'reject'
              },
              success:function (response){
                  if(response.success === 'reject'){
                      toastr.success("Bulk Requests Rejected successfully!", "Finance Alert");
                      location.reload();
                  }
                  else{
                      toastr.error("Something went wrong!", "Finance Alert");
                  }
              }
          })
      });

        // Handle click on "Pay All" button
        $('#payBtn').on('click', function() {
        var selectedIds = [];

        $('input[name="id[]"]:checked').each(function() {
          selectedIds.push($(this).attr('value'));
        });
        var ids=selectedIds.map(input=>{
          return $(input).attr('value');
        })
        var bulkIds = ids.join(',');
        var url = "{{url('accounting/bulk-pay-or-reject/')}}";
            // $('#loader').show();

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    bulkIds:bulkIds,
                    action:'pay'
                },
                success:function (response){
                    // $('#loader').hide();
                    if(response.success === 'success'){
                        toastr.success("Bulk Requests Paid successfully!", "Finance Alert");
                        location.reload();
                    }
                    else{
                        // $('#loader').hide();
                        toastr.error("Something went wrong!", "Finance Alert");
                    }
                }
            });
          // $('#submit-btn').attr('action', url);
          // $('#submit-btn').submit();
        });

    });





    </script>

@endsection
