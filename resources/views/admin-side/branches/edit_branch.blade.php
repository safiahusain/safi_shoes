@extends('admin-side.home')
@section('content')
<div class="main-content">
   
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
            @if(session()->has('error'))
                                            <div class="alert alert-success">
                                            <button type="button" class="close" data-dismiss="alert">X</button>
                                                {{session('error')}}
</div>
                                                @endif
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-success">Edit Branch</h4>
                                {{-- <p class="card-title-desc text-info">Please Provide Correct Information.</p> --}}
                                <form class="needs-validation"  novalidate  action="{{ url('update-branch/'.$data->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Enter Name:</label>
                                                <input type="text" name="name" class="form-control" id="validationCustom01"
                                                    value="{{ $data->name }}" required>
                                                    @if($errors->has('name'))
                                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                                    @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom02" class="form-label"> Email:</label>
                                                <input type="email" class="form-control" id="validationCustom03"
                                                value="{{ $data->email }}" name="email"  required>
                                                @if($errors->has('email'))
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
                                                <label for="validationCustom01" class="form-label">Enter Phone Number:</label>
                                                <input type="number" name="phone_number" class="form-control" id="validationCustom01"
                                                    value="{{ $data->phone_number }}" >
                                                    @if($errors->has('phone'))
                                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                                    @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom02" class="form-label"> Address:</label>
                                                <input type="text" class="form-control" id="validationCustom03"
                                                value="{{ $data->branch_address }}" name="branch_address" >
                                                @if($errors->has('address'))
                                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                                @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                   
                                    <!--<div class="row">-->
                                    <!--    <div class="col-md-6">-->
                                    <!--        <div class="mb-3">-->
                                    <!--            <label for="validationCustom01" class="form-label">Enter Manager Name:</label>-->
                                    <!--            <input type="text" name="manager_name" class="form-control" id="validationCustom01"-->
                                    <!--            value="{{ $data->manager_name }}" required>-->
                                    <!--                @if($errors->has('manager_name'))-->
                                    <!--                <span class="text-danger">{{ $errors->first('manager_name') }}</span>-->
                                    <!--                @endif-->
                                    <!--            <div class="valid-feedback">-->
                                    <!--                Looks good!-->
                                    <!--            </div>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                        <!-- <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom02" class="form-label">Date:</label>
                                                <input type="date" class="form-control" id="validationCustom03"
                                                name="date" value="{{ $data->date }}" >
                                                @if($errors->has('date'))
                                                <span class="text-danger">{{ $errors->first('date') }}</span>
                                                @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Your Old Password:</label>
                                            <input type="password" name="old_password"  placeholder="enter password" class="form-control" id="validationCustom03"
                                            value="" >
                                            
                                          
                                            @if($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Enter New Password:</label>
                                            <input type="password"  placeholder="enter password" class="form-control" id="validationCustom03"
                                            name="new_password" >
                                           
                                            @if($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Confirm Password:</label>
                                            <input type="password" class="form-control" id="validationCustom03"
                                            name="new_password_confirmation"  required>
                                            @if($errors->has('date'))
                                            <span class="text-danger">{{ $errors->first('date') }}</span>
                                            @endif
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                      <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom01" class="form-label">Select Role Name </label>
                                                       <select class="form-control" name="role" id="user_type">
                                                        <option value="">Select Role Name</option>
                                                        @foreach($roles as $roles)
                                                         <option value="{{$roles->name}}" {{$roles->name == $data->role ? 'selected' : ''}}>{{$roles->name}}</option>
                                                         @endforeach
                                                       </select>
                                                        @if($errors->has('brand_id'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('brand_id') }}</span>
                                                        @endif
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                </div>
                                    </div>
                                    <div class="row" style="display:none;">
                                        <div class="col-md-6">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" value="" id="invalidCheck"
                                                    required>
                                                <label class="form-check-label" for="invalidCheck">
                                                    Agree to terms and conditions
                                                </label>
                                                <div class="invalid-feedback">
                                                    You must agree before submitting.
                                                </div>
                                            </div>
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                            <button type="reset" class="btn btn-secondary waves-effect">
                                                Cancel
                                            </button>
                                           
                                        </div>  
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