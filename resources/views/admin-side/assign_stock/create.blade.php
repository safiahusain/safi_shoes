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
        <form  action="{{route('store-warehouse-stock',['param'  => $param])}}" method="post" enctype="multipart/form-data" id="purchase_form">
            @csrf
            <div class="row">
                <div class="box col-md-10">
                    <div class="box-inner">
                        <div class="box-header well" data-original-title="" style="background-color : rgba(10,10,40,0.7) !important; color:white;">
                            <h2>
                                <i class="glyphicon glyphicon-user"></i>Create Assign Stock
                            </h2>
                        </div>
                        <div class="box-content">
                                        <input type="text" hidden="" value="{{Auth::user()->id}}" name="created_by" class="created_by" id="created_by" />
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="validationCustom01" class="form-label">User/Name:</label>
                                        <input type="text" readonly value="{{Auth::user()->name}}" name="customer_id" class="form-control warehouse_name"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="validationCustom01" class="form-label">Ware House:</label>
                                        <select name="user_id" class="form-control combine js-example-basic-single" tabIndex="-1" required>
                                            <option value="" readonly>Select Ware House </option>
                                            @foreach ($users as $key  => $user)
                                                <option value="{{$user->id}}">{{$user->email}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="validationCustom01" class="form-label">Product Name:</label>
                                        <select name="product_id" class="form-control combine js-example-basic-single" onchange="productName(this)" tabIndex="-1" required>
                                            <option value="" readonly>Select Product Name </option>
                                            @foreach ($products as $key  => $product)
                                                <option value="{{$product->id}}">{{ucwords($product->name)}} ({{$product->item_code}})</option>
                                            @endforeach
                                        </select>
                                        <input type='hidden' id="size_value" value="{{json_encode($sizes)}}">
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="validationCustom01" class="form-label">Size:</label>
                                        <input class="form-control combine Stock num_only_integer_quantity vertical " id='disable_value' type="text" readonly  value="" required />
                                        <div id="size_no_data" class="size-no-data">
    
                                        </div>
                                        <input type="hidden" value="" class="stock_data">
                                        <input type="hidden" value="" class="stock_id">
                                    </div>
                                </div>
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
                                            <input class="remaing_stock"  hidden="" type="text"  name="remaing_stock" value=""/>
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
        
        $(document).ready(function() 
        {
            $('.js-example-basic-single').select2();
            
             toastr.options.timeOut = 10000;
             @if (Session::has('error'))
                 toastr.error('{{ Session::get('error') }}');
             @elseif(Session::has('success'))
                 toastr.success('{{ Session::get('success') }}');
             @endif
        });
        
        function productName(findindex)
        {
            var index               =   $(findindex).parent().parent().index();
            var selectedOption      =   findindex.options[findindex.selectedIndex];
            var product_size_no     =   selectedOption.value;
            var route               =   "{{ route('fetch-product-detail') }}?id=" + product_size_no;
            console.log(selectedOption,product_size_no);
            $.ajax(
            {
                type    :   "GET",
                url     :   route,
                datatype:   "JSON",
                success :   function(response)
                {
                    let product     =   response.product;
                    let sizes       =   response.stock;
                    sizes           =   JSON.parse(sizes);
                    let stock_data  =   "";
                    $('.warehouse-stock-table tbody').find('tr:last-child .size-no-data').html('');
                    $('.stock_no').html('');
                    $('.stock_data').html('');
                    let product_stock   =   JSON.parse(product.stock);
                    
                    document.getElementsByClassName("product_id").value = product.id;
                    $('.stock_data').eq(index).val(JSON.stringify(product));

                    stock_data  =  "<select name='size' onchange='updateStockOnSizeChange(this)' class='form-control combine size_no' tabIndex='-1' required>\
                                      <option value='' disabled selected>Select size </option>";
                                      let i=0;
                                      
                                     $("#stock-no").addClass('d-none');
                                      $.each(sizes, function (key, value)
                                      {
                                          if('size_'+i ===  key)
                                          {
                                            stock_data  +="<option dataId='"+key+"' data-value='"+product.id+"' value='"+value+"'>"+value+"</option>";
                                            i++
                                          }
                                      });

                    stock_data  += "</select>";

                    $('.size-no-data').html(stock_data);
                    var inputField = document.getElementById("disable_value");
                    inputField.style.display = "none";
                    $('#pro_id').val(response.stock);
                }

            });
        }
        
        function updateStockOnSizeChange(x)
        {
            let target_btn      =   $(x);
            var index2          =   target_btn.parent().parent().parent().index();
            var selectedOption  =   x.options[x.selectedIndex];
            var selectedValue   =   selectedOption.value;
            var product_stock   =   $("#pro_id").val();
            product_stock       =   JSON.parse(product_stock);
            $("#stock-no").removeClass('d-none');
            
            i=0;
            $.each(product_stock, function (key, value)
            {
                if('size_'+i ==  key)
                {
                    if(value == selectedValue)
                    {
                        $('#stock-no').val(product_stock['stock_'+i]);
                    }
                    i++;
                }
            });
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
    </script>
</body>

</html>
