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


    <div class="">
        <button id="all" class="btn btn-info active filter">All</button>
{{--        <button class="btn btn-info" data-filter="new">New</button>--}}
        <button id="review" class="btn btn-info filter" >Submitted for review</button>
        <button id="rejected" class="btn btn-info filter" >Rejected</button>
        <button id="finance" class="btn btn-info filter" >Finance ok</button>
        <button id="confirmed" class="btn btn-info filter" >Confirmed</button>
        <button id="paid" class="btn btn-info filter" >Paid</button>
    </div>



    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-3">
        <div class="row">
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#ModalLoginForm">
                Add Request
            </button>
        </div>
        <!-- Add Request Modal -->
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
                            <div class="d-flex">
                                <div class="form-group w-100 px-2">
                                    <label for="initiator">Initiator</label>
                                    <input type="text" class="form-control" id="initiator"
                                           value="<?php echo $user->name;  ?>" readonly>
                                    <input type="hidden" name="initiator_id" value="<?php echo $user->name;  ?>">
                                </div>
                                <div class="form-group w-100 px-2">
                                    <label for="company">Company</label>
                                    <select class="form-control" id="company" name="company" required>
                                        <?php foreach ($companies as $company){ ?>
                                        <option
                                            value="{{$company->id}}" {{ $company->user_id == $user->id? 'selected' : '' }}>{{$company->name}}</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="form-group w-100 px-2">
                                    <label for="department">Department</label>
                                    <select class="form-control" id="department" name="department" required>
                                        <?php foreach ($departments as $department){ ?>
                                        <option
                                            value="{{$department->id}}" {{ $department->user_id == $user->id? 'selected' : '' }}>{{$department->name}}</option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group w-100 px-2">
                                    <label for="supplier">Supplier</label>
                                    <select class="form-control" id="supplier" name="supplier" required
                                            placeholder="select a supplier">
                                        <?php foreach ($suppliers as $supplier){ ?>
                                        <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="form-group w-100 px-2">
                                    <label for="expense-type">Type of Expense</label>
                                    <select class="form-control" id="expense_type" name="expense_type" required>
                                        <?php foreach ($expenses as $expense){ ?>
                                        <option value="{{$expense->id}}">{{$expense->name}}</option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group w-100 px-2">
                                    <label for="currency">Currency</label>
                                    <select class="form-control currency" id="currency" name="currency" required>
                                        <option value="">Select a currency</option>
                                        <option value="USD">USD</option>
                                        <option value="EUR">EUR</option>
                                        <option value="GEL">GEL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="form-group w-100 px-2">
                                    <label for="amount">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" required>
                                </div>
                                <div class="form-group w-100 px-2">
                                    <label for="gel-amount">Amount in GEL:</label>
                                    <input type="text" class="form-control" name="amount_in_gel" id="gel-amount" readonly>
                                </div>
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
                            <div class="d-flex">
                                <div class="form-group w-100 px-2">
                                    <label for="due-date-payment">Due Date of Payment</label>
                                    <input type="date" class="form-control" id="due-date-payment" name="due-date-payment"
                                           min="<?php echo date('Y-m-d');?>" required>
                                </div>
                                <div class="form-group w-100 px-2">
                                    <label for="due-date" class="form-label">Due Date</label>
                                    <input type="date" class="form-control" id="due-date" name="due-date"
                                           min="<?php echo date('Y-m-d');?>" required>
                                </div>
                            </div>
                            <div class="form-group d-flex gx-5">
{{--                                <div class='p-2'>--}}

{{--                                    <button type="submit" value="{{App\Classes\Enums\StatusEnum::New}}" name="button"--}}
{{--                                            class="btn btn-primary">{{App\Classes\Enums\StatusEnum::New}}</button>--}}
{{--                                </div>--}}
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
        </div>
        <!-- /.modal -->
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
                            <div class="d-flex align-items-center">
                                <div class="form-group w-100 px-2">
                                    <label for="initiator">Initiator</label>
                                    <input type="text" class="form-control" id="initiator" name="initiator"
                                           value="<?php echo $user->name;  ?>" readonly>
                                </div>
                                <div class="form-group w-100 px-2">
                                    <label for="company">Company</label>
                                    <select class="form-control" id="company" name="company" required>
                                        <?php foreach ($companies as $company){ ?>
                                        <option
                                            value="{{$company->id}}" {{ $company->id == $user->id? 'selected' : '' }}>{{$company->name}}</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="form-group w-100 px-2">
                                    <label for="department">Department</label>
                                    <select class="form-control" id="department" name="department" required>
                                        <?php foreach ($departments as $department){ ?>
                                        <option
                                            value="{{$department->id}}" {{ $department->user_id == $user->id? 'selected' : '' }}>{{$department->name}}</option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group w-100 px-2">
                                    <label for="supplier">Supplier</label>
                                    <select class="form-control" id="supplier" name="supplier" required>
                                        <?php foreach ($suppliers as $supplier){ ?>
                                        <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="form-group w-100 px-2">
                                    <label for="expense-type">Type of Expense</label>
                                    <select class="form-control" id="expense-type" name="expense-type" required>

                                        <?php foreach ($expenses as $expense){ ?>
                                        <option value="{{$expense->id}}">{{$expense->name}}</option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group w-100 px-2">
                                    <label for="currency">Currency</label>
                                    <select class="form-control edit-current" id="edit_currency" name="currency" required>
                                        <option value="USD">USD</option>
                                        <option value="EUR">EUR</option>
                                        <option value="GEL">GEL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="form-group w-100 px-2">
                                    <label for="amount">Amount</label>
                                    <input type="number" class="form-control" id="amount2" name="amount" required>
                                </div>

                                <div class="form-group w-100 px-2">
                                    <label for="gel-amount">Amount in GEL:</label>
                                    <input type="text" class="form-control" id="gel-amount2" name="gel-amount2" readonly>
                                </div>

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

                            <div class="d-flex align-items-center">
                                <div class="form-group w-100 px-2">
                                    <label for="due-date-payment">Due Date of Payment</label>
                                    <input type="date" class="form-control" id="due-date-payment2" name="due-date-payment2" min='<?php echo date('Y-m-d');?>' required>
                                </div>
                                <div class="form-group w-100 px-2">
                                    <label for="due-date" class="form-label">Due Date</label>
                                    <input type="date" class="form-control" id="due-date2" name="due-date2"
                                           min='<?php echo date('Y-m-d');?>' required>
                                </div>
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
        </div>

        <div class="overflow-auto">

            {{--All Datatable--}}
            {{-- <div class="overflow-auto"> --}}
            <table name="suppliertable" id="suppliertable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr class="text-nowrap text-center">
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
                        @hasanyrole('super-admin|accounting')
                        <th>Actions</th>
                        @endhasanyrole
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($requests as $request)
                        <tr class="text-nowrap text-center" data-status="{{$request['status']}}">
                            <td>{{$request->initiator}}</td>
                            <td>{{$request->company->name}}</td>
                            <td>{{$request->department->name}}</td>
                            <td>{{$request->supplier->supplier_name}}</td>
                            <td>{{$request->typeOfExpense->name}}</td>
                            <td>{{$request->currency}}</td>
                            <td>{{$request->amount}}</td>
                            <td>{{$request->description}}</td>
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

                        </tr>
                    @endforeach
                    </tbody>
            </table>
            {{-- </div> --}}
        </div>
    </div>
    {{-- Delete Modal --}}
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
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>
{{--
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script> --}}

    <script type="text/javascript">
     $('#suppliertable').DataTable();
        $('.delete_btn').click(function () {
            var a = $(this).data('id');
            $('.user-delete').val(a);
        });
    </script>
    <script type="text/javascript">
        var basisFiles2 = '';

        // Preview Start
        $(document).ready(function () {
            // $('#suppliertable').DataTable();

            var d = new Date();

            var month = d.getMonth()+1;
            var day = d.getDate();

            var currentDate = d.getFullYear() + '/' +
                ((''+month).length<2 ? '0' : '') + month + '/' +
                ((''+day).length<2 ? '0' : '') + day;

            $("#basis").change(function () {
                $("#preview").empty(); // Clear the preview div
                if (this.files && this.files.length > 0) {
                    for (let i = 0; i < this.files.length; i++) {
                        let file = this.files[i];
                        let reader = new FileReader();
                        reader.onload = function (e) {
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
            // Preview End

            $("#currency").change(function() {
                var currency = $(this).val();
                var amount = $("#amount").val();
                console.log("currency", currency)
                if (currency != "GEL" && amount != "") {
                    $.ajax({
                        url: "https://nbg.gov.ge/gw/api/ct/monetarypolicy/currencies/ka/json/?date="+currentDate,
                        dataType: "json",
                        success: function(data) {
                            if(currency === "USD"){
                                var rate = data[0].currencies[40].rate;
                            }
                            if(currency === "EUR"){
                                var rate = data[0].currencies[13].rate;
                            }
                            if (rate) {
                                var gelAmount = amount * rate;
                                $("#gel-amount").val(gelAmount.toFixed(2));
                            }
                        }
                    });
                } else {
                    $("#gel-amount").val(amount);
                }
            });

            /*for edit*/
            $("#edit_currency").change(function() {
                var currency = $(this).val();
                var amount = $("#amount2").val();
                console.log("currency", amount, currency);
                if (currency != "GEL" && amount != "") {
                    $.ajax({
                        url: "https://nbg.gov.ge/gw/api/ct/monetarypolicy/currencies/ka/json/?date="+currentDate,
                        dataType: "json",
                        success: function(data) {
                            if(currency === "USD"){
                                var rate = data[0].currencies[40].rate;
                            }
                            if(currency === "EUR"){
                                var rate = data[0].currencies[13].rate;
                            }
                            if (rate) {
                                var gelAmount = amount * rate;
                                $("#gel-amount2").val(gelAmount.toFixed(2));
                            }
                        }
                    });
                } else {
                    $("#gel-amount").val(amount);
                }
            });

            $("#amount").keyup(function() {
                $("#currency").trigger("change");
            });
            $("#amount2").keyup(function() {
                $("#edit_currency").trigger("change");
            });
        });

        $(document).ready(function() {
            var maxLength = 500; 
            var description = $('#description');
            var counter = $('<span class="char-count">0/' + maxLength + ' Characters</span>').insertAfter(description);
            var submitBtn = $('button[name="button"]');
            
            description.on('input', function() {
                var length = description.val().length;
                counter.text(length + '/' + maxLength + ' Characters');
                
                if (length > maxLength) {
                    description.addClass('is-invalid');
                    submitBtn.prop('disabled', true);
                } else {
                    description.removeClass('is-invalid');
                    submitBtn.prop('disabled', false);
                }
            });
        });


        //=============================
        // Edit Document Preview Start
        //=============================
        var removedFiles = [];


        $('body').on('click', '#userEdit', function () {
            var request_id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{url('/user/edit-request/')}}" + '/' + request_id,
                success: function (response) {
                console.log("response", response);
                $('#reqid').val(response.id);
                $('#amount2').val(response.amount);
                $('#description2').val(response.description);
                $('#basis2').val(removedFiles);
                $('#due-date-payment2').val(response.payment_date);
                $('#due-date2').val(response.submission_date);
                $('#gel-amount2').val(response.amount_in_gel);


                $('#requestFormEdit').attr('action', "{{url('/user/edit-request/')}}" + '/' + request_id);
                    // Show previously uploaded files
                    basisFiles2 = response.basis;
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
                    $('#previousFiles').html(fileHtml);
                    $('#basis3').val(docs2);
                }
            })
        })
        $('body').on('click', '.remove-file', function () {
            var fileName = $(this).data('file');
            $(this).parent().remove();
            // removedFiles.push(fileName);
            var basisFiles = $('#basis3').val().split(',');
            // Find the index of the removed file in the array
            var index = basisFiles.indexOf(fileName);
            // If the file is in the array, remove it
            if (index > -1) {
                basisFiles.splice(index, 1);
            }
            // Convert the array to a comma-separated string and set it as the value of the basis3 field
            $('#basis3').val(basisFiles.join(','));
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
        // $(document).ready(function () {
        //     $(".btn-group button").click(function () {
        //         var filterValue = $(this).attr('data-filter');
        //         console.log("filterValue", filterValue)
        //         $("#suppliertable").hide();
        //         $("#suppliertable tbody tr[data-status='" + filterValue + "']").show();
        //         if (filterValue === "all") {
        //             $("#suppliertable").show();
        //         } else {
        //             $("#suppliertable").hide();
        //             $("#suppliertable tr[data-status='" + filterValue + "']").show();
        //         }
        //         $(".btn-group button").removeClass("active");
        //         $(this).addClass("active");
        //     });
        // });

        $(document).ready(function() {
            // listen for click events on all the buttons
            $('.filter').click(function() {
                // get the id of the clicked button
                var buttonId = $(this).attr('id');
                // log the button name to the console
                console.log(buttonId);

                var url = "{{ route('user.filter', ':id') }}";
                url = url.replace(':id', buttonId);
                location.href = url;
            });
        });

    </script>
@endsection
