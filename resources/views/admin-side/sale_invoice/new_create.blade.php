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
        <form action="{{ route('upadte-saleInvoice',['id' => $data->id,'param'  => $param]) }}" method="post" enctype="multipart/form-data" id="purchase_form">
            @csrf
            <div class="row">
                <div class="box col-md-10">
                    <div class="box-inner">
                        <div class="box-header well" data-original-title="" style="background-color : rgba(10,10,40,0.7) !important; color:white;">
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
                                        <input type="text" hidden="" value="{{Auth::user()->id}}" name="user_id" class="user_id" id="user_id" />
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="validationCustom01" class="form-label">User/Name:</label>
                                        <input type="text" readonly value="{{Auth::user()->name}}" name="customer_id" class="form-control warehouse_name" id="warehouse_id"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="validationCustom01" class="form-label">Color:</label>
                                        @if($param  ==  'invoice')
                                            <select name="color_id" class="form-control combine js-example-basic-single" tabIndex="-1" required>
                                                <option value="" readonly>Select Color </option>
                                                @foreach ($colors as $key  => $color)
                                                    <option value="{{$color->id}}" @if($data->color_id == $color->id) selected @endif>{{ucwords($color->name)}}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            @if($target ==  'sales')
                                                <input type="text" hidden="" value="{{$data->color_id}}" name="color_id"/>
                                                <input type="text" readonly value="{{$data->color->name}}" name="color" class="form-control"/>
                                            @else
                                                <input type="text" hidden="" value="{{$data->color_id}}" name="color_id"/>
                                                <input type="text" readonly value="{{$data->color->name}}" name="color" class="form-control"/>
                                            @endif
                                        @endif
                                        <input type="hidden" id='pro_id'>
                                    </div>
                                </div>
                            </div>
                            <input type='hidden' id="product_data" value="{{json_encode($products)}}">
                            <input type='hidden' id="product_id" value="{{$data->product_id}}">
                            <input type='text' hidden="" name='prev_size_id' id="prev_size_id" value="{{$data->size}}">
                            <input type='text' hidden="" name='prev_product_id' id="prev_product_id" value="{{$data->product_id}}">
                            <input type='text' hidden="" name='prev_quantity' id="prev_quantity" value="{{$data->assign_stock}}">
                            <div class="row">
                                <div class="col-md-6"> 
                                    <div class="form-group mb-3">
                                        <label for="validationCustom01" class="form-label">Product Name:</label>
                                        @if($param  ==  'invoice')
                                            <div id='show_product'>
                                                
                                            </div>
                                        @else
                                            @if($target ==  'sales')
                                                <input type="text" readonly value="{{$data->product->name}}" name="product_id" class="form-control"/>
                                            @else
                                                <input type="text" readonly value="{{$brances->product->name}}" name="product_id" class="form-control"/>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="validationCustom01" class="form-label">Size:</label>
                                        @if($param  ==  'invoice')
                                            <div id="show_size" class="size-no-data">
        
                                            </div>
                                        @else
                                            @if($target ==  'sales')
                                                <input type="text" readonly value="{{$data->size}}" name="size_id" class="form-control"/>
                                            @else
                                                <input type="text" readonly value="{{$brances->size}}" name="size_id" class="form-control"/>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <input type='hidden' id="size_data" value="{{json_encode($result)}}">
                            <input type='hidden' id="selected_size" value="{{$data->size}}">
                            <input type="hidden" value="000" id="new_size_value">
                            <input type='hidden' id="stock_data" value="{{json_encode($Stocks_data)}}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <div id="edit_stock">
                                            <label for="validationCustom01" class="form-label">Available Stock:</label>
                                            @if($param  ==  'invoice')
                                                <input class="form-control combine Stock num_only_integer_quantity vertical stock_no" type="text" readonly name="stock" id='stock-no' value="" required />
                                            @else
                                                @if($target ==  'sales')
                                                    <input class="form-control combine Stock num_only_integer_quantity vertical stock_no" type="text" readonly value="{{$data->assign_stock}}" name="stock" class="form-control"/>
                                                @else
                                                    <input class="form-control combine Stock num_only_integer_quantity vertical stock_no" type="text" readonly value="{{$brances->assign_stock}}" name="stock" class="form-control"/>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="validationCustom01" class="form-label">Quantity:</label>
                                        @if($param  ==  'invoice')
                                            <input class="form-control combine num_only_integer_quantity quantity vertical" type="text" id="quantity_value"  data_id="{{$data->product_id}}" data_param={{$param}} name="quantity" value="{{$data->assign_stock}}"  onkeyup="calc(this)" required/>
                                        @else
                                            @if($target ==  'sales')
                                                <input class="form-control combine num_only_integer_quantity quantity vertical" type="text" id="quantity_value"  data_id="{{$data->product_id}}" data_param={{$param}} data_target="{{$target}}"  data_value="{{$data->assign_stock}}" name="quantity" value="{{$data->assign_stock}}"  onkeyup="calc(this)" required/>
                                            @else
                                                <input class="form-control combine num_only_integer_quantity quantity vertical" type="text" id="quantity_value"  data_id="{{$brances->product_id}}" data_target="{{$target}}" data_value="{{$data->assign_stock}}" data_param={{$param}} name="quantity" value="{{$data->assign_stock}}"  onkeyup="calc(this)" required/>
                                            @endif
                                        @endif
                                        <span class="validation_error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <input type='hidden' id="product_price" value="{{json_encode($prices)}}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="validationCustom01" class="form-label">Price:</label>
                                        <input class="form-control combine num_only_integer_quantity price_value vertical" readonly type="text" id="price_value"  name="price" value="{{$data->price}}"  onkeyup="calc(this)" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="validationCustom01" class="form-label">Total Price:</label>
                                        <input class="form-control combine num_only_integer_quantity total_price vertical" readonly type="text" id="total_price"  name="total_price" value="{{$data->total_price}}"  onkeyup="calc(this)" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <input type='hidden' id="product_price" value="{{json_encode($prices)}}">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="validationCustom01" class="form-label">Dis (%):</label>
                                            @if($param  ==  'invoice')
                                                <input class="form-control combine num_only_decimal vertical" type="text" id="discount_product"  name="discount_product" value="{{$data->discount}}"  onkeyup="calc(this)" />
                                            @else
                                                @if($target ==  'sales')
                                                    <input type="text" readonly value="{{$data->discount}}" id="discount_product" name="discount_product" class="form-control"/>
                                                @else
                                                    <input type="text" readonly value="{{$brances->discount}}" id="discount_product" name="discount_product" class="form-control"/>
                                                @endif
                                            @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="validationCustom01" class="form-label">Dis (Rs):</label>
                                         <!--<input type="text" readonly tabIndex="-1"  class="form-control less  num_only_decimal vertical" name="less[]" value="0"  style="width:70px;"/>-->
                                        <input class="form-control less num_only_decimal vertical" readonly type="text" id="less"  name="less" value="{{$data->discount_price}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <input type='hidden' id="pro_price" value="{{$data->price}}">
                                <input type='hidden' id="product_price" value="{{json_encode($prices)}}">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="validationCustom01" class="form-label">Net:</label>
                                  <!--      <input class="form-control net num_only_decimal vertical"-->
                                  <!--type="text" id="net" readonly tabIndex="-1"  name="net[]" value=""   style="width:70px;"/>-->
                                        <input class="form-control net num_only_decimal vertical" readonly type="text" id="net"  name="net" value="{{$data->net_price}}"  onkeyup="calc(this)" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <div class=""id="">
                                            <!--<label for="validationCustom01" class="form-label">Remaining Stock:</label>-->
                                            <input class="remaing_stock" hidden="" type="text"  name="remaing_stock" value=""/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table>
                                <tfoot id="tfoot">
                                    <tr>
                                        <td colspan="6"></td>
                                        <td colspan="3" class="total">Current Invoice:</td>
                                        <td colspan="2"  id="total_amount">
                                            <input type="text" class="form-control total_value" readonly tabIndex="-1"  value="{{$data->net_price}}" id='total_value' name="total_value" style="width:150px;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"></td>
                                        <td colspan="3" class="discount">
                                          Extra Discount:
                                        </td>
                                        <td colspan="2" class="discount-td">
                                            @if($param  ==  'invoice')
                                                <input type="text" value="{{$data->extra_discount}}" class="form-control extra-discountss" id='extra-discountss' name="extra_discount" onkeyup="calc(this)" style="width:150px;">
                                            @else
                                                @if($target ==  'sales')
                                                    <input type="text" value="{{$data->extra_discount}}" class="form-control extra-discountss" readonly id='extra-discountss' name="extra_discount" onkeyup="calc(this)" style="width:150px;">
                                                @else
                                                    <input type="text" value="{{$data->extra_discount}}" class="form-control extra-discountss" readonly id='extra-discountss' name="extra_discount" onkeyup="calc(this)" style="width:150px;">
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    <!--<tr>-->
                                    <!--    <td colspan="6"></td>-->
                                    <!--    <td colspan="3" class="total">Total:</td>-->
                                    <!--    <td colspan="2" class="total-val" id="payable_balance">-->
                                    <!--        <input type="text" class="form-control" value="{{$data->net_balance}}" readonly tabIndex="-1" name="total_value_of_sub_previous" id="total_value_of_sub_previous" style="width:150px;">-->
                                    <!--    </td>-->
                                    <!--</tr>-->
                                    <tr>
                                        <td colspan="6"></td>
                                        <td colspan="3" class="total">Net Balance:</td>
                                        <td colspan="2" class="total-val" id="total_bal">
                                            <input type="text" value="{{$data->net_balance}}" readonly tabIndex="-1" class="form-control net_customer_balance" id='net_customer_balance' name="net_customer_balance" style="width:150px;">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="submit" id="submit_btn" class="btn btn-success btn-sm" value="Save Invoice" style="width:150px;">
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--/.fluid-container-->



    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/toastr.js') }}"></script>
    <script>
        let user_name   =   "{{Auth::user()->name}}";
        let pre_quantity    =   $('#quantity_value').val();
        
        $(document).ready(function() 
        {
            show_product();
            $('.js-example-basic-single').select2();
            let x=null;
            productName(x)
            get_stock(x)
            
             toastr.options.timeOut = 10000;
             @if (Session::has('error'))
                 toastr.error('{{ Session::get('error') }}');
             @elseif(Session::has('success'))
                 toastr.success('{{ Session::get('success') }}');
             @endif
        });
        
        function show_product()
        {
            let product_id      =   $('#product_id').val();
            let product_data    =   $('#product_data').val();
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
                                        
                                        input_value +=  "<option value='"+pro_id+"' " + (product_id == pro_id ? "selected" : "") + ">"+capitalizeFirstLetter(value)+"</option>";
                                        i++;
                                    }
                                });
            input_value +=  "</select>";
            
            $('#show_product').html(input_value);
        }
        
        function productName(x)
        {
            var product =   "";
            
            if(x)
            {
                var target  =   x.options[x.selectedIndex];
                product     =   target.value;
            }
            else
            {
                product     =   $('#product_id').val();
            }
            
            
            let size_data   =   $('#size_data').val();
            size_data       =   JSON.parse(size_data);
            let size_value  =   "";
            let i           =   0;
            
            if(x)
            {
                size_value +=  "<select name='size_id' class='form-control combine js-example-basic-single' onchange='get_stock(this)' tabIndex='-1' required>\
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
                            $('#price_value').val(p_value);
                            $('#pro_price').val(p_value);
                        }
                        j++;
                    }
                });
                
                $('#stock-no').val('');
                $(".remaing_stock").val('');
                $(".quantity").val('');
                $("#total_price").val('');
                $("#total_value").val('0.00');
                $("#net").val('');
                $("#net_customer_balance").val('0.00');
            }
            else
            {
                size_value +=  "<select name='size_id' class='form-control combine js-example-basic-single' onchange='get_stock(this)' tabIndex='-1' required>\
                                    <option value='' disabled selected>Select Size </option>";
                                    $.each(size_data, function (key, value)
                                    {
                                        if(key  ==  'size_'+i)
                                        {
                                            if(size_data['proid_'+i] == product)
                                            {
                                                
                                                let selected_size   =   $('#selected_size').val();
                                                
                                                size_value +=  "<option value='"+value+"' data-id='"+product+"'" + (value == selected_size ? "selected" : "") + ">"+value+"</option>";
                                            }
                                            i++;
                                        }
                                    });
                size_value +=  "</select>";
            }
            
            $('#show_size').html(size_value);
        }
        
        function get_stock(x)
        {
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
                data_value  =   $('#product_id').val();
                size        =   $('#selected_size').val();
            }
            
            let stock_data  =   $('#stock_data').val();
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
            
            $('#stock-no').val(stock_value);
        }

        function calc(findIndex)
        {
            var index           =   $(findIndex).parent().parent().index();
            let target_btn      =   $(findIndex);
            let product_id      =   target_btn.attr('data_id');
            let param           =   target_btn.attr('data_param');
            var price           =   $("#pro_price").val();
            let new_product_id  =   $('#product_id').val();
            let size            =   $('#selected_size').val();
            let new_size        =   $('#new_size_value').val();
            var quantity        =   $("#quantity_value").val();
            var stock           =   $(".stock_no").val();
            quantity            =   parseInt(quantity) || 0;
            stock               =   parseInt(stock);
            target              =   'sales';
            
            if(param == 'return')
            {
                let p_quantity  =   target_btn.attr('data_value');
                target          =   target_btn.attr('data_target');
                pre_quantity    =   parseInt(p_quantity);
            }
            else
            {
                pre_quantity    =   parseInt(pre_quantity);
            }
            
            let remaining_stock =   "";
            
            if(product_id   ==  new_product_id)
            {
                if(new_size ==  '000')
                {
                    if(quantity ==  0)
                    {
                        $(".validation_error").eq(index).hide();
                        if(stock  ==  0)
                        {
                            $(".remaing_stock").val(pre_quantity);   
                            $('.stock_no').val(pre_quantity);
                        }
                        $("#total_price").val('');
                        $("#total_value").val('0.00');
                        $("#net").val('');
                        $("#net_customer_balance").val('0.00');
                    }
                    else
                    {
                        $(".validation_error").hide();
                        let total_stock =   null;
                        
                        if(param == 'return'   &&   target  ==  'return')
                        {
                            total_stock =   pre_quantity + stock;
                        }
                        else if(param == 'return'   &&   target  ==  'sales')
                        {
                            total_stock =   pre_quantity;
                        }
                        else
                        {
                            total_stock =   pre_quantity + stock;
                        }
                        
                        if(quantity>total_stock)
                        {
                            $(".validation_error").show();
                            $(".validation_error").text("Quantity "+quantity+" mut be less than total stock "+total_stock);
                        }
                        else
                        {
                            $(".validation_error").hide();
                            let total_quantity  =   "";
                            
                            if(pre_quantity > quantity)
                            {
                                total_quantity  =   pre_quantity - quantity;
                            }
                            else
                            {
                                total_quantity  =   quantity - pre_quantity;
                            }
                            
                            remaining_stock =   stock-total_quantity;
                            $(".remaing_stock").val(remaining_stock);     
                        }
                    }
                }
                else
                {
                    if(quantity>stock)
                    {
                        $(".validation_error").eq(index).show();
                        $(".validation_error").eq(index).text("Quantity mut be less than stock");
                    }
                    else
                    {
                        $(".validation_error").eq(index).hide();
                        remaining_stock =   stock-quantity;
                        $(".remaing_stock").val(remaining_stock);
                    }
                }
            }
            else
            {
                if(quantity>stock)
                {
                    $(".validation_error").eq(index).show();
                    $(".validation_error").eq(index).text("Quantity mut be less than stock");
                    $('#submit_btn').prop('disabled', true);
                }
                else
                {
                    $('#submit_btn').prop('disabled', false);
                    $(".validation_error").eq(index).hide();
                    remaining_stock =   stock-quantity;
                    $(".remaing_stock").val(remaining_stock);
                }
            }
            
            var total   = quantity * price ;
            
            $("#total_price").val(total);
            $("#total_value").val(total);
            $("#net").val(total);
            $("#net_customer_balance").val(total);


            var discount        =   $("#discount_product").val();
            
            if(discount !=  0)
            {
                var totalDiscount   =   discount/100;
                var totalLess       =   total - (total*totalDiscount);
                var less            =   total - totalLess;
                var net             =   total - less;
                
                $("#total_value").val(totalLess);
                $("#less").val(less);
                $("#net").val(net);
                $("#net_customer_balance").val(totalLess);
            }
            
            var extra_discount  =   $(".extra-discountss").val();
            
            if(extra_discount  != 0.00)
            {
                var total_value                             =   $("#total_value").val();
                var subtract_extra_discount_from_total_value=   total_value - extra_discount;
                
                $("#total_value_of_sub_previous").val(subtract_extra_discount_from_total_value);
                $("#net_customer_balance").val(subtract_extra_discount_from_total_value);
            }
        }
        
        function findExtraDiscount(v)
        {
            var extra_discount                          =   $(".extra-discountss").val();
            var total_value                             =   $("#total_value").val();
            var subtract_extra_discount_from_total_value=   total_value - extra_discount;
            
            $("#total_value_of_sub_previous").val(subtract_extra_discount_from_total_value);
            $("#net_customer_balance").val(subtract_extra_discount_from_total_value);
        }
    </script>
</body>

</html>
