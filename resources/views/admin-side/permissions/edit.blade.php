@extends('admin-side.home')
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            @dd("here")
                            <h4 class="card-title text-success">Edit Permission </h4>
                            <form class="needs-validation"  novalidate  action="{{ route ('admin.permissions.update', $permission->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="">
                                            <label for="validationCustom01" class="form-label">Permission:</label>
                                            <input type="text" name="permission_name" class="form-control" id="validationCustom01" value="{{ $permission->name }}" required> 
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
                            <h4 class="mt-3 mb-3">Roles and Permissions </h4>
                            <div class="d-flex ">
                                @if($permission->roles)
                                    @foreach($permission->roles as $permission_role)
                                        <form class="mb-4" action="{{route('admin.permissions.roles.remove', [$permission->id, $permission_role->id])}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger mr-2"> {{$permission_role->name}} </button>
                                        </form>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                                        
                                
                                    <form class="needs-validation mt-5"  novalidate  action="{{ route ('admin.permissions.roles', $permission->id)}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <label for="role">Roles:</label>
                                        <select name="role_name" class="form-control"  required>
                                            <option value="">Select Role</option>
                                            @foreach($roles as $roles)
                                                <option value="{{$roles->name}}">{{$roles->name}}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-primary mt-3"> Assign</button>
                                    </div>  
                                   </form>
                                </div>
                        <!-- end card -->
                    </div> <!-- end col -->
                </div>
            </div>
            
            </div>
        </div>
    </div>
</div>



@endsection