@extends('admin.admin.app')
@section('pageTitle')
    Suppliers
@endsection
@section('content')
    <!--begin::Header-->
    <br>
    <div class="card-header pt-5">

        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1">Manage Suppliers</span>
        </h3>


    </div>
    <div class="card-toolbar">
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-3">
        @role('user')
        <div class="row">
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#ModalLoginForm">
                Add Supplier
            </button>
        </div>
        @endrole
        <div class="modal fade modal1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form method="post" action="{{route('user.delete-supplier')}}">
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

        @role('user')
        <!-- Modal HTML Markup -->
        <div id="ModalLoginForm" class="modal fade">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title">Add Supplier</h1>
                    </div>
                    <div class="modal-body">
                        <form id="categoryForm" method="POST" action="{{route('user.addsupplier')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="control-label">ID / Software</label>
                                <div>
                                    <input type="text" name="id_software" placeholder="Enter tax ID "
                                           class="form-control input-lg" required>
                                </div>
                                <br>

                                <label class="control-label">Tax ID</label>
                                <div>
                                    <input type="text" name="tax_id" placeholder="Enter tax ID "
                                           class="form-control input-lg" required>
                                </div>
                                <br>

                                <label class="control-label">Supplier Name</label>
                                <div>
                                    <input type="text" name="name" placeholder="Enter supplier name"
                                           class="form-control input-lg" required>
                                </div>
                                <br>

                                <label class="control-label">Bank ID</label>
                                <div>
                                    <input type="text" name="bank_id" placeholder="Enter  Bank ID"
                                           class="form-control input-lg" @role('user') disabled @endrole>
                                </div>
                                <br>

                                <label class="control-label">Bank Name</label>
                                <div>
                                    <input type="text" name="bank_name" placeholder="Enter  Bank name"
                                           class="form-control input-lg" @role('user') disabled @endrole>
                                </div>
                                <br>

                                <label class="control-label">Bank Account</label>
                                <div>
                                    <input type="text" name="bank_account" placeholder="Enter Bank Account"
                                           class="form-control input-lg" @role('user') disabled @endrole>
                                </div>
                                <br>

                                <label class="control-label">Bank Swift</label>
                                <div>
                                    <input type="text" name="bank_swift" placeholder="Enter Bank Swift"
                                           class="form-control input-lg" @role('user') disabled @endrole>
                                </div>
                                <br>
                                <label class="control-label"> Accounting ID</label>
                                <div>
                                    <input type="text" name="accounting_id" placeholder="Enter  Accounting ID"
                                           class="form-control input-lg" @role('user') disabled @endrole>
                                </div>
                                <br>

                            </div>

                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-success">Add Supplier</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        @endrole
        <div class="tab-content">

            {{--All Datatable--}}
            <table id="suppliertable" name="suppliertable" class="ui celled table allTable" style="width:100%">
                <thead>
                <tr class="text-nowrap text-center">
                    <th>ID Software</th>
                    <th>Tax ID</th>
                    <th>Supplier Name</th>
                    <th>Bank ID</th>
                    <th>Bank Name</th>
                    <th>Bank Account</th>
                    <th>Bank Swift</th>
                    <th>Accounting ID</th>
                    @hasanyrole('super-admin|accounting')
                    <th>Action</th>
                    @endhasanyrole
                </tr>
                </thead>
                <tbody>
                @foreach($suppliers as $supplier)
                    <tr class="text-nowrap text-center">
                        <td>{{$supplier['id_software']}}</td>
                        <td>{{$supplier['tax_id']}}</td>
                        <td>{{$supplier['supplier_name']}}</td>
                        <td>{{$supplier['bank_id']}}</td>
                        <td>{{$supplier['bank_name']}}</td>
                        <td>{{$supplier['bank_account']}}</td>
                        <td>{{$supplier['bank_swift']}}</td>
                        <td>{{$supplier['accounting_id']}}</td>
                        @hasanyrole('super-admin|accounting')
                        <td><a href="" class="btn btn-primary btn-sm" id="userEdit" data-toggle="modal"
                               data-target="#ModalEdit" data-id="{{$supplier->id}}">Edit</a>
                               <a id="deleteBtn" data-toggle="modal" data-target=".modal1" data-id="{{$supplier->id}}"
                                   class="btn btn-danger delete_btn btn-sm">Delete</a></td>
                            </tr>
                        <td>
                            <i id="userEdit" data-toggle="modal" data-target="#ModalEdit" data-id="{{$supplier->id}}" class="fas px-1 fa-edit cursor-pointer text-primary"></i>
                        </td>
                        @endhasanyrole
                    </tr>
                @endforeach
                </tbody>
                {{-- <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Tax ID</th>
                    <th>Supplier Name</th>
                    <th>Bank ID</th>
                    <th>Bank Name</th>
                    <th>Bank Account</th>
                    <th>Bank Swift</th>
                    <th>Accounting ID</th>
                    <th>Action</th>
                </tr>
                </tfoot> --}}
            </table>
        </div>
    </div>
    <div id="ModalEdit" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">Edit Supplier</h1>
                </div>
                <div class="modal-body">
                    <form id="userFormEdit" method="POST" action=""
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="supplier_id" id="supplier_id">
                        <div class="form-group">


                            <label class="control-label">ID / Software</label>
                            <div>
                                <input type="text" name="id_software" id="id_software" placeholder="Enter tax ID "
                                       class="form-control input-lg" required>
                            </div>
                            <br>
                            <label class="control-label">Tax ID</label>
                            <div>
                                <input type="text" name="tax_id" id="tax_id" placeholder="Enter tax ID "
                                       class="form-control input-lg" required>
                            </div>
                            <br>
                            <label class="control-label"> Supplier Name</label>
                            <div>
                                <input type="text" name="name" id="name" placeholder="Enter full name"
                                       class="form-control input-lg" required>
                            </div>
                            <br>
                            <label class="control-label">Bank ID</label>
                            <div>
                                <input type="text" name="bank_id" id="bank_id" placeholder="Enter  Bank ID"
                                       class="form-control input-lg" @role('user') disabled @endrole>
                            </div>
                            <br>

                            <label class="control-label">Bank Name</label>
                            <div>
                                <input type="text" name="bank_name" id="bank_name" placeholder="Enter  Bank name"
                                       class="form-control input-lg" @role('user') disabled @endrole>
                            </div>
                            <br>

                            <label class="control-label">Bank Account</label>
                            <div>
                                <input type="text" name="bank_account" id="bank_account"
                                       placeholder="Enter Bank Account"
                                       class="form-control input-lg" @role('user') disabled @endrole>
                            </div>
                            <br>

                            <label class="control-label">Bank Swift</label>
                            <div>
                                <input type="text" name="bank_swift" id="bank_swift" placeholder="Enter Bank Swift"
                                       class="form-control input-lg" @role('user') disabled @endrole>
                            </div>
                            <br>
                            <label class="control-label"> Accounting ID</label>
                            <div>
                                <input type="text" name="accounting_id" id="accounting_id"
                                       placeholder="Enter  Accounting ID"
                                       class="form-control input-lg" @role('user') disabled @endrole>
                            </div>
                            <br>

                        </div>


                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-success">Update Supplier</button>
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

          $('.delete_btn').click(function () {
            var a = $(this).data('id');
            $('.user-delete').val(a);
        });
        $(document).ready(function () {
            $('#suppliertable').DataTable();
        });
        $('body').on('click', '#userEdit', function () {
            var supplier_id = $(this).data('id');
            console.log(supplier_id);
            $.ajax({
                type: "GET",
                url: "{{url('/user/edit-supplier/')}}" + '/' + supplier_id,
                success: function (response) {
                    console.log(response);
                    $('#id_software').val(response.id_software);
                    $('#name').val(response.supplier_name);
                    $('#tax_id').val(response.tax_id);
                    $('#name').val(response.supplier_name);
                    $('#bank_id').val(response.bank_id);
                    $('#bank_name').val(response.bank_name);
                    $('#bank_account').val(response.bank_account);
                    $('#bank_swift').val(response.bank_swift);
                    $('#accounting_id').val(response.accounting_id);
                    $('#userFormEdit').attr('action', "{{url('/user/edit-supplier/')}}" + '/' + supplier_id);
                }

            });
        });

    </script>
@endsection
