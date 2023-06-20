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
@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#changepass').click(function () {
                var a = $(this).data('id');
            $('.user-delete').val(a);
        });

            $('#appointmentTable').DataTable({
                "order": [[ 0, "desc" ]]
            });
        });
        $('body').on('click', '#completeAppointment', function () {
            var appointment_id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{url('/admin/get-data/')}}" + '/' + appointment_id,
                success: function (response) {
                    $('#fullName').val(response.name);
                    $('#phone').val(response.phone);
                    $('#address').val(response.address);
                    $('#invoiceNumber').val("UH000215" + response.id);
                    $('#invoiceForm').attr('action', "{{url('/admin/invoice/')}}" + '/' + appointment_id);
                }

            });
        });
    </script>
@endsection
