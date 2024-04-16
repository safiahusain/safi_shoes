@extends('admin-side.home')
@section('content')
<div class="main-content">
   
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
               
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-success">Edit Stock Details</h4>
                                {{-- <p class="card-title-desc text-info">Please Provide Correct Information.</p> --}}
                                <form class="needs-validation"  novalidate  action="{{ url('update-stock/'.$data->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Product Name:</label>
                                                <input type="text" name="name" class="form-control" id="validationCustom01"
                                                    value="{{ $data->name }}" >
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
                                                <label for="validationCustom01" class="form-label">Item Code:</label>
                                                <input type="text" name="item_code" class="form-control" id="validationCustom01"
                                                value="{{ $data->item_code }}" >
                                                    @if($errors->has('item_code'))
                                                    <span class="text-danger">{{ $errors->first('item_code') }}</span>
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
                                                <label for="validationCustom01" class="form-label">Your Category:</label>
                                                  <input type="text" name="category_id" class="form-control" id="validationCustom01"
                                                    value="{{ $data->category_id }}" >
                                                    @if($errors->has('category_id'))
                                                    <span class="text-danger">{{ $errors->first('category_id') }}</span>
                                                    @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Your Color Name:</label>
                                                    
                                                        
                                                    <input type="text" name="color_id" class="form-control" id="validationCustom01"
                                                    value="{{ $data->color_id }}" >
                                                    @if($errors->has('brand_id'))
                                                    <span class="text-danger">{{ $errors->first('brand_id') }}</span>
                                                    @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                       
                                    <!-- </div>  -->
                                    
                                    <!-- <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label"> Your Size Number:</label>
                                
                                                    
                                                    <input type="number" name="size_id" class="form-control" id="validationCustom01"
                                                    value="{{ $data->size_id }}">
                                                    @if($errors->has('size_id'))
                                                    <span class="text-danger">{{ $errors->first('size_id') }}</span>
                                                    @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div> -->
                                       
                                        <!-- <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Choose Date:</label>
                                                <input type="date" name="date" class="form-control" id="validationCustom01"
                                                     value="{{ $data->date }}">
                                                    @if($errors->has('sale_price'))
                                                    <span class="text-danger">{{ $errors->first('sale_price') }}</span>
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
                                                <label for="validationCustom01" class="form-label">your Company name:</label>
                                                        
                                                    <input type="text" name="company_id" class="form-control" id="validationCustom01"
                                                    value="{{ $data->company_id }}" >
                                                    @if($errors->has('company_id'))
                                                    <span class="text-danger">{{ $errors->first('company_id') }}</span>
                                                    @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Your Brand Name:</label>
                                                    
                                                    
                                                    <input type="text" name="brand_id" class="form-control" id="validationCustom01"
                                                    value="{{ $data->brand_id }}" >
                                                    @if($errors->has('brand_id'))
                                                    <span class="text-danger">{{ $errors->first('brand_id') }}</span>
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
                                                <label for="validationCustom01" class="form-label">Purchase Price:</label>
                                                <input type="number" name="purchase_price" class="form-control" id="validationCustom01"
                                                value="{{ $data->purchase_price }}" >
                                                    @if($errors->has('purchase_price'))
                                                    <span class="text-danger">{{ $errors->first('purchase_price') }}</span>
                                                    @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Sale Price:</label>
                                                <input type="number" name="sale_price" class="form-control" id="validationCustom01"
                                                value="{{ $data->sale_price }}" >
                                                    @if($errors->has('sale_price'))
                                                    <span class="text-danger">{{ $errors->first('sale_price') }}</span>
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
                                                <label for="validationCustom01" class="form-label">Quantity:</label>
                                                <input type="number" name="quantity" class="form-control" id="validationCustom01"
                                                value="{{ $data->quantity }}" >
                                                    @if($errors->has('quantity'))
                                                    <span class="text-danger">{{ $errors->first('quantity') }}</span>
                                                    @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Image:</label>
                                                <input type="file" name="image" class="form-control" id="validationCustom01"
                                                value="{{ $data->image }}"  readonly>
                                                    @if($errors->has('image'))
                                                    <span class="text-danger">{{ $errors->first('image') }}</span>
                                                    @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
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