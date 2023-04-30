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
            <span class="card-label fw-bolder fs-3 mb-1">My Company</span>
        </h3>


    </div>
    <div class="card-toolbar">
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-3">

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
                                <label class="control-label">ID / Software (Must be Unique)</label>
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

            <table name="companyTable" id="companyTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">

                {{-- <table id="companyTable" name="companyTable" class="ui celled table allTable" style="width:100%"> --}}
                <thead>
                <tr class="text-nowrap text-center">
                    <th>ID</th>
                    <th>Logo</th>
                    <th>Created At</th>
                    <th>ID / Software</th>
                    <th>Tax ID</th>
                    <th>Company Name</th>
                    <th>Threshold Amount</th>
                    <th>Legal Address</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($companys as $company)
                    <tr class="text-nowrap text-center">
                        <td>{{$company->id ?? ''}}</td>
                        <td><img src="{{asset('image/'.$company->logo)}}" alt="Company Logo" width="50" height="40"></td>
                        <td>{{\Carbon\Carbon::parse($company['created_at']) ?? ''}}</td>
                        <td>{{$company->id_software}}</td>
                        <td>{{$company->tax_id}}</td>
                        <td>{{$company->name}}</td>
                        <td>{{$company->threshold_amount}}</td>
                        <td>{{$company->legal_address}}</td>

                          <td>
                         {{--   <a href="" class="btn btn-primary btn-sm" id="companyEdit"  data-toggle="modal" data-target="#ModalEdit" data-id="{{$company->id}}">Edit</a>
                            <a id="deleteBtn" data-toggle="modal" data-target=".modal1" data-id="{{$company->id}}"
                               class="btn btn-danger delete_btn btn-sm">Delete</a> --}}
                            <i id="companyEdit"  data-toggle="modal" data-target="#ModalEdit" data-id="{{$company->id}}" class="fas px-1  fa-edit cursor-pointer text-primary"></i>

                        </td>
                    </tr>
                @endforeach
                </tbody>

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
        $('.delete_btn').click(function () {
            var a = $(this).data('id');
            $('.user-delete').val(a);
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#companyTable').DataTable({
                'order': [[2, 'desc']],
            });
        });

        //Edit Company Get Req
        $('body').on('click', '#companyEdit', function () {
            var company_id = $(this).data('id');
            console.log(company_id);
            $.ajax({
                type: "GET",
                url: "{{url('/admin/edit-company/')}}"+'/'+company_id,
                success:function (response){
                    console.log(response)
                $('#company_id').val(company_id);
                    $('#id_software').val(response.id_software);
                    $('#tax_id').val(response.tax_id);
                    $('#company_name').val(response.name);
                    $('#threshold_amount').val(response.threshold_amount);
                    $('#legal_address').val(response.legal_address);
                    // $('#logoedit').attr('src',response.logo);
                    // $('#avatar-upload').val(null);
                    var userType = response.users[0].id;
                    $('#user-id').val(userType);
                    console.log("User type", userType)
                    $('#companyFormEdit').attr('action',"{{url('/admin/edit-company/')}}"+'/'+company_id);

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
            console.log(company_id);
            var formData = new FormData($('#companyFormEdit')[0]);
            formData.append('logo', $('#edit-avatar-upload')[0].files[0]);
            $.ajax({
                type: 'POST',
                url: "{{ url('/admin/edit-company/') }}" + '/' + company_id,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log("response::::::",response);
                    console.log("form", formData);

                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });


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
