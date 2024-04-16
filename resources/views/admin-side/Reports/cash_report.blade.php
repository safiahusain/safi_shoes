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
                <h2 class="text-center mb-3 mt-2">Cash Report</h2>
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                @if(isset($cash_voucher))

                                <form action="{{url('show-cash-report')}}" method="GET">

                                <div class="d-flex">

                                

                                    <select class="js-example-basic-single selectpicker mb-3 p-none" name="customer_name" id="customer_name" width="150px;">
                                    
                                    <option>Select Customer Name</option>
                                    @foreach($customer as $customer)
                                    <option value="{{$customer->name}}">{{$customer->name}}</option>
                                   @endforeach
                                </select>

                                <input type="submit" class="btn btn-success btn-sm ml-3" value="Search" style="height:35px; width:70px">
                                <input type="button" class="btn btn-success btn-sm ml-3" value="Print" style="height:35px; width:70px" onclick="getPrint()">

                                </div>

                                </form>

                                <hr class="mb-3">

                                    <!-- <h4 class="card-title">Buttons example</h4>
                                    <p class="card-title-desc">Data table with CSV and 
                                    </p> -->
                                    
                                 
                                    
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 table-sm">
                                        
                                        <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            <!-- <th>Inv#</th> -->
                                            <th>Date</th>
                                            <th>Customer Name</th>
                                            <th>Particular</th>
                                            <th>Receive</th>
                                           
                                           
                                        </tr>
                                        </thead>
                  
                                        <tbody>
                                        @php $i=1; @endphp
                                       
                                        @foreach ($cash_voucher as $item)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$item->date}}</td>
                                            <td>{{$item->customer_name}}</td>
                                            <td>Cash Payment</td>
                                            <td>{{$item->paid_amount}}</td>
                                            
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
                $(document).on("change", "#saleman_name", function(e){
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
