@extends('admin.admin.app')
@section('pageTitle')
    Department
@endsection
@section('content')
    <!--begin::Header-->
    <br>
    <div class="card-header pt-5">

        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1">Manage Department</span>
        </h3>


    </div>
    <div class="card-toolbar">
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-3">
        <div class="row">
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#ModalLoginForm">
                Add Department
            </button>
        </div>
        <!-- Modal HTML Markup -->
        <div id="ModalLoginForm" class="modal fade">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title">Add Department</h1>
                    </div>
                    <div class="modal-body">
                        <form id="categoryForm" method="POST" action="{{route('admin.department-post')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="company_id" value="<?= $companyId; ?>">
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <div>
                                    <input type="text" name="name" placeholder="Enter Name"
                                           class="form-control input-lg" required>
                                </div>
                                <br>
                                <br>
                                <label class="control-label">Select User</label>
                                <div>
                                    <select name="user_id" class="form-control">
                                        <option value="">Select User</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-success">Add Department</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        {{--Edit Modal--}}
        <div id="ModalEdit" class="modal fade">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title">Edit Department</h1>
                    </div>
                    <div class="modal-body">
                        <form id="companyFormEdit" method="POST" action=""
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="company_id" id="company_id">
                            <div class="form-group">

                                <label class="control-label">Name</label>
                                <div>
                                    <input type="text" name="name" id="name" placeholder="Enter Name"
                                           class="form-control input-lg" required>
                                </div>
                                <br>

                            </div>


                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-success">Update Department</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="overflow-auto">

            {{--All Datatable--}}
            <table name="departmentTable" id="departmentTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            {{-- <table id="departmentTable" name="departmentTable" class="ui celled table allTable" style="width:100%"> --}}
                <thead>
                <tr class="text-nowrap text-center">
                    <th>S. no</th>
                    <th class="d-none">Created AT</th>
                    <th>ID / Software</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody> <?php $num=0; ?>
                @foreach($departments as $department)
                    <tr class="text-center">
                        <td><?= ++$num; ?></td>
                        <td class="d-none">{{formatDate($department['created_at']) ?? ''}}</td>
                        <td>{{$department->id_software}}</td>
                        <td>{{$department->name}}</td>

                        <td>
                            {{-- <a href="" class="btn btn-primary btn-sm" id="departmentEdit"  data-toggle="modal" data-target="#ModalEdit" data-id="{{$department->id}}">Edit</a>
                            <a id="deleteBtn" data-toggle="modal" data-target=".modal1" data-id="{{$department->id}}"
                               class="btn btn-danger delete_btn btn-sm">Delete</a> --}}
                            <i id="departmentEdit"  data-toggle="modal" data-target="#ModalEdit" data-id="{{$department->id}}" class="fas px-1 fa-edit cursor-pointer text-primary"></i>
                            <i id="deleteBtn" data-toggle="modal" data-target=".modal1" data-id="{{$department->id}}" class="fa px-1 fa-trash delete_btn cursor-pointer text-danger" aria-hidden="true"></i>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                {{-- <tfoot>
                <tr class="text-center">
                    <th>ID / Software</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                </tfoot> --}}
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

                <form method="post" action="{{route('admin.delete-department')}}">
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

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>
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
            $('#departmentTable').DataTable({
                "order": [[ 0, "desc" ]]
            });
        });
        $('body').on('click', '#departmentEdit', function () {
            var department_id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{url('/admin/edit-department/')}}"+'/'+department_id,
                success:function (response){
                    // console.log(response);
                    $('#id_software').val(response.id_software);
                    $('#name').val(response.name);
                    $('#companyFormEdit').attr('action',"{{url('/admin/edit-department/')}}"+'/'+department_id);
                }
            });
        });

    </script>
@endsection
