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
                            <div class="card" style="overflow-x: auto">
                                <div class="card-body">

                                    <!--<h4 class="card-title">Buttons example</h4>-->
                                    <!--<p class="card-title-desc">Data table with CSV and-->
                                    <!--</p>-->
                                    <div class="align-middle ">
                                        <div class="d-flex align-center justify-content-between my-4">
                                            <button type="button"
                                                class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"
                                                data-bs-toggle="modal" data-bs-target=".transaction-detailModal">
                                                Add New Record
                                            </button>
                                        </div>

                                    </div>


                                    @if (isset($data))
                                        <h3 class="text-center mt-4 mb-4">Product Detail</h3>
                                        <table id="datatable-buttons"
                                            class="table table-bordered dt-responsive nowrap text-center  table-sm">
                                            <table id="table_one" class="table table-bordered dt-responsive nowrap  table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Article Name</th>
                                                        <th><code>Code</code></th>
                                                        <th>Image</th>
                                                        <th>Category</th>
                                                        <th>Company</th>
                                                        <th>Brand</th>
                                                        <th>Purchase Price</th>
                                                        <th>Sale Price</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $i=1; @endphp
                                                    @if (count($data)> 0)
                                                        @foreach ($data as $item)
                                                            <tr>
                                                            <td>{{$i++}}</td>
                                                            <td>{{$item->name}}</td>
                                                            <td><code>{{$item->item_code}}</code></td>
                                                            <td>
                                                                <img src="{{asset('public/uploads/products/'.$item->image) }}"
                                                                    width="120" height="90">
                                                            </td>
                                                            <td>{{$item->category->name}}</td>
                                                            <td>{{$item->company_id}}</td>
                                                            <td>{{$item->brand_id}}</td>
                                                            <td>{{$item->price}}</td>
                                                            <td>{{$item->s_price}}</td>
                                                            <td>
                                                                <a href="{{ url('edit-product/'.$item->id)}} "
                                                                    class="btn btn-primary btn-sm">Edit</a>
                                                                |
                                                                <a href="{{ url('delete-product/'.$item->id) }}"
                                                                    class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Are you sure to Delete this Record ?')">Delete</a>
                                                                 |
                                                                <button type="button" data-toggle="modal" data-target="#exampleModalone"
                                                                    style="border: none; background-color: transparent; outline: none;" value="{{$item->id}}" id="">
                                                                    <i class="fa-solid fa-magnifying-glass-plus"  ></i>
                                                                </button>
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


        <!-- Transaction Modal -->
        <div id="exampleModal" class="modal fade transaction-detailModal" tabindex="-1" role="dialog"
            aria-labelledby="transaction-detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transaction-detailModalLabel">Product's Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        <div class="table-responsive" style="overflow-x: hidden;">
                            <table class="table align-middle table-nowrap">
                                <thead>
                                </thead>
                                <tbody>
                                    <form class="needs-validation" novalidate action="{{ route('store-product')}}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                 <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Article
                                                        Name:</label>
                                                    <input type="text" name="name" class="form-control"
                                                        id="validationCustom01" placeholder="Enter Article Name" required>
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
                                                    <label for="validationCustom01" class="form-label">Barcode
                                                        Code:</label>
                                                    <input type="text" name="item_code" class="form-control"
                                                        id="validationCustom01" placeholder="Enter bar_code" required>
                                                    @if($errors->has('item_code'))
                                                    <span class="text-danger">{{ $errors->first('item_code') }}</span>
                                                    @endif
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Select One
                                                        Brand:</label>
                                                    <select class="form-select form-control" id="brand_id"
                                                        name="brand_id" style="width:220px;" required>
                                                        <option>Select Brand Name</option>
                                                        @foreach ($brands as $country)
                                                        <option value="{{ $country->name}}">{{ $country->name}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('brand_id'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('brand_id') }}</span>
                                                    @endif
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Select One
                                                        Company:</label>
                                                    <select class="form-select form-control" id="company_id"
                                                        name="company_id" style="width:220px;" required>
                                                        <option selected disabled>Select Company Name</option>
                                                        @foreach ($companies as $country)
                                                        <option value="{{ $country->name}}">{{ $country->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('company_id'))
                                                    <span class="text-danger">{{ $errors->first('company_id') }}</span>
                                                    @endif
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">
                                                       Purchase Price:</label>
                                                    <input type="number" name="p_price" class="form-control"
                                                        id="validationCustom01" placeholder="Enter price" required>
                                                    @if($errors->has('purchase_price'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('purchase_price') }}</span>
                                                    @endif
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Sale
                                                        Price:</label>
                                                    <input type="number" name="s_price" class="form-control"
                                                        id="validationCustom01" placeholder="Enter sale_price" required>
                                                    @if($errors->has('sale_price'))
                                                    <span class="text-danger">{{ $errors->first('sale_price') }}</span>
                                                    @endif
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">New Stock:</label>
                                                    <input type="text" name="new_stock" class="form-control"
                                                        id="validationCustom01" placeholder="Enter New Stock" required>
                                                    @if($errors->has('new_stock'))
                                                    <span class="text-danger">{{ $errors->first('new_stock') }}</span>
                                                    @endif
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <!-- <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Sale
                                                        Return:</label>
                                                    <input type="number" name="sale_return" class="form-control"
                                                        id="validationCustom01" placeholder="Enter sale return">
                                                    @if($errors->has('sale_return'))
                                                    <span class="text-danger">{{ $errors->first('sale_return') }}</span>
                                                    @endif
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Balance:</label>
                                                    <input type="number" name="balance" class="form-control" id="validationCustom01"
                                                         >
                                                        @if($errors->has('balance'))
                                                        <span class="text-danger">{{ $errors->first('balance') }}</span>
                                                        @endif
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Choose Image:</label>
                                                    <input type="file" name="image" class="form-control"
                                                        id="validationCustom01" required>
                                                    @if($errors->has('image'))
                                                    <span class="text-danger">{{ $errors->first('image') }}</span>
                                                    @endif
                                                    <div class="valid-feedback">30
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom02" class="form-label">Paid Balance:</label>
                                                <input type="number" class="form-control" id="paid_balance"
                                                name="paid_balance"  >
                                                @if($errors->has('paid_balance'))
                                                <span class="text-danger">{{ $errors->first('paid_balance') }}</span>
                                                @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div> --}}
                                        <!--</div>-->
                                        <div style="display:flex; margin-top: 50px;">
                                            <label for="shoe-category">Choose Category:</label>
                                            <select name="category_id" class="form-select form-control" onchange="get_show_category(this)" id="shoeCategory" style="width: 50%; margin-left: 10px;" required>
                                                <option selected disabled>Select Category</option>
                                                @foreach($categories as $key => $category)
                                                {
                                                    <option value="{{$category->id}}" data-value="{{ucwords($category->name)}}">{{ucwords($category->name)}}</option>
                                                }
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <input type='text' hidden="" value="" name="stoke" class="stock_data_value">
                                        <div class='gents-shoe-sizes d-none' id='getSizes'>
                                            <div id='heading_value'>
                                                
                                            </div>
                                            <label class='form-label' for='size' style='padding-top: 10px; margin-right: 10rem'> Shoe Size</label>
                                            <label class='form-label' for='size' style='padding-top: 10px'> Stock</label>
                                            <div class="category_size" id="category_size">
                                                                    
                                            </div>
                                        </div>
                                        <!--<div class="gents-shoe-sizes" id="getSizes">-->
                                        <!--    <h5 class="modal-header" style="padding-left: 0; margin-bottom: 16px;">Gents Shoes Sizes:</h5>-->
                                        <!--    <label class="form-label" for="size" style="padding-top: 10px; margin-right: 10rem"> Shoe Size</label>-->
                                        <!--    <label class="form-label" for="size" style="padding-top: 10px"> Stock</label>-->
                        
                                        <!--    <div style="margin-bottom: 16px; display: flex;">-->
                                        <!--        <label class="form-label" for="size" style="padding-top: 10px; margin-right: 3rem">Size 38:</label>-->
                                        <!--            <input type="number" id="size" class="form-control"  placeholder="Enter Quantity"-->
                                        <!--            name="stock_38" style="width: 70%; margin-left: 10px;">-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        <div class="modal-footer">
                                            <button class="btn btn-primary" type="submit">Submit </button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



