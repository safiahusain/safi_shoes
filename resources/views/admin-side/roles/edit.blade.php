@extends('admin-side.home')
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-success">Edit Role Name</h4>
                            <form class="needs-validation mb-4"  novalidate  action="{{ route ('admin.roles.update', $role->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="">
                                            <label for="validationCustom01" class="form-label">Role:</label>
                                            <input type="text" name="role_name" class="form-control" id="validationCustom01"
                                                value="{{ $role->name }}" required> 
                                                
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <br>
                                        </div>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </form>
                            <style>
                                    .role-button {
                                        position: relative;
                                    }
                                    
                                    .icon-cross {
                                        position: absolute;    
                                        top: -10px;
                                        right: -7px;
                                        font-size: 12px;
                                        background: red;
                                        padding: 5px;
                                        border-radius: 50%;
                                        
                                    }
                                </style>
                            <h4>Role Permission</h4>
                            @if($role->permissions)
                                <div class="mb-5 d-flex flex-wrap">
                                    @foreach($role->permissions as $role_permission)
                                        <form action="{{ route('admin.roles.permissions.revoke', [$role->id, $role_permission->id])}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-success mr-2 my-2 p-2 role-button">{{str_replace('_',' ',ucwords($role_permission->name))}} <i class="fa-solid fa-xmark icon-cross"></i></button>
                                        </form>
                                    @endforeach
                                </div>
                            @endif
                            <form action="{{ route('admin.roles.permissions',$role->id)}}" method="POST">
                                @csrf
                                <h4 class="mt-3"> Permission</h4>
                                <select name="permission_name" class="form-control js-example-basic-single" required>
                                    <option value="" selected disabled>Select Permission</option>
                                    @foreach($permissions as $permissions)
                                        <option value="{{$permissions->name}}">{{str_replace('_',' ',ucwords($permissions->name))}}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary mt-2">Assign</button>
                            </form>
                        </div>
                        <!-- end card -->
                    </div> <!-- end col -->
                </div>
            </div>
        </div>
    </div>
</div>

$(document).ready(function() 
{
    $('.js-example-basic-single').select2();
});

@endsection