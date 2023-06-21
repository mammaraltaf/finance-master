<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="changemodal" >
    <div class="modal-dialog modal-l" role="document">
        <div class="modal-content">
            <form method="post" action="{{route(auth()->user()->user_type.'.changepassword')}}">
                @csrf

                <div class="modal-header" style="text-align: center;">
                    <h2 class="modal-title" id="myModalLabel">Profile</h2>
                </div>
{{--                <div class="modal-body" style="text-align: center;">--}}
                <div class="modal-body">

                    <label><b>Name :</b></label>
                    <label>{{auth()->user()->name}}</label>
                    <br>

                    <label><b>Email :</b></label>
                    <label>{{auth()->user()->email}}</label>
                    <br>

                    <label><b>Role :</b></label>
                    <label>{{auth()->user()->user_type}}</label>
                    <br>

                    @php
                        $companies = auth()->user()->companies;
                        $departments = auth()->user()->departments;
                        $companyNames = $companies->pluck('name')->implode(', ');
                        $departmentNames = $departments->pluck('name')->implode(', ');

                    @endphp
                    <label><b>Company :</b></label>
                    <label>{{$companyNames}}</label>
                    <br>

                    <label><b>Department :</b></label>
                    <label>{{$departmentNames}}</label>
                    <br>
                    <hr>

                    <input type="hidden" name="id" class="user-delete" value="{{auth()->user()->id}}"/>
                    <label>Current Password </label>
                    <input type="password" name="currentPassword" class="form-control" required>
                    <label>New Password </label>
                    <input type="password" name="password"  class="form-control" required>
                    <label>Confirm New Password</label>
                    <input type="password" name="passwordConfirm"  class="form-control" required>
                </div>
                <div class="modal-footer" style="text-align: center;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
