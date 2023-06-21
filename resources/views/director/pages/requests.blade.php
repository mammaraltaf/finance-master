@php use App\Classes\Enums\UserTypesEnum; @endphp
@extends('admin.admin.app')
@section('pageTitle')
@endsection
@section('content')
    <style>
        .acceptBtn, .rejectBtn {
            font-size: 10px;
            padding: 4px 6px !important;
        }
    </style>
    <!--begin::Header-->
    <style>
        .dataTables_length {
            margin-right: 10px;
        }

        div.dt-buttons {
            margin-top: 10px;
        }
    </style>
    {{-- Generate Start--}}
    <div class="card-header pt-5">
        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1">Requests</span>
        </h3>
        <div class="">
            <button id="pending" class="btn btn-info active filter">Pending</button>
            <button id="exceed" class="btn btn-info filter">Threshold Exceeded</button>
        </div>
    </div>

    <div class="ml-5 mt-3">
        <form action="{{route('director.payments')}}" method="post">
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

    {{-- <div class="modal-footer">
      <button type="button" class="btn btn-secondary close-pop-up">Close</button>
    </div> --}}


    {{-- Generate End --}}
    <div class="modal fade" id="rowModal" tabindex="-1" role="dialog" aria-labelledby="rowModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rowModalLabel">Row Information</h5>
                    <button type="button" class="close close-pop-up" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Display row data here -->
                    <p id="status"></p>
                    <p id="rowInitiator"></p>
                    <p id="rowCreatedAt"></p>
                    <p id="rowCompany"></p>
                    <p id="rowDepartment"></p>
                    <p id="rowSupplier"></p>
                    <p id="rowTypeOfExpense"></p>
                    <p id="rowCurrency"></p>
                    <p id="rowAmount"></p>
                    <p id="rowAmountInGel"></p>
                    <p id="rowDescription"></p>
                    <p id="rowLink"></p>
                    <p id="rowBasis"></p>
                    <p id="rowDueDatePayment"></p>
                    <p id="rowDueDate"></p>
