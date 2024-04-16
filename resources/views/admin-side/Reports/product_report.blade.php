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
                <h2 class="text-center mb-3 mt-2">Product Report</h2>
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    
                                @if(isset($show_product_report))
                                <div class="d-flex" style="margin-left:100px">
                                    <input type="button" class="btn btn-success btn-sm ml-3" value="Print" style="height:35px; float:right; width:70px" onclick="getPrint()">
                                <h5 class="ml-5" >1 : Represent -> Gents</h5> <h5 class="ml-5">2 : Represent -> Ladies</h5> <h5 class="ml-5">3 : Represent -> Kids</h5>
                               </div>
                                <hr class="mb-3">

                                    <!-- <h4 class="card-title">Buttons example</h4>
                                    <p class="card-title-desc">Data table with CSV and 
                                    </p> -->
                                    
                                 
                                    
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
                                           
                                           
                                        </tr>
                                        </thead>
                  
                                        <tbody>
                                        @php $i=1; @endphp
                                       
                                        @foreach ($show_product_report as $item)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->company_id}}</td>
                                            <td>{{$item->category_id}}</td>
                                            <td>{{$item->color_id}}</td>
                                            <td>{{$item->balance}}</td>
                                            
                                   </tr>
                                   @php $i++; @endphp
                                  
                                   @endforeach
                                   
                                      </tbody>
                                    </table>
                                    @endisset
                                   
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
                $(document).on("change", "#company_name", function(e){
                    e.preventDefault();
                    var company_name = $(this).val();
                    alert(company_name);
                    $.ajax({
                            type:"GET",
                            url:"fetch-customer-name-using-company/"+company_name,
                            datatype:"JSON",
                            success:function(data)
                            {
                                // console.log(data.customer_name);
                                $("#customer_name").html("");
                                $("#customer_name").html("<option value='all'>All Customer Name </option>");
                                $.each(data.customer_name, function(key, item){
                                    $("#customer_name").append(
                                    '<option value='+item.name+'>'+item.name+'</option>'
                                    );
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
