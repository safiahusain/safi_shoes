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
                    
                                    <h4 class="card-title">Buttons example</h4>
                                    <p class="card-title-desc">Data table with CSV and 
                                    </p>
                                     <div class="align-middle " >
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".transaction-detailModal">
                                            Add New Record
                                        </button> <br><br>
                                    </div> 
                                    
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 table-sm">
                                        
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>address</th>
                                            <th>Branch Name</th>
                                            <th>Total Remaining</th>
                                            <!-- <th>Status</th> -->
                                            <th>Action</th>
                                            
                                        </tr>
                                        </thead>
                    
                                        <tbody>
                                            @php $i=1; @endphp
                                        @foreach ($data as $item)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->user->email}}</td>
                                            <td>{{$item->phone}}</td>
                                            <td>{{$item->address}}</td>
                                            <td>{{$item->branch_id}}</td>
                                            <td>{{$item->open_balance}}</td>
                                            
                                            <!-- <td>{{$item->status}}</td> -->
                                            <td>
                                                <a href="{{ url('edit-warehouse/'.$item->id)}} " class="btn btn-primary btn-sm">Edit</a>
                                                |
                                                <a href="{{ url('delete-warehouse/'.$item->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to Delete this Record ?')">Delete</a>
                                            </td>
                                            
                                        </tr>
                                        @endforeach
                                       
                                        </tbody>
                                    </table>
                                    
                                    
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
                <h5 class="modal-title" id="transaction-detailModalLabel">WareHouse Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               

                <div class="table-responsive">
                    <table class="table align-middle table-nowrap">
                        <thead>
                            
                        </thead>
                        <tbody>
                            <form class="needs-validation"  novalidate action="{{ route('store-warehouse')}}"  method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">Warehouse Name:</label>
                                            <input type="text" name="name" class="form-control" id="validationCustom01"
                                                placeholder="Enter Warehouse Name" >
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
                                            <label for="validationCustom02" class="form-label">User Email:</label>
                                             <select class="form-select form-control" id="branch_id" name="user_id" style="width:220px;" required>
                                                <option selected disabled>Select Email</option>
                                                @foreach ($users as $user)
                                                <option value="{{ $user->id}}">{{ $user->email}}</option>
                                                @endforeach
                                            </select>
                                            <!--<input type="email" class="form-control" id="validationCustom03"-->
                                            <!--placeholder="Enter Warehouse Email" name="email" >-->
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
                                                placeholder="Enter Warehouse Phone Number" >
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
                                            placeholder="Enter Warehouse Address" name="address" >
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
                                            <label for="validationCustom01" class="form-label">Select One Major Branch:</label>
                                                <select class="form-select form-control" id="branch_id" name="branch_id" style="width:220px;" required>
                                                    <option selected disabled>Select Branch</option>
                                                    @foreach ($branches as $country)
                                                    <option value="{{ $country->name}}">{{ $country->name}}</option>
                                                    @endforeach
                                                </select>
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
                                            <input type="text" value="{{now()->format('d-m-y')}}" class="form-control" id="validationCustom03"
                                            name="date" >
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
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">Opening Balance:</label>
                                            <input type="number" name="open_balance" class="form-control" id="validationCustom01"
                                                placeholder="Enter Opening Balance" >
                                                @if($errors->has('manager_name'))
                                                <span class="text-danger">{{ $errors->first('manager_name') }}</span>
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
                                            name="paid_balance"   >
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
