@extends('admin.admin.app')
@section('pageTitle')
    Users
@endsection
@section('content')
    <!--begin::Header-->
    <br>
    <div class="card-header pt-5">

        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1">Manage Users</span>
        </h3>


    </div>
    <div class="card-toolbar">
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-3">
        <!-- Modal HTML Markup -->
        <div class="tab-content">

            {{--All Datatable--}}
            <table id="categoryTable" name="categoryTable" class="ui celled table allTable" style="width:100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Cnic</th>
                    <th>Email</th>
                    <th>City</th>
                    <th>Area</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->mobile}}</td>
                        <td>{{$user->cnic}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->city}}</td>
                        <td>{{$user->area}}</td>
                        <td>
                            @if($user->status == 1)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">New User</span>
                            @endif
                        <td>
                            @if($user->status == 1)
                                <a href="{{route('admin.user.status',$user->id)}}" class="btn btn-danger btn-sm">Deactivate</a>
                            @else
                                <a href="{{route('admin.user.status',$user->id)}}" class="btn btn-success btn-sm">Activate</a>
                            @endif
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Cnic</th>
                    <th>Email</th>
                    <th>City</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="modal fade modal1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
{{--                {!! Form::open( array(--}}
{{--                  'url' => route('admin.destroyCategory', array(), false),--}}
{{--                  'method' => 'post',--}}
{{--                  'role' => 'form' )) !!}--}}

                <form method="post" action="{{route('admin.destroyCategory')}}">
                    @csrf
                <div class="modal-header" style="text-align: center;">
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span--}}
{{--                            aria-hidden="true">&times;</span></button>--}}
                    <h2 class="modal-title" id="myModalLabel">Delete</h2>
                </div>
                <div class="modal-body" style="text-align: center;">

                    Are you sure you want to delete ?
                    <input type="hidden" name="id" class="user-delete" value=""/>
                </div>
                <div class="modal-footer" style="text-align: center;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
                </form>
{{--                {!! Form::close() !!}--}}

            </div>
        </div>
    </div>

    <!--end::Body-->
@endsection
@section('script')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
    <script type="text/javascript">
        $('.delete_btn').click(function () {
            var a = $(this).data('id');
            $('.user-delete').val(a);
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#categoryTable').DataTable();
        });
        $('body').on('click', '#categoryEdit', function () {
            var category_id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{url('/admin/edit-category/')}}"+'/'+category_id,
                success:function (response){
                    $('#category').val(response.category_name);
                    $('#categoryFormEdit').attr('action',"{{url('/admin/edit-category/')}}"+'/'+category_id);
                }

            });
        });

    </script>
@endsection
