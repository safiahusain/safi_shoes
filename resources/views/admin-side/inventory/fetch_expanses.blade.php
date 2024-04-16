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
                                    
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                        
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Expanse Title</th>
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
                                            <td>{{$item->title}}</td>
                                            <td>{{$item->status}}</td>
                                            <td>
                                                <a href="{{ url('edit-expanses/'.$item->id)}} " class="btn btn-primary btn-sm">Edit</a>
                                                |
                                                <a href="{{ url('delete-expanses/'.$item->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to Delete this Record ?')">Delete</a>
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
                <h5 class="modal-title" id="transaction-detailModalLabel">City Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               

                <div class="table-responsive">
                    <table class="table align-middle table-nowrap">
                        <thead>
                            
                        </thead>
                        <tbody>
                        <form class="needs-validation"  novalidate action="{{ url('store-expanses')}}"  method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Enter Expanse Head(title):</label>
                                                <input type="text" name="title" class="form-control" id="validationCustom01"
                                                    placeholder="Enter Your Expanses Name"  required> 
                                                    @if ($errors->has('title'))
                                                        <span class="text-danger">{{ $errors->first('title') }}</span>
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
</div>
<!-- end modal -->

<script src="asset('assets/js/pages/form-validation.init.js')}}"></script>
@endsection