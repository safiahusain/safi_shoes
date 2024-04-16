@extends('admin-side.home')
@section('content')
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">

                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-success">Edit Product Details</h4>
                                {{-- <p class="card-title-desc text-info">Please Provide Correct Information.</p> --}}
                                <form class="needs-validation"  novalidate  action="{{ url('update-product/'.$data->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Article Name:</label>
                                                <input type="text" name="name" class="form-control" id="validationCustom01"
                                                    value="{{ $data->name }}" >
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
                                                <label for="validationCustom01" class="form-label">Item Code:</label>
                                                <input type="text" name="item_code" class="form-control" id="validationCustom01"
                                                value="{{ $data->item_code }}" >
                                                    @if($errors->has('item_code'))
                                                    <span class="text-danger">{{ $errors->first('item_code') }}</span>
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
                                           <label for="validationCustom02" class="form-label">Old Image</label><br>
                                          <img src="{{asset('public/uploads/products/'.$data->image)}}" width="150">
                                       </div>
                                   </div>

                                   <div class="col-md-6">
                                       <div class="mb-3">
                                           <label for="validationCustom02" class="form-label">New Image</label>
                                          <input type="file" name="image" id="image" class="form-control">
                                           <div class="valid-feedback">
                                               Looks good!
                                           </div>
                                       </div>
                                   </div>


                                    <!--<div class="col-md-6">-->
                                    <!--    <div class="mb-3">-->
                                    <!--        <label for="validationCustom01" class="form-label">Your Color Name:</label>-->
                                    <!--        <input type="text" name="color_id" class="form-control" id="validationCustom01"-->
                                    <!--        value="{{ $data->color_id }}" >-->
                                    <!--            @if($errors->has('color_id'))-->
                                    <!--            <span class="text-danger">{{ $errors->first('color_id') }}</span>-->
                                    <!--            @endif-->
                                    <!--        <div class="valid-feedback">-->
                                    <!--            Looks good!-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->


                                    <!-- <div class="row"> -->
                                        <!-- <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Select One Size Number:</label>
                                                    <select class="form-select form-control" id="size_id" name="size_id">


                                                        <option value="{{ $data->size_id}}">{{ $data->size_id}}</option>

                                                    </select>
                                                    @if($errors->has('size_id'))
                                                    <span class="text-danger">{{ $errors->first('size_id') }}</span>
                                                    @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>  -->

                                        <!-- <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Choose Date:</label>
                                                <input type="date" name="date" class="form-control" id="validationCustom01"
                                                     value="{{ $data->date }}">
                                                    @if($errors->has('sale_price'))
                                                    <span class="text-danger">{{ $errors->first('sale_price') }}</span>
                                                    @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        -->
                                    <!-- </div> -->


                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Your Company Name:</label>

                                                    <input type="text" name="company_id" class="form-control" id="validationCustom01"
                                                value="{{ $data->company_id }}" >

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
                                                <label for="validationCustom01" class="form-label">Your Brand Name:</label>
                                                    <input type="text" name="brand_id" class="form-control" id="validationCustom01"
                                                value="{{ $data->brand_id }}" >

                                                    @if($errors->has('brand_id'))
                                                    <span class="text-danger">{{ $errors->first('brand_id') }}</span>
                                                    @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Purchase Price:</label>
                                                <input type="number" name="p_price" class="form-control" id="validationCustom01"
                                                value="{{ $data->price }}" >
                                                    @if($errors->has('purchase_price'))
                                                    <span class="text-danger">{{ $errors->first('purchase_price') }}</span>
                                                    @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                            <!--<div class="col-md-6">-->
                                            <!--    <div class="mb-3">-->
                                            <!--        <label for="validationCustom01" class="form-label">opening balance:</label>-->
                                            <!--        <input type="number" name="opening_balance" class="form-control" id="validationCustom01"-->
                                            <!--        value="{{ $data->opening_balance }}" >-->
                                            <!--            @if($errors->has('opening_balance'))-->
                                            <!--            <span class="text-danger">{{ $errors->first('opening_balance') }}</span>-->
                                            <!--            @endif-->
                                            <!--        <div class="valid-feedback">-->
                                            <!--            Looks good!-->
                                            <!--        </div>-->
                                            <!--    </div>-->
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom01" class="form-label">Sale Price:</label>
                                                <input type="number" name="s_price" class="form-control" id="validationCustom01"
                                                value="{{ $data->s_price }}" >
                                                    @if($errors->has('sale_price'))
                                                    <span class="text-danger">{{ $errors->first('sale_price') }}</span>
                                                    @endif
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                        </div>
    
                                        <!--<div class="row">-->
                                        <!--    <div class="col-md-6">-->
                                        <!--        <div class="mb-3">-->
                                        <!--            <label for="validationCustom01" class="form-label">Quantity:</label>-->
                                        <!--            <input type="number" name="quantity" class="form-control" id="validationCustom01"-->
                                        <!--            value="{{ $data->quantity }}" >-->
                                        <!--                @if($errors->has('quantity'))-->
                                        <!--                <span class="text-danger">{{ $errors->first('quantity') }}</span>-->
                                        <!--                @endif-->
                                        <!--            <div class="valid-feedback">-->
                                        <!--                Looks good!-->
                                        <!--            </div>-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                        <!--    <div class="col-md-6">-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        <!-- start of gents sizes -->
                                        
                                        <input type='hidden' value="{{$data->category_id}}" id="edit_stock_id">
                                        <input type='hidden' value="{{$data->category->name}}" id="edit_name">
                                        <div style="display:flex; margin-top: 50px;">
                                            <label for="shoe-category">Choose Category:</label>
                                            <select name="category_id" class="form-select form-control" onchange="get_show_category(this)" id="shoeCategory" style="width: 50%; margin-left: 10px;">
                                                <option selected disabled>Select Category</option>
                                                @foreach($categories as $key => $category)
                                                {
                                                    <option value="{{$category->id}}" data-value="{{ucwords($category->name)}}" @if($category->id == $data->category_id) selected @endif>{{ucwords($category->name)}}</option>
                                                }
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type='hidden' value="{{$stockData}}" id="edit_stock_data">
                                        <input type='text' hidden="" value="" name="stoke" class="stock_data_value">
                                        <div class='gents-shoe-sizes' id='getSizes'>
                                            <div id='heading_value' class="text-center">
                                                
                                            </div>
                                            <label class='form-label' for='size' style='padding-top: 10px; margin-right: 10rem'> Shoe Size</label>
                                            <label class='form-label' for='size' style='padding-top: 10px;'> Stock</label>
                                            <div class="category_size" id="category_size">
                                                                    
                                            </div>
                                        </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-primary float-right m-1" type="submit">Submit</button>
                                             <a href="{{ route('show-product') }}" class="btn btn-secondary waves-effect float-right m-1">
                                                Cancel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card -->
                        </div> <!-- end col -->
                    </div>
                </div>{{-- main row closed --}}
            </div>
        </div>
    </div>
