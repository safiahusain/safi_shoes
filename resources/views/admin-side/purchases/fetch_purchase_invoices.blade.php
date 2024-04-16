
@extends('admin-side.home')
@section('content')
@include('admin-side.purchases.purchase-modal-css')
<div class="main-content">
  

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                @if(isset($purchaseinvoice))
                                    <!--<h4 class="card-title">Buttons example</h4>-->
                                    <!--<p class="card-title-desc">Data table with CSV and -->
                                    <!--</p>-->
                                     <div class="align-middle " >
                                     <a href="{{url('purchase-invoice-form')}}">  <button id="abc" type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light" >
                                            Add New Record
                                        </button> </a> <br><br>
                                    </div> 
                                 
                                    
                                    <table id="table_one" class="table table-bordered table-responsive nowrap">
                                        
                                        <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            <th>Inv#</th>
                                            <th>Date</th>
                                            <th>Company Name</th>
                                            <th>Sub Total</th>
                                            <!--<th>Discount</th>-->
                                            <!--<th>Extra Discount</th>-->
                                        
                                            <th>Total</th>
                                           <th>Action</th>
                                            
                                        </tr>
                                        </thead>
                  
                                        <tbody>
                                        @php $i=0; @endphp
                                        <!-- @if (count($purchaseinvoice)> 0) -->
                                        @foreach ($purchaseinvoice as $item)
                                        <tr>
                                            @php $i++ @endphp
                                            <td style='width:10%'>{{$i}}</td>
                                            <td style='width:10%'>{{$item->id}}</td>
                                            <td style='width:10%'>{{$item->date}}</td>
                                            <td style='width:10%'>{{$item->company_name}}</td>
                                            <td style='width:10%'> {{$item->sum_of_all_product}}</td>
                                            <!--<td>{{$item->discount}}%</td>-->
                                            <!--<td> {{$item->less}}%</td>-->
                                           
                                            <td style='width:10%'>{{$item->sub_total}}</td>
                                         
                                          <td style='width:20%'>
                                            
                                                <a href="{{url('edit-purchase-invoice/'.$item->id)}}"  style="background-color:white; border:none">
                                               <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                                |
                                                <a href="{{ url('delete-purchase-invoice/'.$item->id) }}"   onclick="return confirm('Are you sure to Delete this Record ?')">   <button style="background-color:white; border:none" name="product_id[]" value="{{$item->product_id}}" >
                                                <i class="fa-solid fa-trash-can"></i>
                                                 </button></a>
                                               
                                                <!-- model of complete product -->
                                                |
                                                <button
                                                    type="button"
                                                    data-toggle="modal"
                                                    data-target="#exampleModal"  
                                                    style="border: none; background-color: transparent; outline: none;" value="{{$item->id}}" id="purchase_detail" 
                                                    >
                                                    <i class="fa-solid fa-magnifying-glass-plus"  ></i>
                                                    </button>
                                                    |
                                                    <!--<button  style="background-color:white; border:none;" value="{{$item->id}}" id="purchase_detailss" onclick="getPrint2('exampleModal')"><i class="fa-solid fa-print"></i></button>-->

                                                    <!-- Modal -->
                                            </td>
                                   </tr>
                                   @endforeach
                                   <!-- @endif -->
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


  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 1000px !important;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Purchase Invoice Detail</h5>
          <button type="button" class="close btn_s" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <section class="container">
            <div class="box-header">
              <h2>Purchase Detail</h2>
            </div>
            <div style="padding: 10px 20px;">
              <h3 class="text-center">Company: <span id="p_company_name"></span></h3>
              <div style="display: flex; justify-content: space-between;">
                <div>
                  <p>Purchase Invoice #: <span id="p_id"></span></p>
                  <p>Previous Balance: <span id="p_previous_balance"></span></p>
                </div>
                <div>
                  <p>Date: <span id="p_date"></span></p>
                  <p>Company Invoice#: <span></span></p>
                </div>
              </div>
            </div>
            <div>
              <table class="table table-striped  bootstrap-datatable responsive" id="myTable">
                <thead>
                  <tr>
                    <th width="50">S.No</th>
                    <th width="215">Product Name/Barcode</th>
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
                    <!-- <a href="{{url('edit-purchase-invoice/')}}"> <button type="button" id="btn_aedit btn_s" class="btn btn-success btn-sm btn_s">Edit</button></a> -->
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

  @endif

  <!-- script section -->

<script>

       function getPrint2(exampleModal)
       {

            // var purchase_detail = document.getElementById('purchase_detail').value;
            var purchase_detail = $('#purchase_detailss').val();

            

            $.ajax({

                  type:"GET",
                  url:"fetch-purchase-invoice-detail-ajax/"+purchase_detail,
                  datatype:"JSON",
                  success:function(response)
                  {

                    // console.log(response.purchase_detail)
                    
                    $.each(response.purchase_detail, function(key, item){

                      // console.log(item.company_name)
                      $("#p_company_name").html(item.company_name);
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
                    $.each(response.purchaseii_detail, function(key, item){

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

    $(document).ready(function()
    {
        $('#table_one').DataTable(
        {
            "scrollX": true
        });

        $(document).on('click', '#purchase_detail', function(e){

            e.preventDefault();

            var purchase_detail = $(this).val();
            

            $.ajax({

              type:"GET",
              url:"fetch-purchase-invoice-detail-ajax/"+purchase_detail,
              datatype:"JSON",
              success:function(response)
              {
                
                $.each(response.purchase_detail, function(key, item){

                  console.log(item.company_name)
                  $("#p_company_name").html(item.company_name);
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
                $.each(response.purchaseii_detail, function(key, item){

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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
<script src="{{asset('assets/js/pages/form-validation.init.js')}}"></script>
<script src="{{asset('assets/js/pages/shoes.js')}}"></script>
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



