@php use App\Classes\Enums\UserTypesEnum; @endphp
@extends('admin.admin.app')
@section('pageTitle')
    Users
@endsection
@section('content')
    <!--begin::Header-->

    <style>
        .dropdown-menu.show{
            width: 100% !important;
            padding: 10px 0;
        }
    </style>
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
        <div class="row">
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#ModalLoginForm">
                Add User
            </button>
        </div>
        <!-- Modal HTML Markup -->
        <div id="ModalLoginForm" class="modal fade">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title">Add New User</h1>
                    </div>
                    <div class="modal-body">
                        <form id="add-user" method="POST" action="{{route('admin.add-user-post')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <div>
                                    <input type="text" name="name" placeholder="Enter full name"
                                           class="form-control input-lg" required>
                                </div>
                                <br>

                                <label class="control-label">Email</label>
                                <div>
                                    <input type="email" name="email" placeholder="Enter email"
                                           class="form-control input-lg" required>
                                </div>
                                <br>

                                <label class="control-label">Password</label>
                                <div>
                                    <input type="password" name="password" auto-complete="off"
                                           class="form-control input-lg" required>
                                </div>
                                <br>

                                <label class="control-label">User Type</label>
                                <div>
                                    <select name="type" class="form-control" aria-placeholder="Select User Type"
                                            required>
                                        <option value="">Select Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->name}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>





                            </div>

                            <div class="form-group">
                                <div>
                                    <input type="submit" class="btn btn-success" value="Add User">
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="overflow-auto">

            {{--All Datatable--}}
            <table name="categoryTable" id="categoryTable"
                   class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">

                {{-- <table id="categoryTable" name="categoryTable" class="ui celled table allTable" style="width:100%"> --}}
                <thead>
                <tr class="text-nowrap text-center">
                    <th>Created At</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="text-center">
                        <td>{{formatDate($user['created_at']) ?? ''}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            <span class="badge badge-success">{{$user->user_type}}</span>
                        </td>
                        <td><span class="badge badge-{{($user->status == \App\Classes\Enums\StatusEnum::Blocked) ? 'danger' : 'success'}}">{{$user->status}}</span></td>
                            <td>
                                <i id="userEdit" data-toggle="modal" data-target="#ModalEdit"
                                   data-id="{{$user->id}}" class="fas px-1 fa-edit cursor-pointer text-primary"></i>
                                <i id="deleteBtn" data-toggle="modal" data-target=".modal1" data-id="{{$user->id}}"
                                   class="fa px-1 fa-trash delete_btn cursor-pointer text-danger" aria-hidden="true"></i>
                                @if($user->status != \App\Classes\Enums\StatusEnum::Blocked)
                                    <i id="blockBtn" data-toggle="modal" data-target=".modal2" data-id="{{$user->id}}"
                                       class="fa px-1 fa-ban block_btn cursor-pointer text-danger" aria-hidden="true"></i>
                                    @else
                                    <i id="unblockBtn" data-toggle="modal" data-target=".modal3" data-id="{{$user->id}}"
                                       class="fa px-1 fa-check unblock_btn cursor-pointer text-success" aria-hidden="true"></i>
                                @endif
                            </td>
                    </tr>

                @endforeach
                </tbody>
                {{-- <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                  <th>Type</th>
                  <th>Action</th>
                </tr>
                </tfoot> --}}
            </table>
        </div>
    </div>
    <div class="modal fade modal1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form id="categoryForm" method="POST" action="{{route('admin.delete-user')}}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="text-align: center;">
                        <h2 class="modal-title" id="myModalLabel">Delete</h2>
                    </div>
                    <div class="modal-body" style="text-align: center;">

                        Are you sure you want to delete ?
                        <input type="hidden" name="id" class="user-delete" id="deleteid" value=""/>
                    </div>
                    <div class="modal-footer" style="text-align: center;">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <div class="modal fade modal2" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form id="categoryForm" method="POST" action="{{route('admin.block-user')}}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="text-align: center;">
                        <h2 class="modal-title" id="myModalLabel">Block</h2>
                    </div>
                    <div class="modal-body" style="text-align: center;">

                        Are you sure you want to block ?
                        <input type="hidden" name="id" class="user-block" id="blockid" value=""/>
                    </div>
                    <div class="modal-footer" style="text-align: center;">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Block</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


        <div class="modal fade modal3" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <form id="categoryForm" method="POST" action="{{route('admin.unblock-user')}}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header" style="text-align: center;">
                            <h2 class="modal-title" id="myModalLabel">Un Block</h2>
                        </div>
                        <div class="modal-body" style="text-align: center;">

                            Are you sure you want to unblock ?
                            <input type="hidden" name="id" class="user-unblock" id="blockid" value=""/>
                        </div>
                        <div class="modal-footer" style="text-align: center;">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">UnBlock</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    <!--end::Body-->
    <div id="ModalEdit" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">Edit User</h1>
                </div>
                <div class="modal-body">
                    <form id="userFormEdit" method="POST" action=""
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <div>
                                <input type="text" name="name" id="name" placeholder="Enter full name"
                                       class="form-control input-lg" required>
                            </div>
                            <br>

                            <label class="control-label">Email</label>
                            <div>
                                <input type="email" name="email" id="email" placeholder="Enter email"
                                       class="form-control input-lg" required>
                            </div>
                            <br>

                            <label class="control-label">User Type</label>
                            <div>
                                <select name="type" id="type" class="form-control" aria-placeholder="Select User Type"
                                        required>
                                    <option value="" selected="selected">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->name}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br>



                            <label class="control-label">Password</label>
                            <div>
                                <input type="text" name="password" id="password"
                                       class="form-control input-lg" required>
                            </div>
                            <br>

                        </div>


                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-success">Update User</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
 <script src="https://code.jquery.com/jquery-3.5.1.js"></script>


    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css"
    />
    <script type="text/javascript">
       $('.delete_btn').click(function () {
            var a = $(this).data('id');
            $('.user-delete').val(a);
        });

       $('.block_btn').click(function () {
           var a = $(this).data('id');
           $('.user-block').val(a);
       });

         $('.unblock_btn').click(function () {
              var a = $(this).data('id');
              $('.user-unblock').val(a);
         });
    </script>

    <script type="text/javascript">


        $(document).ready(function () {
            $('#deleteBtn').click(function () {
            var a = $(this).data('id');
            $('#deleteid').val(a);
        });

            $('#categoryTable').DataTable({
                'order': [[0, 'desc']],
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });
        });

        var editCompanyOption;


        $('body').on('click', '#userEdit', function () {
            var user_id = $(this).data('id');
             console.log(user_id);
            $.ajax({
                type: "GET",
                url: "{{url('/admin/edit-user/')}}" + '/' + user_id,
                success: function (response) {
                    console.log(response);
                    $('#name').val(response.name);
                    $('#email').val(response.email);
                    $('#password').val(response.original_password);
                    $('select[name="type"]').val(response.user_type).trigger('change');
                    $('#userFormEdit').attr('action', "{{url('/admin/edit-user/')}}" + '/' + user_id);
                    // Preload companies dropdown


                }
            });
        });













    </script>
@endsection
