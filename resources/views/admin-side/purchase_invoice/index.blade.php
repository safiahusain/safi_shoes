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
                                    <h4 class="card-title">Return Assign Stock</h4>
                                    
                                    <!--<p class="card-title-desc">Data table with CSV and -->
                                    </p>
                                         <div class="align-middle " >
                                         <a href="{{url('add/purchase/'.'purchase')}}">  <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light" >
                                                Add New Record
                                            </button> </a> <br><br>
                                        </div>
                                    
                                    <table id="table_one" class="table table-bordered dt-responsive nowrap w-100 table-sm">
                                        
                                        <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            <th>Warehouse Name</th>
                                            <th>Product</th>
                                            <th>Color</th>
                                            <th>Branch</th>
                                            <th>Stock</th>
                                            <th>Date</th>
                                           <th>Action</th>
                                            
                                        </tr>
                                        </thead>
                    
                                        <tbody>
                                        @php $i=0; @endphp
                                        @if (count($data)> 0)
                                        @foreach ($data as $item)
                                        <tr>
                                            @php $i++ @endphp
                                            <td>{{$i}}</td>
                                            <td>{{$item->user->name}}</td>
                                            <td> {{$item->product->name}}</td>
                                            <td>{{$item->color->name}}</td>
                                            <td>{{$item->warehouse->name}}</td>
                                            <td> {{$item->assign_stock}}</td>
                                            <td>{{$item->updated_at}}</td>
                                            <td>
                                                <a href="{{ url('edit/purchase/' . urlencode($param) . '/' . $item->id) }}" class=""> <i class="fa-solid fa-pen-to-square"></i></a>
                                                |
                                                <a href="{{ url('delete/purchase/' . urlencode($param) . '/' . $item->id)}}" class="" onclick="return confirm('Are you sure to Delete this Record ?')"><button style="background-color:white; border:none;"><i class="fa-solid fa-trash-can"></button></i></a>
                                                
                                            </td>
                                   </tr>
                                   @endforeach
                                   @endif
                                      </tbody>
                                    </table>
                                    
                                  
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
<!-- <div class="modal fade transaction-detailModal" tabindex="-1" role="dialog" aria-labelledby="transaction-detailModalLabel" aria-hidden="true">
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
                                            <input type="date" class="form-control" id="validationCustom03"
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
</div> -->
<!-- end modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 1000px !important;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Sale Invoice Detail</h5>
          <button type="button" class="close btn_s" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <section class="container">
            <div class="box-header">
              <h2>Sale Detail</h2>
            </div>
            <div style="padding: 10px 20px;">
              <h3 class="text-center">Customer: <span id="p_customer_name"></span></h3>
              <div style="display: flex; justify-content: space-between;">
                <div>
                  <p>Purchase Invoice #: <span id="p_id"></span></p>
                  <p>Previous Balance: <span id="p_previous_balance"></span></p>
                </div>
                <div>
                  <p>Date: <span id="p_date"></span></p>
                  <p>Customer Invoice#: <span></span></p>
                </div>
              </div>
            </div>
            <div>
              <table class="table table-striped  bootstrap-datatable responsive" id="myTable">
                <thead>
                  <tr>
                    <th width="50">S.No</th>
                    <th width="215">Product Name/ Barcode</th>
                    <th width="90">Price</th>
                    <th width="90">Quantity</th>
                    <th width="110">Total</th>
                    <th width="80">Dis (%)</th>
                    <th width="90">Dis Value</th>
                    <th width="100">Net</th>
                  </tr>
                </thead>
                <tbody id="p_t_body">
                 

                
                </tbody>
                <tfoot id="tfoot">
                  <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="invoice-total" style="font-weight: bold;">Invoice Total:</td>
                    <td colspan="2" class="invoice-total-value" style="font-weight: bold;" id="t_net"></td>
                  </tr>
                  <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="dis" style="font-weight: bold; border-bottom: 1px solid black;">Discount:
                    </td>
                    <td colspan="2" class="dis-td" style="font-weight: bold; border-bottom: 1px solid black;" id="t_discount"></td>
                  </tr>

                  <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="payable-invoice" style="font-weight: bold;">Discount In Value:</td>
                    <td colspan="2" class="payable-invoice-value" style="font-weight: bold;" id="t_discount_value"></td>
                  </tr>
                  <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="extra-dis" style="font-weight: bold; border-bottom: 1px solid black;">Extra
                      Discount:</td>
                    <td colspan="2" class="extra-dis-value" style="font-weight: bold; border-bottom: 1px solid black;" id="e_discount">
                      %</td>
                  </tr>

                  <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="subtotal" style="font-weight: bold;">Sub Total:</td>
                    <td colspan="2" class="subtotal-value" style="font-weight: bold;" id="s_total"></td>
                  </tr>
                  <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="prev-balance" style="font-weight: bold; border-bottom: 1px solid black;">
                      Previous Balance:</td>
                    <td colspan="2" class="prev-balance-value"
                      style="font-weight: bold; border-bottom: 1px solid black;"  id="p_balances"></td>
                  </tr>

                  <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="total" style="font-weight: bold;">Total:</td>
                    <td colspan="2" class="total-value" style="font-weight: bold;" id="net_total"></td>
                  </tr>
                  <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="paid" style="font-weight: bold; border-bottom: 1px solid black;">Paid:</td>
                    <td colspan="2" class="paid-value" style="font-weight: bold; border-bottom: 1px solid black;" id="c_paid">
                    </td>
                  </tr>

                  <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="balance" style="font-weight: bold;">Balance:</td>
                    <td colspan="2" class="balance-value" style="font-weight: bold;" id="all_balance"></td>
                  </tr>
                  <tr>
                    <td style="display: flex; gap: 10px;" class="print-btn-hide">
                      <button type="button" id="btn_close btn_s" class="btn btn-success btn-sm btn_s" data-dismiss="modal">Close</button>
                      <button type="button" id="btn_print btn_s" class="btn btn-success btn-sm btn_s" onclick="getPrint('exampleModal')">Print</button>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>

  <!-- end of customer model -->


  <!-- script section start -->

  
