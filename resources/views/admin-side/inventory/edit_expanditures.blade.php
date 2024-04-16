@extends('admin-side.home')
@section('content')
<div class="main-content">
   
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
               
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-success">Edit Area Form</h4>
                                {{-- <p class="card-title-desc text-info">Please Provide Correct Information.</p> --}}
                                <form class="needs-validation"  novalidate action="{{ url('update-expanditures/'.$data->id)}}"  method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        
                                            <div class="col-md-6">
                                                <div class="mb-6">
                                                <label for="validationCustom01" class="form-label">Select One Expanses Title:</label>
                                                <select class="form-select form-control" id="title_id" name="title_id">
                                                    <option selected disabled>Select Expanses Head</option>
                                                    @foreach ($test as $country)
                                                    <option value="{{ $country->id }}">{{ $country->title }}</option>
                                                    @endforeach
                                                </select>
                                                     @if ($errors->has('title_id'))
                                                     <span class="text-danger">{{ $errors->first('title_id') }}</span>
                                                    @endif                                                                                                                    
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Enter Description:</label>
                                                    <input type="text" name="description" class="form-control" id="description"
                                                    value="{{$data->description}}" required>
                                                       
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div> 
                                            </div>
                                           
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Enter Amount:</label>
                                                <input type="number" name="amount" class="form-control" id="amount"
                                                value="{{$data->amount}}" required>
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
                                                <label for="validationCustom01" class="form-label">Select Date:</label>
                                                <input type="date" name="date" class="form-control" id="date"
                                                   value="{{$data->date}}" required>
                                                    @if ($errors->has('date'))
                                                    <span class="text-danger">{{ $errors->first('date') }}</span>
                                                @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" value="" id="invalidCheck"
                                                required>
                                            <label class="form-check-label" for="invalidCheck">
                                                Agree to terms and conditions
                                            </label>
                                            <div class="invalid-feedback">
                                                You must agree before submitting.
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                        <button type="reset" class="btn btn-secondary waves-effect">
                                            Cancel
                                        </button>
                                    <div>  
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


<script src="asset('assets/js/pages/form-validation.init.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#country').on('change', function () {
            var countryId = this.value;
            $('#state').html('');
            $.ajax({
                url: '{{ route('get-items') }}?country_id='+countryId,
                type: 'get',
                success: function (res) {
                    console.log(res);
                    var x= document.getElementById("state").value = res[0].purchase_price;
                //    console.log(x);
                                    }
            });
        });
      
    });
</script>

<script>
    function myFunction() {
        // alert(1);
      var x = document.getElementById("state").value;
      var y = document.getElementById("quantity").value;
      
      var z= document.getElementById("total_amount").innerHTML = x*y;
    //   alert(z);
    }
</script>
@endsection