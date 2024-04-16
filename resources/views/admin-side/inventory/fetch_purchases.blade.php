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
                                            <th>Item Name</th>
                                            <th>Purchase Price</th>
                                            <th>Quantity</th>
                                            <th>Total Amount</th>
                                            {{-- <th>Status</th> --}}
                                            <th>Action</th>
                                            
                                        </tr>
                                        </thead>
                    
                                        <tbody>
                                            @php $i=1; @endphp
                                            @if (count($data)> 0)
                                        @foreach ($data as $item)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$item->item_name}}</td>
                                            <td>{{$item->purchase_price}}</td>
                                            <td>{{$item->quantity}}</td>
                                            <td>{{$item->total}}</td>
                                            {{-- <td>{{$item->status}}</td> --}}
                                            <td>
                                                <a href="{{ url('edit-purchases/'.$item->id)}} " class="btn btn-primary btn-sm">Edit</a>
                                                |
                                                <a href="{{ url('delete-purchases/'.$item->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to Delete this Record ?')">Delete</a>
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
                <h5 class="modal-title" id="transaction-detailModalLabel">Purchase Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               

                <div class="table-responsive">
                    <table class="table align-middle table-nowrap">
                        <thead>
                            
                        </thead>
                        <tbody>
                        <form class="needs-validation"  novalidate action="{{ url('store-purchases')}}"  method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                       
                                            <div class="col-md-6">
                                                <div class="mb-6">
                                                <label for="validationCustom01" class="form-label">Select One Item:</label>
                                                <select class="form-select form-control" id="country" name="item_id">
                                                    <option selected disabled>Select Purchased Item</option>
                                                    @foreach ($test as $country)
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