<div id="actionbuttons"></div>
                    <!-- Add more fields as needed -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-pop-up">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="overflow-auto">
            {{-- <table name="reviewDocument" id="reviewDocument" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%"> --}}

            <table id="reviewDocument" name="reviewDocument" class="ui celled table allTable" cellspacing="0">
                <thead>
                <tr class="text-nowrap">
                    <th>Action</th>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Initiator</th>
                    <th>Created At</th>
                    <th>Company</th>
                    <th>Department</th>
                    <th>Supplier</th>
                    <th>Type of Expense</th>
                    <th>Currency</th>
                    <th>Amount</th>
                    <th>Amount In Gel</th>
                    <th>Description</th>
                    <th>Link</th>
                    <th>Basis (file attachment title)</th>
                    <th>Due Date of Payment</th>
                    <th>Due Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($requests as $request)
                    <tr>
                        {{--                    <td><button type="button" id="reviewBtn" class="btn btn-primary" data-toggle="modal" data-target="#document-modal"  data-document-id="1" data-id="{{$request->id}}">Review</button></td>--}}
                        <td>
                            <div class="d-flex">
                                <button class="mr-2 btn btn-success acceptBtn" id="" data-id="{{$request->id}}">Accept
                                </button>
                                <button class="ml-2 btn btn-danger rejectBtn" id="" data-id="{{$request->id}}">Reject
                                </button>
                            </div>
                        </td>
                        <td class="cursor-pointer bg-primary"
                            style="color: #FFFFFF; font-weight: bold; padding: 10px; border-radius: 5px;">{{$request->id}}</td>
                        <td>{{$request->status ?? ''}}</td>
                        <td title="{{ $request->initiator }}">{{ getAlias($request->initiator) ?? '' }}</td>
                        <td>{{formatDate($request->created_at) ?? ''}}</td>
                        <td>{{$request->company->name ?? ''}}</td>
                        <td>{{$request->department->name ?? ''}}</td>
                        <td>{{$request->supplier->supplier_name ?? ''}}</td>
                        <td>{{$request->typeOfExpense->name ?? ''}}</td>
                        <td>{{$request->currency ?? ''}}</td>
                        <td>{{$request->amount ?? ''}}</td>
                        <td>{{$request->amount_in_gel ?? ''}}</td>
                        <td>{{$request->description ?? ''}}</td>
                        <td><a href="{{URL::to($request->request_link)}}"
                               target="_blank">{{$request->request_link ?? ''}}</a></td>
                        <td><?php if (isset($request->basis)){
                                $files = explode(',', $request->basis);
                            foreach ($files as $file){ ?>
                            <a href="{{asset('basis/'.$file)}}" target="_blank">{{$file}}</a>
                            <?php }
                            } else {
                                echo "No document available";
                            }
                                ?></td>
                        <td>{{formatDate($request->payment_date) ?? ''}}</td>
                        <td>{{formatDate($request->submission_date) ?? ''}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="document-modal" tabindex="-1" role="dialog" aria-labelledby="document-modal-label"
             aria-hidden="true">
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
                                <textarea class="form-control" id="document-comments" name="comment"
                                          rows="3"></textarea>
                            </div>
                            <!-- <div class="form-group form-check">
                              <input type="checkbox" class="form-check-input" id="amount-verification" name="amount_verification">
                              <label class="form-check-label" for="amount-verification">Verify amount manually</label>
                            </div> -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger reject-button" id="btnReject" name="reject"
                                        disabled>Reject
                                </button>
                                <button type="submit" class="btn btn-success approve-button" id="btnAccept"
                                        name="approve">Approve
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
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
                <form class="response-modal" action="{{route(auth()->user()->user_type.'.approve-request')}}"
                      method="POST">
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
                        <button type="submit" class="btn btn-primary btn-response" id="confirmAcceptBtn">Accept</button>
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
                <form class="response-modal" action="{{route(auth()->user()->user_type.'.reject-request')}}" method="POST">
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
                        <button type="submit" class="btn btn-danger btn-response" id="confirmRejectBtn">Reject</button>
                    </div>
                </form>
            </div>
        </div>
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
            $('table#reviewDocument tbody tr ').on('click', 'td:nth-child(2)', function () {
                var row = $(this).closest('tr');
                var status = row.find('td:nth-child(3)').text().trim();
                var initiator = row.find('td:nth-child(4)').text().trim();
                var createdAt = row.find('td:nth-child(5)').text().trim();
                var company = row.find('td:nth-child(6)').text().trim();
                var department = row.find('td:nth-child(7)').text().trim();
                var supplier = row.find('td:nth-child(8)').text().trim();
                var typeOfExpense = row.find('td:nth-child(9)').text().trim();
                var currency = row.find('td:nth-child(10)').text().trim();
                var amount = row.find('td:nth-child(11)').text().trim();
                var amountInGel = row.find('td:nth-child(12)').text().trim();
                var description = row.find('td:nth-child(13)').text().trim();
                var link = row.find('td:nth-child(14)').text().trim();
                var basis = row.find('td:nth-child(15)').text().trim();
                var dueDatePayment = row.find('td:nth-child(16)').text().trim();
                var dueDate = row.find('td:nth-child(17)').text().trim();
                var requestId = row.find('td:nth-child(2)').text().trim();

                $('#status').text('Status: ' + status);
                $('#rowInitiator').text('Initiator: ' + initiator);
                $('#rowCreatedAt').text('Created At: ' + createdAt);
                $('#rowCompany').text('Company: ' + company);
                $('#rowDepartment').text('Department: ' + department);
                $('#rowSupplier').text('Supplier: ' + supplier);
                $('#rowTypeOfExpense').text('Type Of Expense: ' + typeOfExpense);
                $('#rowCurrency').text('Currency: ' + currency);
                $('#rowAmount').text('Amount: ' + amount);
                $('#rowAmountInGel').text('Amount In Gel: ' + amountInGel);
                $('#rowDescription').text('Description: ' + description);
                $('#rowLink').html('Link: <a href="' + link + '" target="_blank">' + link + '</a>');
                $('#rowBasis').html('Basis: <a href="' + window.location.origin + '/basis/' + basis + '" target="_blank">' + basis + '</a>');
                ;
                $('#rowDueDatePayment').text('Due Date Payment: ' + dueDatePayment);
                $('#rowDueDate').text('Due Date: ' + dueDate);

                var acceptButton = $('<button>').addClass('mr-2 btn btn-success acceptBtn').attr('data-id', requestId).text('Accept');
    var rejectButton = $('<button>').addClass('ml-2 btn btn-danger rejectBtn').attr('data-id', requestId).text('Reject');
    $('#actionbuttons').empty().append(acceptButton, rejectButton);
                $('#rowModal').modal('show');
                $('.close-pop-up').click(function () {
                    $('#rowModal').modal('hide');
                });
            });
            $('#rowModal').on('click', '.acceptBtn', function() {
    let requestId = $(this).data('id');
    $('.approve-request-id').val(requestId);
    $('#acceptConfirmationModal').modal('show');
});

$('#rowModal').on('click', '.rejectBtn', function() {
    let requestId = $(this).data('id');
    $('.reject-request-id').val(requestId);
    $('#rejectConfirmationModal').modal('show');
});
        });
        $(document).ready(function () {
            $('.filter').click(function () {
                var buttonId = $(this).attr('id');
                var url = "{{ route('director.filtering', ':id') }}";
                url = url.replace(':id', buttonId);
                location.href = url;
            });
            $('#reviewDocument').DataTable({
                'order': [[4, 'desc']],
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
        });


        const commentTextarea = document.getElementById("document-comments");
        const rejectButton = document.getElementsByClassName("reject-button")[0];

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


        $('body').on('click', '#reviewBtn', function () {
            var req_id = $(this).data('id');
            $('#id').val(req_id);
        });
        // $('body').on('click', '.reject-button', function () {
        //     $('#directorAcceptRejectForm').attr('action', "{{url('director/reject')}}");
        // });
        // $('body').on('click', '.approve-button', function () {
        //     $('#directorAcceptRejectForm').attr('action', "{{url('director/accept')}}");
        // });

        $('body').on('click', '.reject-button', function () {
            var directorAcceptRejectForm = $('#directorAcceptRejectForm');
            directorAcceptRejectForm.attr('action', "{{url('director/reject')}}");
            $(this).prop('disabled', true);
            $('.approve-button').prop('disabled', true);
            directorAcceptRejectForm.submit();
        });

        $('body').on('click', '.approve-button', function () {
            var directorAcceptRejectForm = $('#directorAcceptRejectForm');
            directorAcceptRejectForm.attr('action', "{{url('director/accept')}}");
            $(this).prop('disabled', true);
            $('.reject-button').prop('disabled', true);
            directorAcceptRejectForm.submit();
        });
        $('.acceptBtn').click(function () {
            let a = $(this).data('id');
            $('.approve-request-id').val(a);
            $('#acceptConfirmationModal').modal('show');
        });
        $('#confirmAcceptBtn').click(function () {
            var comment = $('#acceptComment').val();
            $('#acceptConfirmationModal').modal('hide');
        });
        $('.rejectBtn').click(function () {
            let a = $(this).data('id');
            $('.reject-request-id').val(a);
            $('#rejectConfirmationModal').modal('show');
        });
        $('#confirmRejectBtn').click(function () {
            var comment = $('#rejectComment').val();
            $('#rejectConfirmationModal').modal('hide');
        });
    </script>

@endsection
