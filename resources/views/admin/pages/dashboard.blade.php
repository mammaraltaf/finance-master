@php use App\Classes\Enums\UserTypesEnum; @endphp
@extends('admin.admin.app')
@section('pageTitle')
@endsection
@section('content')
    <!--begin::Header-->

    <div class="card-header pt-5">

        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1">Dashboard</span>
        </h3>
    </div>
    <!--end::Header-->
    <!--begin::Body-->

    <div class="container">

  </div>


@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script type="text/javascript">
        $(document).ready(function () {
            $('#changepass').click(function () {
                var a = $(this).data('id');
            $('.user-delete').val(a);
        });
    });
    </script>
@endsection
