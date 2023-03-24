@extends('admin.admin.app')
@section('pageTitle') Services @endsection
@section('content')
    <!--begin::Header-->
<br>
    <div class="card-header pt-5">

        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1">Manage Services</span>
        </h3>
    </div>
    <div class="card-toolbar">
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-3">
        <div class="row">
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#ModalLoginForm">
                Add Service
            </button>
        </div>
        <!-- Modal HTML Markup -->
        <div id="ModalLoginForm" class="modal fade">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title">Add Service Name</h1>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('admin.servicesPost') }}">
                            @csrf
                            <div class="form-group">
                                <label class="control-label">Select Category</label>
                                <div class="input-group">
                                    <select id="categoryDropdown" class="form-control" name="category" style="width: 100%; height:100%;" tabindex="-1" aria-hidden="true" required>
                                        <option selected="selected" id="0" >--Select Category--</option>
                                        @foreach($categories as $category)
                                            <option id="{{$category->id}}" data-id="{{$category->id}}" value="{{$category->id}}">{{$category->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Enter Service Name</label>
                                <div>
                                    <input type="text" name="service_name"  placeholder="Enter Service Name" class="form-control input-lg" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Enter Price</label>
                                <div>
                                    <input type="integer" name="service_price"  placeholder="Enter Price" class="form-control input-lg" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-success">Add Service</button>
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
                        <h1 class="modal-title">Edit Service</h1>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="serviceFormEdit" action="">
                            @csrf
                            <input type="hidden" name="service_id" id="service_id">
                            <div class="form-group">
                                <label class="control-label">Select Category</label>
                                <div class="input-group">
                                    <select id="categoryDropdownEdit" class="form-control" name="category" style="width: 100%; height:100%;" tabindex="-1" aria-hidden="true" required>
                                        <option selected="selected" name="" id="0" >--Select Category--</option>
                                        @foreach($categories as $category)
                                            <option id="{{$category->id}}" data-id="{{$category->id}}" value="{{$category->id}} ">{{$category->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Enter Service Name</label>
                                <div>
                                    <input type="text" name="service_name"  id="service_name" placeholder="Enter Service Name" class="form-control input-lg" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Enter Price</label>
                                <div>
                                    <input type="text" name="service_price"  id="service_price" placeholder="Enter Service Price" class="form-control input-lg" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-success">Update Service</button>
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
                    <th>Category</th>
                    <th>Offered Service Name</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($services as $service)
                    @php
                        $category = \App\Models\Category::where('id',$service->category_id)->first();
                        @endphp
                    <tr>
                        <td>{{$category->category_name}}</td>
                        <td>{{$service->service_name}}</td>
                        <td>{{$service->service_price}}</td>

                        <td>
                            <a href="{{url('admin/edit-service',$service->id)}}" id="serviceEdit" class="btn btn-primary btn-sm"
                               data-id="{{$service->id}}"  id="{{$service->id}}" data-toggle="modal" data-target="#EditModalForm">Edit</a>

                            <a id="deleteBtn" data-toggle="modal" data-target=".modal1" data-id="{{$service->id}}"
                               class="btn btn-danger delete_btn btn-sm">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Category</th>
                    <th>Offered Service Name</th>
                    <th>Price</th>
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

                        <form method="post" action="{{route('admin.destroyService')}}">
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
            // Hide div by setting display to none
            $("#categoryDropdown").on('change',function() {
                var id = $(this).children(":selected").data('id');
            });
            $('body').on('click', '#serviceEdit', function () {
                var service_id = $(this).data('id');
                // console.log(service_id);
                $.ajax({
                    type: "GET",
                    url: "{{url('/admin/edit-service/')}}"+'/'+service_id,
                    success:function (response){
                        console.log(response);
                        $('#service_name').val(response.service_name);
                        $('#service_price').val(response.service_price);
                        $('#categoryDropdownEdit').prop('selectedIndex', response.category_id);
                        $('#serviceFormEdit').attr('action',"{{url('/admin/edit-service/')}}"+'/'+service_id);
                    }

                });
            });
        });
    </script>
@endsection
