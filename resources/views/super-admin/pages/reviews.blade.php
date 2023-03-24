@extends('admin.admin.app')
@section('pageTitle')
    User Reviews
@endsection
@section('content')
    <!--begin::Header-->

    <div class="card-header pt-5">
        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1">User Reviews</span>
        </h3>

    </div>
    <div class="card-toolbar">
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-3">
        <div class="row">
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#ModalLoginForm">
                Add Review
            </button>
        </div>
        <!-- Modal HTML Markup -->
        <div id="ModalLoginForm" class="modal fade">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title">Add Review</h1>
                    </div>
                    <div class="modal-body">
                        <form id="reviewForm" method="POST" action="{{route('admin.reviewsPost')}}"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label class="control-label">Enter User Name</label>
                                <div>
                                    <input type="text" name="customer_name" placeholder="Enter Name"
                                           class="form-control input-lg" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Enter Service Name</label>
                                <div>
                                    <select name="service" class="form-control input-lg" id="service" style="height: auto;" required>
                                        <option value="" id="">---Select Service---</option>
                                        @isset($services)
                                            @foreach($services as $service)
                                                <option value="{{$service->id}}" id="{{$service->id}}">{{$service->service_name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Upload Picture</label>
                                <div>
                                    <input type="file" name="image" class="form-control input-lg" required>
{{--                                    <label for="" class="form-label">Thumbnail Image<span style="color:red">*</span></label>--}}
{{--                                    <input type="hidden" name="thumnailImage" value="{{$editPressRelease->thumnailImage}}">--}}
{{--                                    <img class="mt-2" id="img-preview" src="{{asset('upload/PressReleaseThumbnail/'.$editPressRelease->thumnailImage)}}" alt="{{ ($editPressRelease->thumnailImage ?? '') }}" style="height: 150px; display: block;">--}}
{{--                                    <input style="width: 120px; opacity: 0.01; cursor: pointer;" id="file1" type="file" class="form-control" name="image" value="{{$editPressRelease->thumnailImage}}" />--}}
{{--                                    <label style="margin-top: -30px; padding: 7px; background: #009ef7; width: 120px; padding-left: 15px; color: white; display: block;">Change Image</label>--}}
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label">Enter Review</label>
                                <div>
                                    <textarea rows="3" cols="5" class="form-control" name="review"
                                              placeholder="Enter Review"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-success">Add Review</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        {{--Edit Modal--}}
        <div id="EditModalForm" class="modal fade">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title">Edit Review</h1>
                    </div>
                    <div class="modal-body">
                        <form id="reviewFormEdit" method="POST" action=""
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="review_id" id="review_id">

                            <div class="form-group">
                                <label class="control-label">Enter User Name</label>
                                <div>
                                    <input type="text" name="customer_name" id="customer_name" placeholder="Enter Name"
                                           class="form-control input-lg" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Enter Service Name</label>
                                <div>
                                    <select name="service" class="form-control input-lg" id="serviceDropdownEdit" style="height: auto;" required>
                                        <option value="" id="">---Select Service---</option>
                                        @isset($services)
                                            @foreach($services as $service)
                                                <option value="{{$service->id}}" data-id="{{$service->id}}" value="{{$service->id}}">{{$service->service_name}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Upload Picture</label>
                                <div>
                                    <input type="hidden" name="imageName" value="">
                                    <img id="img-preview" src="{{asset('assests/photo1.jpg')}}" alt="" style="height: 150px; display: block;">
                                    <input style="width: 120px; opacity: 0.01; cursor: pointer;" id="file1" type="file" class="form-control" name="image" value="" />
                                    <label style="margin-top: -30px; padding: 7px; background: #1ab394; width: 120px; padding-left: 15px; color: white; display: block;">Change Image</label>
{{--                                    <input type="file" name="image" id="editImage" class="form-control input-lg" required>--}}
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label">Enter Review</label>
                                <div>
                                    <textarea rows="3" cols="5" id="review" class="form-control" name="review"
                                              placeholder="Enter Review"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-success">Update Review</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="tab-content">

            {{--All Datatable--}}
            <table id="example" name="allTable" class="ui celled table allTable" style="width:100%">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Service Name</th>
                    <th>Picture</th>
                    <th>Review</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reviews as $review)
                    @php
                        $service = \App\Models\Service::where('id',$review->service)->first();
                        @endphp
                    <tr>
                        <td>{{$review->customer_name ?? ''}}</td>
                        <td>{{$service->service_name ?? ''}}</td>
                        <td>
                            <img src="{{asset('upload/reviews/'.$review->image)}}" alt="" width="70px" height="70px">
{{--                            {{$review->image ?? ''}}--}}
                        </td>
                        <td>{{$review->review ?? ''}}</td>
                        <td>
                            <a href="{{url('admin/edit-service',$review->id)}}" class="btn btn-primary btn-sm"
                               data-id="{{$review->id}}" id="editReview" data-toggle="modal" data-target="#EditModalForm">Edit</a>

                            <a id="deleteBtn" data-toggle="modal" data-target=".modal1" data-id="{{$review->id}}"
                               class="btn btn-danger delete_btn btn-sm">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Username</th>
                    <th>Service Name</th>
                    <th>Picture</th>
                    <th>Review</th>
                    <th>Action</th>

                </tr>
                </tfoot>
            </table>
            <div class="modal fade modal1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        {{--                {!! Form::open( array(--}}
                        {{--                  'url' => route('admin.destroyCategory', array(), false),--}}
                        {{--                  'method' => 'post',--}}
                        {{--                  'role' => 'form' )) !!}--}}

                        <form method="post" action="{{route('admin.destroyReview')}}">
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
            $('#example').DataTable();
        });
        $('body').on('click', '#editReview', function () {
            var review_id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{url('/admin/edit-review/')}}"+'/'+review_id,
                success:function (response){
                    console.log(response);
                    $('#customer_name').val(response.customer_name);
                    $('#review').val(response.review);
                    $('#serviceDropdownEdit').prop('selectedIndex', response.service);
                    $("#img-preview").attr("src","http://ustadhere.test/upload/reviews/"+response.image);
                    $('#reviewFormEdit').attr('action',"{{url('/admin/edit-review/')}}"+'/'+review_id);
                }

            });
        });
    </script>
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#img-preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#file1").change(function() {
            readURL(this);
        });
    </script>
@endsection
