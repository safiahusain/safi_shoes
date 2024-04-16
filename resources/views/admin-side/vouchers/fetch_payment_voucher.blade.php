@extends('admin-side.home')
@section('content')
<style>
 
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>
<div class="main-content">
  
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                    
                                   
                                     <div class="align-middle " >
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".transaction-detailModal">
                                            Add New Record
                                        </button> <br><br>
                                    </div> 
                                    @if (isset($payment_voucher))
                                    
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                        
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Company Name</th>
                                            <th>Description</th>
                                            <th>Paid Amount</th>
                                            <th>Date</th>
                                            <!-- <th>Status</th> -->
                                           
                                            <th>Action</th>
                                            
                                        </tr>
                                        </thead>
                    
                                        <tbody>
                                            @php $i=1; @endphp
                                            @if (count($payment_voucher)> 0)
                                        @foreach ($payment_voucher as $item)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$item->company_name}}</td>
                                            <td>{{$item->description}}</td>
                                            <td>{{$item->paid_amount}}</td>
                                            <td>{{$item->date}}</td>
                                            <!-- <td>{{$item->status}}</td> -->
                                            <td>
                                                <a href="{{ url('edit-payment-voucher/'.$item->id)}} " class="" style="background-color:white; border:none"><i class="fa-solid fa-pen-to-square"></i></a>
                                                |
                                                <a href="{{ url('delete-payment-voucher/'.$item->id) }}" class="" style="background-color:white; border:none" onclick="return confirm('Are you sure to Delete this Record ?')"><i class="fa-solid fa-trash-can"></i></a>
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
<div id="exampleModal" class="modal fade transaction-detailModal" tabindex="-1" role="dialog" aria-labelledby="transaction-detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transaction-detailModalLabel">Payment Voucher Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               

                <div class="table-responsive">
                    <table class="table align-middle table-nowrap">
                        <thead>
                            
                        </thead>
                        <tbody>
                        <form class="needs-validation"  novalidate action="{{ url('store-payment-voucher')}}"  method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        
                                            <div class="col-md-6">
                                                <div class="mb-6">
                                                <label for="validationCustom01" class="form-label">Select One Company Name:</label>
                                                <select class=" form-control" id="company_name" name="company_name" style="width:220px;" required>
                                                    <option selected disabled>Select Company name</option>
                                                    @foreach ($company_name as $company_name)
                                                    <option value="{{ $company_name->name }}">{{ $company_name->name }}</option>

                                                    @endforeach
                                                </select>
                                                     @if ($errors->has('title_id'))
                                                     <span class="text-danger">{{ $errors->first('company_name') }}</span>
                                                    @endif                                                                                                                    
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Balance:</label>
                                                    <input type="text" readonly="" name="balance" class="form-control" id="balance" placeholder="Old balance">
                                                     <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div> 
                                            </div>
                                            
                                            <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Enter Amount:</label>
                                                <input type="number" name="paid_amount" class="form-control" id="amount"
                                                    placeholder="Enter Your Name"  >
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
                                                <label for="validationCustom01" class="form-label"> Description</label>
                                                <input type="text"  name="description" class="form-control" id="date"
                                                    placeholder="Enter Your description"  required>
                                                    @if ($errors->has('description'))
                                                    <span class="text-danger">{{ $errors->first('description') }}</span>
                                                @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Date</label>
                                                    <input type="text" readonly name="date" value="{{now()->format('d-m-y')}}" class="form-control" id="date">
                                                     <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div> 
                                            </div>

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
    </div>
</div>
<!-- end modal -->

<!-- <script src="asset('assets/js/pages/form-validation.init.js')}}"></script> -->
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   -->

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
@endsection