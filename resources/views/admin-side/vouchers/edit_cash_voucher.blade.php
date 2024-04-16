@extends('admin-side.home')
@section('content')
<div class="main-content">
   
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
               
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-success">Edit Expanses Entry Form</h4>
                                {{-- <p class="card-title-desc text-info">Please Provide Correct Information.</p> --}}
                                <form class="needs-validation"   action="{{ url('update-cash-voucher/'.$cash_voucher->id)}}"  method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                     
                                            
                                           

                                           


                                            <div class="col-md-6">
                                                <div class="mb-6">
                                                <label for="validationCustom01" class="form-label">Select Customer Name:</label>
                                                <select class="form-select form-control" id="customer_name" name="customer_name">
                                                    <option selected disabled>Select Customer Name</option>
                                                    @foreach ($customer_name as $customer_name)
                                                    <option value="{{ $customer_name->name }}" {{$customer_name->name == $cash_voucher->customer_name ? 'selected' : ''}}>{{ $customer_name->name }}</option>
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
                                                    <input type="text" readonly name="balance" class="form-control" id="balance"
                                                    value="{{$customer_name_balance->balance}}" required>
                                                       
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div> 
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label"> Description:</label>
                                                    <input type="text" name="description" class="form-control" id="description"
                                                    value="{{$cash_voucher->description}}" required>
                                                       
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div> 
                                            </div>
                                           
                                       
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Your Amount:</label>
                                                <input type="number" name="paid_amount" class="form-control" id="amount"
                                                value="{{$cash_voucher->paid_amount}}" required>
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
                                                   value="{{$cash_voucher->date}}" required>
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
                                        <a href="{{route('show-cash-voucher')}}" class="btn btn-secondary waves-effect">
                                            
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


<!-- <script src="asset('assets/js/pages/form-validation.init.js')}}"></script> -->

<script>

// ********************** get customer names *****************************
      
                     $(document).ready(function(){

                    $(document).on("change", "#salesman_name", function(e){

                        e.preventDefault();

                        var salesman_name = $(this).val();

                        // alert(salesman_name)

                        $.ajax({

                            type:"GET",
                            url:'fetch-customer-name/'+salesman_name,
                            datatype:"JSON",

                            success:function(data){

                                $("#customer_name").html('');
                                $("#customer_name").append('<option>Select Customer Name</option>');
                                $.each(data.customer_name, function(key, item){
                                
                                    $("#customer_name").append(

                                        '<option value='+item.name+'>'+item.name+'</option>'

                                        );

                                });


                            }

                        });

                    });

                    });


                      //   ************************ get customer details ******************


                      $(document).ready(function(){

                        $(document).on("change", "#customer_name", function(e){

                            e.preventDefault();

                            var customer_name = $(this).val();

                            // alert(customer_name)

                            $.ajax({

                                type:"GET",
                                url:'fetch-customer-detail-for-cash/'+customer_name,
                                datatype:"JSON",

                                success:function(data){

                                    $("#customer_address").val(data.customer_detail.address);
                                    $("#balance").val(data.customer_detail.balance);

                                    // console.log(data.customer_detail)

                                }

                            });

                        });

                        });


    </script>

@endsection