<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Saafi Shoes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Basic Business Transactions - Add Purchase Invoice" />
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<!-- select2  cdn -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/toastr.css') }}">
<!--end of select2  cdn -->
  <!-- The styles -->
  <!-- The styles -->


  <style>
    .small {
      padding: 0px 5px;
    }

    #tbody input[type="text"] {
      width: 50px;
      border-radius: 3px;
      border: 1px solid #cccccc;
      text-align: center;
    }
    .will{
       background-color : black !important;
       color : white;
    }

    #tbody>tr>td,
    #tfoot>tr>td {
      padding: 4px 8px;
    }

    #tfoot>tr>td {
      border: 40px;
    }

    #tfoot .total {
      font-weight: bold;
      font-size: 16px;
    }

    #tfoot .total-val {
      font-weight: bold;
      font-size: 16px;
      padding-left: 10px;
    }

    #tfoot .prebal,
    #tfoot .prebal-val {
      font-weight: bold;
      font-size: 16px;
      border-bottom: double 3px #dddddd;
    }

    #tfoot .prebal-val {
      padding-left: 10px;
    }

    #tfoot .discount {
      font-size: 16px;
    }

    #tfoot .discount-td,
    #tfoot .discount {
      font-weight: bold;
      border-bottom: double 3px #dddddd;
    }

    #tfoot .discount-val {
      padding: 7px 0px;
      font-size: 16px;
    }

    .table-hover>thead>tr>th,
    .table>tbody>tr>td {
      padding: 5px 8px 5px 8px;
    }

    /*for chosen.js required attribute validation*/
    .action-btn {
      color: #333;
    }

    /* select:invalid {
      height: 0px !important;
      opacity: 0 !important;
      position: absolute !important;
      display: flex !important;
    }

    select:invalid[multiple] {
      margin-top: 15px !important;
    } */
    select {
    display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
    box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
    -webkit-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
}
    .bold {
      font-weight: bold;
    }
  </style>
</head>

