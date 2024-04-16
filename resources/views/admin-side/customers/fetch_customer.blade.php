@extends('admin-side.home')
@section('content')

  <style>
 
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>
  
  
   <!-- Modal -->
   
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Customer's Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{url('store-customer')}}" method="POST">
            @csrf
        <div class="modal-body">
          <div style="display: flex; gap: 30px; margin-bottom: 10px;">
            <div style="width: 50%;"> 
                <label for="" style="font-weight: 500;">Name:</label> <br>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter Customer Name" required>
            </div>
            <div style="width: 50%;">
                <label for="" style="font-weight: 500;">Email:</label> <br>
                <input type="email" id="name" name="email" class="form-control" placeholder="Enter Email Optional">
            </div>
          </div>

          <div style="display: flex; gap: 30px; margin-bottom: 10px;">
            <div style="width: 50%;"> 
                <label for="" style="font-weight: 500;">Date:</label> <br>
                <input type="text" id="date" value="{{now()->format('d-m-y')}}"  name="date" class="form-control">
            </div>
            <!--<div style="width: 50%;">-->
            <!--    <label for="" style="font-weight: 500;">Companies Name:</label> <br>-->
            <!--    <select class="" name="company_name" id="company_name" style="width:220px;">-->
            <!--        <option value="">Select Company Name</option>-->
            <!--       @foreach($company as $company)-->
            <!--       <option value="{{$company->name}}">{{$company->name}}</option>-->
            <!--      @endforeach-->
            <!--    </select>-->
            <!--</div>-->
          </div>
          
          
          <div style="display: flex; gap: 30px; margin-bottom: 10px;">
            <div style="width: 50%;"> 
                <label for="" style="font-weight: 500;">Mobile:</label> <br>
                <input type="tel" id="mobile" name="mobile" class="form-control" placeholder="Enter Customer Contact">
            </div>
            <div style="width: 50%;">
                <label for="" style="font-weight: 500;">Address:</label> <br>
                <input type="text" id="address" name="address" class="form-control" placeholder="Enter Customer Address">
            </div>
          </div>

          <div style="width: 100%;">
            <div style="width: 100%;"> 
                <label for="" style="font-weight: 500;">Op. Balance:</label> <br>
                <input type="number" name="open_balance" id="opBlance" class="form-control" placeholder="Enter Open Balance">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
       </form>
    </div>
  </div>
 

     <!--customer info start -->
    <!--<div style="width: 1000px; margin: 80px 50px 20px auto"> -->
    <!--    <h4 style="background-color: yellow; text-align: center; padding: 10px;">CUSTOMER INFO FORM</h4>-->
    <!--    <form action="{{url('store-customer')}}" method="POST">-->
    <!--        @csrf-->
    <!--         customer info top start  -->
    <!--        <div style="display: flex;">-->

    <!--             customer info top left side  -->
    <!--            <div style="padding: 10px; background-color: rgb(152, 255, 152); width: 60%;">-->
    <!--                <div style="display: flex;">-->
    <!--                    <div>-->
    <!--                        <label for="code" style="width: 56px; font-weight: bold;">Code</label>-->
    <!--                        <input type="number" name="code" id="code">-->
    <!--                    </div>-->
    <!--                    <div style="margin-left: 50px;">-->
    <!--                        <label for="date" style="width: 56px; font-weight: bold;">Date</label>-->
    <!--                        <input type="text" id="date" value="{{now()->format('d-m-y')}}"  name="date" style="margin-left: 77px;">-->
    <!--                    </div>-->
    <!--                </div>-->
        
    <!--                <div style="display: flex; margin-bottom: 5px;">-->
    <!--                    <label for="name" style="width: 60px; font-weight: bold;">Name</label>-->
    <!--                    <input type="text" id="name" name="name" style="width: 90%; margin-left: auto;" required/>-->
    <!--                </div>-->

    <!--                <div style="display: flex; margin-bottom: 5px;">-->
    <!--                    <label for="name" style="width: 60px; font-weight: bold;">Email</label>-->
    <!--                    <input type="email" id="name" name="email" style="width: 90%; margin-left: auto;">-->
    <!--                </div>-->

    <!--                <div class="" style="display: flex; margin-bottom: 5px;">-->
    <!--                    <div style="display: flex; width: 50%;">-->
    <!--                        <label for="name" style="display: block; font-weight: bold; margin-right: 10px;">Saleman's Name</label>-->
    <!--                        <select name="saleman_name">-->
    <!--                            @foreach($saleman as $saleman)-->
    <!--                            <option value="{{$saleman->name}}">{{$saleman->name}}</option>-->
    <!--                            @endforeach-->
    <!--                        </select>-->
    <!--                    </div>-->
    <!--                    <div style="display: flex; width: 50%;">-->
    <!--                        <label for="" style="display: block; font-weight: bold; margin-right: 10px;">Companies Name</label>-->
    <!--                        <select name="company_name" style="width: auto;">-->
    <!--                           
    <!--                        </select>-->
    <!--                    </div>-->
    <!--                </div>-->
        
    <!--                <div style="display: flex;">-->
    <!--                    <div>-->
    <!--                        <label for="phone" style="width: 56px; font-weight: bold;">Phone</label>-->
    <!--                        <input type="number" id="phone" name="phone" style="margin-left: auto;">-->
    <!--                    </div>-->
    <!--                    <div style="margin-left: 50px">-->
    <!--                        <label for="mobile" style="width: 56px; font-weight: bold;">Mobile</label>-->
    <!--                        <input type="number" id="mobile" name="mobile" style="margin-left: 30px;">-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--                <div style="display: flex; margin-bottom: 5px;">-->
    <!--                    <label for="address" style="width: 60px; font-weight: bold;">Address</label>-->
    <!--                    <input type="text" id="address" name="address" style="width: 90%; margin-left: auto;">-->
    <!--                </div>-->
    <!--            </div>-->

    <!--             customer info top right side  -->
    <!--            <div style="padding: 10px; background-color: rgb(188, 152, 255); width: 40%;">-->
    <!--                <div>-->
    <!--                    <label for="opBalance" style="font-weight: bold; width: 120px;">Op. Balance</label>-->
    <!--                    <input type="number" name="open_balance" id="opBlance">-->
    <!--                </div>-->
    <!--                 <div>-->
    <!--                    <label for="sale" style="font-weight: bold; width: 120px;">Sale</label>-->
    <!--                    <input type="number" name="sale" id="sale">-->
    <!--                </div>-->
    <!--                <div>-->
    <!--                    <label for="received" style="font-weight: bold; width: 120px;">Received</label>-->
    <!--                    <input type="number" name="received" id="received">-->
    <!--                </div>-->
    <!--                <div>-->
    <!--                    <label for="balance" style="font-weight: bold; width: 120px;">Balance</label>-->
    <!--                    <input type="number" name="balance" id="balance">-->
    <!--                </div> -->-->
                
    <!--                     <label for="balance" style="font-weight: bold; width: 120px;">Balance</label> -->
    <!--                     <input type="button" class="btn btn-success" name="balance" value="submit" id="balance"> -->
    <!--                    <button type="submit" class="btn btn-success">Submit</button>-->
                       
    <!--                </div>-->
    <!--              </div>-->
    <!--              </form>-->
    <!--            </div>-->
        
    <!--     <form action="" method="get">-->
    <!--        <div class="text-center pt-3 float-end mr-4 mb-2" style="">-->
    <!--            <label for="search" style="font-weight: bold;">Search</label>-->
    <!--            <input type="text" id="search" name="search">-->
    <!--            <button class="btn btn-primary btn-sm" type="submit" >Search</button>-->
    <!--        </div>-->
    <!--    </form>-->
            <!-- customer info top end  -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" style="margin-left: 234px; margin-top: 100px;">
                 Add New Customer
             </button>
            @if (isset($data))


            <!-- customer info table start  -->

            <div class="" style="margin-bottom:100px; ">
                 <!-- Button trigger modal -->
              
                
            <table id="dataTable" class="table table-striped table-bordered " style="width:78%; margin-left:262px; margin-right:auto; ">
            <thead>
                    <tr>
                        <th>Date</th>
                        <th>Code</th>
                        <th>Customer</th>
                        <!-- <th>Email</th> -->
                        <!--<th>Phone</th>-->
                        <th>Mobile</th>
                        <th>Address</th>
                        <th>Op_Balance</th>
                        <!-- <th>Saleman</th>
                        <th>Company</th>  -->
                        <th>Action</th>
                    </tr>
                </thead>
            <tbody>
                @php $i=1; @endphp
               @if (count($data)> 0)
                 @foreach ($data as $item)
                    <tr>
                     <td>{{$item->date}}</td>
                     <td>{{$item->id}}</td>
                     <td>{{$item->name}}</td>
                     <!-- <td>{{$item->email}}</td> -->
                     <!--<td>{{$item->phone}}</td>-->
                     <td>{{$item->mobile}}</td>
                     <td>{{$item->address}}</td>
                     <td>{{$item->open_balance}}</td>
                     <!-- <td>{{$item->saleman_name}}</td> 
                    <td>{{$item->company_name}}</td> -->
                    
                    <!-- <td>{{$item->sale}}</td>
                    <td>{{$item->receive}}</td>
                    <td>{{$item->balance}}</td> -->
                    
                    <td>
                                                <a href="{{url('edit-customer/'.$item->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                                |
                                                <a href="{{ url('delete-customer/'.$item->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to Delete this Record ?')">Delete</a>
                                               
                                                <!-- Button trigger modal -->
                                                <button
                                                    type="button"
                                                    data-toggle="modal"
                                                    data-target="#exampleModalone"  
                                                    style="border: none; background-color: transparent; outline: none;" value="{{$item->id}}" id="customer_specific_id"
                                                    >
                                                    <i class="fa-solid fa-magnifying-glass-plus"  ></i>
                                                    </button>


                                                    <!-- Modal -->
                                            </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
         </table>
