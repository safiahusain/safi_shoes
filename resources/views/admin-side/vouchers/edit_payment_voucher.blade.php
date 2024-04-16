@extends('admin-side.home')
@section('content')
<div class="main-content">
   
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
               
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-success">Edit Payment Voucher Form</h4>
                                {{-- <p class="card-title-desc text-info">Please Provide Correct Information.</p> --}}
                                <form class="needs-validation"   action="{{ url('update-payment-voucher/'.$payment_voucher->id)}}"  method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        
                                            <div class="col-md-6">
                                                <div class="mb-6">
                                                <label for="validationCustom01" class="form-label">Select Company_name:</label>
                                                <select class="form-select form-control" id="company_name" name="company_name">
                                                    <option selected disabled>Select Company_name</option>
                                                    @foreach ($company_name as $company_name)
                                                    <option value="{{ $company_name->name }}" {{$company_name->name == $payment_voucher->company_name ? 'selected' : ''}}>{{ $company_name->name }}</option>
                                                    @endforeach
                                                </select>
                                                     @if ($errors->has('title_id'))
                                                     <span class="text-danger">{{ $errors->first('title_id') }}</span>
                                                    @endif                                                                                                                    
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label"> Balance:</label>
                                                    <input type="text" readonly="" name="balance" class="form-control" id="balance"
                                                    value="{{$company_name_balance->balance}}" required>
                                                       
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div> 
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label"> Description:</label>
                                                    <input type="text" name="description" class="form-control" id="description"
                                                    value="{{$payment_voucher->description}}" required>
                                                       
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div> 
                                            </div>
     
                                    
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Your Amount:</label>
                                                <input type="number" name="paid_amount" class="form-control" id="paid_amount"
                                                value="{{$payment_voucher->paid_amount}}" required>
                                                    @if ($errors->has('amount'))
                                                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                                                @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Select Date:</label>
                                                <input type="text" name="date" class="form-control" id="date"
                                                   value="{{$payment_voucher->date}}" required>
                                                    @if ($errors->has('date'))
                                                    <span class="text-danger">{{ $errors->first('date') }}</span>
                                                @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!--<div class="col-md-6">-->
                                    <!--    <div class="form-check mb-3">-->
                                    <!--        <input class="form-check-input" type="checkbox" value="" id="invalidCheck"-->
                                    <!--            required>-->
                                    <!--        <label class="form-check-label" for="invalidCheck">-->
                                    <!--            Agree to terms and conditions-->
                                    <!--        </label>-->
                                    <!--        <div class="invalid-feedback">-->
                                    <!--            You must agree before submitting.-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                       <a href="{{route('show-payment-voucher')}}" class="btn btn-secondary waves-effect">
                                            Cancel
                                        </a>
                                    <div>  
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

<script>

            $(document).ready(function(){

                $(document).on("change", "#company_name", function(e){

                    e.preventDefault();

                    var company_name = $(this).val();

                    // alert(company_name)

                    $.ajax({

                        type:"GET",
                        url:'fetch-company-balance/'+company_name,
                        datatype:"JSON",

                        success:function(data){

                            $("#balance").val(data.company_balance.balance);

                        }

                    });

                });

            });


    </script>


<!-- <script src="asset('assets/js/pages/form-validation.init.js')}}"></script> -->

@endsection