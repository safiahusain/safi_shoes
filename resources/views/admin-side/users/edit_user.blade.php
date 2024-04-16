@extends('admin-side.home')
@section('content')
<div class="main-content">
   
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
               
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-success">Edit User Form</h4>
                                {{-- <p class="card-title-desc text-info">Please Provide Correct Information.</p> --}}
                                <form class="needs-validation"  novalidate  action="{{ url('update-user/'.$data->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">User Name:</label>
                                                    <input type="text" name="name" class="form-control" id="validationCustom01"
                                                        value="{{ $data->name }}" required> 
                                                        @if ($errors->has('name'))
                                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                                        @endif
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                    <br>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">User Email:</label>
                                                    <input type="email" name="email" class="form-control" id="email"
                                                        value="{{ $data->email }}">
                                                        @if ($errors->has('email'))
                                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                                        @endif
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div> 
                                            </div>
                                        
                                    </div>

                                    <div class="row">   
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">User Role:</label>
                                                <select name="role_id" id="role_id" class="form-control">
                                                    <option value="{{ $data->role_as }}" selected>{{ $data->role_as }}</option>
                                                    @foreach ($roles as $role)
                                                    <option value="{{$role->id}}" @if($role->id == $data->role->id) selected @endif>{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-primary mt-4" type="submit">Submit</button>
                                           <a href="{{route('show-user')}}" class="btn btn-secondary waves-effect mt-4">
                                                Cancel</a>
                                            
                                            <!--<div class="form-check mb-3">-->
                                            <!--    <input class="form-check-input" type="checkbox" value="" id="invalidCheck"-->
                                            <!--        required>-->
                                            <!--    <label class="form-check-label" for="invalidCheck">-->
                                            <!--        Agree to terms and conditions-->
                                            <!--    </label>-->
                                            <!--    <div class="invalid-feedback">-->
                                            <!--        You must agree before submitting.-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                           
                                        </div>  
                                </div>
                                   
                        <!-- end card -->
                    </div> <!-- end col -->
                </div>
            </div>
            {{-- main row closed --}}
            </div>
        </div>
    </div>
</div>

<script src="{{asset('assets/js/pages/form-validation.init.js')}}"></script>

@endsection