</div>
          
            <!-- customer info table end  -->

         

    
    </div>
    @endisset


    <!-- purchase opening model -->
<div
      class="modal fade"
      id="exampleModalone"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document" style="max-width: 700px !important;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Customer Details</h5>
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
                    <th width="150px">Customer Name</th>
                    <th width="60">Opening</th>
                    <th width="90">Sale price</th>
                    <th width="150">Sale Return</th>
                    <th width="60">Paid</th>
                    <th width="80">Balance</th>
                  </tr>
                </thead>
                <tbody id="customer_details">
                  
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


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  


    
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
<script>

$(document).ready(function(){

    $('#dataTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'pdfHtml5',
            'print'
        ]
    });



   $(document).on('click','#customer_specific_id', function(e){
    e.preventDefault();
    var customer_specific_id = $(this).val();

   

        
    $.ajax({
            type:"GET",
             url:"show-customer-balance-detail/"+customer_specific_id,
             datatype: "JSON",
             success: function(response)
             {
              
                $('#customer_details').html('');
                $.each(response.customer, function(key, item){
               
                $('#customer_details').append(

                        '<tr>\
                          <td>'+item.name+'</td>\
                          <td>'+item.open_balance+'</td>\
                          <td>'+item.sale_price+'</td>\
                          <td>'+item.sale_return+'</td>\
                          <td>'+item.total_paid_balance+'</td>\
                          <td>'+item.balance+'</td>\
                        <tr>'

                    );
                });
             }
        });


    

   });




});

</script>


@endsection