<body>

  <style>
    li ul li {
      font-size: 12px;
    }
  </style>
  <div class="ch-container">
    <div class="row">
      <!-- left menu starts -->
      <div class="col-sm-2 col-lg-2">

      </div>
      <!--/span-->
      <!-- left menu ends -->


      <style>
        #tbody input[type="text"] {
          width: 100%;
        }

        #myTable .chosen-container a {
          height: 25px;
        }

        #myTable .chosen-container a span {
          line-height: 18px;
        }

        #myTable .chosen-container a div {
          padding-top: 2px;
        }
      </style>
      <div id="content" class="col-lg-10 col-sm-10">
        <!-- content starts -->
        <div>
          <ul class="breadcrumb">

          </ul>
        </div>

        <form  action="{{route('store-saleInvoice',['param'  => $param])}}" method="post" enctype="multipart/form-data" id="purchase_form">
         @csrf
         <!-- <span class="formdata"> -->
          <div class="row">
            <div class="box col-md-12">
              <div class="row">
                <div class="box col-md-10">
                  <div class="box-inner">
                     
                    <div class="box-header well" data-original-title="" style="background-color : rgba(10,10,40,0.7) !important; color:white;">
                        @if($param == 'invoice') 
                            <h2>
                                <i class="glyphicon glyphicon-user"></i> Sale Invoice
                            </h2>
                         @else  
                            <h2>
                                <i class="glyphicon glyphicon-user"></i> Return Sale Invoice
                            </h2> 
                        @endif
                    </div>
                    <div class="box-content">
                      <table class="table table-striped table-bordered bootstrap-datatable responsive invoice-table" id="myTable">
                        <thead>
                          <tr>
                            <th width="50">S.No</th>
                            <th width="90">User/Name</th>
                            <th style="width:130px;">Product Name</th>
                            <th width="50">Color</th>
                            <th width="90">Size</th>
                            <th width="90">Available Stock</th>
                            <th width="100" style="min-width: 85px">Price</th>
                            <th width="90">Quantity</th>
                            <th width="110">Total</th>
                            <th width="80">Dis (%)</th>
                            <th width="80">Dis (Rs)</th>
                            <th width="110">Net</th>
                            <th width="30"></th>
                          </tr>
                        </thead>
                        <tbody id="TBody">



                          <tr id="TRow" class="d-none">
                           <!-- ********************product id************************************* -->
                 <td style="text-align: center" id="count">&nbsp;
                 <!--<input type="text" hidden="" value="" name="product_id[]" class="product_id" id="product_id" />-->
                </td>

                <!-- ********************product id************************************* -->
                            <td>
                              <select class="warehouse vertical-select " id="warehouse"
                                name="user_id[]" required>
                                <option value="{{Auth::user()->id}}" style="min-width: 100%">
                                  {{Auth::user()->name}}
                                </option>
                              </select>
                            </td>
                            <input type='hidden' id="product_data" value="{{json_encode($products)}}">
                            <td>
                                <div class="show_product" value='0'>
                                            
                                </div>
                                <div class="product_list" style="position: relative;">
                                 </div>

                            </td>
                            <input type='hidden' class="pro_price" id="pro_price" value="">
                            <input type='hidden' id="product_price" value="{{json_encode($prices)}}">
                            <input type='hidden' id="size_value" value="{{json_encode($result)}}">
                            <td>
                                <select name="color[]" class="form-control combine js-example-basic-single" style="width:70px;" tabIndex="-1" required>
                                    <option value="" readonly>Select Color </option>
                                    @foreach ($colors as $key  => $color)
                                        <option value="{{$color->id}}">{{ucwords($color->name)}}</option>
                                    @endforeach
                                </select>
                              {{-- <input class="form-control combine color num_only_integer_quantity vertical "
                                  type="text" readonly tabIndex="-1" name="color[]" value=""  style="width:70px;" /> --}}
                            </td>
                            <input type="hidden" id='pro_id'>
                            <input type='hidden' id="size_data" value="{{json_encode($result)}}">
                            <td calss='remove_none d_none'>
                              <!-- <option value="">Select size </option> -->
                              <div class="size-no-data">
    
                              </div>
                            </td>
                            {{-- <td>
                                <input class="form-control combine num_only_integer_quantity Available Stock"
                                    type="text"  name="quantity[]" value=""  onkeyup="calc(this)" required style="width:50px;"/>
                              </td> --}}
                                <input type='hidden' id="stock_data" value="{{json_encode($Stocks_data)}}">
                              <td  id="edit_stock">
                                <input class="form-control combine Stock num_only_integer_quantity vertical stock_no"
                                    type="text" readonly name="stock[]" id='stock-no' value="" required  style="width:70px;" />
                                <input type="hidden" value="" class="stock_data">
                              </td>
                            <td style="padding-right: 3px">
                            <input class="form-control combine price num_only_integer_quantity vertical price_value"
                                  type="text" readonly tabIndex="-1"  name="price[]" value="" onkeyup="calc(this)"  id="price_value"  required style="width:70px;"/>
                            </td>
                            <td>
                              <input class="form-control combine num_only_integer_quantity quantity vertical"
                                  type="text"  name="quantity[]" value=""  onkeyup="calc(this)" required style="width:50px;"/>
                            </td>
                            <!-- <td >
                            <input class="total num_only_integer_quantity vertical"
                                  type="text"  name="total_value[]" value="" disabled="" style="width:70px;"/>
                            </td> -->
                            <td>
                              <input type="text" class="form-control total total_roww" readonly tabIndex="-1"  name="total[]"  value="0.00" style="width:70px;">

                         </td>
                            <td>
                              <input type="text"  class="form-control form_discount num_only_decimal vertical" name="discount_product[]" value="0" onkeyup="calc(this)" style="width:70px;"/>
                            </td>
                            <td>
                              <input type="text" readonly tabIndex="-1"  class="form-control less  num_only_decimal vertical" name="less[]" value="0"  style="width:70px;"/>
                            </td>
                            <td>

                            <input class="form-control net num_only_decimal vertical"
                                  type="text" id="net" readonly tabIndex="-1"  name="net[]" value=""   style="width:70px;"/>
                            </td>
                            <td>
                              <a name="delete_link[]" onClick="delete_row(this)" tabIndex="-1" class="delete"
                                href="javascript:void(0)"><i class="glyphicon glyphicon-remove fa-lg"
                                  style="font-size: 20px"></i></a>
                            </td>
                          </tr>
                        </tbody>


                        <!-- ***************************start next ****************************************************** -->

                        <tfoot id="tfoot">
                            <input type="hidden" hidden="" class="form-control sum_totals_of_product" readonly tabIndex="-1"  name="sum_of_all_product" style="width:150px;">
                          <tr>
                            <td colspan="6">
                              <button type="button" id="btn_add" class="btn btn-success btn-sm" onClick="addbtn()">Add Line</button>&nbsp;
                            </td>
                            <td colspan="3" class="total">Current Invoice:</td>
                            <td colspan="2"  id="total_amount">
                              <input type="text" class="form-control total_value" readonly tabIndex="-1" name="total_value" style="width:150px;">

                            </td>
                          </tr>

                          <tr style="display:none;">
                            <td colspan="6"></td>
                            <td colspan="3" class="discount">Discount:</td>
                            <td colspan="2" class="discount-td">
                              <input readonly class="form-control form-control discount-val num_only_decimal vertical"

                              value="0.00" id="total_discount"
                                type="text" name="total_discount" readonly tabIndex="-1" style="width:150px;"/>
                            </td>
                          </tr>

                          <tr style="display:none;">
                            <td colspan="6"></td>
                            <td colspan="3" class="total">Discount in value :</td>
                            <td colspan="2"  id="net_amount">
                              <input type="text" readonly tabIndex="-1" class="form-control" value="00.0" name="total_discount_value" id="total_discount_value" style="width:150px;">
                            </td>
                          </tr>
                          <tr>
                            <td colspan="6"></td>
                            <td colspan="3" class="discount">
                              Extra Discount:
                            </td>
                            <td colspan="2" class="discount-td">

                              <input type="text" value="0.00" class="form-control extra-discountss" name="extra_discount" onkeyup="findExtraDiscount(this)" style="width:150px;">
                            </td>
                          </tr>

                          <tr style="display:none;">
                            <td colspan="6"></td>
                            <td colspan="3" class="total">Sub Total:</td>
                            <td colspan="2" class="total-val" id="sub_total">
                             <input type="text" name=" sub_total" readonly tabIndex="-1" class="form-control sub_totals" value="0.00" style="width:150px;">
                            </td>
                          </tr>
                          <tr>
                            <td colspan="6"></td>
                            <td colspan="3" class="total">Total:</td>
                            <td colspan="2" class="total-val" id="payable_balance">
                              <input type="text" class="form-control" value="0.00" readonly tabIndex="-1" name="total_value_of_sub_previous" id="total_value_of_sub_previous" style="width:150px;">
                            </td>
                          </tr>
                          <tr>
                            <td colspan="6"></td>
                            <td colspan="3" class="total">Net Balance:</td>
                            <td colspan="2" class="total-val" id="total_bal">
                            <input type="text" value="0.00" readonly tabIndex="-1" class="form-control net_customer_balance" name="net_customer_balance" style="width:150px;">
                            </td>
                          </tr>
                        </tfoot>
                      </table>
                      <div class="row">
                        <div class="col-sm-12">
                          <input type="submit" class="btn btn-success btn-sm" value="Save Invoice" style="width:150px;">

        </form>

                        </div>
                        <div class="col-sm-12"></div>
                        <div class="col-sm-12"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--/span-->
                <div class="col-md-2" style="padding-left: 0px">
                  <div class="form-group">
                    <!-- <label style="font-size: 12px">Printable Invoice Notes</label>
                    <textarea class="form-control" name="printable" style="resize: none"></textarea> -->
                  </div>
                  <div class="form-group">
                    <!-- <label style="font-size: 12px">Non-Printable (Private) Invoice Notes</label>
                    <textarea class="form-control" name="non_printable" style="resize: none"></textarea> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        <!--/row-->

        <!--/row-->
        <!-- content ends -->
      </div>
      <!--/#content.col-md-0-->
    </div>
    <!--/fluid-row-->
  </div>
  <!--/.fluid-container-->



  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <!--  data table plugin -->
  <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<!-- select2 tag cdn  -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  
            <script src="{{ asset('assets/js/toastr.js') }}"></script>

     <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>-->
  <!-- end select2 tag cdn  -->
  <script>
    $(document).ready(function() 
    {
            show_product();
        $('.js-example-basic-single').select2();
        
            
         toastr.options.timeOut = 10000;
         @if (Session::has('error'))
             toastr.error('{{ Session::get('error') }}');
         @elseif(Session::has('success'))
             toastr.success('{{ Session::get('success') }}');
         @endif
    });
    
    let index    =   0;
    
    function addbtn() 
    {
        var lastRow =   $('.invoice-table tbody tr:last-child');
        var newRow  =   lastRow.clone();
       
        newRow.find("input").val('');
        newRow.find("select").val('');
        newRow.removeClass("d-none");
        
        newRow.find('.select2-container').remove();
        
        newRow.find("[id]").each(function() 
        {
            var oldId = $(this).attr("id");
            var newId = oldId ? oldId.replace(/\d+$/, "") + "_" + ($('.invoice-table tbody tr').length) : undefined;
            if (newId) 
            {
                $(this).attr("id", newId);
            }
        });
        
        newRow.find('.size-no-data').html('');
        lastRow.after(newRow);
        $('.js-example-basic-single').select2();
    }
       
        function show_product()
        {
            let product_data    =   $('#product_data').val();
            product_data        =   JSON.parse(product_data);
            let capitalizeFirstLetter = str => str.charAt(0).toUpperCase() + str.slice(1);
            let input_value     =   "";
            let i               =   0;
            
            input_value +=  "<select name='product_id[]' class='form-control combine js-example-basic-single' style='width: 100px;' onchange='productName(this)' tabIndex='-1' required>\
                                <option value='' disabled selected>Select Product Name </option>";
                                console.log(product_data);
                                $.each(product_data, function (key, value)
                                {
                                    if(key  ==  'name_'+i)
                                    {
                                        let pro_id  =   product_data['id_'+i];
                                        
                                        console.log(value);
                                        input_value +=  "<option value='"+product_data['id_'+i]+"'>"+capitalizeFirstLetter(value)+" "+(product_data['code_'+i])+" </option>";
                                        i++;
                                    }
                                });
            input_value +=  "</select>";
            
            $('.show_product').html(input_value);
            
        }
        

  function delete_row(findIndex)
  {
     $(findIndex).parent().parent().remove();

     // ************************calculate price total************************

      var sum_product_price = 0;

          var totals = document.getElementsByClassName("total_roww");

      for(let index = 0; index < totals.length; index++)
        {
          var total = totals[index].value;

          // console.log(total);


          sum_product_price += parseInt(total);

        }

        $(".sum_totals_of_product").val(sum_product_price);
//

      // ************************end calculate price total************************

    // $(findRow).find("input").val('');
    // operation perform in all row net value

        var sum = 0;

       var amounts = document.getElementsByClassName("net");

        for(let index = 0; index < amounts.length; index++)
        {
          var amount = amounts[index].value;

          var sum = +(sum) + +(amount);

        }

         $(".total_value").val(sum);


         var total_discount = 0;

         var discounts = document.getElementsByClassName("form_discount");

         for(let index = 0; index < discounts.length; index++)
        {
          var discount = discounts[index].value;

          var total_discount = +(total_discount) + +(discount);

        }

        $("#total_discount").val(total_discount);



var total_discount_value = 0;

 var discount_values = document.getElementsByClassName("less");

 for(let index = 0; index < discount_values.length; index++)
{
  var discount_value = discount_values[index].value;

  var total_discount_value = +(total_discount_value) + +(discount_value);

}

$("#total_discount_value").val(total_discount_value);

// console.log(total_discount);



//  *********************** after adding extra discount in discount **********************************



 //  var total_value =  $(".total_value").val();
 //  console.log(total_value);


 //  var subtract_extra_discount_from_total_value = total_value - (total_value * find_percentage_of_extra_discount);

  $(".sub_totals").val(sum);

  var sub_totals =  $(".sub_totals").val();
//   var previous_balance =  $("#previous_balance").val();

  var add_subtotal_previous_balance = +(sub_totals);

  $("#total_value_of_sub_previous").val(add_subtotal_previous_balance);

  $(".net_customer_balance").val(add_subtotal_previous_balance);


 //  find extra discount


 var extra_discount = $(".extra-discountss").val();
 //  console.log(extra_discount);

   var find_percentage_of_extra_discount = extra_discount;
 //  console.log(find_percentage_of_extra_discount);

 var total_value =  $(".total_value").val();
 //  console.log(total_value);


  var subtract_extra_discount_from_total_value = total_value - find_percentage_of_extra_discount;

  $(".sub_totals").val(subtract_extra_discount_from_total_value);

  var sub_totals =  $(".sub_totals").val();
//   var previous_balance =  $("#previous_balance").val();

  var add_subtotal_previous_balance = +(sub_totals);

  $("#total_value_of_sub_previous").val(add_subtotal_previous_balance);

  $(".net_customer_balance").val(add_subtotal_previous_balance);


//   // paid customer balaance

//   var paid_balance = $(".paid_customer_balance").val();
//         var net_customer_balance =  $("#total_value_of_sub_previous").val();

//         var all_balance_of_customer = +(net_customer_balance) - +(paid_balance);

//         $(".net_customer_balance").val(all_balance_of_customer);

  }




  function calc(findIndex)
  {

    var index = $(findIndex).parent().parent().index();

// find multipication of quantity and price

    var quantity = document.getElementsByClassName("quantity")[index].value;
    var price = document.getElementsByClassName("price")[index].value;
    var total = quantity * price ;

    document.getElementsByClassName("total")[index].value = total;



  // get discount value
    var discount =  document.getElementsByClassName("form_discount")[index].value;

    // find discount value and discount and percentage

    var totalDiscount = discount/100;
    var totalLess = total - (total*totalDiscount);

    var less = total - totalLess;

    // show less value in input

    document.getElementsByClassName("less")[index].value = less;


    var net = total - less;

  //  show net value in net input
    document.getElementsByClassName("net")[index].value = net;

    // operation perform in all row net value

     var sum = 0;

        var amounts = document.getElementsByClassName("net");

     for(let index = 0; index < amounts.length; index++)
     {
       var amount = amounts[index].value;

       var sum = +(sum) + +(amount);

     }

      $(".total_value").val(sum);


      var total_discount = 0;

      var discounts = document.getElementsByClassName("form_discount");

      for(let index = 0; index < discounts.length; index++)
     {
       var discount = discounts[index].value;

       var total_discount = +(total_discount) + +(discount);

     }

     $("#total_discount").val(total_discount);



     var total_discount_value = 0;

      var discount_values = document.getElementsByClassName("less");

      for(let index = 0; index < discount_values.length; index++)
     {
       var discount_value = discount_values[index].value;

       var total_discount_value = +(total_discount_value) + +(discount_value);

     }

     $("#total_discount_value").val(total_discount_value);

    // console.log(total_discount);



  //  *********************** after adding extra discount in discount **********************************



      //  var total_value =  $(".total_value").val();
      //  console.log(total_value);


      //  var subtract_extra_discount_from_total_value = total_value - (total_value * find_percentage_of_extra_discount);

       $(".sub_totals").val(sum);

       var sub_totals =  $(".sub_totals").val();
    //   var previous_balance =  $("#previous_balance").val();

       var add_subtotal_previous_balance = +(sub_totals);

       $("#total_value_of_sub_previous").val(add_subtotal_previous_balance);

       $(".net_customer_balance").val(add_subtotal_previous_balance);


      //  find extra discount


      var extra_discount = $(".extra-discountss").val();
      //  console.log(extra_discount);

        var find_percentage_of_extra_discount = extra_discount;
      //  console.log(find_percentage_of_extra_discount);

      var total_value =  $(".total_value").val();
      //  console.log(total_value);


       var subtract_extra_discount_from_total_value = total_value - find_percentage_of_extra_discount;

       $(".sub_totals").val(subtract_extra_discount_from_total_value);

       var sub_totals =  $(".sub_totals").val();
    //   var previous_balance =  $("#previous_balance").val();

       var add_subtotal_previous_balance = +(sub_totals);

       $("#total_value_of_sub_previous").val(add_subtotal_previous_balance);

       $(".net_customer_balance").val(add_subtotal_previous_balance);


       // paid customer balaance

    //   var paid_balance = $(".paid_customer_balance").val();
    //          var net_customer_balance =  $("#total_value_of_sub_previous").val();

    //          var all_balance_of_customer = +(net_customer_balance) - +(paid_balance);

    //          $(".net_customer_balance").val(all_balance_of_customer);



              // ************************calculate price total************************

      var sum_product_price = 0;

          var totals = document.getElementsByClassName("total_roww");

      for(let index = 0; index < totals.length; index++)
        {
          var total = totals[index].value;

          // console.log(total);


          sum_product_price += parseInt(total);

        }

        $(".sum_totals_of_product").val(sum_product_price);
//

      // ************************end calculate price total************************


  }


 function findExtraDiscount(v)
 {

  var extra_discount = $(".extra-discountss").val();
      //  console.log(extra_discount);

        // var find_percentage_of_extra_discount = extra_discount/100;
      //  console.log(find_percentage_of_extra_discount);

      var total_value =  $(".total_value").val();
      //  console.log(total_value);


       var subtract_extra_discount_from_total_value = total_value - extra_discount;

       $(".sub_totals").val(subtract_extra_discount_from_total_value);

       var sub_totals =  $(".sub_totals").val();
    //   var previous_balance =  $("#previous_balance").val();

       var add_subtotal_previous_balance = +(sub_totals);

       $("#total_value_of_sub_previous").val(add_subtotal_previous_balance);

       $(".net_customer_balance").val(add_subtotal_previous_balance);


       // paid customer balaance

    //   var paid_balance = $(".paid_customer_balance").val();
    //          var net_customer_balance =  $("#total_value_of_sub_previous").val();

    //          var all_balance_of_customer = +(net_customer_balance) - +(paid_balance);

    //          $(".net_customer_balance").val(all_balance_of_customer);

 }

        function paidCustomerBalance(v)
        {
            //  var paid_balance = $(".paid_customer_balance").val();
             var net_customer_balance =  $("#total_value_of_sub_previous").val();

             var all_balance_of_customer = +(net_customer_balance);

             $(".net_customer_balance").val(all_balance_of_customer);
        }
         // get product name in list
        var i   =   0;
        
        function productName(x)
        {
            var index           =   $(x).parent().parent().parent().index();
            var target          =   x.options[x.selectedIndex];
            var product         =   target.value;
            let size_data       =   $('#size_data').val();
            size_data           =   JSON.parse(size_data);
            let product_price   =   $('#product_price').val();
            product_price       =   JSON.parse(product_price);
            let size_value      =   "";
            let i               =   0;
            let j               =   0;
             
            $('.remove_none').removeClass('d-none');
            size_value +=  "<select name='size_id[]' class='form-control combine js-example-basic-single' style='width: 100px;' onchange='get_stock(this)' tabIndex='-1' required>\
                                <option value='' disabled selected>Select Size </option>";
                                
                                $.each(size_data, function (key, value)
                                {
                                    if(key  ==  'size_'+i)
                                    {
                                        if(size_data['proid_'+i] == product)
                                        {
                                            size_value +=  "<option value='"+value+"' data-id='"+product+"'>"+value+"</option>";
                                        }
                                        i++;
                                    }
                                });
            size_value +=  "</select>";
            
            
            
            $.each(product_price, function (p_key, p_value)
            {
                if(p_key  ==  'price_'+j)
                {
                    if(product_price['proid_'+j] == product)
                    {
                        $('.price_value').eq(index).val(p_value);
                        $('.pro_price').eq(index).val(p_value);
                    }
                    j++;
                }
            });
            
            $('.size-no-data').eq(index).html(size_value);
            $('.js-example-basic-single').select2();
        }
        
        function get_stock(x)
        {
            let target_btn  =   $(x);
            var index2      =   target_btn.parent().parent().parent().index();
             var target     =   x.options[x.selectedIndex];
            var size        =   target.value;
            let data_value  =   target.getAttribute('data-id');
            let stock_data  =   $('#stock_data').val();
            stock_data      =   JSON.parse(stock_data);
            let stock_value =   "";
            let i           =   0;
            let j           =   0;
            
            $.each(stock_data, function (key, value) 
            {
                if (value['proid'] == data_value) 
                {
                    $.each(value['sizes'], function (s_key, s_value) 
                    {
                        if (s_value.size == size) 
                        {
                            stock_value = s_value.stock;
                            return false; 
                        }
                    });
                    return false;
                }
            });
            console.log(stock_value);                
            $('.stock_no').eq(index2).val(stock_value);
        }
        var category_table1 = 1;

        function fetchProduct(findindex)
        {
            var index = $(findindex).parent().parent().index();


            var product_name = document.getElementsByClassName("product_name")[index].value;

            $.ajax({

                    type: "GET",
                    url:"fetch-product-detail",
                    data:{'product_name':product_name},
                    datatype:"JSON",
                    success: function(response)
                    {
                        // console.log(response.product);
                        $('.size_no').eq(index).html('');
                        $('.stock_no').eq(index).html('');
                        $('.stock_data').eq(index).html('');
                        // console.log(response.product);
                        $.each(response.product, function(key, item){

                        document.getElementsByClassName("price")[index].value = item.s_price;


                        $('.stock_data').eq(index).val(JSON.stringify(item));
                        var category_table = item.category_id;
                        console.log(category_table);
                        if(category_table == 1)
                        {
                            $('.size_no').eq(index).append(
                                    '<option dataId="38" value="'+item.size_38+'">'+item.size_38+'</option>',
                                    '<option dataId="39" value="'+item.size_39+'">'+item.size_39+'</option>',
                                    '<option dataId="40" value="'+item.size_40+'">'+item.size_40+'</option>',
                                    '<option dataId="41" value="'+item.size_41+'">'+item.size_41+'</option>',
                                    '<option dataId="42" value="'+item.size_42+'">'+item.size_42+'</option>',
                                    '<option dataId="43" value="'+item.size_43+'">'+item.size_43+'</option>',
                                    '<option dataId="44" value="'+item.size_44+'">'+item.size_44+'</option>',
                                    '<option dataId="45" value="'+item.size_45+'">'+item.size_45+'</option>',
                                    '<option dataId="46" value="'+item.size_46+'">'+item.size_46+'</option>',
                                );
                        }
                        else if(category_table == 2)
                        {
                            $('.size_no').eq(index).append(
                            '<option dataId="36" value="'+item.l_size_36+'">'+item.l_size_36+'</option>',
                            '<option dataId="37" value="'+item.l_size_37+'">'+item.l_size_37+'</option>',
                            '<option dataId="38" value="'+item.l_size_38+'">'+item.l_size_38+'</option>',
                            '<option dataId="39" value="'+item.l_size_39+'">'+item.l_size_39+'</option>',
                            '<option dataId="40" value="'+item.l_size_40+'">'+item.l_size_40+'</option>',
                            '<option dataId="41" value="'+item.l_size_41+'">'+item.l_size_41+'</option>',
                            '<option dataId="42" value="'+item.l_size_42+'">'+item.l_size_42+'</option>',
                            );
                        }
                        else if(category_table == 3)
                        {
                            // kids sizes portions

                            $('.size_no').eq(index).append(

                            '<option dataId="1" value="'+item.k_size_1+'">'+item.k_size_1+'</option>',
                            '<option dataId="2" value="'+item.k_size_2+'">'+item.k_size_2+'</option>',
                            '<option dataId="3" value="'+item.k_size_3+'">'+item.k_size_3+'</option>',
                            '<option dataId="4" value="'+item.k_size_4+'">'+item.k_size_4+'</option>',
                            '<option dataId="5" value="'+item.k_size_5+'">'+item.k_size_5+'</option>',
                            '<option dataId="6" value="'+item.k_size_6+'">'+item.k_size_6+'</option>',
                            '<option dataId="7" value="'+item.k_size_7+'">'+item.k_size_7+'</option>',
                            '<option dataId="8" value="'+item.k_size_8+'">'+item.k_size_8+'</option>',
                            '<option dataId="9" value="'+item.k_size_9+'">'+item.k_size_9+'</option>',
                            '<option dataId="10" value="'+item.k_size_10+'">'+item.k_size_10+'</option>',
                            '<option dataId="11" value="'+item.k_size_11+'">'+item.k_size_11+'</option>',
                            '<option dataId="12" value="'+item.k_size_12+'">'+item.k_size_12+'</option>',
                            '<option dataId="13" value="'+item.k_size_13+'">'+item.k_size_13+'</option>',
                            '<option dataId="17" value="'+item.k_size_17+'">'+item.k_size_17+'</option>',
                            '<option dataId="18" value="'+item.k_size_18+'">'+item.k_size_18+'</option>',
                            '<option dataId="19" value="'+item.k_size_19+'">'+item.k_size_19+'</option>',
                            '<option dataId="20" value="'+item.k_size_20+'">'+item.k_size_20+'</option>',
                            '<option dataId="21" value="'+item.k_size_21+'">'+item.k_size_21+'</option>',
                            '<option dataId="22" value="'+item.k_size_22+'">'+item.k_size_22+'</option>',
                            '<option dataId="23" value="'+item.k_size_23+'">'+item.k_size_23+'</option>',
                            '<option dataId="24" value="'+item.k_size_24+'">'+item.k_size_24+'</option>',
                            '<option dataId="25" value="'+item.k_size_25+'">'+item.k_size_25+'</option>',
                            '<option dataId="26" value="'+item.k_size_26+'">'+item.k_size_26+'</option>',
                            '<option dataId="27" value="'+item.k_size_27+'">'+item.k_size_27+'</option>',
                            '<option dataId="28" value="'+item.k_size_28+'">'+item.k_size_28+'</option>',
                            '<option dataId="29" value="'+item.k_size_29+'">'+item.k_size_29+'</option>',
                            '<option dataId="30" value="'+item.k_size_30+'">'+item.k_size_30+'</option>',
                            '<option dataId="31" value="'+item.k_size_31+'">'+item.k_size_31+'</option>',
                            '<option dataId="32" value="'+item.k_size_32+'">'+item.k_size_32+'</option>',
                            '<option dataId="33" value="'+item.k_size_33+'">'+item.k_size_33+'</option>',
                            '<option dataId="34" value="'+item.k_size_34+'">'+item.k_size_34+'</option>',
                            '<option dataId="35" value="'+item.k_size_35+'">'+item.k_size_35+'</option>',
                            );
                        }

                        var category_table1 = item.category_id;
                        if(category_table1 == 1)
                        {
                            $('.stock_no').eq(index).val(item.stock_38);
                        }
                        else if(category_table1 == 2)
                        {
                            $('.stock_no').eq(index).val(item.l_stock_36);
                        }
                        else
                        {
                            $('.stock_no').eq(index).val(item.k_stock_1);
                        }

                        });
                    }
            });
        }
        
              $(document).ready(function(e){

            $(document).on('change', '#customer_id', function(){


            var customer_id = $(this).val();


            $.ajax({

                type: "GET",
                url:"fetch-customer-for-sale/"+customer_id,
                datatype:"JSON",
                success: function(response)
                {

                    $.each(response.customer, function(key, item){

                        $('#customer_id').val(item.id);
                       $('.balance').val(item.balance);

                    });

                }
            });

            });

});

                         
    </script>
  <!-- select or dropdown enhancer -->

  <!-- library for making tables responsive -->
  <!-- <script src="http://mcas.com.pk/system/assets/admin/bower_components/responsive-tables/responsive-tables.js"></script> -->
</body>

</html>
