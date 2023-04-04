@extends('admin.admin.app')
@section('pageTitle')
    Type Of Expanse
@endsection
@section('content')
    <!--begin::Header-->
  
    <br>
    <div class="card-header pt-5">
        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1">Manage Type of Expanse</span>
        </h3>
    </div>
    <div class="card-toolbar">
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-3">
        <div class="row">
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#ModalLoginForm">
                Add Type of Expanse
            </button>
        </div>
        <!-- Modal HTML Markup -->
        <div id="ModalLoginForm" class="modal fade">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title">Add Type of Expanse</h1>
                    </div>
                    <div class="modal-body">
                        <form id="categoryForm" method="POST" action="{{route('super-admin.type-of-expense-post')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="control-label">ID / Software (Must be Unique)</label>
                                <div>
                                    <input type="text" name="id_software" placeholder="Enter ID / Software"
                                           class="form-control input-lg" required>
                                </div>
                                <br>

                                <label class="control-label">Name</label>
                                <div>
                                    <input type="text" name="name" placeholder="Enter Name"
                                           class="form-control input-lg" required>
                                </div>
                                <br>

                                <label class="control-label">Accounting ID</label>
                                <div>
                                    <input type="text" name="accounting_id" placeholder="Enter Accounting ID"
                                           class="form-control input-lg" required>
                                </div>
                                <br>
                            </div>

                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-success">Add Type Of Expanse</button>
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
                        <h1 class="modal-title">Edit Type Of Expanse</h1>
                    </div>
                    <div class="modal-body">
                        <form id="companyFormEdit" method="POST" action=""
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="company_id" id="company_id">
                            <div class="form-group">
                                <label class="control-label">ID / Software (Must be Unique)</label>
                                <div>
                                    <input type="text" name="id_software" id="id_software" placeholder="Enter ID / Software"
                                           class="form-control input-lg" required>
                                </div>
                                <br>

                                <label class="control-label">Name</label>
                                <div>
                                    <input type="text" name="name" id="name" placeholder="Enter Name"
                                           class="form-control input-lg" required>
                                </div>
                                <br>

                                <label class="control-label">Accounting ID</label>
                                <div>
                                    <input type="text" name="accounting_id" id="accounting_id" placeholder="Enter Accounting ID"
                                           class="form-control input-lg" required>
                                </div>
                                <br>

                            </div>


                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-success">Update Type Of Expanse</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="tab-content">

            {{--All Datatable--}}
            <table id="typeOfExpenseTable" name="typeOfExpenseTable" class="ui celled table allTable" style="width:100%">
                <thead>
                <tr class="text-center">
                    <th>ID / Software</th>
                    <th>Name</th>
                    <th>Accounting ID</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($typeOfExpenses as $typeOfExpense)
                    <tr class="text-center">
                        <td>{{$typeOfExpense->id_software}}</td>
                        <td>{{$typeOfExpense->name}}</td>
                        <td>{{$typeOfExpense->accounting_id}}</td>

                        <td>
                            {{-- <a href="" class="btn btn-primary btn-sm" id="typeOfExpenseEdit"  data-toggle="modal" data-target="#ModalEdit" data-id="{{$typeOfExpense->id}}">Edit</a>
                            <a id="deleteBtn" data-toggle="modal" data-target=".modal1" data-id="{{$typeOfExpense->id}}"
                               class="btn btn-danger delete_btn btn-sm">Delete</a> --}}
                            <i id="typeOfExpenseEdit"  data-toggle="modal" data-target="#ModalEdit" data-id="{{$typeOfExpense->id}}"  class="fas px-1 fa-edit cursor-pointer text-primary"></i>
                            <i id="deleteBtn" data-toggle="modal" data-target=".modal1" data-id="{{$typeOfExpense->id}}" class="fa px-1 fa-trash cursor-pointer text-danger" aria-hidden="true"></i>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                {{-- <tfoot>
                <tr>
                    <th>ID / Software</th>
                    <th>Name</th>
                    <th>Accounting ID</th>
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

                <form method="post" action="{{route('super-admin.delete-type-of-expense')}}">
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
            $('#typeOfExpenseTable').DataTable();
        });
        $('body').on('click', '#typeOfExpenseEdit', function () {
            var typeOfExpanse_id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{url('/super-admin/edit-type-of-expense/')}}"+'/'+typeOfExpanse_id,
                success:function (response){
                    console.log(response);
                    $('#id_software').val(response.id_software);
                    $('#name').val(response.name);
                    $('#accounting_id').val(response.accounting_id);
                    $('#companyFormEdit').attr('action',"{{url('/super-admin/edit-type-of-expense/')}}"+'/'+typeOfExpanse_id);
                }
            });
        });

    </script>
@endsection
