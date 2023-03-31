@extends('users.users.app')
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
        <div class="container">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#new">New</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#submitted">Submitted for review</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#rejected">Rejected</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#finance">Finance ok</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#confirmed">Confirmed</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#paid">Paid</a>
                </li>
            </ul>
  
        <div class="tab-content">
            <div id="new" class="tab-pane fade show active">
                <h3>New - Request creating</h3>
                <p>Content for the New tab goes here.</p>
            </div>
            <div id="submitted" class="tab-pane fade">
                <h3>Submitted for review - Finish and send</h3>
                <p>Content for the Submitted for review tab goes here.</p>
            </div>
            <div id="rejected" class="tab-pane fade">
                <h3>Rejected</h3>
                <p>Content for the Rejected tab goes here.</p>
            </div>
            <div id="finance" class="tab-pane fade">
                <h3>Finance ok - Finance approved</h3>
                <p>Content for the Finance ok tab goes here.</p>
            </div>
            <div id="confirmed" class="tab-pane fade">
            <h3>Confirmed</h3>
            <p>Content for the Confirmed tab goes here.</p>
            </div>
            <div id="paid" class="tab-pane fade">
            <h3>Paid</h3>
            <p>Content for the Paid tab goes here.</p>
            </div>
        </div>
    </div>

    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-3">
        <div class="row">
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#ModalLoginForm">
                Manage Request
            </button>
        </div>
        <!-- Modal HTML Markup -->
        <div id="ModalLoginForm" class="modal fade">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title">Add Supplier</h1>
                    </div>
                    <div class="modal-body">
                        <form id="categoryForm" method="POST" action="{{route('user.addrequest')}}"
                        enctype='multipart/form-data'>
                            @csrf     
                            <div class="form-group">
                                <label for="initiator">Initiator</label>
                                <input type="text" class="form-control" id="initiator" value="<?php echo $user->name;  ?>" readonly>
                                <input type="hidden"  name="initiator_id" value="<?php echo $user->id;  ?>">
                            </div>
                            <div class="form-group">
                                <label for="company">Company</label>
                                <select class="form-control" id="company" name="company" required>
                      <?php          foreach($companies as $company){ ?>
        <option value="{{$company->id}}"  {{ $company->user_id == $user->id? 'selected' : '' }}>{{$company->name}}</option>
   <?php  } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="department">Department</label>
                                <select class="form-control" id="department" name="department" required>
                                <?php          foreach($departments as $department){ ?>
        <option value="{{$department->id}}"  {{ $department->user_id == $user->id? 'selected' : '' }}>{{$department->name}}</option>
   <?php  } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="supplier">Supplier</label>
                                <select class="form-control" id="supplier" name="supplier" required placeholder="select a supplier">
                                <?php          foreach($suppliers as $supplier){ ?>
        <option value="{{$supplier->id}}"  >{{$supplier->supplier_name}}</option>
   <?php  } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="expense-type">Type of Expense</label>
                                <select class="form-control" id="expense_type" name="expense_type" required>
                                <?php          foreach($expenses as $expense){ ?>
        <option value="{{$expense->id}}"  >{{$expense->name}}</option>
   <?php  } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="currency">Currency</label>
                                <select class="form-control" id="currency" name="currency" required>
                                <option value="">Select a currency</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                                <option value="GEL">GEL</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="basis">Basis</label>
                                <input type="file" class="form-control" id="basis" name="basis[]" multiple required>
                            </div>
                            <div class="form-group">
                                <label for="due-date-payment">Due Date of Payment</label>
                                <input type="date" class="form-control" id="due-date-payment" name="due-date-payment" required>
                            </div>
                            <div class="form-group">
                                <label for="due-date" class="form-label">Due Date</label>
                                <input type="date" class="form-control" id="due-date" name="due-date" required>
                            </div>
                          

                            <div class="form-group d-flex gx-5">
                                <div class='p-2'>
                                    <button type="submit" value="add" name="button" class="btn btn-primary">Save</button>
                                </div>
                                <div class='p-2'>
                                    <button type="submit" value="submit" name="button" class="btn btn-success">Submit</button>
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
                        <h1 class="modal-title">Edit Company Name</h1>
                    </div>
                    <div class="modal-body">
                        <form id="companyFormEdit" method="POST" action=""
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="company_id" id="company_id">
                            <div class="form-group">
                                <label class="control-label">ID / Software (Must be Unique)</label>
                                <div>
                                    <input type="text" name="id_software" id="id_software"
                                           placeholder="Enter ID / Software"
                                           class="form-control input-lg" required>
                                </div>
                                <br>

                                <label class="control-label">Tax ID</label>
                                <div>
                                    <input type="text" name="tax_id" id="tax_id" placeholder="Enter Tax ID"
                                           class="form-control input-lg" required>
                                </div>
                                <br>

                                <label class="control-label">Company Name</label>
                                <div>
                                    <input type="text" name="company_name" id="company_name"
                                           placeholder="Enter Company Name"
                                           class="form-control input-lg" required>
                                </div>
                                <br>

                                <label class="control-label">Threshold Amount</label>
                                <div>
                                    <input type="number" name="threshold_amount" id="threshold_amount"
                                           placeholder="Enter Threshold Amount"
                                           class="form-control input-lg" required>
                                </div>
                                <br>

                                <label class="control-label">Legal Address</label>
                                <div>
                                    <textarea name="legal_address" id="legal_address" cols="30" rows="10"
                                              class="form-control"></textarea>
                                </div>

                            </div>


                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-success">Update Company</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="tab-content">

            {{--All Datatable--}}
            <div class="overflow-auto">
                <table id="suppliertable" name="suppliertable" class="ui celled table allTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>Initiator</th>
                            <th>Company</th>
                            <th>Department</th>
                            <th>Supplier</th>
                            <th>Type of Expense</th>
                            <th>Currency</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Basis</th>
                            <th>Due Date of Payment</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                        <tr>
                            <td>{{$request['initiator']}}</td>
                            <td>{{$request['company']}}</td>
                            <td>{{$request['department']}}</td>
                            <td>{{$request['supplier']}}</td>
                            <td>{{$request['expense_type']}}</td>
                            <td>{{$request['currency']}}</td>
                            <td>{{$request['amount']}}</td>
                            <td>{{$request['description']}}</td>
                            <td>{{$request['basis']}}</td>
                            <td>{{$request['payment_date']}}</td>
                            <td>{{$request['submission_date']}}</td>
                            <td>{{$request['status']}}</td>
                          <?php  if($request['status'] == "add") { ?>
                            <td>
<a href="">Edit</a>

                            <?php  } else{ ?>
                               
                                <?php }?>
                        </tr>
                        @endforeach
                    </tbody>
                    <!-- <tfoot>
                        <tr>
                            <th>Initiator</th>
                            <th>Company</th>
                            <th>Department</th>
                            <th>Supplier</th>
                            <th>Type of Expense</th>
                            <th>Currency</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Basis (file attachment title)</th>
                            <th>Due Date of Payment</th>
                            <th>Due Date</th>
                            <th>Status</th>
                        </tr>
                    </tfoot> -->
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade modal1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form method="post" action="{{route('super-admin.delete-company')}}">
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
            $('#suppliertable').DataTable();
        });
        $('body').on('click', '#companyEdit', function () {
            var company_id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{url('/super-admin/edit-company/')}}" + '/' + company_id,
                success: function (response) {
                    console.log(response);
                    $('#id_software').val(response.id_software);
                    $('#tax_id').val(response.tax_id);
                    $('#company_name').val(response.name);
                    $('#threshold_amount').val(response.threshold_amount);
                    $('#legal_address').val(response.legal_address);
                    $('#companyFormEdit').attr('action', "{{url('/super-admin/edit-company/')}}" + '/' + company_id);
                }

            });
        });

    </script>
@endsection
