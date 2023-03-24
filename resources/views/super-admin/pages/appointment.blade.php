@extends('admin.admin.app')
@section('pageTitle')
    Appointment
@endsection
@section('content')
    <!--begin::Header-->
    <br>
    <div class="card-header pt-5">

        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1">Manage Appointment</span>
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
{{--                    <th>Category</th>--}}
                    <th>Service</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Appointment Date Time</th>
                    <th>Appointment Detail</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($appointments as $appointment)
                    @php
                        $category = \App\Models\Category::where('id',$appointment->category_id)->first();
                        $service = \App\Models\Service::where('id',$appointment->service_id)->first();
                    @endphp
                    <tr>
{{--                        <td>{{$category->category_name}}</td>--}}
                        <td>{{$service->service_name ?? ''}}</td>
                        <td>{{$appointment->name}}</td>
                        <td>{{$appointment->phone}}</td>
                        <td>{{$appointment->email}}</td>
                        <td>{{$appointment->address}}</td>
                        <td>{{$appointment->city}}</td>
                        <td>{{$appointment->appointmentDateTime}}</td>
                        <td>{{$appointment->appointmentDetail}}</td>
                        @if($appointment->status == 0)
                            <td><span class="badge badge-pill badge-warning">Pending</span></td>
                        @elseif($appointment->status == 1)
                            <td><span class="badge badge-pill badge-success">Completed</span></td>
                        @else
                            <td><span class="badge badge-pill badge-danger">No Status</span></td>
                        @endif
                        <td>
                            @if($appointment->status == 0)
{{--                            <a href="" class="btn btn-primary btn-sm m-2" data-id="{{$appointment->id}}" id="completeAppointment"--}}
{{--                               data-toggle="modal" data-target="#ModalEdit"><i class="fa-solid fa-check"></i></a>--}}

                                <a href="" class="btn btn-primary btn-sm" data-id="{{$appointment->id}}" id="sendAppointmentToProvider"
                                   data-toggle="modal" data-target="#ModalSendToProvider"><i class="fa-solid fa-check"></i></a>

                            @elseif($appointment->status == 1)
                                <a href="{{route('admin.downloadInvoice',['id'=>$appointment->id])}}" class="btn btn-info btn-sm" data-id="{{$appointment->id}}"><i class="fa fa-download"></i></a>
                                <a href="{{route('admin.sendEmail',['id'=>$appointment->id])}}" class="btn btn-success btn-sm" data-id="{{$appointment->id}}"><i class="fa fa-paper-plane"></i></a>
                            @endif
                        </td>
                    </tr>
                    <div id="ModalSendToProvider" class="modal fade">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title">Send to Providers</h1>
                                </div>
                                <div class="modal-body">
                                    <form id="sendToProvidersForm" method="POST" action="{{route('admin.sendToProviders', ['appointment_id' => $appointment->id])}}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            @foreach($providers as $provider)
                                                <div class="form-check">
                                                    <input class="form-check-input" name="providerList[]" type="checkbox" value="{{$provider->id}}" id="flexCheckIndeterminate{{$provider->id}}">
                                                    <label class="form-check-label" for="flexCheckIndeterminate{{$provider->id}}">
                                                        {{$provider->name}} - ({{$provider->city}})
                                                    </label>
                                                </div>
                                                <br>
                                            @endforeach
                                            <br>
                                        </div>
                                        <br>

                                        <div class="form-group">
                                            <div>
                                                <button type="submit" class="btn btn-success">Send to Providers</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <!--end::Body-->
                @endforeach
                </tbody>
                <tfoot>
                <tr>
{{--                    <th>Category</th>--}}
                    <th>Service</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Appointment Date Time</th>
                    <th>Appointment Detail</th>
                    <th>Status</th>
                    <th>Action</th>
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
                    <form id="sendToProviders" method="POST" action=""
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

        {{--$('body').on('click', '#sendToProviders', function () {--}}
        {{--    var appointment_id = $(this).data('id');--}}
        {{--    alert(appointment_id);--}}
        {{--    $('#sendToProvidersForm').attr('action',"{{url('/admin/send-to-providers/')}}"+'/'+appointment_id);--}}
        {{--});--}}


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