</div>

<script src="{{asset('assets/js/pages/form-validation.init.js')}}"></script>
<script>
    let name    =   null;
    let id      =   null;
    
    $(document).ready(function()
    {
        let x    =  null;   
        get_show_category(x)
    });

        let stock_object = {};
        function get_show_category(x)
        {
            var selectedValue   =   "";
            var category_name   =   "";
            let i               =   0;
            
            if(x)
            {
                var selectedOption  =   x.options[x.selectedIndex];
                selectedValue       =   selectedOption.value;
                category_name       =   selectedOption.getAttribute('data-value');
            }
            else
            {
                selectedValue   =   $('#edit_stock_id').val();
                category_name   =   $('#edit_name').val();
            }
            
            var route           =   "{{ route('get-category-sizes', ':id') }}";
            route               =   route.replace(':id', selectedValue);
            let edit_stock_data =   $('#edit_stock_data').val();
            edit_stock_data     =   JSON.parse(edit_stock_data);
            // console.log(edit_stock_data);
            
            $.ajax(
            {
                type    :   "GET",
                url     :   route,
                datatype:   "JSON",
                success :   function(response)
                {
                    let size_data = "";
                    let heading_value  = "";
                        
                        // $('#getSizes').removeClass('d-none');
                        
                        heading_value = "<h5 class='modal-header text-center' style='padding-left: 0; margin-bottom: 16px;'>"+category_name+" Shoes Sizes</h5>";
                        if(x)
                        {
                            let  category_id    =   $('#edit_stock_id').val();
                            
                            if(category_id   ===  response.sizes[i].category_id)
                            {
                                $.each(response.sizes, function (key, value)
                                {
                                    size_data += "<div style='margin-bottom: 16px; display: flex;'>\
                                                    <label class='form-label' for='size' style='padding-top: 10px; margin-right: 3rem'>Size "+value.name+":</label>\
                                                    <input type='hidden' name='size_"+key+"' id='size_"+key+"' value='"+value.name+"'>\
                                                    <input type='number'id='stock_"+key+"' value='"+edit_stock_data['stock_'+key]+"' onkeyup='get_values(this)' class='form-control form-set' name='stock_"+key+"' style='width: 70%; margin-left: 10px;'>\
                                                </div>";
                                });
                            }
                            else
                            {
                                console.log('here');
                                $.each(response.sizes, function (key, value)
                                {
                                    size_data += "<div style='margin-bottom: 16px; display: flex;'>\
                                                    <label class='form-label' for='size' style='padding-top: 10px; margin-right: 3rem'>Size "+value.name+":</label>\
                                                    <input type='hidden' name='size_"+key+"' id='size_"+key+"' value='"+value.name+"'>\
                                                    <input type='number'id='stock_"+key+"' value='' onkeyup='get_values(this)' class='form-control form-set' name='stock_"+key+"' style='width: 70%; margin-left: 10px;'>\
                                                </div>";
                                });
                            }
                            i++;
                        }
                        else
                        {
                            $.each(response.sizes, function (key, value)
                            {
                                size_data += "<div style='margin-bottom: 16px; display: flex;'>\
                                                <label class='form-label' for='size' style='padding-top: 10px; margin-right: 3rem'>Size "+value.name+":</label>\
                                                <input type='hidden' name='size_"+key+"' id='size_"+key+"' value='"+value.name+"'>\
                                                <input type='number'id='stock_"+key+"' value='"+edit_stock_data['stock_'+key]+"' onkeyup='get_values(this)' class='form-control form-set' name='stock_"+key+"' style='width: 70%; margin-left: 10px;'>\
                                            </div>";
                            });
                        }
                    
                    $('#category_size').empty().html(size_data);
                    // $('form.needs-validation').append($('#category_size').html());
                    $('#heading_value').empty().html(heading_value);
                }
            });
        }
        
        function get_values(x)
        {
            let target = $(x);
            let id = x.id;
            let index = id.split("_")[1];
            
            console.log(id, index);
        
            for (let i = 0; i <= index; i++) 
            {
                if (i == index) {
                    stock_object['stock_' + i] = target.val();
                    stock_object['size_' + i] = $('#size_'+i).val();
                }
            }
        
            console.log(stock_object);
            // index           =   'stock_'+index;
            $(".stock_data_value").val(JSON.stringify(stock_object));
            // document.getElementsByClassName("stock_data_value")value = stock_object;
        }
</script>
@endsection
