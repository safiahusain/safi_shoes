@extends('admin-side.home')
@section('content')
@include('admin-side.purchases.purchase-modal-css')

<div class="main-content">
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

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                <h4 class="text-center mb-5 mt-3 text-decoration-underline">Customer ledger Report</h4>
                                 @if(isset($customer_name))

                                        <div class="d-flex">

                                        <select class="selectpicker mb-4 mr-4 p-none js-example-basic-single" name="customer_name" id="customer_name" width="150px;">
                                            <option value="">Select Customer Name</option>
                                            @foreach($customer_name as $customer_name)
                                                <option value="{{$customer_name->name}}">{{$customer_name->name}}</option>
                                                @endforeach
                                        </select>

                                <!--        <select class="selectpicker mb-3 p-none" name="customer_name" id="customer_name" width="150px;">-->
                                    
                                <!--    <option>Select Customer Name</option>-->
                                   
                                <!--</select>-->


                                        <input type="submit" class="btn btn-success btn-sm ml-3" value="Search" style="height:35px; width:70px" onclick="getData()">
                                        <input type="button" class="btn btn-success btn-sm ml-3" value="Print" style="height:35px; width:70px" onclick="getPrint()">

                                        </div>
                                        <hr class="bg-black">

                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 table-sm">
                                        
                                        <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            
                                            <th>Date</th>
                                            <th>Customer Name</th>
                                            <th>Particular</th>
                                            <th>Paid Amount</th>
                                            <th>Sale Amount</th>
                                             <th>Balance</th> 
                                           
                                        </tr>
                                        </thead>
                  
                                        <tbody class="customer_details">

                                      
                                      </tbody>
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
    </div>
</div>

  
<script>


//   fetch customer of saleman name 


             $(document).ready(function(){
                $(document).on("change", "#salesman_name", function(e){
                    e.preventDefault();
                    var saleman_name = $(this).val();
                    // alert(saleman_name);
                    $.ajax({
                            type:"GET",
                            url:"fetch-customer-name-using-saleman/"+saleman_name,
                            datatype:"JSON",
                            success:function(data)
                            {
                                // console.log(data.customer_name);
                                $("#customer_name").html("");
                                $("#customer_name").html("<option value='all'> All Customer Name </option>");
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



       function getData()
       {
 
               var customer_name = document.getElementById("customer_name").value;
           
                    $.ajax({
                            type:"GET",
                            url:"fetch-customer-detail-using-customer-name-ajax/"+customer_name,
                            datatype:"JSON",
                            success:function(data)
                            {
                                // get opening balance

                                 var open_balance = data.customer_names.open_balance;
                                // alert(open_balance)
                                // console.log(data.company_details);
                                var i = 1;
                                var payment = "Total Customer Balance";
                                var sale_amount = "Total Sale Amount ";
                                var paid_amount = "Total Paid Amount ";
                                var opening_balance = "Opening Balance ";
                                var opening_balance_total_sale = "Opening Balance + Sale Balance";
                                $(".customer_details").html("");
                                // console.log(data.customer_names.name);

                              
                                // customize customer ledger reports

                                $(".customer_details").append( '<tr>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td>'+opening_balance+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td>'+data.customer_names.open_balance+'</td>\
                                    </tr>'
                                    
                                    );
                                    
                              var cal = data.customer_names.open_balance;
                              
                              $.each(data.customer_details, function(key, item){

                                // var open_balances = +(data.company_names.open_balance) + +(item.purchase_amount) ;
                                    cal = (+cal) + +(item.sale_amount) - +(item.paid_amount);
                                    $(".customer_details").append( '<tr>\
                                    <td>'+i+'</td>\
                                    <td>'+item.date+'</td>\
                                    <td>'+item.customer_name+'</td>\
                                    <td>'+item.particular+'</td>\
                                    <td>'+item.paid_amount+'</td>\
                                    <td>'+item.sale_amount+'</td>\
                                    <td>'+cal+'</td>\
                                    </tr>'
                                    
                                    );
                                    i++;
                                });

                               
                            // });

                            }
                    });
                // });
                
                 

        }


           
          
    </script>
    
    


@endsection
