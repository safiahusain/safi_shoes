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
                                            <th>Company-Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>address</th>
                                            {{-- <th>Branch Name</th> --}}
                                            <th>Balance</th>
                                            <th>Date</th>
                                            <!-- <th>Status</th> -->
                                            <th>Action</th>
                                            
                                        </tr>
                                        </thead>
                    
                                        <tbody>
                                            @php $i=1; @endphp
                                            @if (count($data)> 0)
                                        @foreach ($data as $item)
                                        <input type="text" id="company_id" value="{{$item->id}}" hidden="">
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->email}}</td>
                                            <td>{{$item->phone}}</td>
                                            <td>{{$item->address}}</td>
                                            {{-- <td>{{$item->branch_name}}</td> --}}
                                            <td>{{$item->open_balance}}</td>
                                            <td>{{$item->date}}</td>
                                            <!-- <td>{{$item->status}}</td> -->
                                            <td>
                                                <a href="{{ url('edit-company/'.$item->id)}} " class="btn btn-primary btn-sm">Edit</a>
                                                |
                                                <a href="{{ url('delete-company/'.$item->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to Delete this Record ?')">Delete</a>
                                          <!-- opening modal -->
 <!-- Button trigger modal -->
                                                 <button
                                                    type="button"
                                                    data-toggle="modal"
                                                    data-target="#exampleModal"  
                                                    style="border: none; background-color: transparent; outline: none;" value="{{$item->id}}" id="company_detail" 
                                                    >
                                                    <i class="fa-solid fa-magnifying-glass-plus"  ></i>
                                                    </button>

                                                    <!-- Modal -->

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
                <h5 class="modal-title" id="transaction-detailModalLabel">Company's Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               

                <div class="table-responsive">
                    <table class="table align-middle table-nowrap">
                        <thead>
                            
                        </thead>
                        <tbody>
                            <form class="needs-validation"  novalidate action="{{ route('store-company')}}"  method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">Company Name:</label>
                                            <input type="text" name="name" class="form-control" id="validationCustom01"
                                                placeholder="Enter company Name" >
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
                                            <label for="validationCustom02" class="form-label">Company Email:</label>
                                            <input type="email" class="form-control" id="validationCustom03"
                                            placeholder="Enter Company Email" name="email"  >
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
                                            <label for="validationCustom01" class="form-label">Company Phone Number:</label>
                                            <input type="number" name="phone" class="form-control" id="validationCustom01"
                                                placeholder="Enter Company Phone Number" >
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
                                            <label for="validationCustom02" class="form-label">Company Address:</label>
                                            <input type="text" class="form-control" id="validationCustom03"
                                            placeholder="Enter Company Address" name="address"  >
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
                                    {{-- <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">Select One Major Branch:</label>
                                                <select class="form-select form-control" id="branch_id" name="branch_id">
                                                    <option selected disabled>Select Branch</option>
                                                    @foreach ($branches as $country)
                                                    <option value="{{ $country->id}}">{{ $country->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('branch_id'))
                                                <span class="text-danger">{{ $errors->first('branch_id') }}</span>
                                                @endif
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">Opening:</label>
                                            <input type="number" name="open_balance" class="form-control" id="validationCustom01"
                                                placeholder="Enter Opening Balance" >
                                                @if($errors->has('open_balance'))
                                                <span class="text-danger">{{ $errors->first('open_balance') }}</span>
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
                                            name="date"  >
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


<!-- purchase opening model -->
<div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document" style="max-width: 700px !important;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Company Details</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
       
            <div class="modal-body">
            <table class="table table-striped table-bordered bootstrap-datatable responsive" id="myTable">
                <thead>
                  <tr>
                    <th width="150px">Company Name</th>
                    <th width="60">Opening</th>
                    <th width="90">Purchase</th>
                    <th width="150">Purchase Return</th>
                    <th width="60">Paid</th>
                    <th width="80">Balance</th>
                  </tr>
                </thead>
                <tbody id="company_details">
                  
                </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
    <script>
   
       

        $(document).ready(function(){

            $(document).on('click', '#company_detail', function(){

          var company_detail = $(this).val();
      
        $.ajax({
            type:"GET",
             url:"show-company-balance-detail/"+company_detail,
             datatype: "JSON",
             success: function(response)
             {

                $('#company_details').html('');
                $.each(response.company, function(key, item){
               
                $('#company_details').append(

                        '<tr>\
                          <td>'+item.name+'</td>\
                          <td>'+item.open_balance+'</td>\
                          <td>'+item.purchase_price+'</td>\
                          <td>'+item.purchase_return+'</td>\
                          <td>'+item.total_paid_balance+'</td>\
                          <td>'+item.balance+'</td>\
                        </tr>'

                    );
                });
             }
        });

            });

    });
    

    </script>


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