<script>

function getPrint2(exampleModal)
{

     // var purchase_detail = document.getElementById('purchase_detail').value;
     var sale_detail = $('#sale_details').val();

     // alert(purchase_detail)

     $.ajax({

           type:"GET",
           url:"fetch-sale-invoice-detail-ajax/"+sale_detail,
           datatype:"JSON",
           success:function(response)
           {
               console.log(response);

             // console.log(response.purchase_detail)
             
             $.each(response.sale_detail, function(key, item){

               // console.log(item.company_name)
               $("#p_customer_name").html(item.customer_name);
               $("#p_previous_balance").html(item.old_balance);
               $("#p_date").html(item.date);
               $("#p_id").html(item.id);


               $("#t_net").html(item.net);
               $("#t_discount").html(item.discount);
               $("#t_discount_value").html(item.total_discount_value);
               $("#e_discount").html(item.less);
               $("#s_total").html(item.sub_total);
               $("#p_balances").html(item.old_balance);
               $("#net_total").html(item.total_value_of_sub_previous);
               $("#c_paid").html(item.paid_customer_balance);
               $("#all_balance").html(item.net_customer_balance);

             });


             var i = 1;
             $('#p_t_body').html('');
             $.each(response.saleii_detail, function(key, item){

               $('#p_t_body').append(

                   '<tr>\
                     <td>'+i+'</td>\
                     <td>'+item.product_name+'</td>\
                     <td>'+item.price+'</td>\
                     <td>'+item.quantity+'</td>\
                     <td>'+item.total+'</td>\
                     <td>'+item.discount+'</td>\
                     <td>'+item.less+'</td>\
                     <td>'+item.net+'</td>\
                   </tr>'
                 

               );
               i++;

             });

           }

           });

           getPrint(exampleModal);

  
}


function getPrint(exampleModal)
{

     var backup = document.body.innerHTML;

     var divcontent = document.getElementById(exampleModal).innerHTML;

     document.body.innerHTML = divcontent;

     window.print();

     document.body.innerHTML = backup;

}


//  }

              $(document).ready(function(){

              $(document).on('click', '#sale_detail', function(e){

                  e.preventDefault();

                  var sale_detail = $(this).val();
                  

                  $.ajax({

                    type:"GET",
                    url:"fetch-sale-invoice-detail-ajax/"+sale_detail,
                    datatype:"JSON",
                    success:function(response)
                    {

                  console.log(response.sale_detail)

                      
                      $.each(response.sale_detail, function(key, item){

                        console.log(item.customer_name)
                        $("#p_customer_name").html(item.customer_name);
                        $("#p_previous_balance").html(item.old_balance);
                        $("#p_date").html(item.date);
                        $("#p_id").html(item.id);


                        $("#t_net").html(item.net);
                        $("#t_discount").html(item.discount);
                        $("#t_discount_value").html(item.total_discount_value);
                        $("#e_discount").html(item.less);
                        $("#s_total").html(item.sub_total);
                        $("#p_balances").html(item.old_balance);
                        $("#net_total").html(item.total_value_of_sub_previous);
                        $("#c_paid").html(item.paid_customer_balance);
                        $("#all_balance").html(item.net_customer_balance);

                      });


                      var i = 1;
                      $('#p_t_body').html('');
                      $.each(response.saleii_detail, function(key, item){

                        $('#p_t_body').append(

                            '<tr>\
                              <td>'+i+'</td>\
                              <td>'+item.product_name+'</td>\
                              <td>'+item.price+'</td>\
                              <td>'+item.quantity+'</td>\
                              <td>'+item.total+'</td>\
                              <td>'+item.discount+'</td>\
                              <td>'+item.less+'</td>\
                              <td>'+item.net+'</td>\
                            </tr>'
                          

                          );
                          i++;

                      });

                    }

                  });
              });
              });


</script>


  <!-- script section end -->

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () 
    {
        $('#table_one').DataTable(
        {
            "scrollX": true
        });
    //   $('.dataTables_length').addClass('bs-select');
    });
</script>


<script src="{{asset('assets/js/pages/form-validation.init.js')}}"></script>
<script src="{{asset('assets/js/pages/shoes.js')}}"></script>
<script>
    function myFunction() 
    {
        var x = document.getElementById("validationCustom04");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>  
@endsection