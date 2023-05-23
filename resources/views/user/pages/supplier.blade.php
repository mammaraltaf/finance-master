@extends('admin.admin.app')
@section('pageTitle')
    Suppliers
@endsection
@section('content')
    <!--begin::Header-->
    <style>
        ul.pagination .paginate_button:hover {
            color: white !important;
            /* border: 1px solid #111; */
            background-color: blue!important;
            /* background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #585858), color-stop(100%, #111)); */
            /* background: -webkit-linear-gradient(top, #585858 0%, #111 100%); */
            background: -moz-linear-gradient(top, #585858 0%, #1755ba 100%)!important;
            background: -ms-linear-gradient(top, #585858 0%, #1755ba 100%)!important;
            background: -o-linear-gradient(top, #585858 0%, #1755ba 100%)!important;
            /* background: linear-gradient(to bottom, #585858 0%, #111 100%); */
        }
        .dataTables_length {
            margin-right: 10px;
        }
    </style>
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
{{--                                <label class="control-label">ID / Software</label>--}}
{{--                                <div>--}}
{{--                                    <input type="text" name="id_software" placeholder="Enter tax ID "--}}
{{--                                           class="form-control input-lg" required>--}}
{{--                                </div>--}}
{{--                                <br>--}}
                                <div>
                                    <input type="hidden" name="id_software" value="{{ Illuminate\Support\Str::random(10) }}"  class="form-control input-lg" required>
                                </div>
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

        <div class="modal fade" id="rowModal" tabindex="-1" role="dialog" aria-labelledby="rowModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="rowModalLabel">Row Information</h5>
                  <button type="button" class="close close-pop-up" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <p id="rowIdSoftware"></p>
                    <p id="rowTaxId"></p>
                    <p id="rowSupplierName"></p>
                    <p id="rowBankId"></p>
                    <p id="rowBankName"></p>
                    <p id="rowBankAccount"></p>
                    <p id="rowBankSwift"></p>
                    <p id="rowAccountingId"></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary close-pop-up" >Close</button>
                </div>
              </div>
            </div>
        </div>
        <div class="overflow-auto">

            {{--All Datatable--}}
            <table name="suppliertable" id="suppliertable"
                   class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                {{-- <table id="suppliertable" name="suppliertable" class="ui celled table allTable" style="width:100%"> --}}
                <thead>
                <tr class="text-nowrap text-center">
                    <th class="">+</th>
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
                    <tr class=" text-nowrap text-center">
                        {{-- <td class="cursor-pointer">
                            <div class="rounded-circle bg-primary dot"></div>
                            <div class="d-none">{{\Carbon\Carbon::parse($supplier['created_at']) ?? ''}}</div>
                        </td> --}}
                        <td class="cursor-pointer text-xl bg-primary" 
                            style="color: #FFFFFF; font-weight: bold; padding: 10px; border-radius: 5px;">
                            +
                            <div class="d-none">
                                {{\Carbon\Carbon::parse($supplier['created_at']) ?? ''}}
                            </div>
                        </td>
                        <td>{{$supplier['id_software']}}</td>
                        <td>{{$supplier['tax_id']}}</td>
                        <td>{{$supplier['supplier_name']}}</td>
                        <td>{{$supplier['bank_id']}}</td>
                        <td>{{$supplier['bank_name']}}</td>
                        <td>{{$supplier['bank_account']}}</td>
                        <td>{{$supplier['bank_swift']}}</td>
                        <td>{{$supplier['accounting_id']}}</td>
                        @hasanyrole('super-admin|accounting')
                        <td>
                            <i id="userEdit" data-toggle="modal" data-target="#ModalEdit" data-id="{{$supplier->id}}"
                               data-user_type="{{auth()->user()->user_type}}"
                               class="fas px-1 fa-edit delete_btn cursor-pointer text-primary"></i>
                        </td>
                        @endhasanyrole
                    </tr>
                @endforeach
                </tbody>

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


{{--                            <label class="control-label">ID / Software</label>--}}
{{--                            <div>--}}
{{--                                <input type="text" name="id_software" id="id_software" placeholder="Enter tax ID "--}}
{{--                                       class="form-control input-lg" required>--}}
{{--                            </div>--}}
{{--                            <br>--}}
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
<!-- Modal Popup -->

    </div><!-- /.modal -->

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

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap4.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script type="text/javascript">
    $(document).ready(function() {
        $('table#suppliertable tbody tr td:first-child').on('click', function() {
            var row = $(this).closest('tr');
            var idSoftware = row.find('td:nth-child(2)').text().trim();
            var taxId= row.find('td:nth-child(3)').text().trim();
            var supplierName = row.find('td:nth-child(4)').text().trim();
            var bankId = row.find('td:nth-child(5)').text().trim();
            var bankName = row.find('td:nth-child(6)').text().trim();
            var bankAccount = row.find('td:nth-child(7)').text().trim();
            var bankSwift = row.find('td:nth-child(8)').text().trim();
            var accountingId = row.find('td:nth-child(9)').text().trim();

            $('#rowIdSoftware').text('ID Software: ' + idSoftware);
            $('#rowTaxId').text('Tax ID: ' + taxId);
            $('#rowSupplierName').text('Supplier Name: ' + supplierName);
            $('#rowBankId').text('Bank ID: ' + bankId);
            $('#rowBankName').text('Bank Name: ' + bankName);
            $('#rowBankAccount').text('Bank Account: ' + bankAccount);
            $('#rowBankSwift').text('Bank Swift: ' + bankSwift);
            $('#rowAccountingId').text('Accounting ID: ' + accountingId);
         

            $('#rowModal').modal('show');
            $('.close-pop-up').click(function () {
                $('#rowModal').modal('hide');
            });
        });
    });

        $('.delete_btn').click(function () {
            var a = $(this).data('id');
            $('.user-delete').val(a);
        });
        $(document).ready(function () {
            $('#suppliertable').DataTable({
                'order': [0, 'desc'],
                dom: 'Blfrtip',
                lengthChange: true,
                buttons: [

                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },
                    {
                        extend: 'excel',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        }
                    },
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        }
                    },
                    'colvis'
                ]
            });
        });
        $('body').on('click', '#userEdit', function () {
            var supplier_id = $(this).data('id');
            var user_type = $(this).data('user_type');
            $.ajax({
                type: "GET",
                url: "{{url('/')}}/" + user_type + "/edit-supplier/" + supplier_id,
                success: function (response) {
                    // console.log(response);
                    $('#id_software').val(response.id_software);
                    $('#name').val(response.supplier_name);
                    $('#tax_id').val(response.tax_id);
                    $('#bank_id').val(response.bank_id);
                    $('#bank_name').val(response.bank_name);
                    $('#bank_account').val(response.bank_account);
                    $('#bank_swift').val(response.bank_swift);
                    $('#accounting_id').val(response.accounting_id);
                    $('#userFormEdit').attr('action', "{{url('/')}}/" + user_type + "/edit-supplier/" + supplier_id);
                }

            });
        });

    </script>
@endsection
