<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Basic Business Transactions - Add Purchase Invoice</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Basic Business Transactions - Add Purchase Invoice" />
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/css/toastr.css') }}">
   <!--The styles -->


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
        <form  action="{{ route('upadte-saleInvoice',['id' => $data->id,'param'  => $param]) }}" method="post" enctype="multipart/form-data" id="purchase_form">
         @csrf
          <div class="row">
            <div class="box col-md-12">
              <div class="row">
                <div class="box col-md-10">
                  <div class="box-inner">
                    <div class="box-header well col-sm-12" data-original-title="" style="background-color : rgba(10,10,40,0.7) !important; color:white;">
                        @if($param == 'invoice') 
                            <h2>
                                <i class="glyphicon glyphicon-user"></i> Edit Sale Invoice
                            </h2>
                         @else  
                            <h2>
                                <i class="glyphicon glyphicon-user"></i> Edit Return Sale Invoice
                            </h2> 
                        @endif
                    </div>
                    <div class="box-content">
                      <table class="table table-striped table-bordered bootstrap-datatable responsive" id="myTable">
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

                            <input type="hidden" id="edit_product_size" value="{{$sales_balances}}">
                           
                            @foreach($sales_balances as $purchaseinvoice)
                            
                                <tr id="TRow" class="d-none">
                                     <td style="text-align: center" id="count">&nbsp;
                                    </td>
        
                                    <td>
                                      <select class="warehouse vertical-select" id="warehouse"
                                        name="user_id[]">
                                        <option value="{{Auth::user()->id}}" style="min-width: 100%">
                                          {{Auth::user()->name}}
                                        </option>
                                      </select>
                                    </td>
                                    <td>
                                        <div id='show_product' class="show_product">
                                                
                                        </div>
                                    </td>
                                    <input type='hidden' id="size_data" class='size_data' value="{{json_encode($result)}}">
                                    <input type='hidden' id="data-id" value="{{$purchaseinvoice->id}}">
                                    <input type='hidden' id="product_data" class="product_data" value="{{json_encode($products)}}">
                                    <input type='hidden' id="product_id" class="product_data_id" value="">
                                    <input type='hidden' id="data-product-id" value="{{$purchaseinvoice->product_id}}">
                                    <input type='hidden' id="data-invoice-id" value="{{$purchaseinvoice->id}}">
                                    <input type='hidden' id="stock_data" class='stock_data' value="{{json_encode($Stocks_data)}}">
                                    <input type='text' hidden="" name='prev_size_id[]' id="prev_size_id" value="{{$purchaseinvoice->size}}">
                                    <input type='text' hidden="" name='prev_product_id[]' id="prev_product_id" value="{{$purchaseinvoice->product_id}}">
                                    <input type='text' hidden="" name='prev_quantity[]' id="prev_quantity" value="{{$purchaseinvoice->assign_stock}}">
                                    <input type='hidden' id="selected_size" class="selected_size" value="">
                                    <input type='hidden' id="data-key" value="">
                                    <input type='hidden' id="size_value" value="{{json_encode($result)}}">
                                    <td>
                                        <select name="color[]" class="form-control combine js-example-basic-single" style="width:70px;" tabIndex="-1">
                                            <option value="" readonly>Select Color </option>
                                            @foreach ($colors as $key  => $color)
                                                <option value="{{$color->id}}" @if($purchaseinvoice->color_id==$color->id)   selected @endif>{{ucwords($color->name)}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <div id='{{"$purchaseinvoice->id-edit_size_no"}}'>
        
                                        </div>
                                        <div id="show_size" class="show_size">
        
                                        </div>
                                    </td>
                                    <td style="padding-right: 3px" id="edit_stock">
                                        <input class="form-control combine price num_only_integer_quantity vertical stock_no" id="stock-no" value="" type="text"  name="stock[]" readonly onkeyup="calc(this)"  style="width:70px;"/>
                                        </td>
                                    <input type="hidden" id='pro_id'>
                                <input type='hidden' id="pro_price" class="pro_price" value="{{$data->price}}">
                                <input type='hidden' id="product_price" value="{{json_encode($prices)}}">
                                    <td style="padding-right: 3px">
                                    <input class="form-control combine price num_only_integer_quantity vertical price_value"
                                          type="text"  name="price[]" readonly value="{{$purchaseinvoice->price}}" onkeyup="calc(this)"  style="width:70px;"/>
                                    </td>
                                    <td>
                                      <input class="form-control combine num_only_integer_quantity quantity vertical"
                                          type="text"  name="quantity[]" value="{{$purchaseinvoice->assign_stock}}"  onkeyup="calc(this)" style="width:70px;"/>
                                    </td>
                                    <td>
                                      <input type="text" class="form-control total total_roww" readonly name="total[]"  value="{{$purchaseinvoice->total_price}}" style="width:70px;">
        
                                 </td>
                                    <td>
                                      <input type="text"  class="form-control form_discount num_only_decimal vertical" name="discount_product[]" value="{{$purchaseinvoice->discount}}" onkeyup="calc(this)" style="width:70px;"/>
                                    </td>
                                    <td>
                                      <input type="text" readonly  class="form-control less  num_only_decimal vertical" name="less[]" value="{{$purchaseinvoice->discount_price}}"  style="width:70px;"/>
                                    </td>
                                    <td>
        
                                    <input class="form-control net num_only_decimal vertical"
                                          type="text" id="net" readonly  name="net[]" value="{{$purchaseinvoice->net_balance}}"   style="width:90px;"/>
                                    </td>
                                    <td>
                                      <a name="delete_link[]" onClick="delete_row(this)" class="delete"
                                        href="javascript:void(0)"><i class="glyphicon glyphicon-remove fa-lg"
                                          style="font-size: 20px"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>


                        <!-- ***************************start next ****************************************************** -->

                        <tfoot id="tfoot">
                          <tr>
                            <td colspan="6">
                              <!-- <button type="button" id="btn_add" class="btn btn-success btn-sm" onClick="addbtn()">Add Line</button>&nbsp;<button type="button" id="clear" class="btn btn-success btn-sm" onClick="clear_all()">Clear</button> -->
                            </td>
                            <td colspan="3" class="total">Current Invoice:</td>
                            <td colspan="2"  id="total_amount">
                              <input type="text" readonly class="form-control total_value" name="total_value" value="{{$data->current_invoice}}">
                            </td>
                          </tr>

                          <tr style="display:none;">
                            <td colspan="6"></td>
                            <td colspan="3" class="discount">Discount:</td>
                            <td colspan="2" class="discount-td">
                              <input readonly class="form-control discount-val num_only_decimal vertical"
                                autocomplete="off" style="
                                background-color: #fff;
                                padding-left: 2px;
                                font-size: 16px;"
                               id="total_discount"
                                type="text" name="total_discount" readonly value="{{$data->total_discount}}"/>
                            </td>
                          </tr>

                          <tr style="display:none;">
                            <td colspan="6"></td>
                            <td colspan="3" class="total">Discount in value :</td>
                            <td colspan="2"  id="net_amount">
                              <input type="text" class="form-control" readonly value="{{$data->total_discount}}" name="total_discount_value" id="total_discount_value">
                            </td>
                          </tr>
                          <tr style="">
                            <td colspan="6"></td>
                            <td colspan="3" class="discount">
                              Extra Discount:
                            </td>
                            <td colspan="2" class="discount-td">
                               <!--<input class="form-control extra-discount  num_only_decimal vertical" type="text" name="extra_discount" />-->
                              <input type="text" value="{{$data->extra_descount}}" class="form-control extra-discountss" name="extra_discount" onkeyup="findExtraDiscount(this)">
                            </td>
                          </tr>

                          <tr style="">
                            <td colspan="6"></td>
                            <td colspan="3" class="total">Sub Total:</td>
                            <td colspan="2" class="total-val" id="sub_total">
                             <input type="text" name="sub_total" readonly class="form-control sub_totals"  value="{{$data->sub_total}}">
                            </td>
                          </tr>
                          <tr>
                            <td colspan="6"></td>
                            <td colspan="3" class="total">Net Balance:</td>
                            <td colspan="2" class="total-val" id="total_bal">
                            <input type="text" readonly value="{{$data->net_balance}}" class="form-control net_customer_balance" name="net_customer_balance">
                            </td>
                          </tr>
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

  <!-- <script>
    $(document).ready(function () {
      $('#myTable').DataTable({
        responsive: true
      });
    });
  </script> -->
  <!-- <script type="application/javascript">
    // $.widget.bridge("uitooltip", $.ui.tooltip);
    // $.widget.bridge("uibutton", $.ui.button);

    $(document).ready(function () {
      // confirmation
      $(".confirm-dialog").on("click", function () {
        event.preventDefault();
        var lnk = $(this).attr("href");
        $.confirm({
          title: "Confirmation",
          content: "To confirm please click on proceed.",
          icon: "fa fa-question-circle",
          animation: "scale",
          closeAnimation: "scale",
          opacity: 0.5,
          buttons: {
            confirm: {
              text: "Proceed",
              btnClass: "btn-blue",
              action: function () {
                location.href = lnk;
              },
            },
            cancel: function () { },
          },
        });
      });
    });
  </script> -->



      <!-- <form action="">
        <input type="text" id="product" >
        <input type="text" id="colorsss" >
        <input type="text" id="pricesss" >
        <input type="text" id="product" > -->
      <!-- </form>  -->


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

  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="{{ asset('assets/js/toastr.js') }}"></script>
  <script>
    let purchaseinvoice     =   null;
    let product_size        =   null;
    let edit_pro_id         =   null;

    $(document).ready(function()
    {
        
        
        let edit_pro_id     =   $('#edit_pro_id').val();
        purchaseinvoice     =   $('#edit_product_size').val();
        purchaseinvoice     =   JSON.parse(purchaseinvoice);
    
        $.each(purchaseinvoice, function(key, value)
        {
            let i   =   0;
            let data_invoice_id =   $('#data-invoice-id').val(value.id);
            let data_product_id =   $('#data-product-id').val(value.product_id);
            let product_id      =   $('.product_data_id').val(value.product_id);
            document.getElementsByClassName("product_data_id").value    =   value.product_id;
            document.getElementsByClassName("selected_size").value    =   value.size;
            let data_key        =   $('#data-key').val(key);
            let x               =   null;
            
            show_product(value.product_id);
            productName(x);
            get_stock(x);
        });
        
            
        $('.js-example-basic-single').select2();
         toastr.options.timeOut = 10000;
         @if (Session::has('error'))
             toastr.error('{{ Session::get('error') }}');
         @elseif(Session::has('success'))
             toastr.success('{{ Session::get('success') }}');
         @endif

    });
    
    
        function show_product(id)
        {
            let product_id      =   id;
            let product_data    =   $('.product_data').val();
            product_data        =   JSON.parse(product_data);
            let capitalizeFirstLetter = str => str.charAt(0).toUpperCase() + str.slice(1);
            let input_value     =   "";
            let i               =   0;

            input_value +=  "<select name='product_id[]' class='form-control combine js-example-basic-single' onchange='productName(this)' tabIndex='-1' required>\
                                <option value='' disabled selected>Select Product Name </option>";
                                $.each(product_data, function (key, value)
                                {
                                    if(key  ==  'name_'+i)
                                    {
                                        let pro_id  =   product_data['id_'+i];
                                        
                                        input_value +=  "<option value='"+product_data['id_'+i]+"' " + (product_id == product_data['id_'+i] ? "selected" : "") + ">"+capitalizeFirstLetter(value)+" "+(product_data['code_'+i])+" </option>";
                                        i++;
                                    }
                                });
            input_value +=  "</select>";
            
            $('.show_product').html(input_value);
        }
        
        function productName(x)
        {
            var index           =   $(x).parent().parent().index();
            var product         =   "";
            
            if(x)
            {
                var target  =   x.options[x.selectedIndex];
                product     =   target.value;
            }
            else
            {
                index       =   $('#data-key').val();
                product     =   document.getElementsByClassName("product_data_id").value;
            }
            
            let size_data   =   $('.size_data').val();
            size_data       =   JSON.parse(size_data);
            let size_value  =   "";
            let i           =   0;
            
            if(x)
            {
                size_value +=  "<select name='size_id[]' class='form-control combine js-example-basic-single' onchange='get_stock(this)' tabIndex='-1' required>\
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
                            $('.price_value').val(p_value);
                            $('.pro_price').val(p_value);
                        }
                        j++;
                    }
                });
                
                // $('#stock-no').val('');
                // $(".remaing_stock").val('');
                // $(".quantity").val('');
                // $("#total_price").val('');
                // $("#total_value").val('0.00');
                // $("#net").val('');
                // $("#net_customer_balance").val('0.00');
            }
            else
            {
                size_value +=  "<select name='size_id[]' class='form-control combine js-example-basic-single' onchange='get_stock(this)' tabIndex='-1' required>\
                                    <option value='' disabled selected>Select Size </option>";
                                    $.each(size_data, function (key, value)
                                    {
                                        if(key  ==  'size_'+i)
                                        {
                                            if(size_data['proid_'+i] == product)
                                            {
                                                let selected_size   =   document.getElementsByClassName("selected_size").value;  
                                                
                                                size_value +=  "<option value='"+value+"' data-id='"+product+"'" + (value == selected_size ? "selected" : "") + ">"+value+"</option>";
                                            }
                                            i++;
                                        }
                                    });
                size_value +=  "</select>";
            }
            
            $('.show_size').eq(index).html(size_value);
        }
        
        function get_stock(x)
        {
            var index2      =   $(x).parent().parent().parent().index();
            let data_value  =  "";
            let size        =  "";
            
            if(x)
            {
                var target  =   x.options[x.selectedIndex];
                size        =   target.value;
                data_value  =   target.getAttribute('data-id');
            }
            else
            {
                data_value  =   document.getElementsByClassName("product_data_id").value;
                size        =   document.getElementsByClassName("selected_size").value;  
                index2      =   $('#data-key').val();
            }
            
            let stock_data  =   $('.stock_data').val();
            stock_data      =   JSON.parse(stock_data);
            let stock_value =   "";
            let i           =   0;
            
            if(x)
            {
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
                
                $(".quantity").val('');
                $("#total_price").val('');
                $("#total_value").val('0.00');
                $("#net").val('');
                $("#net_customer_balance").val('0.00');
            }
            else
            {
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
            }
            
            $('.stock_no').eq(index2).val(stock_value);
        }
        
        function updateStockOnSizeChange(x)
        {
            let target_btn      =   $(x);
            var index2          =   target_btn.parent().parent().parent().index();
            index2              =   index2-1;
            var selectedOption  =   x.options[x.selectedIndex];
            var selectedValue   =   selectedOption.value;
            var product_id      =   selectedOption.getAttribute('data-value');
            
            $("#edit_stock").removeClass('d-none');
            
            var route = "{{ route('fetch-product-detail') }}?id=" + product_id;

            $.ajax(
            {
                type    :   "GET",
                url     :   route,
                datatype:   "JSON",
                success :   function(response)
                {
                    let product         =   response.product;
                    let product_stock   =   response.stock;
                    product_stock       =   JSON.parse(product_stock);
                    let stock_data      =   "";
                    let i               =   0;
                    
                    $.each(product_stock, function (key, value)
                    {
                        if('size_'+i ==  key)
                        {
                            if(value == selectedValue)
                            {
                                stock_data  =   product_stock['stock_'+i];
                            }
                            i++;
                        }
                    });
                    
                    $('.stock_no').eq(index2).val(stock_data);
                }
            });
            
        }

     function addbtn()
  {
    var findRow = $("#TRow").clone().appendTo("#TBody");
    $(findRow).find("input").val('');
    $(findRow).removeClass("d-none");
  }


  function delete_row(findIndex)
  {
     $(findIndex).parent().parent().remove();

    // $(findRow).find("input").val('');

  }




  function calc(findIndex)
  {

    var index = $(findIndex).parent().parent().index();
    index   =   index-1;
// find multipication of quantity and price
    
    var quantity = document.getElementsByClassName("quantity")[index].value;
    var price = document.getElementsByClassName("price_value")[index].value;
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

 }

        function paidCustomerBalance(v)
        {
            //  var paid_balance = $(".paid_customer_balance").val();
            //  var net_customer_balance =  $("#total_value_of_sub_previous").val();

            //  var all_balance_of_customer = +(net_customer_balance) - +(paid_balance);

            //  $(".net_customer_balance").val(all_balance_of_customer);
        }




      function fetchProduct(findindex)
      {

         var index = $(findindex).parent().parent().index();
        findIndex.preventDefault();

        var product_name = document.getElementsByClassName("product_name")[index].value;

       $.ajax({

            type: "GET",
            url:"fetch-product-detail/"+product_name,
            datatype:"JSON",
            success: function(response)
            {
            console.log(response.product);
             $('#size_no').html('');
              $.each(response.product, function(key, item){

              document.getElementsByClassName("color")[index].value = item.color_id;
              document.getElementsByClassName("price")[index].value = item.purchase_price;


              var category_table = item.category_id;
              if(category_table == 1)

                  $('.size_no')[index].append(
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



                        $('.size_no')[index].append(
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

                        $('.size_no')[index].append(

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





</script>



        <script>

              $(document).ready(function(e){


            $(document).on('change', '#company_id', function(e){
              e.preventDefault();
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
                    $('#company_id_open_balance').val(response.company.id);
                    $('.balance').val(response.company.open_balance);
                    // $('#balance').val(response.company.open_balance);
                    //  $('#company_name').val(response.company.name);
                    //  $('#address').val(response.company.address);
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