</div>
</div>
<!-- end modal -->

   <!-- product  opening model -->
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
            <h5 class="modal-title" id="exampleModalLabel">Product Details</h5>
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
                    <th width="150px">Product Size</th>
                    <th width="60">Stock</th>
                  </tr>
                </thead>
                <tbody id="product_details">

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
    $(document).ready(function () {
  $('#table_one').DataTable({
    "scrollX": true
  });
//   $('.dataTables_length').addClass('bs-select');
});
    </script>


<script src="{{asset('assets/js/pages/form-validation.init.js')}}"></script>
<script src="{{asset('assets/js/pages/shoes.js')}}"></script>
<script>


</script>

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


    $(document).on("click","#product_detail", function(e){

        var product_id = $(this).val();
        // alert(product_id)

        $.ajax({

            type:"GET",
            url:"retreive-product-detail/"+product_id,
            datatype:"JSON",
            success:function(response){

                // console.log(response.product);
                $("#product_details").html('');
                $.each(response.product, function(key, item){
                    $("#product_details").append(

                        '<tr>\
                        <td>'+item.name+'</td>\
                        <td>'+item.opening_balance+'</td>\
                        <td>'+item.purchase_price+'</td>\
                        <td>'+item.purchase_return+'</td>\
                        <td>'+item.sale_price+'</td>\
                        <td>'+item.sale_return+'</td>\
                        <td>'+item.balance+'</td>\
                         </tr>'

                    );


                });
            }

        });

    });



});

        function get_show_category(x)
        {
            var selectedOption  =   x.options[x.selectedIndex];
            var selectedValue   =   selectedOption.value;
            var category_name   =   selectedOption.getAttribute('data-value');
            var route           =   "{{ route('get-category-sizes', ':id') }}";
            route               =   route.replace(':id', selectedValue);
            
            $.ajax(
            {
                type    :   "GET",
                url     :   route,
                datatype:   "JSON",
                success :   function(response)
                {
                    let size_data = "";
                    let heading_value  = "";
                        
                        $('#getSizes').removeClass('d-none');
                        
                        heading_value = "<h5 class='modal-header text-center' style='padding-left: 0; margin-bottom: 16px;'>"+category_name+" Shoes Sizes</h5>";
                    $.each(response.sizes, function (key, value)
                    {
                        size_data += "<div style='margin-bottom: 16px; display: flex;'>\
                                        <label class='form-label' for='size' style='padding-top: 10px; margin-right: 3rem'>Size "+value.name+":</label>\
                                        <input type='hidden' name='size_"+key+"' id='size_"+key+"' value='"+value.name+"'>\
                                        <input type='number'id='stock_"+key+"' value='' onkeyup='get_values(this)' class='form-control form-set' placeholder='Enter Quantity' name='stock_"+key+"' style='width: 70%; margin-left: 10px;' required>\
                                    </div>";
                    });
                    $('#category_size').empty().html(size_data);
                    // $('form.needs-validation').append($('#category_size').html());
                    $('#heading_value').empty().html(heading_value);
                }
            });
        }
        
        let stock_object = {};
        
        function get_values(x)
        {
            let target = $(x);
            let id = x.id;
            let index = id.split("_")[1];
            
        
            for (let i = 0; i <= index; i++) 
            {
                if (i == index) {
                    stock_object['stock_' + i] = target.val();
                    stock_object['size_' + i] = $('#size_'+i).val();
                }
            }
            
            $(".stock_data_value").val(JSON.stringify(stock_object));
        }

    </script>
@endsection
