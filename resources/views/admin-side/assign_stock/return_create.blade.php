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
            <form  action="{{route('store-warehouse-stock',['param'  => $param])}}" method="post" enctype="multipart/form-data" id="purchase_form">
                @csrf
                <div class="row">
                    <div class="box col-md-10">
                        <div class="box-inner">
                            <div class="box-header well" data-original-title="" style="background-color : rgba(10,10,40,0.7) !important; color:white;">
                                @if($param  ==  'return')
                                    <h2>
                                        <i class="glyphicon glyphicon-user"></i> Return Stock
                                    </h2>
                                @else
                                    <h2>
                                        <i class="glyphicon glyphicon-user"></i> Assign Stock
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
                                            <label for="validationCustom01" class="form-label">User:</label>
                                            <select name="btanch_id" class="form-control combine js-example-basic-single" tabIndex="-1" required>
                                                <option value="" readonly>Select user </option>
                                                @foreach ($users as $key  => $user)
                                                    <option value="{{$user->id}}">{{$user->email}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type='hidden' id="product_data" value="{{json_encode($products)}}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="validationCustom01" class="form-label">Product Name:</label>
                                            <div id='show_product'>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="validationCustom01" class="form-label">Color:</label>
                                            <select name="color_id" class="form-control combine js-example-basic-single" tabIndex="-1" required>
                                                <option value="" readonly>Select Color </option>
                                                @foreach ($colors as $key  => $color)
                                                    <option value="{{$color->id}}">{{ucwords($color->name)}}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" id='pro_id'>
                                        </div>
                                    </div>
                                </div>
                                <input type='hidden' id="size_data" value="{{json_encode($result)}}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="validationCustom01" class="form-label">Size:</label>
                                             <input class="form-control combine Stock num_only_integer_quantity vertical " id='disable_value' type="text" readonly  value="" required />
                                            <div id="show_size" class="size-no-data">
        
                                            </div>
                                        </div>
                                    </div>
                                    <input type='hidden' id="stock_data" value="{{json_encode($Stocks_data)}}">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <div id="edit_stock">
                                                <label for="validationCustom01" class="form-label">Available Stock:</label>
                                                <input class="form-control combine Stock num_only_integer_quantity vertical stock_no" type="text" readonly name="stock" id='stock-no' value="" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="validationCustom01" class="form-label">Quantity:</label>
                                            <input class="form-control combine num_only_integer_quantity quantity vertical" type="text"  name="quantity" value=""  onkeyup="calc(this)" required/>
                                            <span class="validation_error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <div class=""id="">
                                                <!--<label for="validationCustom01" class="form-label">Remaining Stock:</label>-->
                                                <input class="remaing_stock" type="text" hidden="" name="remaing_stock" value=""/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input type="submit" id="submit_btn" class="btn btn-success btn-sm" value="Save Invoice" style="width:150px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    <!--/.fluid-container-->



    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let user_name   =   "{{Auth::user()->name}}";
        
        $(document).ready(function() 
        {
            show_product();
            $('.js-example-basic-single').select2();
        });
        
        function show_product()
        {
            let product_data    =   $('#product_data').val();
            console.log(product_data);
            product_data        =   JSON.parse(product_data);
            let capitalizeFirstLetter = str => str.charAt(0).toUpperCase() + str.slice(1);
            let input_value     =   "";
            let i               =   0;
            
            input_value +=  "<select name='product_id' class='form-control combine js-example-basic-single' onchange='productName(this)' tabIndex='-1' required>\
                                <option value='' disabled selected>Select Product Name </option>";
                                $.each(product_data, function (key, value)
                                {
                                    if(key  ==  'name_'+i)
                                    {
                                        let pro_id    =   product_data['id_'+i];
                                        let pro_code  =   product_data['code_'+i];
                                        console.log(pro_code);
                                        input_value +=  "<option value='"+pro_id+"'>"+capitalizeFirstLetter(value)+" ("+pro_code+")"+"</option>";
                                        i++;
                                    }
                                });
            input_value +=  "</select>";
            
            $('#show_product').html(input_value);
            $('#stock-no').val('');
            $(".remaing_stock").val('');
            $(".quantity").val('');
        }
        
        function productName(x)
        {
            var target      =   x.options[x.selectedIndex];
            var product     =   target.value;
            let size_data   =   $('#size_data').val();
            size_data       =   JSON.parse(size_data);
            let size_value  =   "";
            let i           =   0;
            
            size_value +=  "<select name='size_id' class='form-control combine js-example-basic-single' onchange='get_stock(this)' tabIndex='-1' required>\
                                <option value='' disabled selected>Select Size </option>";
                                $.each(size_data, function (key, value)
                                {
                                    if(key  ==  'size_'+i)
                                    {;
                                        if(size_data['proid_'+i] == product)
                                        {
                                            size_value +=  "<option value='"+value+"' data-id='"+product+"'>"+value+"</option>";
                                        }
                                        i++;
                                    }
                                });
            size_value +=  "</select>";
            
            $('#show_size').html(size_value);
            var inputField = document.getElementById("disable_value");
            inputField.style.display = "none";
            $('#stock-no').val('');
            $(".remaing_stock").val('');
            $(".quantity").val('');
        }
        
        function get_stock(x)
        {
            var target      =   x.options[x.selectedIndex];
            var size        =   target.value;
            let data_value  =   target.getAttribute('data-id');
            let stock_data  =   $('#stock_data').val();
            stock_data      =   stock_data  ?   JSON.parse(stock_data)  :   null;
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
                        
            $('#stock-no').val(stock_value);
        }

        function calc(findIndex)
        {
            var index           =   $(findIndex).parent().parent().index();
            var quantity        =   $(".quantity").val();
            var stock           =   $(".stock_no").val();
            quantity            =   parseInt(quantity) || 0;
            stock               =   parseInt(stock);
            let remaining_stock =   "";
            
            
            if(quantity>stock)
            {
                $(".validation_error").eq(index).show();
                $(".validation_error").eq(index).text("Quantity must be less than stock");
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
    </script>
</body>

</html>
