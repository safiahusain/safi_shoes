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
                                <form class="needs-validation"  novalidate action="{{ url('update-purchases/'.$data->id)}}"  method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                       
                                            <div class="col-md-6">
                                                <div class="mb-6">
                                                <label for="validationCustom01" class="form-label">Select One Item:</label>
                                                <select class="form-select form-control" id="country" name="item_id">
                                                    <option selected disabled>Select Purchased Item</option>
                                                    @foreach ($stock as $country)
                                                    <option value="{{ $country->id }}">{{ $country->item_name }}</option>
                                                    @endforeach
                                                </select>
                                                     @if ($errors->has('item_id'))
                                                     <span class="text-danger">{{ $errors->first('item_id') }}</span>
                                                    @endif                                                                                                                    
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Selected Item Price:</label>
                                                    <input type="text" name="purchase_price" class="form-control" id="state"
                                                        required>
                                                       
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div> 
                                            </div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Enter Quantity:</label>
                                                <input type="number" name="quantity" class="form-control" id="quantity"
                                                    placeholder="Enter Your Name"  oninput="myFunction()" required>
                                                    @if ($errors->has('quantity'))
                                                    <span class="text-danger">{{ $errors->first('quantity') }}</span>
                                                @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Total Amount:</label>
                                                <div class="text-danger" id="total_amount">
    
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