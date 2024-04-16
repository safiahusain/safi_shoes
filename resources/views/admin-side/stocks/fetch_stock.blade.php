@extends('admin-side.home')
@section('content')
<div class="main-content">
  

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                    
                                    <h4 class="card-title">Buttons example</h4>
                                    <p class="card-title-desc">Data table with CSV and 
                                    </p>
                                     <div class="align-middle " >
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".transaction-detailModal">
                                            Add New Record
                                        </button> <br><br>
                                    </div> 
                                    @if (isset($data))
                                    
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 table-sm">
                                        
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th><code>Code</code></th>
                                            <th>Category</th>
                                            <th>Color</th>
                                            <!-- <th>Size</th> -->
                                            <th>Company</th>
                                            <th>Brand</th>
                                            <th>Purchase</th>
                                            <th>Sale</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <!-- <th>Date</th> -->
                                            <th>Status</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                        </thead>
                    
                                        <tbody>
                                            @php $i=1; @endphp
                                            @if (count($data)> 0)
                                        @foreach ($data as $item)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$item->name}}</td>
                                            <td><code>{{$item->item_code}}</code></td>
                                            {{-- <td>{{$item->image}}</td> --}}
                                            <td>{{$item->category_id}}</td>
                                            <td>{{$item->color_id}}</td>
                                            <!-- <td>{{$item->size_id}}</td> -->
                                            <td>{{$item->company_id}}</td>
                                            <td>{{$item->brand_id}}</td>
                                            <td>{{$item->purchase_price}}</td>
                                            <td>{{$item->sale_price}}</td>
                                            <td>{{$item->quantity}}</td>
                                            <td>{{$item->total_cost}}</td>
                                            <!-- <td>{{$item->date}}</td> -->
                                            
                                            <td>{{$item->status}}</td>
                                            <td>
                                                <a href="{{ url('edit-stock/'.$item->id)}} " class="btn btn-primary btn-sm">Edit</a>
                                                |
                                                <a href="{{ url('delete-stock/'.$item->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to Delete this Record ?')">Delete</a>
                                            </td>
                                            
                                        </tr>
                                        @endforeach
                                        
                                        @else
                                        <tr>
                                            <td>(<code>No Record Found!</code>)</td>
                                        </tr>
                                    @endif
                                        </tbody>
                                    </table>
                                    
                                    @endif
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                    
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>
</div>
 
<!-- Transaction Modal -->
<div class="modal fade transaction-detailModal" tabindex="-1" role="dialog" aria-labelledby="transaction-detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transaction-detailModalLabel">Stock's Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               

                <div class="table-responsive">
                    <table class="table align-middle table-nowrap">
                        <thead>
                            
                        </thead>
                        <tbody>
                            <form class="needs-validation"  novalidate action="{{ route('store-stock')}}"  method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">Product Name:</label>
                                            <input type="text" name="name" class="form-control" id="validationCustom01"
                                                placeholder="Enter Product Name">
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
                                                placeholder="Enter item_code" >
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
                                            <label for="validationCustom01" class="form-label">Select One Category:</label>
                                                <select class="form-select form-control" id="category_id" name="category_id">
                                                    <option selected disabled>Select Category Name</option>
                                                    @foreach ($categories as $country)
                                                    <option value="{{ $country->name}}">{{ $country->name}}</option>
                                                    @endforeach
                                                </select>
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
                                            <label for="validationCustom01" class="form-label">Select One Color Name:</label>
                                                <select class="form-select form-control" id="color_id" name="color_id">
                                                    <option selected disabled>Select Color Name</option>
                                                    @foreach ($colors as $country)
                                                    <option value="{{ $country->name}}">{{ $country->name}}</option>
                                                    @endforeach
                                                </select>
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
                                    <!-- <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">Select One Size:</label>
                                                <select class="form-select form-control" id="size_id" name="size_id">
                                                    <option selected disabled>Select One Size</option>
                                                    @foreach ($sizes as $country)
                                                    <option value="{{ $country->name}}">{{ $country->name}}</option>
                                                    @endforeach
                                                </select>
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
                                                 >
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
                                            <label for="validationCustom01" class="form-label">Select One Company:</label>
                                                <select class="form-select form-control" id="company_id" name="company_id">
                                                    <option selected disabled>Select Company Name</option>
                                                    @foreach ($companies as $country)
                                                    <option value="{{ $country->name}}">{{ $country->name}}</option>
                                                    @endforeach
                                                </select>
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
                                            <label for="validationCustom01" class="form-label">Select One Brand:</label>
                                                <select class="form-select form-control" id="brand_id" name="brand_id">
                                                    <option selected disabled>Select Brand Name</option>
                                                    @foreach ($brands as $country)
                                                    <option value="{{ $country->name}}">{{ $country->name}}</option>
                                                    @endforeach
                                                </select>
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
                                                placeholder="Enter purchase_price" >
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
                                                placeholder="Enter sale_price" >
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
                                            <label for="validationCustom01" class="form-label">Quantity Number:</label>
                                            <input type="number" name="quantity" class="form-control" id="validationCustom01"
                                                placeholder="Enter quantity Number" >
                                                @if($errors->has('size_no'))
                                                <span class="text-danger">{{ $errors->first('size_no') }}</span>
                                                @endif
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">Choose Image:</label>
                                            <input type="file" name="image" class="form-control" id="validationCustom01"
                                               >
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
                                            name="paid_balance"  >
                                            @if($errors->has('paid_balance'))
                                            <span class="text-danger">{{ $errors->first('paid_balance') }}</span>
                                            @endif
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>  
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </form>
    </div>
</div>
<!-- end modal -->


<script src="{{asset('assets/js/pages/form-validation.init.js')}}"></script>
{{-- <script src="{{asset('assets/js/pages/form-advanced.init.js')}}"></script> --}}
<script>
    function myFunction() {
        var x = document.getElementById("validationCustom04");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>  
@endsection