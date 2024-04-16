<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Saafi Shoes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Basic Business Transactions - Add Purchase Invoice" />
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

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
        
        <form  action="{{url('store-purchase-return-invoice')}}" method="post" enctype="multipart/form-data" id="purchase_form">
         @csrf
         <!-- <span class="formdata"> -->
          <div class="row">
            <div class="box col-md-12">
              <div class="box-inner">
                <div class="box-header well col-sm-10" data-original-title="" style="background-color : rgba(10,10,40,0.7) !important; color:white;">
                  <h2><i class="glyphicon glyphicon-plus"></i>Add Purchase Return Invoice</h2>
                </div>
                <div class="box-content col-sm-10" id="add_form">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <input type="text" hidden="" id="company_ids" name="company_id">
                      <label class="control-label" for="Compnay Name">Company</label>
                      <div class="controls">
                        <select id="company_id"  data-rel="chosen"
                          name="company_name" required>
                          <option value="" style="min-width:100%;">Select Company</option>
                          @foreach($company as $company)
                          <option value="{{$company->name}}">{{$company->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="Date of Purchase">Date</label>
                      <input title="Please Select Date of Purchase" data-toggle="tooltip" type="text"
                        style="background-color:#FFF;" class="form-control datetime-purchase vertical" id="date"
                        value="{{now()->format('d-m-y')}}" name="date" placeholder="Enter Date">
                    </div>

                    <div class="form-group col-md-3">
                      <label for="Purchase Invoice Number">Invoice No.</label>
                      <input type="text" autocomplete="off" title="Purchase Invoice No." data-toggle="tooltip"
                        class="form-control vertical" id="invoice" name="invoice" placeholder="Invoice Number">
                    </div>

                    <div class="form-group col-md-2">
                      <label for="Company Previous Balance">Old Balance</label>
                      <input type="text" title="Previous Balance of Company" data-toggle="tooltip" class="balance form-control"
                        id="balance" readonly value="0" name="old_balance" placeholder="Balance">
                    </div>
                  </div>

                </div>
                <!--/span-->
              </div>



              <div class="row">
                <div class="box col-md-10">
                  <div class="box-inner">
                    <div class="box-header well" data-original-title="" style="background-color : rgba(10,10,40,0.7) !important; color:white;">
                      <h2>
                        <i class="glyphicon glyphicon-user"></i>Purchase Return Invoice
                      </h2>
                    </div>
                    <div class="box-content">
                      <table class="table table-striped table-bordered bootstrap-datatable responsive" id="myTable">
                        <thead>
                          <tr>
                            <th width="50">S.No</th>
                            <th width="90">Shop/Warehouse</th>
                            <th style="width:130px;">Product Name</th>
                            <th width="50">Color</th>
                            <th width="90">Size</th>
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
                 <input type="text" hidden="" name="product_id[]" class="product_id" id="product_id" />
                </td>
             
                <!-- ********************product id************************************* -->
                            <td>
                              <select class="warehouse vertical-select" id="warehouse" 
                                name="shop_warehouse[]" required>
                                <option value="" style="min-width: 100%">
                                  Select Warehouse
                                </option>
                                @foreach($warehouses as $warehous)
                                <option value="{{$warehous->name}}">{{$warehous->name}}</option>
                                @endforeach
                              </select>
                            </td>
                            <td>
                              <input style="
                                  width: 100%;
                                  text-align: left;
                                  padding-left: 5px;
                                " type="text"
                                class="form-control alphanum_product vertical product_name" placeholder="Product Name" style="width:110px;"
                                name="product_name[]" onkeyup="fetchProduct(this)" required/>
                             
                            </td>
                            <td>
                              <input class="form-control combine color num_only_integer_quantity vertical " 
                                  type="text" readonly  name="color[]" value=""  style="width:70px;" />
                            </td>
                            <td>
                              <select name="size[]"  class="form-control combine size_no" style="width:70px;">
                              <!-- <option value="">Select size </option> -->
                              </select> 
                            </td>
                            <td style="padding-right: 3px">
                            <input class="form-control combine price num_only_integer_quantity vertical" 
                                  type="text" readonly name="price[]" value="" onkeyup="calc(this)"  style="width:70px;"/>
                            </td>
                            <td>
                              <input class="form-control combine num_only_integer_quantity quantity vertical" 
                                  type="text"  name="quantity[]" value=""  onkeyup="calc(this)" style="width:70px;" required/>
                            </td>
                            <!-- <td >
                            <input class="total num_only_integer_quantity vertical" 
                                  type="text"  name="total_value[]" value="" disabled="" style="width:70px;"/>
                            </td> -->
                            <td>
                              <input type="text" readonly class="form-control total"  name="total[]"  value="0.00" style="width:70px;">

                         </td>
                            <td>
                              <input type="text"  class="form-control form_discount num_only_decimal vertical" name="discount_product[]" value="0" onkeyup="calc(this)" style="width:70px;"/>
                            </td>
                            <td>
                              <input type="text" readonly class="form-control less  num_only_decimal vertical" name="less[]" value="0"  style="width:70px;"/>
                            </td>
                            <td>

                            <input class="form-control net num_only_decimal vertical" 
                                  type="text" id="net" readonly name="net[]" value=""   style="width:90px;"/>
                            </td>
                            <td>
                              <a name="delete_link[]" onClick="delete_row(this)" class="delete"
                                href="javascript:void(0)"><i class="glyphicon glyphicon-remove fa-lg"
                                  style="font-size: 20px"></i></a>
                            </td>
                          </tr>
                        </tbody>
                     

                        <!-- ***************************start next ****************************************************** -->
                      
                        <tfoot id="tfoot" >
                          <tr >
                            <td colspan="6">
                              <button type="button" id="btn_add" class="btn btn-success btn-sm" onClick="addbtn()">Add Line</button>&nbsp;
                            </td>
                            <td colspan="3" class="total" >Current Invoice:</td>
                            <td colspan="2"  id="total_amount">
                              <input type="text" readonly class="form-control total_value" name="total_value" >
                            </td>
                          </tr>

                          <tr>
                            <td colspan="6"></td>
                            <td colspan="3" class="discount">Discount:</td>
                            <td colspan="2" class="discount-td">
                              <input readonly class="form-control discount-val num_only_decimal vertical"
                                autocomplete="off" style="
                                background-color: #fff;
                                padding-left: 2px;
                                font-size: 16px;"
                              value="0.00" id="total_discount"
                                type="text" name="total_discount" />
                            </td>
                          </tr>

                          <tr>
                            <td colspan="6"></td>
                            <td colspan="3" class="total">Discount in value :</td>
                            <td colspan="2"  id="net_amount">
                              <input type="text" readonly class="form-control" value="00.0" name="total_discount_value" id="total_discount_value">
                            </td>
                          </tr>
                          <tr>
                            <td colspan="6"></td>
                            <td colspan="3" class="discount">
                              Extra Discount(%):
                            </td>
                            <td colspan="2" class="discount-td">
                              <!-- <input class="form-control extra-discount  num_only_decimal vertical" type="text" name="extra_discount" /> -->
                              <input type="text" value="0.00" class="form-control extra-discountss" name="extra_discount" onkeyup="findExtraDiscount(this)">
                            </td>
                          </tr>

                          <tr>
                            <td colspan="6"></td>
                            <td colspan="3" class="total">Sub Total:</td>
                            <td colspan="2" class="total-val" id="sub_total">
                             <input type="text" readonly name="sub_total" class="form-control sub_totals" value="0.00" >
                            </td>
                          </tr>
                          <tr>
                            <td colspan="6"></td>
                            <td colspan="3" class="prebal">Previous Balance:</td>
                            <td colspan="2" class="prebal-val" id="previous_bal">
                             <input type="text" readonly value="0.00" class="form-control balance" id="previous_balance">
                            </td>
                          </tr>
                          <tr>
                            <td colspan="6"></td>
                            <td colspan="3" class="total">Total:</td>
                            <td colspan="2" class="total-val" id="payable_balance">
                              <input type="text" readonly class="form-control" value="0.00" name="total_value_of_sub_previous" id="total_value_of_sub_previous">
                            </td>
                          </tr>
                          <tr>
                            <!-- <td colspan="6"></td>
                            <td colspan="3" class="discount" style="padding-top: 8px">
                              Paid:
                            </td>
                            <td colspan="2" class="discount-td"> -->
                            <!-- <input type="text" value="0.00" class="paid_customer_balance" id="paid_customer_balance" name="paid_customer_balance" onkeyup="calc(this)"> -->
                             <!-- <input type="text"  value="0.00" class="form-control paid_customer_balance" id="paid_customer_balance" name="paid_customer_balance" onkeyup="paidCustomerBalance(this)">
                            </td>
                          </tr> -->
                        
                           <!-- <tr>
                            <td colspan="6"></td>
                            <td colspan="3" class="total">Net Balance:</td>
                            <td colspan="2" class="total-val" id="total_bal">
                            <input type="text" readonly value="0.00" class="form-control net_customer_balance" name="net_customer_balance">
                            </td> 
                          </tr> -->
                        </tfoot>
                      </table>
                      <div class="row">
                        <div class="col-sm-12">
                          <input type="submit" class="btn btn-success btn-sm" value="Save Invoice" >
                          <!-- <button type="submit" name="submit" 
                            class="btn btn-success btn-sm verticalbtn">
                            Save Invoice</button>&nbsp;-->
                            <!-- <button type="submit" id="submit_button1" name="submit" 
                            value="snp" class="btn btn-success btn-sm verticalbtn1" onClick="submitform(event)">
                            Save & Print
                          </button> -->
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

  <!-- external javascript -->

 


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

  <script>

     function addbtn()
  {
    var findRow = $("#TRow").clone().appendTo("#TBody");
    $(findRow).find("input").val('');
    $(findRow).find("select").val('');
    $(findRow).removeClass("d-none");
  }


  function delete_row(findIndex)
  {
     $(findIndex).parent().parent().remove();

    // $(findRow).find("input").val('');

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
       var previous_balance =  $("#previous_balance").val();

       var add_subtotal_previous_balance = +(sub_totals) + +(previous_balance);

       $("#total_value_of_sub_previous").val(add_subtotal_previous_balance);
     
       $(".net_customer_balance").val(add_subtotal_previous_balance);

     
      //  find extra discount


      var extra_discount = $(".extra-discountss").val();
      //  console.log(extra_discount);

        var find_percentage_of_extra_discount = extra_discount/100;
      //  console.log(find_percentage_of_extra_discount);

      var total_value =  $(".total_value").val();
      //  console.log(total_value);


       var subtract_extra_discount_from_total_value = total_value - (total_value * find_percentage_of_extra_discount);

       $(".sub_totals").val(subtract_extra_discount_from_total_value);

       var sub_totals =  $(".sub_totals").val();
       var previous_balance =  $("#previous_balance").val();

       var add_subtotal_previous_balance = +(sub_totals) + +(previous_balance);

       $("#total_value_of_sub_previous").val(add_subtotal_previous_balance);
     
       $(".net_customer_balance").val(add_subtotal_previous_balance);

       
       // paid customer balaance

       var paid_balance = $(".paid_customer_balance").val();
             var net_customer_balance =  $("#total_value_of_sub_previous").val();

             var all_balance_of_customer = +(net_customer_balance) - +(paid_balance);

             $(".net_customer_balance").val(all_balance_of_customer);

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
       var previous_balance =  $("#previous_balance").val();

       var add_subtotal_previous_balance = +(sub_totals) + +(previous_balance);

       $("#total_value_of_sub_previous").val(add_subtotal_previous_balance);
     
       $(".net_customer_balance").val(add_subtotal_previous_balance);

     
      //  find extra discount


      var extra_discount = $(".extra-discountss").val();
      //  console.log(extra_discount);

        var find_percentage_of_extra_discount = extra_discount/100;
      //  console.log(find_percentage_of_extra_discount);

      var total_value =  $(".total_value").val();
      //  console.log(total_value);


       var subtract_extra_discount_from_total_value = total_value - (total_value * find_percentage_of_extra_discount);

       $(".sub_totals").val(subtract_extra_discount_from_total_value);

       var sub_totals =  $(".sub_totals").val();
       var previous_balance =  $("#previous_balance").val();

       var add_subtotal_previous_balance = +(sub_totals) + +(previous_balance);

       $("#total_value_of_sub_previous").val(add_subtotal_previous_balance);
     
       $(".net_customer_balance").val(add_subtotal_previous_balance);

       
       // paid customer balaance

       var paid_balance = $(".paid_customer_balance").val();
             var net_customer_balance =  $("#total_value_of_sub_previous").val();

             var all_balance_of_customer = +(net_customer_balance) - +(paid_balance);

             $(".net_customer_balance").val(all_balance_of_customer);


  }


 function findExtraDiscount(v)
 {

  var extra_discount = $(".extra-discountss").val();
      //  console.log(extra_discount);

        var find_percentage_of_extra_discount = extra_discount/100;
      //  console.log(find_percentage_of_extra_discount);

      var total_value =  $(".total_value").val();
      //  console.log(total_value);


       var subtract_extra_discount_from_total_value = total_value - (total_value * find_percentage_of_extra_discount);

       $(".sub_totals").val(subtract_extra_discount_from_total_value);

       var sub_totals =  $(".sub_totals").val();
       var previous_balance =  $("#previous_balance").val();

       var add_subtotal_previous_balance = +(sub_totals) + +(previous_balance);

       $("#total_value_of_sub_previous").val(add_subtotal_previous_balance);
     
       $(".net_customer_balance").val(add_subtotal_previous_balance);

       
       // paid customer balaance

       var paid_balance = $(".paid_customer_balance").val();
             var net_customer_balance =  $("#total_value_of_sub_previous").val();

             var all_balance_of_customer = +(net_customer_balance) - +(paid_balance);

             $(".net_customer_balance").val(all_balance_of_customer);

 }

        function paidCustomerBalance(v)
        {
             var paid_balance = $(".paid_customer_balance").val();
             var net_customer_balance =  $("#total_value_of_sub_previous").val();

             var all_balance_of_customer = +(net_customer_balance) - +(paid_balance);

             $(".net_customer_balance").val(all_balance_of_customer);
        }

  




      function fetchProduct(findindex)
      {

         var index = $(findindex).parent().parent().index();


        var product_name = document.getElementsByClassName("product_name")[index].value;

       $.ajax({

            type: "GET",
            // url:"fetch-product-detail/"+product_name,
            url:"fetch-product-detail",
            data:{'product_name':product_name},
            datatype:"JSON",
            success: function(response)
            {
      console.log(response.product);
             $('.size_no').eq(index).html('');
              $.each(response.product, function(key, item){
                
              document.getElementsByClassName("product_id")[index].value = item.id;
              document.getElementsByClassName("color")[index].value = item.color_id;
              document.getElementsByClassName("price")[index].value = item.price;
             

              var category_table = item.category_id;
              if(category_table == 1)
           
                  $('.size_no').eq(index).append(
                        '<option value="'+item.size_38+'">'+item.size_38+'</option>',
                        '<option value="'+item.size_39+'">'+item.size_39+'</option>',
                        '<option value="'+item.size_40+'">'+item.size_40+'</option>',
                        '<option value="'+item.size_41+'">'+item.size_41+'</option>',
                        '<option value="'+item.size_42+'">'+item.size_42+'</option>',
                        '<option value="'+item.size_43+'">'+item.size_43+'</option>',
                        '<option value="'+item.size_44+'">'+item.size_44+'</option>',
                        '<option value="'+item.size_45+'">'+item.size_45+'</option>',
                        '<option value="'+item.size_46+'">'+item.size_46+'</option>',
                    );

                   else if(category_table == 2)

                        $('.size_no').eq(index).append(
                        '<option value="'+item.l_size_36+'">'+item.l_size_36+'</option>',
                        '<option value="'+item.l_size_37+'">'+item.l_size_37+'</option>',
                        '<option value="'+item.l_size_38+'">'+item.l_size_38+'</option>',
                        '<option value="'+item.l_size_39+'">'+item.l_size_39+'</option>',
                        '<option value="'+item.l_size_40+'">'+item.l_size_40+'</option>',
                        '<option value="'+item.l_size_41+'">'+item.l_size_41+'</option>',
                        '<option value="'+item.l_size_42+'">'+item.l_size_42+'</option>',
                   
                    );

                    else

                        // kids sizes portions

                        $('.size_no').eq(index).append(

                        '<option value="'+item.k_size_1+'">'+item.k_size_1+'</option>',
                        '<option value="'+item.k_size_2+'">'+item.k_size_2+'</option>',
                        '<option value="'+item.k_size_3+'">'+item.k_size_3+'</option>',
                        '<option value="'+item.k_size_4+'">'+item.k_size_4+'</option>',
                        '<option value="'+item.k_size_5+'">'+item.k_size_5+'</option>',
                        '<option value="'+item.k_size_6+'">'+item.k_size_6+'</option>',
                        '<option value="'+item.k_size_7+'">'+item.k_size_7+'</option>',
                        '<option value="'+item.k_size_8+'">'+item.k_size_8+'</option>',
                        '<option value="'+item.k_size_9+'">'+item.k_size_9+'</option>',
                        '<option value="'+item.k_size_10+'">'+item.k_size_10+'</option>',
                        '<option value="'+item.k_size_11+'">'+item.k_size_11+'</option>',
                        '<option value="'+item.k_size_12+'">'+item.k_size_12+'</option>',
                        '<option value="'+item.k_size_13+'">'+item.k_size_13+'</option>',
                        '<option value="'+item.k_size_17+'">'+item.k_size_17+'</option>',
                        '<option value="'+item.k_size_18+'">'+item.k_size_18+'</option>',
                        '<option value="'+item.k_size_19+'">'+item.k_size_19+'</option>',
                        '<option value="'+item.k_size_20+'">'+item.k_size_20+'</option>',
                        '<option value="'+item.k_size_21+'">'+item.k_size_21+'</option>',
                        '<option value="'+item.k_size_22+'">'+item.k_size_22+'</option>',
                        '<option value="'+item.k_size_23+'">'+item.k_size_23+'</option>',
                        '<option value="'+item.k_size_24+'">'+item.k_size_24+'</option>',
                        '<option value="'+item.k_size_25+'">'+item.k_size_25+'</option>',
                        '<option value="'+item.k_size_26+'">'+item.k_size_26+'</option>',
                        '<option value="'+item.k_size_27+'">'+item.k_size_27+'</option>',
                        '<option value="'+item.k_size_28+'">'+item.k_size_28+'</option>',
                        '<option value="'+item.k_size_29+'">'+item.k_size_29+'</option>',
                        '<option value="'+item.k_size_30+'">'+item.k_size_30+'</option>',
                        '<option value="'+item.k_size_31+'">'+item.k_size_31+'</option>',
                        '<option value="'+item.k_size_32+'">'+item.k_size_32+'</option>',
                        '<option value="'+item.k_size_33+'">'+item.k_size_33+'</option>',
                        '<option value="'+item.k_size_34+'">'+item.k_size_34+'</option>',
                        '<option value="'+item.k_size_35+'">'+item.k_size_35+'</option>',



                        );
                    });
                  }
               });

            }









              $(document).ready(function(e){


            $(document).on('change', '#company_id', function(){


            var company_id = $('#company_id').val();

            $.ajax({

                type: "GET",
                url:"fetch-company/"+company_id,
                datatype:"JSON",
                success: function(response)
                {
                  // console.log(response.company);
                    //  $('#booker').val(response.company.id);
                    $('#company_ids').val(response.company.id);
                    $('.balance').val(response.company.balance);
                    // $('#balance').val(response.company.open_balance);
                    //  $('#company_name').val(response.company.name);
                    //  $('#address').val(response.company.address);
                }
            });

            });
            
            
             // show product name in list below search 
            
            
              $(document).on('keyup', '.product_name', function(){

        var value = $(this).val();
        
        $.ajax({

            type:"GET",
            url:"show-product-name-in-li",
            data:{'name':value},
            success:function(data)
            {
              $(".product_list").html(data);
            }

        });

      });

      $(document).on('click', 'li', function(){

        var value = $(this).text();
        $(".product_name").val(value);
        $(".product_list").html('');

      });


});
    </script>
  <!-- select or dropdown enhancer -->

  <!-- library for making tables responsive -->
  <!-- <script src="http://mcas.com.pk/system/assets/admin/bower_components/responsive-tables/responsive-tables.js"></script> -->
</body>

</html>