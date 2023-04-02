@extends('admin.admin.app')
@section('pageTitle')
    Requests
@endsection
@section('content')

    <!--begin::Header-->
    <br>

    <div class="card-header pt-5">
        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1">Manage Requests</span>
        </h3>
    </div>


    <div class="btn-group">
        <button class="btn btn-info active" data-filter="all">All</button>
        <button class="btn btn-info" data-filter="new">New</button>
        <button class="btn btn-info" data-filter="submitted-for-review">Submitted for review</button>
        <button class="btn btn-info" data-filter="rejected">Rejected</button>
        <button class="btn btn-info" data-filter="finance">Finance ok</button>
        <button class="btn btn-info" data-filter="confirmed">Confirmed</button>
        <button class="btn btn-info" data-filter="paid">Paid</button>
    </div>



    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-3">
        <div class="row">
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#ModalLoginForm">
                Add Request
            </button>
        </div>
        <!-- Modal HTML Markup -->
        <div id="ModalLoginForm" class="modal fade">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title">Add Request</h1>
                    </div>
                    <div class="modal-body">
                        <form id="categoryForm" method="POST" action="{{route('user.addrequest')}}"
                              enctype='multipart/form-data'>
                            @csrf
                            <div class="form-group">
                                <label for="initiator">Initiator</label>
                                <input type="text" class="form-control" id="initiator"
                                       value="<?php echo $user->name;  ?>" readonly>
                                <input type="hidden" name="initiator_id" value="<?php echo $user->name;  ?>">
                            </div>
                            <div class="form-group">
                                <label for="company">Company</label>
                                <select class="form-control" id="company" name="company" required>
                                    <?php foreach ($companies as $company){ ?>
                                    <option
                                        value="{{$company->name}}" {{ $company->user_id == $user->id? 'selected' : '' }}>{{$company->name}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="department">Department</label>
                                <select class="form-control" id="department" name="department" required>
                                    <?php foreach ($departments as $department){ ?>
                                    <option
                                        value="{{$department->name}}" {{ $department->user_id == $user->id? 'selected' : '' }}>{{$department->name}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="supplier">Supplier</label>
                                <select class="form-control" id="supplier" name="supplier" required
                                        placeholder="select a supplier">
                                    <?php foreach ($suppliers as $supplier){ ?>
                                    <option value="{{$supplier->supplier_name}}">{{$supplier->supplier_name}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="expense-type">Type of Expense</label>
                                <select class="form-control" id="expense_type" name="expense_type" required>
                                    <?php foreach ($expenses as $expense){ ?>
                                    <option value="{{$expense->name}}">{{$expense->name}}</option>
                                    <?php } ?>
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
                                <textarea class="form-control" id="description" name="description" rows="3"
                                          required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="basis">Basis</label>
                                <input type="file" class="form-control" id="basis" name="basis[]" multiple required>
                                <div class="d-flex justify-content-between align-items-center" id="preview"></div>
                            </div>
                            <div class="form-group">
                                <label for="due-date-payment">Due Date of Payment</label>
                                <input type="date" class="form-control" id="due-date-payment" name="due-date-payment"
                                       min="<?php echo date('Y-m-d');?>" required>
                            </div>
                            <div class="form-group">
                                <label for="due-date" class="form-label">Due Date</label>
                                <input type="date" class="form-control" id="due-date" name="due-date"
                                       min="<?php echo date('Y-m-d');?>" required>
                            </div>
                            <div class="form-group d-flex gx-5">
                                <div class='p-2'>

                                    <button type="submit" value="{{App\Classes\Enums\StatusEnum::New}}" name="button"
                                            class="btn btn-primary">{{App\Classes\Enums\StatusEnum::New}}</button>
                                </div>
                                <div class='p-2'>
                                    <button type="submit" value="{{App\Classes\Enums\StatusEnum::SubmittedForReview}}"
                                            name="button"
                                            class="btn btn-success">{{App\Classes\Enums\StatusEnum::SubmittedForReview}}</button>
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
                        <h1 class="modal-title">Edit Request</h1>
                    </div>
                    <div class="modal-body">
                        <form id="requestFormEdit" method="POST" action=""
                              enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="reqid" id="reqid">
                            <div class="form-group">
                                <label for="initiator">Initiator</label>
                                <input type="text" class="form-control" id="initiator" name="initiator"
                                       value="<?php echo $user->name;  ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="company">Company</label>
                                <select class="form-control" id="company" name="company" required>
                                    <?php foreach ($companies as $company){ ?>
                                    <option
                                        value="{{$company->name}}" {{ $company->id == $user->id? 'selected' : '' }}>{{$company->name}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="department">Department</label>
                                <select class="form-control" id="department" name="department" required>
                                    <?php foreach ($departments as $department){ ?>
                                    <option
                                        value="{{$department->name}}" {{ $department->user_id == $user->id? 'selected' : '' }}>{{$department->name}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="supplier">Supplier</label>
                                <select class="form-control" id="supplier" name="supplier" required>
                                    <?php foreach ($suppliers as $supplier){ ?>
                                    <option value="{{$supplier->supplier_name}}">{{$supplier->supplier_name}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="expense-type">Type of Expense</label>
                                <select class="form-control" id="expense-type" name="expense-type" required>

                                    <?php foreach ($expenses as $expense){ ?>
                                    <option value="{{$expense->name}}">{{$expense->name}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="currency">Currency</label>
                                <select class="form-control" id="currency" name="currency" required>
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                    <option value="GEL">GEL</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" id="amount2" name="amount" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description2" rows="3" name="description"
                                          required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="basis">Basis</label>
                                <input type="file" class="form-control" multiple id="basis2" name="basis[]">
                                <input type="hidden" id="basis3" name="basis3">
                                <div class="text-danger" id="fileList"></div>
                                <div id="previousFiles">
                                  <!-- Show previously uploaded files here -->
                                </div>
                              </div>
                              
                            <div class="form-group">
                                <label for="due-date-payment">Due Date of Payment</label>
                                <input type="date" class="form-control" id="due-date-payment2" name="due-date-payment2"
                                       min='<?php echo date('Y-m-d');?>' required>
                            </div>
                            <div class="form-group">
                                <label for="due-date" class="form-label">Due Date</label>
                                <input type="date" class="form-control" id="due-date2" name="due-date2"
                                       min='<?php echo date('Y-m-d');?>' required>
                            </div>
                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-success">Update Request</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
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
                        @hasanyrole('super-admin|accounting|user')
                        <th>Actions</th>
                        @endhasanyrole
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($requests as $request)
                        <tr data-status="{{$request['status']}}">
                            <td>{{$request['initiator']}}</td>
                            <td>{{$request['company']}}</td>
                            <td>{{$request['department']}}</td>
                            <td>{{$request['supplier']}}</td>
                            <td>{{$request['expense_type']}}</td>
                            <td>{{$request['currency']}}</td>
                            <td>{{$request['amount']}}</td>
                            <td>{{$request['description']}}</td>
                            <td><?php
                            if(isset($request['basis'])){ 
                                $files=explode(',',$request['basis']);
                                foreach($files as $file){ ?>
<a href="{{asset('basis/'.$file)}}" target="_blank">{{$file}}</a>

                        <?php  }   }else{
                               echo "No document available";
                            }
                            ?></td>
                            <td>{{$request['payment_date']}}</td>
                            <td>{{$request['submission_date']}}</td>
                            <td>{{$request['status']}}</td>
                            @hasanyrole('super-admin|accounting|user')
                            <?php if ($request['status'] == "new") { ?>
                            <td>
                                <a href="" class="btn btn-primary btn-sm" id="userEdit" data-toggle="modal"
                                   data-target="#ModalEdit" data-id="{{$request->id}}">Edit</a>
                                <a id="deleteBtn" data-toggle="modal" data-target=".modal1" data-id="{{$request->id}}"
                                   class="btn btn-danger delete_btn btn-sm">Delete</a></td>
                            <?php }
                            elseif ($request['status'] == "submitted-for-review}}") {

                            } else { ?>

                            <?php } ?>
                            @endhasanyrole

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade modal1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form method="post" action="{{route('user.delete-request')}}">
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

        // Preview Start
        $(document).ready(function() {
            $("#basis").change(function() {
                $("#preview").empty(); // Clear the preview div
                if(this.files && this.files.length > 0) {
                    for(let i = 0; i < this.files.length; i++) {
                        let file = this.files[i];
                        let reader = new FileReader();
                        reader.onload = function(e) {
                        let fileType = file.type.split('/')[0];
                        let previewItem = '';
                        if (fileType === 'image') {
                            previewItem = '<div class="w-100"><img src="' + e.target.result + '" class="img-thumbnail" width="100%"></div>';
                        } else if (fileType === 'application' && file.type === 'application/pdf') {
                            previewItem = '<div class=""><embed class="p-2" src="' + e.target.result + '" type="application/pdf" width="100%"></div>';
                        } else if (fileType === 'application' && file.type === 'application/msword') {
                            previewItem = '<div><i class="far fa-file-word text-primary" style="font-size: 24px; width: 100%;"></i><embed src="' + e.target.result + '" type="application/msword" width="100%"></div>';
                        } else {
                            previewItem = '<p>' + file.name + ' - ' + file.size + ' bytes</p>';
                        }
                        $("#preview").append(previewItem);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });
        });
        // Preview End

        //=============================
        // Edit Document Preview Start
        //=============================

        $('body').on('click', '#userEdit', function () {
            var request_id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{url('/user/edit-request/')}}" + '/' + request_id,
                success: function (response) {
                console.log(response);
                $('#reqid').val(response.id);
                $('#amount2').val(response.amount);
                $('#description2').val(response.description);
                $('#due-date-payment2').val(response.payment_date);
                $('#due-date2').val(response.submission_date);
                $('#requestFormEdit').attr('action', "{{url('/user/edit-request/')}}" + '/' + request_id);
                    // Show previously uploaded files
                    if (response.basis) {
                        var docs2 = [];
                        var files = response.basis.split(',');
                        var fileHtml = '';
                        for (var i = 0; i < files.length; i++) {
                        var fileName = files[i];
                      fileHtml += '<div><a href="{{asset('basis')}}' +'/'+ fileName + '" target="_blank">' + fileName + '</a> <div  class="text-danger cursor-pointer remove-file" data-file="' + fileName + '">X</div></div>';
                      docs2.push(fileName);
                    }  
                        $('#previousFiles').html(fileHtml);
                        $('#basis3').val(docs2);
                    }
                }
            });
        });

            // Bind a click event to the "Remove" button
            $('body').on('click', '.remove-file', function() {
            var fileName = $(this).data('file');
            $(this).parent().remove(); 
            });
        //=============================
        // Edit Document Preview End
        //=============================

        //=============================
        // Edit Document Preview Start
        //=============================
        



// Remove file event
$('body').on('click', '.remove-btn', function () {
    $(this).siblings('input.remove-file').prop('checked', true);
    $(this).parent().hide();
});

        // Data Filter Start
        $(document).ready(function () {
            $(".btn-group button").click(function () {
                var filterValue = $(this).attr('data-filter');
                console.log("filterValue", filterValue)
                $("#suppliertable tbody tr").hide();
                $("#suppliertable tbody tr[data-status='" + filterValue + "']").show();
                if (filterValue === "all") {
                    $("#suppliertable tbody tr").show();
                } else {
                    $("#suppliertable tbody tr").hide();
                    $("#suppliertable tbody tr[data-status='" + filterValue + "']").show();
                }
                $(".btn-group button").removeClass("active");
                $(this).addClass("active");
            });
        });
    </script>
@endsection
