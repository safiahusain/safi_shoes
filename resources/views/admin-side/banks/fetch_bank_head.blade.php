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
                                    @if (isset($bank_head))
                                    
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                        
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Bank Name</th>
                                            <th>A/C Number</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                            <!-- <th>Status</th> -->
                                           
                                            <!--<th>Action</th>-->
                                            
                                        </tr>
                                        </thead>
                    
                                        <tbody>
                                            @php $i=1; @endphp
                                            @if (count($bank_head)> 0)
                                        @foreach ($bank_head as $item)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$item->bank_name}}</td>
                                             <td>{{$item->ac_number}}</td> 
                                             <td>{{$item->address}}</td> 
                                             <!--<td>{{$item->status}}</td> -->
                                            <td>
                                                <a href="{{ url('edit-bank-head/'.$item->id)}} " class="" style="background-color:white; border:none"><i class="fa-solid fa-pen-to-square"></i></a>
                                                |
                                                <a href="{{ url('delete-bank-head/'.$item->id) }}" class="" style="background-color:white; border:none" onclick="return confirm('Are you sure to Delete this Record ?')"><i class="fa-solid fa-trash-can"></i></a>
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
                <h5 class="modal-title" id="transaction-detailModalLabel">Bank Head Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               

                <div class="table-responsive">
                    <table class="table align-middle table-nowrap">
                        <thead>
                            
                        </thead>
                        <tbody>
                        <form class="needs-validation"   action="{{ url('store-bank-head')}}"  method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-2">
                                                <label for="validationCustom01" class="form-label">Bank Head Name:</label>
                                                <input type="text" name="bank_name" class="form-control" id="validationCustom01"
                                                    placeholder="Enter Your bank head Name"  required> 
                                                    @if ($errors->has('bank_name'))
                                                        <span class="text-danger">{{ $errors->first('head_name') }}</span>
                                                    @endif

                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        
                                         <div class="col-md-12">
                                            <div class="mb-2">
                                                <label for="validationCustom01" class="form-label">A/C Number:</label>
                                                <input type="text" name="ac_number" class="form-control" id="validationCustom01"
                                                    placeholder="Enter Your A/C Number"  required> 
                                                    @if ($errors->has('bank_name'))
                                                        <span class="text-danger">{{ $errors->first('head_name') }}</span>
                                                    @endif

                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        
                                         <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Address:</label>
                                                <input type="text" name="address" class="form-control" id="validationCustom01"
                                                    placeholder="Enter Your Address"  required> 
                                                    @if ($errors->has('address'))
                                                        <span class="text-danger">{{ $errors->first('head_name') }}</span>
                                                    @endif

                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <br>
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
</form>
</div>
<!-- end modal -->

<script src="asset('assets/js/pages/form-validation.init.js')}}"></script>
@endsection