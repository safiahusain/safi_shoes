@extends('admin-side.home')
@section('content')
<div class="main-content">
   
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
               
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-success">Edit Customer Details</h4>
                                {{-- <p class="card-title-desc text-info">Please Provide Correct Information.</p> --}}
                                <form class="needs-validation"  novalidate  action="{{ url('update-customer/'.$data->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <!--<div class="col-md-6">-->
                                        <!--    <div class="mb-3">-->
                                        <!--        <label for="validationCustom01" class="form-label">Date:</label>-->
                                        <!--        <input type="date" name="date" class="form-control" id="validationCustom01"-->
                                        <!--            value="{{ $data->date }}" required>-->
                                        <!--            @if($errors->has('date'))-->
                                        <!--            <span class="text-danger">{{ $errors->first('date') }}</span>-->
                                        <!--            @endif-->
                                        <!--        <div class="valid-feedback">-->
                                        <!--            Looks good!-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        <!--<div class="col-md-6">-->
                                        <!--    <div class="mb-3">-->
                                        <!--        <label for="validationCustom01" class="form-label">Customer Code:</label>-->
                                        <!--        <input type="text" name="code" class="form-control" id="validationCustom01"-->
                                        <!--            value="{{ $data->code }}" required>-->
                                        <!--            @if($errors->has('code'))-->
                                        <!--            <span class="text-danger">{{ $errors->first('code') }}</span>-->
                                        <!--            @endif-->
                                        <!--        <div class="valid-feedback">-->
                                        <!--            Looks good!-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Customer Name:</label>
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
                                                <label for="validationCustom01" class="form-label">Customer Mobile:</label>
                                                <input type="text" name="mobile" class="form-control" id="validationCustom01"
                                                    value="{{ $data->mobile }}" required>
                                                    @if($errors->has('mobile'))
                                                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                                    @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom02" class="form-label">Customer Address:</label>
                                                <input type="text" class="form-control" id="validationCustom03"
                                                value="{{ $data->address }}" name="address"  required>
                                                @if($errors->has('address'))
                                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                                @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="col-md-6">-->
                                        <!--    <div class="mb-3">-->
                                        <!--        <label for="validationCustom01" class="form-label">Customer Phone Number:</label>-->
                                        <!--        <input type="number" name="phone" class="form-control" id="validationCustom01"-->
                                        <!--            value="{{ $data->phone }}" required>-->
                                        <!--            @if($errors->has('phone'))-->
                                        <!--            <span class="text-danger">{{ $errors->first('phone') }}</span>-->
                                        <!--            @endif-->
                                        <!--        <div class="valid-feedback">-->
                                        <!--            Looks good!-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom02" class="form-label">Customer Address:</label>
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
                                   
                                   
                                        <!--<div class="col-md-6">-->
                                        <!--    <div class="mb-3">-->
                                        <!--        <label for="validationCustom02" class="form-label">Saleman:</label>-->
                                        <!--        <input type="text" class="form-control" id="validationCustom03"-->
                                        <!--            value="{{ $data->saleman_name}}"   name="saleman_name"  required>-->
                                        <!--        @if($errors->has('saleman_name'))-->
                                        <!--        <span class="text-danger">{{ $errors->first('saleman_name') }}</span>-->
                                        <!--        @endif-->
                                        <!--        <div class="valid-feedback">-->
                                        <!--            Looks good!-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                         <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Opening Balance:</label>
                                                <input type="number" name="open_balance" class="form-control" id="validationCustom01"
                                                value="{{ $data->balance }}"  >
                                                    @if($errors->has('open_balance'))
                                                    <span class="text-danger">{{ $errors->first('open_balance') }}</span>
                                                    @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!--<div class="mb-3">-->
                                            <!--    <label for="validationCustom02" class="form-label">Company Name:</label>-->
                                            <!--    <input type="text" class="form-control" id="validationCustom03"-->
                                            <!--        value="{{ $data->company_name}}"   name="company_name"  required>-->
                                            <!--    @if($errors->has('company_name'))-->
                                            <!--    <span class="text-danger">{{ $errors->first('receivecompany_name') }}</span>-->
                                            <!--    @endif-->
                                            <!--    <div class="valid-feedback">-->
                                            <!--        Looks good!-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                        </div>
                                    
                                       
                                      
                                        <div class="col-md-6">
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
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                            <a href="{{route('show-customer')}}" class="btn btn-secondary waves-effect">
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