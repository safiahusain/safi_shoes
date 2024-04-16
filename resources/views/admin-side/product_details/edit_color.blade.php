@extends('admin-side.home')
@section('content')
<div class="main-content">
   
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
               
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-success">Edit Color Details</h4>
                                {{-- <p class="card-title-desc text-info">Please Provide Correct Information.</p> --}}
                                <form class="needs-validation"  novalidate  action="{{ url('update-color/'.$data->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Color Name:</label>
                                                    <input type="text" name="name" class="form-control" id="validationCustom01"
                                                        value="{{ $data->name }}">
                                                        @if($errors->has('name'))
                                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                                        @endif
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Choose Date:</label>
                                                    <input type="date" name="date" class="form-control" id="validationCustom01"
                                                        value="{{ $data->date }}">
                                                        @if($errors->has('date'))
                                                        <span class="text-danger">{{ $errors->first('date') }}</span>
                                                        @endif
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div> -->
                                          
                                        </div>
                                        <div class="col-md-6">
                                             <button class="btn btn-primary" type="submit">Submit </button>
                                            <button type="reset" class="btn btn-secondary waves-effect">
                                                Cancel
                                            </button>
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
                                           
                                           
                                        </div>  
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