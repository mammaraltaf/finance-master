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
                                <input type="file" class="d-none" id="avatar-upload" accept="image/*">
                            </div>

                            <div class="form-group">
                                <label class="control-label">ID / Software (Must be Unique)</label>
                                <div>
                                    <input type="text" name="id_software" placeholder="Enter ID / Software"
                                           class="form-control input-lg" required>
                                </div>
                                <br>

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

                                <label class="control-label">Legal Address</label>
                                <div>
                                    <textarea name="legal_address" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="basis">Basis</label>
                                    <input type="file" class="form-control" id="basis" name="basis[]" multiple required>
                                    <div class="d-flex justify-content-between align-items-center" id="preview"></div>
                                </div>
                                <br>
                                <label class="control-label">Select Admin</label>
                                <div>
                                    <select name="user_id" class="form-control">
                                        <option value="">Select Admin</option>
                                        @foreach($admins as $admin)
                                            <option value="{{$admin->id}}">{{$admin->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
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
                            <div class="form-group">
                                <label class="control-label">ID / Software (Must be Unique)</label>
                                <div>
                                    <input type="text" name="id_software" id="id_software" placeholder="Enter ID / Software"
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

                                <label class="control-label">Legal Address</label>
                                <div>
                                    <textarea name="legal_address" id="legal_address" cols="30" rows="10" class="form-control"></textarea>
                                </div>

                                <br>
                                <label class="control-label">Select Admin</label>
                                <div>
                                    <select name="user_id" id="user_id" class="form-control">
                                        <option value="">Select Admin</option>
                                        @foreach($admins as $admin)
                                            <option value="{{$admin->id}}">{{$admin->name}}</option>
                                        @endforeach
                                    </select>
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
            <table id="companyTable" name="companyTable" class="ui celled table allTable" style="width:100%">
                <thead>
                <tr class="text-nowrap text-center">
                    <th>ID / Software</th>
                    <th>Tax ID</th>
                    <th>Company Name</th>
                    <th>Threshold Amount</th>
                    <th>Legal Address</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($companies as $company)
                    <tr class="text-nowrap text-center">
                        <td>{{$company->id_software}}</td>
                        <td>{{$company->tax_id}}</td>
                        <td>{{$company->name}}</td>
                        <td>{{$company->threshold_amount}}</td>
                        <td>{{$company->legal_address}}</td>

                          <td>
                         {{--   <a href="" class="btn btn-primary btn-sm" id="companyEdit"  data-toggle="modal" data-target="#ModalEdit" data-id="{{$company->id}}">Edit</a>
                            <a id="deleteBtn" data-toggle="modal" data-target=".modal1" data-id="{{$company->id}}"
                               class="btn btn-danger delete_btn btn-sm">Delete</a> --}}
                            <i id="companyEdit"  data-toggle="modal" data-target="#ModalEdit" data-id="{{$company->id}}" class="fas px-1 fa-edit cursor-pointer text-primary"></i>
                            <i id="deleteBtn" data-toggle="modal" data-target=".modal1" data-id="{{$company->id}}" class="fa px-1 fa-trash cursor-pointer text-danger" aria-hidden="true"></i>
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
        </div>
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

    <div class="container-fluid">
        <!-- Document List -->
        <div class="row">
          <div class="col-12">
            <h2>Document List</h2>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Status</th>
                  <th>Directory</th>
                  <th>Project</th>
                  <th>Initiator</th>
                  <th>Supplier</th>
                </tr>
              </thead>
              <tbody>
                <!-- Sample data for document list -->
                <tr>
                  <td>Confirmed</td>
                  <td>Directory A</td>
                  <td>Project X</td>
                  <td>John Doe</td>
                  <td>Supplier Y</td>
                </tr>
                <tr>
                  <td>Paid</td>
                  <td>Directory B</td>
                  <td>Project Y</td>
                  <td>Jane Smith</td>
                  <td>Supplier Z</td>
                </tr>
                <!-- End of sample data -->
              </tbody>
            </table>
          </div>
        </div>

        <!-- Filter -->
        <div class="row">
          <div class="col-12">
            <h2>Filter</h2>
            <form>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="status">Status</label>
                  <select id="status" class="form-control">
                    <option selected>All</option>
                    <option>Confirmed</option>
                    <option>Paid</option>
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="directory">Directory</label>
                  <input type="text" class="form-control" id="directory">
                </div>
                <div class="form-group col-md-4">
                  <label for="project">Project</label>
                  <input type="text" class="form-control" id="project">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="initiator">Initiator</label>
                  <input type="text" class="form-control" id="initiator">
                </div>
                <div class="form-group col-md-4">
                  <label for="supplier">Supplier</label>
                  <input type="text" class="form-control" id="supplier">
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Filter</button>
            </form>
          </div>
        </div>

        <!-- Weekly Paid Report -->
        <div class="row">
          <div class="col-12">
            <h2>Weekly Paid Report</h2>
            <form>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="start-date">Start Date</label>
                  <input type="date" class="form-control" id="start-date">
                </div>
                <div class="form-group col-md-6">
                  <label for="end-date">End Date</label>
                  <input type="date" class="form-control" id="end-date">
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Generate Report</button>
            </form>
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
            $('#companyTable').DataTable();
        });
        $('body').on('click', '#companyEdit', function () {
            var company_id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{url('/super-admin/edit-company/')}}"+'/'+company_id,
                success:function (response){
                    console.log(response);
                    $('#id_software').val(response.id_software);
                    $('#tax_id').val(response.tax_id);
                    $('#company_name').val(response.name);
                    $('#threshold_amount').val(response.threshold_amount);
                    $('#legal_address').val(response.legal_address);
                    $('#user_id').val(response.user_id);
                    $('#companyFormEdit').attr('action',"{{url('/super-admin/edit-company/')}}"+'/'+company_id);
                }

            });
        });
        //====================
        // Avatar upload
        //====================
        const avatarUpload = document.getElementById("avatar-upload");
            const avatarImage = document.querySelector(".avatar img");

            avatarUpload.addEventListener("change", () => {
            const file = avatarUpload.files[0];
            const reader = new FileReader();

            reader.addEventListener("load", () => {
                avatarImage.src = reader.result;
            });

            if (file) {
                reader.readAsDataURL(file);
            }
        });

        //=======================
        // Preview Files Start
        //=======================
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
        //====================
        // Preview Files End
        //====================
    </script>
@endsection
