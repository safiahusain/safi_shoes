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
                                <h4 class="text-center mb-5 mt-3 text-decoration-underline">Companies ledger Report</h4>


                                        <div class="d-flex">

                                        <select class="selectpicker mb-4 mr-4 p-none js-example-basic-single" name="company_name" id="company_name" width="150px;">
                                            <option value="">All Company Name</option>
                                            @foreach($company_name as $company_name)
                                                <option value="{{$company_name->name}}">{{$company_name->name}}</option>
                                                @endforeach
                                        </select>


                                        <input type="submit" class="btn btn-success btn-sm ml-3" value="Search" style="height:35px; width:70px" onclick="getData()">
                                        <input type="button" class="btn btn-success btn-sm ml-3" value="Print" style="height:35px; width:70px" onclick="getPrint()">

                                        </div>
                                        <hr class="bg-black">

                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 table-sm">
                                        
                                        <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            
                                            <th>Date</th>
                                            <th>Company Name</th>
                                            <th>Particular</th>
                                            <th>Paid Amount</th>
                                            <th>Purchase Amount</th>
                                            <th>Balance</th>
                                            <!-- <th>Balance</th> -->
                                           
                                        </tr>
                                        </thead>
                  
                                        <tbody class="company_details">
                                      
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


<script>

       function getData()
       {
 
               var company_name = document.getElementById("company_name").value;
           
                    $.ajax({
                            type:"GET",
                            url:"fetch-company-detail-using-company-name-ajax/"+company_name,
                            datatype:"JSON",
                            success:function(data)
                            {
                                // get opening balance

                                var open_balance = data.company_names.open_balance;
                                // alert(open_balance)
                                // console.log(data.company_details);
                                var i = 1;
                                var payment = "Total Company Balance";
                                var purchase_amount = "Total Purchase Amount ";
                                var paid_amount = "Total Paid Amount ";
                                var opening_balance = "Opening Balance ";
                                var opening_balance_total_purchase = "Opening Balance + Purchasing Balance";
                                $(".company_details").html("");
                                console.log(data.company_names.name);

                                
                                    $(".company_details").append( '<tr>\
                                    <td></td>\
                                    <td></td>\
                                    <td></td>\
                                    <td>'+opening_balance+'</td>\
                                    <td></td>\
                                    <td></td>\
                                    <td>'+data.company_names.open_balance+'</td>\
                                    </tr>'
                                    
                                    );
                                    
                              var cal = data.company_names.open_balance;
                              
                              $.each(data.company_details, function(key, item){

                                // var open_balances = +(data.company_names.open_balance) + +(item.purchase_amount) ;
                                    cal = (+cal) + +(item.purchase_amount) - +(item.paid_amount);
                                    $(".company_details").append( '<tr>\
                                    <td>'+i+'</td>\
                                    <td>'+item.date+'</td>\
                                    <td>'+item.company_name+'</td>\
                                    <td>'+item.particular+'</td>\
                                    <td>'+item.paid_amount+'</td>\
                                    <td>'+item.purchase_amount+'</td>\
                                    <td>'+cal+'</td>\
                                    </tr>'
                                    
                                    );
                                    i++;
                                });


                                // $(".company_details").append('<tr>\
                                //         <td></td>\
                                //         <td></td>\
                                //         <td></td>\
                                //         <td></td>\
                                //         <td>'+purchase_amount+'</td>\
                                //         <td>'+paid_amount+'</td>\
                                //         </tr>');


                                //         $(".company_details").append('<tr>\
                                //         <td></td>\
                                //         <td></td>\
                                //         <td></td>\
                                //         <td></td>\
                                //         <td>'+data.total_company_balance+'</td>\
                                //         <td>'+data.total_company_paid_balance+'</td>\
                                //         </tr>');

                                //         $(".company_details").append('<tr>\
                                //         <td></td>\
                                //         <td></td>\
                                //         <td></td>\
                                //         <td>'+opening_balance+'</td>\
                                //         <td>'+data.company_names.open_balance+'</td>\
                                //         <td></td>\
                                //         </tr>');

                                //         $(".company_details").append('<tr>\
                                //         <td></td>\
                                //         <td></td>\
                                //         <td></td>\
                                //         <td>'+opening_balance_total_purchase+'</td>\
                                //         <td>'+data.sum_opening_balance_and_all_purchase+'</td>\
                                //         <td></td>\
                                //         </tr>');

                                //         $(".company_details").append('<tr>\
                                //         <td></td>\
                                //         <td></td>\
                                //         <td></td>\
                                //         <td></td>\
                                //         <td>'+payment+'</td>\
                                //         <td>'+data.company_all_balance+'</td>\
                                //         </tr>');

                            }
                    });
                // });
           

        }


            function getPrint()
            {
                window.print();
            }
    </script>


@endsection
