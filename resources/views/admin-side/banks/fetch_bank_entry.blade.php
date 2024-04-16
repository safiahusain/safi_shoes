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
                    
                                    <!--<h4 class="card-title">Buttons example</h4>-->
                                    <!--<p class="card-title-desc">Data table with CSV and -->
                                    <!--</p>-->
                                     <div class="align-middle " >
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".transaction-detailModal">
                                            Add New Record
                                        </button> <br><br>
                                    </div> 
                                    @if (isset($bank_entry))
                                    
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                        
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Bank Name</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th>Deposite</th>
                                            <th>WithDrawal</th>
                                            <!-- <th>Status</th> -->
                                            <th>Action</th>
                                            
                                        </tr>
                                        </thead>
                    
                                        <tbody>
                                            @php $i=1; @endphp
                                            @if (count($bank_entry)> 0)
                                        @foreach ($bank_entry as $item)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$item->bank_name}}</td>
                                            
                                            <td>{{$item->description}}</td>
                                            <td>{{$item->date}}</td>
                                            @if($item->check_w_d == "deposite")
                                            <td>{{$item->amount}}</td>
                                            <td></td>
                                            @else
                                            <td></td>
                                             <td>{{$item->amount}}</td>
                                             @endif
                                            <td>
                                                <a href="{{ url('edit-bank-entry/'.$item->id)}} " style="background-color:white; border:none"><i class="fa-solid fa-pen-to-square"></i></a>
                                                |
                                                <a href="{{ url('delete-bank-entry/'.$item->id) }}" style="background-color:white; border:none" onclick="return confirm('Are you sure to Delete this Record ?')"><i class="fa-solid fa-trash-can"></i></a>
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
                <h5 class="modal-title" id="transaction-detailModalLabel">Bank Entry Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               

                <div class="table-responsive">
                    <table class="table align-middle table-nowrap">
                        <thead>
                            
                        </thead>
                        <tbody>
                        <form class="needs-validation"  novalidate action="{{ url('store-bank-entry')}}"  method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Select One Bank Head Name:</label>
                                                <select class="form-select form-control" id="bank_name" name="bank_name" style="width:220px;" required>
                                                    <option selected disabled>Select Bank Head Name</option>
                                                    @foreach ($bank_head as $bank_head)
                                                    <option value="{{ $bank_head->bank_name }}">{{ $bank_head->bank_name }}</option>
                                                    @endforeach
                                                </select>
                                                     @if ($errors->has('title_id'))
                                                     <span class="text-danger">{{ $errors->first('expense_head') }}</span>
                                                    @endif                                                                                                                    
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div>
                                            
                                           
                                            <div class="col-md-6">
                                             <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Description:</label>
                                                <input type="text" name="description" class="form-control" id="validationCustom01"
                                                    placeholder="Enter Your Description "  required> 
                                                    @if ($errors->has('description'))
                                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                                    @endif

                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                  
                                    
                                                <div class="col-md-6">
                                              <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Date:</label>
                                                <input type="text" value="{{now()->format('d-m-y')}}" name="date" class="form-control" id="validationCustom01"
                                                    placeholder="Date"  required> 
                                                    @if ($errors->has('date'))
                                                        <span class="text-danger">{{ $errors->first('date') }}</span>
                                                    @endif

                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                    
                                    
                                    
                                     
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Amount:</label>
                                                    <input type="text" name="amount" class="form-control" id="description"
                                                        required>
                                                       
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div> 
                                            </div>
                                           
                                        
                                    </div>

                                   <div class="mb-6">
                                                <label for="validationCustom01" class="form-label">Select Transaction Type:</label>
                                                <select class="form-select form-control" id="check_w_d" name="check_w_d">
                                                    <option selected disabled>Select Transaction Type</option>
                                                    
                                                    <option value="deposite">Deposite</option>
                                                    <option value="Withdrawal">Withdrawal</option>
                                                  
                                                </select>
                                                     @if ($errors->has('title_id'))
                                                     <span class="text-danger">{{ $errors->first('expense_head') }}</span>
                                                    @endif                                                                                                                    
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        <!--<div class="col-md-6">-->
                                        <!--    <div class="mb-3">-->
                                        <!--        <label for="validationCustom01" class="form-label">Select Date:</label>-->
                                        <!--        <input type="date" name="date" class="form-control" id="date"-->
                                        <!--            placeholder="Enter Your Name"  required>-->
                                        <!--            @if ($errors->has('date'))-->
                                        <!--            <span class="text-danger">{{ $errors->first('date') }}</span>-->
                                        <!--        @endif-->
                                        <!--        <div class="valid-feedback">-->
                                        <!--            Looks good!-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                        <!--</div>-->

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

<script src="asset('assets/js/pages/form-validation.init.js')}}"></script>

@endsection