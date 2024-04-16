@extends('admin-side.home')
@section('content')
<div class="main-content">
   
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
               
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-success">Edit Bank Entry Form</h4>
                                {{-- <p class="card-title-desc text-info">Please Provide Correct Information.</p> --}}
                                <form class="needs-validation"   action="{{ url('update-bank-entry/'.$bank_entry->id)}}"  method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        
                                            <div class="col-md-6">
                                                <div class="mb-6">
                                                <label for="validationCustom01" class="form-label">Select Bank Head Name:</label>
                                                <select class="form-select form-control" id="bank_name" name="bank_name">
                                                    <option selected disabled>Select Bank Head Name</option>
                                                    @foreach ($bank_head as $bank_head)
                                                    <option value="{{ $bank_head->bank_name }}" {{$bank_head->bank_name == $bank_entry->bank_name ? 'selected' : ''}}>{{ $bank_head->bank_name }}</option>
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
                                                    <label for="validationCustom01" class="form-label">Description:</label>
                                                    <input type="text" name="description" class="form-control" id="description"
                                                    value="{{$bank_entry->description}}" required>
                                                       
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div> 
                                            </div>
                                           
                                            
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Transaction Type:</label>
                                                    <input type="text" name="check_w_d" class="form-control" id="check_w_d"
                                                    value="{{$bank_entry->check_w_d}}" required>
                                                       
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div> 
                                            </div>
                                           
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Enter Amount:</label>
                                                <input type="number" name="amount" class="form-control" id="amount"
                                                value="{{$bank_entry->amount}}" required>
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
                                                <input type="date" name="date" class="form-control" id="date"
                                                   value="{{$bank_entry->date}}" required>
                                                    @if ($errors->has('date'))
                                                    <span class="text-danger">{{ $errors->first('date') }}</span>
                                                @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>

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
                                        </div>
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                        <button type="reset" class="btn btn-secondary waves-effect">
                                            Cancel
                                        </button>
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


<script src="asset('assets/js/pages/form-validation.init.js')}}"></script>

@endsection