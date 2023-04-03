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
                        <form id="categoryForm" method="POST" action="{{route('super-admin.add-user-post')}}"
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
                                   <select name="type" class="form-control" aria-placeholder="Select User Type" required>
                                    <option value="" >Select Role</option>
                                       @foreach($roles as $role)
                                             <option value="{{$role->name}}">{{$role->name}}</option>
                                       @endforeach
                                </select>
                                </div>
                                <br>
            
                                <label class="control-label">Company</label>
                                <div>
                                <select name="company" class="form-control" aria-placeholder="Select company" required>
                                    <option value="" >Select Company</option>
                                       @foreach($companies as $company)
                                             <option value="{{$company->name}}">{{$company->name}}</option>
                                       @endforeach
                                </select>
                                </div>
                                <br>
                                
                                <label class="control-label">Department</label>
                                <div>
                                <select name="department" class="form-control" aria-placeholder="Select department" required>
                                    <option value="" >Select Department</option>
                                       @foreach($departments as $department)
                                             <option value="{{$department->name}}">{{$department->name}}</option>
                                       @endforeach
                                </select>
                                </div>
                                <br>

                            </div>

                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-success">Add User</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="tab-content">

            {{--All Datatable--}}
            <table id="categoryTable" name="categoryTable" class="ui celled table allTable" style="width:100%">
                <thead>
                <tr class="text-nowrap text-center">
                    <th>Name</th>
                      <th>Email</th>
                    <th>Type</th>

                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="text-nowrap text-center">
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            <span class="badge badge-success">{{$user->user_type}}</span>
                            </td>
{{--                        <td>--}}
{{--                            @if($user->status == "active")--}}
{{--                                <span class="badge badge-success">Active</span>--}}
{{--                            @else--}}
{{--                                <span class="badge badge-danger">New User</span>--}}
{{--                            @endif--}}
{{--                        <td>--}}
                        @if(($user->user_type == \App\Classes\Enums\UserTypesEnum::Admin) || ($user->user_type == \App\Classes\Enums\UserTypesEnum::User))

                        <td>
                            {{-- <a href="" class="btn btn-primary btn-sm" id="userEdit"  data-toggle="modal" data-target="#ModalEdit" data-id="{{$user->id}}">Edit</a>
                            <a id="deleteBtn" data-toggle="modal" data-target=".modal1" data-id="{{$user->id}}"
                               class="btn btn-danger delete_btn btn-sm">Delete
                            </a> --}}
                            <i id="userEdit" id="userEdit"  data-toggle="modal" data-target="#ModalEdit" data-id="{{$user->id}}" class="fas px-1 fa-edit cursor-pointer text-primary"></i>
                            <i id="deleteBtn" data-toggle="modal" data-target=".modal1" data-id="{{$user->id}}" class="fa px-1 fa-trash cursor-pointer text-danger" aria-hidden="true"></i>
                        </td>
                            @else
                            <td>
                                -
                            </td>
                        @endif

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
        </div></div>
           <div class="modal fade modal1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                      <form id="categoryForm" method="POST" action="{{route('super-admin.delete-user')}}"
                      enctype="multipart/form-data">
                            @csrf
                        <div class="modal-header" style="text-align: center;">
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
                                <select name="type" id="type" class="form-control" aria-placeholder="Select User Type" required>
                                    <option value="" selected="selected">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->name}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <label class="control-label">Company</label>
                                <div>
                                <select name="company" class="form-control" aria-placeholder="Select company" required>
                                    <option value="" >Select Company</option>
                                       @foreach($companies as $company)
                                             <option value="{{$company->name}}" {{ $company->name == $user->company? 'selected' : '' }}>{{$company->name}}</option>
                                       @endforeach
                                </select>
                                </div>
                                <br>
                                
                                <label class="control-label">Department</label>
                                <div>
                                <select name="department" class="form-control" aria-placeholder="Select department" required>
                                    <option value="" >Select Department</option>
                                       @foreach($departments as $department)
                                             <option value="{{$department->name}}" {{ $department->name == $user->department? 'selected' : '' }}>{{$department->name}}</option>
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
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

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
                 $('body').on('click', '#userEdit', function () {
                     var user_id = $(this).data('id');
                     $.ajax({
                         type: "GET",
                         url: "{{url('/super-admin/edit-user/')}}"+'/'+user_id,
                         success:function (response){
                             console.log(response);
                             $('#name').val(response.name);
                             $('#email').val(response.email);
                             $('#type').val(response.user_type);
                             $('#password').val(response.original_password);
                             // $('#type').prop('selectedIndex', response.user_type);
                             $('#userFormEdit').attr('action',"{{url('/super-admin/edit-user/')}}"+'/'+user_id);
                         }

                     });
                 });

            </script>
@endsection
