@extends('admin-side.home')
@section('content')
<div class="main-content">
   
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
               
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-success">Edit Warehouse Details</h4>
                                {{-- <p class="card-title-desc text-info">Please Provide Correct Information.</p> --}}
                                <form class="needs-validation"  novalidate  action="{{ url('update-warehouse/'.$data->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Warehouse Name:</label>
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
                                                <label for="validationCustom03" class="form-label">User Email:</label>
                                                <select class="form-select form-control" id="validationCustom03" name="user_id" style="width:100%;" required>
                                                    <option selected disabled>Select Email</option>
                                                    @foreach ($users as $user)
                                                    <option value="{{$user->id}}" @if($user->id == $data->user->id) selected @endif>{{ $user->email}}</option>
                                                    @endforeach
                                                </select>
                                                <!--<input type="email" class="form-control" id="validationCustom03"-->
                                                <!--value="{{ $data->email }}" name="email" >-->
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
                                                <label for="validationCustom01" class="form-label">Warehouse Phone Number:</label>
                                                <input type="number" name="phone" class="form-control" id="validationCustom01"
                                                    value="{{ $data->phone }}" required>
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
                                                <label for="validationCustom02" class="form-label">Warehouse Address:</label>
                                                <input type="text" class="form-control" id="validationCustom03"
                                                value="{{ $data->address }}"  name="address"  required>
                                                @if($errors->has('address'))
                                                <span class="text-danger">{{ $errors->first('address') }}</span>
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
                                                <label for="validationCustom01" class="form-label">Your Branch Name:</label>
                                                <input type="text" class="form-control" id="validationCustom03"
                                                value="{{ $data->branch_id }}"  name="branch_id"  required>
                                                      
                                                    @if($errors->has('branch_id'))
                                                    <span class="text-danger">{{ $errors->first('branch_id') }}</span>
                                                    @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom02" class="form-label">Entry Date:</label>
                                                <input type="text" class="form-control" id="validationCustom03"
                                                    value="{{ $data->date}}"   name="date"  required>
                                                @if($errors->has('date'))
                                                <span class="text-danger">{{ $errors->first('date') }}</span>
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
                                                <label for="validationCustom01" class="form-label">Opening Balance:</label>
                                                <input type="number" name="open_balance" class="form-control" id="validationCustom01"
                                                value="{{ $data->open_balance }}"  required>
                                                    @if($errors->has('manager_name'))
                                                    <span class="text-danger">{{ $errors->first('manager_name') }}</span>
                                                    @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        <!--    <div class="form-check mb-3">-->
                                        <!--        <input class="form-check-input" type="checkbox" value="" id="invalidCheck"-->
                                        <!--            required>-->
                                        <!--        <label class="form-check-label" for="invalidCheck">-->
                                        <!--            Agree to terms and conditions-->
                                        <!--        </label>-->
                                        <!--        <div class="invalid-feedback">-->
                                        <!--            You must agree before submitting.-->
                                        <!--        </div>-->
                                            <!--</div>-->
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                           <a href="{{route('show-warehouse')}}" class="btn btn-secondary waves-effect">
                                               
                                                Cancel
                                           </a>
                                        
                                           
                                        </div>  
                                        {{-- <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom02" class="form-label">Paid Balance:</label>
                                                <input type="number" class="form-control" id="paid_balance"
                                                name="paid_balance"   required>
                                                @if($errors->has('paid_balance'))
                                                <span class="text-danger">{{ $errors->first('paid_balance') }}</span>
                                                @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div> --}}
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