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
                                    @if (isset($data))
                                    
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 table-sm">
                                        
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th> Name</th>
                                            <th> Email</th>
                                            <th> Phone</th>
                                            <th>Addres</th>
                                            <!--<th>Status</th>-->
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
                                            <td>{{$item->email}}</td>
                                            <td>{{$item->phone_number}}</td>
                                            <td>{{$item->branch_address}}</td>
                                            <!--<td>{{$item->manager_name}}</td>-->
                                            <!-- <td>{{$item->date}}</td> -->
                                            <!--<td>{{$item->status}}</td>-->
                                            <td>
                                                <a href="{{ url('edit-branch/'.$item->id)}} " class="btn btn-primary btn-sm">Edit</a>
                                                |
                                                <a href="{{ url('delete-branch/'.$item->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to Delete this Record ?')">Delete</a>
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
                <h5 class="modal-title" id="transaction-detailModalLabel">Branche Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               

                <div class="table-responsive">
                    <table class="table align-middle table-nowrap">
                        <thead>
                            
                        </thead>
                        <tbody>
                            <form class="needs-validation"  novalidate action="{{ route('store-branch')}}"  method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">Enter Branch Name:</label>
                                            <input type="text" name="name" class="form-control" id="validationCustom01"
                                                placeholder="Enter Branch Name" >
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
                                            <label for="validationCustom02" class="form-label">Branch Email:</label>
                                            <input type="email" class="form-control" id="validationCustom03"
                                            placeholder="Enter Branch Email" name="email"  >
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
                                            <label for="validationCustom01" class="form-label">Enter Phone Number:</label>
                                            <input type="number" name="phone_number" class="form-control" id="validationCustom01"
                                                placeholder="Enter Branch Phone Number" >
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
                                            <label for="validationCustom02" class="form-label">Branch Address:</label>
                                            <input type="text" class="form-control" id="validationCustom03"
                                            placeholder="Enter Branch Address" name="branch_address"  >
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
                                            <label for="validationCustom01" class="form-label">Enter Manager Name:</label>
                                            <input type="text" name="manager_name" class="form-control" id="validationCustom01"
                                                placeholder="Branch's Manager Name" >
                                                @if($errors->has('manager_name'))
                                                <span class="text-danger">{{ $errors->first('manager_name') }}</span>
                                                @endif
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Branch Date:</label>
                                            <input type="date" class="form-control" id="validationCustom03"
                                            name="date" >
                                            @if($errors->has('date'))
                                            <span class="text-danger">{{ $errors->first('date') }}</span>
                                            @endif
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Password:</label>
                                            <input type="password"  placeholder="enter password" class="form-control" id="validationCustom03"
                                            name="password" >
                                            @if($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Confirm Password:</label>
                                            <input type="password" class="form-control" id="validationCustom03"
                                            name="password_confirmation" placeholder="Enter password confirmation" required>
                                            @if($errors->has('date'))
                                            <span class="text-danger">{{ $errors->first('date') }}</span>
                                            @endif
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom01" class="form-label">Select Role Name </label>
                                                       <select class="form-control" name="role" id="user_type">
                                                        <option value="">Select Role Name</option>
                                                        @foreach($roles as $roles)
                                                         <option value="{{$roles->name}}">{{$roles->name}}</option>
                                                         @endforeach
                                                       </select>
                                                        @if($errors->has('brand_id'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('brand_id') }}</span>
                                                        @endif
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