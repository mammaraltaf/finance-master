@extends('admin.admin.app')
@section('pageTitle')
    Company
@endsection
@section('content')
    <!--begin::Header-->
    <style>
        .img-avatar {
            vertical-align: middle;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            cursor: pointer;
            border: 4px solid #1e1e2d;
        }
        .avatar{
            text-align: center;
        }

    </style>
    <br>
    <div class="card-header pt-5">

        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1">Manage Company</span>
        </h3>


    </div>
    <div class="card-toolbar">
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-3">
        <div class="row">
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#ModalLoginForm">
                Add Company
            </button>
        </div>
        <!-- Modal HTML Markup -->
        <div id="ModalLoginForm" class="modal fade">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title">Add Company Name</h1>
                    </div>
                    <div class="modal-body">
                        <form id="categoryForm" method="POST" action="{{route('super-admin.companyPost')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="avatar">
                                <label for="avatar-upload">
                                  <img src="https://res.cloudinary.com/crunchbase-production/image/upload/c_lpad,h_256,w_256,f_auto,q_auto:eco,dpr_1/jtejvun3edchdngsgccx" class="img-avatar" alt="Avatar">
                                </label>
                                <input type="file" class="d-none" id="avatar-upload" name="logo" accept="image/*">
                            </div>
                            {{-- <div id="preview"></div> --}}

                            <div class="form-group">
                                <div>
                                    <input type="hidden" name="id_software" value="{{ Illuminate\Support\Str::random(10) }}"  class="form-control input-lg" required>
                                </div>

                                <label class="control-label">Tax ID</label>
                                <div>
                                    <input type="text" name="tax_id" placeholder="Enter Tax ID"
                                           class="form-control input-lg" required>
                                </div>
                                <br>

                                <label class="control-label">Company Name</label>
                                <div>
                                    <input type="text" name="company_name" placeholder="Enter Company Name"
                                           class="form-control input-lg" required>
                                </div>
                                <br>

                                <label class="control-label">Threshold Amount (GEL)</label>
                                <div>
                                    <input type="number" name="threshold_amount" placeholder="Enter Threshold Amount"
                                           class="form-control input-lg" required>
                                </div>
                                <br>
                                <label class="control-label">BOG Account Number</label>
                                <div>
                                    <input type="text" name="bog" placeholder="Enter BOG Account Number"
                                           class="form-control input-lg" >
                                </div>
                                <br>
                                <label class="control-label">TBC Account Number</label>
                                <div>
                                    <input type="text" name="tbc" placeholder="Enter TBC Account Number"
                                           class="form-control input-lg" >
                                </div>
                                <br>

                                <label class="control-label">Legal Address</label>
                                <div>
                                    <textarea name="legal_address" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                                <br>
{{--                                <label class="control-label">Select Admin</label>--}}
{{--                                <div>--}}
{{--                                    <select name="user_id" class="form-control">--}}
{{--                                        <option value="">Select Admin</option>--}}
{{--                                        @foreach($admins as $admin)--}}
{{--                                            <option value="{{$admin->id}}">{{$admin->name}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
                            </div>

                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-success">Add Company</button>
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
                            <div class="avatar">
                                <label for="edit-avatar-upload">
                                  <img src='' class="img-avatar" alt="Avatar" id="logoedit">
                                </label>
                                <input type="file" class="d-none" id="edit-avatar-upload" name="logo" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Tax ID</label>
                                <div>
                                    <input type="text" name="tax_id" id="tax_id" placeholder="Enter Tax ID"
                                           class="form-control input-lg" required>
                                </div>
                                <br>

                                <label class="control-label">Company Name</label>
                                <div>
                                    <input type="text" name="company_name" id="company_name" placeholder="Enter Company Name"
                                           class="form-control input-lg" required>
                                </div>
                                <br>

                                <label class="control-label">Threshold Amount (GEL)</label>
                                <div>
                                    <input type="number" name="threshold_amount" id="threshold_amount" placeholder="Enter Threshold Amount"
                                           class="form-control input-lg" required>
                                </div>
                                <br>
                                <label class="control-label">BOG Account Number</label>
                                <div>
                                    <input type="text" name="bog" id="bog" placeholder="Enter BOG Account Number"
                                           class="form-control input-lg" >
                                </div>
                                <br>
                                <label class="control-label">TBC Account Number</label>
                                <div>
                                    <input type="text" name="tbc" id="tbc" placeholder="Enter TBC Account Number"
                                           class="form-control input-lg" >
                                </div>
                                <br>

                                <label class="control-label">Legal Address</label>
                                <div>
                                    <textarea name="legal_address" id="legal_address" cols="30" rows="10" class="form-control"></textarea>
                                </div>

                                <br>
{{--                                <label class="control-label">Select Admin</label>--}}
{{--                                <div>--}}
{{--                                    --}}{{-- <select name="user_id" id="user-id" class="form-control" required>--}}
{{--                                        <option value="" disabled>Select Admin</option>--}}
{{--                                        @foreach($admins as $admin)--}}
{{--                                            <option value="{{$admin->id}}">{{$admin->name}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select> --}}
{{--                                    <select name="user_id" id="user-id" class="form-control" required>--}}
{{--                                        <option value="" disabled>Select Admin</option>--}}
{{--                                        @foreach($admins as $admin)--}}
{{--                                            <option value="{{$admin->id}}">{{$admin->name}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
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
        {{--All Datatable--}}
        {{-- <div class="overflow-auto"> --}}
            <table name="companyTable" id="companyTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">

                {{-- <table id="companyTable" name="companyTable" class="ui celled table allTable" style="width:100%"> --}}
                <thead>
                <tr class="text-nowrap text-center">
                    <th class="d-none">Created At</th>
                    <th>Logo</th>
                    <th>ID / Software</th>
                    <th>Tax ID</th>
                    <th>Company Name</th>
                    <th>Threshold Amount</th>
                    <th>BOG</th>
                    <th>TBC</th>
                    <th>Legal Address</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($companies as $company)
                    <tr class="text-nowrap text-center">
                        <td class="d-none">{{formatDate($company['created_at']) ?? ''}}</td>
                        <td><img src="{{asset('image/'.$company->logo)}}" alt="Company Logo" width="50" height="40"></td>
                        <td>{{$company->id_software}}</td>
                        <td>{{$company->tax_id}}</td>
                        <td>{{$company->name}}</td>
                        <td>{{$company->threshold_amount}}</td>
                        <td>{{$company->bog_account_number}}</td>
                        <td>{{$company->tbc_account_number}}</td>
                        <td>{{$company->legal_address}}</td>

                          <td>
                         {{--   <a href="" class="btn btn-primary btn-sm" id="companyEdit"  data-toggle="modal" data-target="#ModalEdit" data-id="{{$company->id}}">Edit</a>
                            <a id="deleteBtn" data-toggle="modal" data-target=".modal1" data-id="{{$company->id}}"
                               class="btn btn-danger delete_btn btn-sm">Delete</a> --}}
                            <i id="companyEdit"  data-toggle="modal" data-target="#ModalEdit" data-id="{{$company->id}}" class="fas px-1  fa-edit cursor-pointer text-primary"></i>
                            <i id="deleteBtn" data-toggle="modal" data-target=".modal1" data-id="{{$company->id}}" class="fa px-1 fa-trash delete_btn cursor-pointer text-danger" aria-hidden="true"></i>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                {{-- <tfoot>
                <tr class="text-nowrap text-center">
                    <th>ID / Software</th>
                    <th>Tax ID</th>
                    <th>Company Name</th>
                    <th>Threshold Amount</th>
                    <th>Legal Address</th>
                    <th>Action</th>
                </tr>
                </tfoot> --}}
            </table>
        {{-- </div> --}}
    </div>
    <div class="modal fade modal1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
{{--                {!! Form::open( array(--}}
{{--                  'url' => route('admin.destroyCategory', array(), false),--}}
{{--                  'method' => 'post',--}}
{{--                  'role' => 'form' )) !!}--}}

                <form method="post" action="{{route('super-admin.delete-company')}}">
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
    {{-- Data table responsive --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>
    {{-- Data table --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
    <script type="text/javascript">

 //zoom in and out
 $(document).ready(function() {
            var initialZoom = 100; 

            function setTableZoom(zoomLevel) {
            $('#companyTable').css('zoom', zoomLevel + '%');
            }

        
            $('#companyTable').on('wheel', function(event) {
            if (event.ctrlKey) {
                event.preventDefault();
                var delta = event.originalEvent.deltaY;
                if (delta > 0) {
                initialZoom -= 10; 
                } else {
                initialZoom += 10;
                }
                setTableZoom(initialZoom);
            }
            });
        });

        $('.delete_btn').click(function () {
            var a = $(this).data('id');
            $('.user-delete').val(a);
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#companyTable').DataTable({
                'order': [[0, 'desc']],
            });
        });

        //Edit Company Get Req
        $('body').on('click', '#companyEdit', function () {
            var company_id = $(this).data('id');
            // console.log(company_id);
            $.ajax({
                type: "GET",
                url: "{{url('/super-admin/edit-company/')}}"+'/'+company_id,
                success:function (response){
                    // console.log(response)
                $('#company_id').val(company_id);
                    $('#id_software').val(response.id_software);
                    $('#tax_id').val(response.tax_id);
                    $('#company_name').val(response.name);
                    $('#threshold_amount').val(response.threshold_amount);
                    $('#legal_address').val(response.legal_address);
                    $('#bog').val(response.bog_account_number);
                    $('#tbc').val(response.tbc_account_number);
                    // $('#logoedit').attr('src',response.logo);
                    // $('#avatar-upload').val(null);
                    // var userType = response.users[0].id;
                    // $('#user-id').val(userType);
                    // console.log("User type", userType)
                    $('#companyFormEdit').attr('action',"{{url('/super-admin/edit-company/')}}"+'/'+company_id);

                    $('#logoedit').attr('src', response.logo);
                    $('#edit-avatar-upload').val(null);
                    if (response.logo) {
                        var logoUrl = "{{url('image')}}/"+response.logo;
                        $('#logoedit').attr('src', logoUrl);
                        $('#logoedit').attr('alt', response.logo);
                        $('#logoedit').siblings('label').html(response.logo);
                    }

                    // Handle logo update
                    $('#edit-avatar-upload').on('change', function() {
                        var logo = $(this)[0].files[0];

                        $("#edit-avatar-upload").val(logo)


                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#logoedit').attr('src', e.target.result);
                            $('#logoedit').siblings('label').html(logo.name);
                        };
                        reader.readAsDataURL(logo);
                    });


                }

            });

        });

        $('#edit-avatar-upload').on('change', function() {
            var logo = $(this)[0].files[0];

            var reader = new FileReader();
            reader.onload = function(e) {
                $('#logoedit').attr('src', e.target.result);
                $('#logoedit').siblings('label').html(logo.name);
            };
            reader.readAsDataURL(logo);
        });

        // Edit company Post Req
        $('body').on('click', '#submitFormBtn', function() {
            var company_id = $(this).data('id');
            var formData = new FormData($('#companyFormEdit')[0]);
            formData.append('logo', $('#edit-avatar-upload')[0].files[0]);
            $.ajax({
                type: 'POST',
                url: "{{ url('/super-admin/edit-company/') }}" + '/' + company_id,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // console.log("response::::::",response);
                    // console.log("form", formData);

                },
                error: function(xhr, status, error) {
                    // console.log(error);
                }
            });
        });


        //=======================
        // Preview Files Start
        //=======================
        // $(document).ready(function() {
        //     $("#avatar-upload").change(function() {
        //         $(".img-avatar").empty(); // Clear the preview div
        //         if(this.files && this.files.length > 0) {
        //             for(let i = 0; i < this.files.length; i++) {
        //                 let file = this.files[i];
        //                 let reader = new FileReader();

        //                 reader.onload = function(e) {
        //                 let fileType = file.type.split('/')[0];
        //                 let previewItem = '';
        //                 if (fileType === 'image') {
        //                     previewItem = '<div class="w-100"><img src="' + e.target.result + '" class="img-thumbnail" width="100%"></div>';
        //                 } else if (fileType === 'application' && file.type === 'application/pdf') {
        //                     previewItem = '<div class=""><embed class="p-2" src="' + e.target.result + '" type="application/pdf" width="100%"></div>';
        //                 } else if (fileType === 'application' && file.type === 'application/msword') {
        //                     previewItem = '<div><i class="far fa-file-word text-primary" style="font-size: 24px; width: 100%;"></i><embed src="' + e.target.result + '" type="application/msword" width="100%"></div>';
        //                 } else {
        //                     previewItem = '<p>' + file.name + ' - ' + file.size + ' bytes</p>';
        //                 }
        //                 $(".img-avatar").append(previewItem);
        //                 };
        //                 reader.readAsDataURL(file);
        //             }
        //         }
        //     });
        // });
        $(document).ready(function() {
            $('#avatar-upload').on('change', function(e) {
                var file = e.target.files[0];
                var reader = new FileReader();

                reader.readAsDataURL(file);

                reader.onload = function(e) {
                $('.img-avatar').attr('src', e.target.result);
                }
            });
        });

        //====================
        // Preview Files End
        //====================
    </script>
@endsection
