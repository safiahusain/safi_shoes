@extends('admin-side.home')
@section('content')
<div class="main-content">
   
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
               
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-success">Edit Skills Form</h4>
                                {{-- <p class="card-title-desc text-info">Please Provide Correct Information.</p> --}}
                                <form class="needs-validation"  novalidate  action="{{ url('update-role/'.$data->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                            <!-- <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Skills Name:</label>
                                                    <input type="text" name="name" class="form-control" id="validationCustom01"
                                                        value="{{ $data->name }}" required> 
                                                        @if ($errors->has('skill_name'))
                                                            <span class="text-danger">{{ $errors->first('skill_name') }}</span>
                                                        @endif
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                    <br>
                                                </div>
                                            </div> -->
                                            
                                            <!-- <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">User Email:</label>
                                                    <input type="email" name="email" class="form-control" id="email"
                                                        value="{{ $data->email }}" required>
                                                        @if ($errors->has('email'))
                                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                                        @endif
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div> 
                                            </div> -->
                                        
                                    </div>

                                    <div class="row">   
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">User Role:</label>
                                               <select name="role_id" id="role_id" class="form-control">
                                                @foreach($roles as $service)
                                                      <option value="{{ $service->id }}" selected>{{ $service->role_as }}</option>
                                                
                                                    <!-- <option value="{{ $service->id }}">{{ $service->role_as }}</option> -->
                                                
                                            @endforeach
                                               </select>
                                                {{-- @foreach($roles as $service)
                                                @if (old('role_id') == $service->id)
                                                      <option value="{{ $service->id }}" selected>{{ $service->role_as }}</option>
                                                  @else
                                                    <option value="{{ $service->id }}">{{ $service->role_as }}</option>
                                                @endif
                                                @endforeach
                                               </select>
                                                @if ($errors->has('role_id'))
                                                    <span class="text-danger">{{ $errors->first('role_id') }}</span>
                                                @endif --}}
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
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