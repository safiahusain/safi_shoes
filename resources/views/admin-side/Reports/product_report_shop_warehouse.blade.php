@extends('admin-side.home')
@section('content')
@include('admin-side.purchases.purchase-modal-css')

<style>

    @media print{
        .btn{
            display:none;
        }

        .p-none{
            display:none;
        }
    }
</style>
<div class="main-content">
  

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <h2 class="text-center mb-3 mt-2">Product Report Shop/Warehouse</h2>
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                
                                <div class="d-flex" style="margin-left:100px">
                                <h5 class="ml-5" >1 : Represent -> Gents</h5> <h5 class="ml-5">2 : Represent -> Ladies</h5> <h5 class="ml-5">3 : Represent -> Kids</h5>
                               </div>
                                <hr class="mb-3">

                                    <!-- <h4 class="card-title">Buttons example</h4>
                                    <p class="card-title-desc">Data table with CSV and 
                                    </p> -->
                                    <select name="shop_warehouse" id="shop_warehouse" class="form-controll">
                                        <option value="all">Select Warehouse Name</option>
                                        @foreach($warehouse as $warehouse)
                                        <option value="{{$warehouse->name}}">{{$warehouse->name}}</option>
                                        @endforeach
                                    </select>
                                 
                                    
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 table-sm">
                                        
                                        <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            <!-- <th>Inv#</th> -->
                                            <th>Product Name</th>
                                            <th>Company Name</th>
                                            <th>Category</th>
                                            <th>Color</th>
                                            <th>Quantity</th>
                                           <th>Purchase Price</th>
                                           
                                        </tr>
                                        </thead>
                  
                                        <tbody id="product_report">
                                      
                                   
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

<Script>

            $(document).ready(function(){
                $(document).on("change", "#shop_warehouse", function(e){
                    e.preventDefault();
                    var shop_warehouse = $(this).val();
                    alert(shop_warehouse);
                    $.ajax({
                            type:"GET",
                            url:"fetch-product-name-and-details/"+shop_warehouse,
                            datatype:"JSON",
                            success:function(data)
                            {
                                console.log(data.product_report_shop_warehouse);
                                
                                $.each(data.product_report_shop_warehouse,function(key,item){
                                    
                                    var add_purchase_q_and_sale_return_q = +(item.purchase_quantity) + +(item.sale_return_quantity);
                                     
                                    var add_purchase_q_and_sale_q = +(item.purchase_return_quantity) + +(item.sale_quantity);
                                    
                                    var total_quantity = +(add_purchase_q_and_sale_return_q) - +(add_purchase_q_and_sale_q);
                                    
                                   console.log(total_quantity);
                                   
                                   $('#product_report').append('<tr>\
                                   <td>'+data.product_report_shop_warehouse_one.shop_godam+'</td>\
                                   <td>'+data.product_report_shop_warehouse_one.product_name+'</td>\
                                   <td>'+data.product_report_shop_warehouse_one.color+'</td>\
                                   <td>'+data.product_report_shop_warehouse_one.size+'</td>\
                                   <td>'+total_quantity+'</td>\
                                   </tr>');
                                    
                                });
                               
                            }
                    });
                });
            });


            function getPrint()
            {
                window.print();
            }


    </script>


@endsection
