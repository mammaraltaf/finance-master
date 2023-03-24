@extends('admin.admin.app')
@section('pageTitle')
    Contact Form
@endsection
@section('content')
    <!--begin::Header-->
    <br>
    <div class="card-header pt-5">

        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1">Manage Contact Form Queries</span>
        </h3>


    </div>
    <div class="card-toolbar">
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-3">
        <div class="tab-content">
            {{--All Datatable--}}
            <table id="appointmentTable" name="appointmentTable" class="ui celled table allTable" style="width:100%">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Query Topic</th>
                    <th>Phone</th>
                    <th>Message</th>
                </tr>
                </thead>
                <tbody>
                @foreach($contacts as $contact)
                    <tr>
                        <td>{{$contact->full_name ?? ''}}</td>
                        <td>{{$contact->email ?? ''}}</td>
                        <td>{{$contact->topic ?? ''}}</td>
                        <td>{{$contact->phone ?? ''}}</td>
                        <td>{{$contact->message ?? ''}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Query Topic</th>
                    <th>Phone</th>
                    <th>Message</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div id="ModalEdit" class="modal fade">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">Generate Invoice</h1>
                </div>
                <div class="modal-body">
                    <form id="invoiceForm" method="POST" action=""
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Invoice Number</label>
                                    <input type="text" name="invoiceNumber" id="invoiceNumber" placeholder="Enter Invoice Number"
                                           class="form-control input-lg" readonly required>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Date/Time</label>

                                    <input type="text" name="dateTime" placeholder="Date/Time" value="{{ date('Y-m-d H:i:s') }}"
                                           class="form-control input-lg" readonly required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Full Name</label>
                                    <input type="text" name="fullName" id="fullName" placeholder="Enter Client Full Name"
                                           class="form-control input-lg" readonly required>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Phone</label>

                                    <input type="text" name="phone" id="phone" placeholder="Enter Phone Number"
                                           class="form-control input-lg" readonly required>
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label">Address</label>
                                    <input type="text" name="address" id="address" placeholder="Enter Address"
                                           class="form-control input-lg" readonly required>
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label">Enter Charges in PKR</label>
                                    <input type="text" name="amount" id="amount" placeholder="Enter Amount"
                                           class="form-control input-lg" required>
                                </div>
                            </div>
{{--                            <br>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-12">--}}
{{--                                    <label class="control-label">Comments</label>--}}
{{--                                    <textarea type="text" name="charges" placeholder="Any Comments"--}}
{{--                                           class="form-control input-lg" required></textarea>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                        <br>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-success">Complete Appointment & Generate Invoice</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!--end::Body-->
@endsection
@section('script')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#appointmentTable').DataTable();
        });
        $('body').on('click', '#completeAppointment', function () {
            var appointment_id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{url('/admin/get-data/')}}"+'/'+appointment_id,
                success:function (response){
                    $('#fullName').val(response.name);
                    $('#phone').val(response.phone);
                    $('#address').val(response.address);
                    $('#invoiceNumber').val("UH000215"+response.id);
                    $('#invoiceForm').attr('action',"{{url('/admin/invoice/')}}"+'/'+appointment_id);
                }

            });
        });
    </script>
@endsection
