@extends('admin-side.home')
@section('content')
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">

                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-success">Edit Size Details</h4>
                                {{-- <p class="card-title-desc text-info">Please Provide Correct Information.</p> --}}
                                <form class="needs-validation"  novalidate  action="{{ url('update-size/'.$data->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Size Number:</label>
                                                    <input type="number" name="name" class="form-control" id="validationCustom01"
                                                        value="{{ $data->name }}">
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
                                                    <label for="validationCustom01" class="form-label">Select One Category:</label>
                                                    <select class="form-select form-control" id="validationCustom01" name="category_id">
                                                        @foreach($categories as $key => $category)
                                                        {
                                                            <option value="{{$category->id}}" @if($data->category_id == $category->id) selected @endif>{{$category->name}}</option>
                                                        }
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('category_id'))
                                                    <span class="text-danger">{{ $errors->first('category_id') }}</span>
                                                    @endif
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
                                            <!--<div class="form-check mb-3">-->
                                            <!--    <input class="form-check-input" type="checkbox" value="" id="invalidCheck"-->
                                            <!--        required>-->
                                            <!--    <label class="form-check-label" for="invalidCheck">-->
                                            <!--        Agree to terms and conditions-->
                                            <!--    </label>-->
                                            <!--    <div class="invalid-feedback">-->
                                            <!--        You must agree before submitting.-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                            <button type="reset" class="btn btn-secondary waves-effect">
                                                Cancel
                                            </button>

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
