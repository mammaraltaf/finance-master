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
        <button class="btn btn-info" id="changepass" data-toggle="modal" data-target="#changemodal" data-id="{{$user_id}}">Change Password</button>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="changemodal" >
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form method="post" action="{{route('admin.changepassword')}}">
                    @csrf
                    <div class="modal-header" style="text-align: center;">
                        <h2 class="modal-title" id="myModalLabel">Change Password</h2>
                    </div>
                    <div class="modal-body" style="text-align: center;">

                     
                        <input type="hidden" name="id" class="user-delete" value=""/>
                        <label>Current Password </label>
                <input type="password" name="currentPassword" class="form-control" required>
                <label>New Password </label>
                <input type="password" name="password"  class="form-control" required>
                <label>Confirm New Password</label>
                <input type="password" name="passwordConfirm"  class="form-control" required>
                    </div>
                    <div class="modal-footer" style="text-align: center;">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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