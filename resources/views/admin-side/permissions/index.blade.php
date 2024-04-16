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
                                    <!-- <div class="align-middle " >-->
                                    <!--    <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".transaction-detailModal">-->
                                    <!--        Add New Permission-->
                                    <!--    </button> <br><br>-->
                                    <!--</div> -->
                                    @if (isset($permissions))
                                    
                                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                        
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Permission Name</th>
                                            
                                            <!--<th>Action</th>-->
                                            
                                        </tr>
                                        </thead>
                    
                                        <tbody>
                                            @php $i=1; @endphp
                                            @foreach($permissions as $permissions)
                                          <tr>
                                              <td>{{$i}}</td>
                                              <td>{{str_replace('_',' ',ucwords($permissions->name))}}</td>
                                              <!--<td class="d-flex">-->
                                                <!--<a href="{{ route('admin.permissions.edit', $permissions->id)}} " style="background-color:white; border:none"><i class="fa-solid fa-pen-to-square"></i></a>-->
                                                <!--|-->
                                                <!--<a href="{{ url('delete-bank-entry/') }}" style="background-color:white; border:none" onclick="return confirm('Are you sure to Delete this Record ?')"><i class="fa-solid fa-trash-can"></i></a>-->
                                            
                                            <!-- <form action="{{route('admin.permissions.destroy', $permissions->id)}}" method="POST" onsubmit="return confirm('Are you sure to Delete this Record ?')">-->
                                            <!--    @csrf-->
                                            <!--    @method('DELETE')-->
                                                <!--<button type="submit" style="background-color:white !importent; border:none;"><i class="fa-solid fa-trash-can"></i></button>-->
                                            <!--</form>-->
                                            <!--</td>-->
                                          </tr>
                                          @php $i++; @endphp
                                          @endforeach
                                      
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
                <h5 class="modal-title" id="transaction-detailModalLabel">Add Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               

                <div class="table-responsive">
                    <table class="table align-middle table-nowrap">
                        <thead>
                            
                        </thead>
                        <tbody>
                        <form class="needs-validation"  novalidate action="{{ route('admin.permissions.store')}}"  method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        
                                            <div class="col-md-12">
                                             <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Permission:</label>
                                                <input type="text" name="permission_name" class="form-control" id="validationCustom01"
                                                    placeholder="Enter permission name  "  required> 
                                                  

                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                          @error('permission_name')
                                                        <span class="text-danger">{{$message}}</span>
                                                    @enderror
                                  
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