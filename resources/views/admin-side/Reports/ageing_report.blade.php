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
                <h2 class="text-center mb-3 mt-2">Ageing Report</h2>
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                @if(isset($ageing_report))
                                 
                                <hr class="mb-3">

                                    <!-- <h4 class="card-title">Buttons example</h4>
                                    <p class="card-title-desc">Data table with CSV and 
                                    </p> -->
                                    <input type="button" class="btn btn-success btn-sm ml-3" value="Print" style="height:35px; float:right; width:70px" onclick="getPrint()">
                               
                                 
                                    
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 table-sm">
                                        
                                        <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            <th>Date</th>
                                            <th>Inv#</th>
                                            <th>Customer Name</th>
                                            <th>Amount</th>
                                            <th>Due Date</th>
                                            <th>Remaining Days</th>
                                            <th>Received</th>
                                            <th>Balance</th>
                                           
                                           
                                        </tr>
                                        </thead>
                  
                                        <tbody>
                                        @php $i=1; @endphp
                                       
                                        @foreach ($ageing_report as $item)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$item->date}}</td>
                                            <td>{{$item->invoice_number}}</td>
                                            <td>{{$item->customer_name}}</td>
                                            <td>{{$item->amount}}</td>
                                            
                                            <td>{{ \Carbon\Carbon::parse($item->due_date)->format('d/m/Y')}}</td>
                                            <td>@php

                                            $current_date = $date;
                                            $due_date = $item->due_date;
                                            $datetime1 = new DateTime($current_date);
                                            $datetime2 = new DateTime($due_date);
                                         
                                             $interval = $datetime1->diff($datetime2);
                                             $days = $interval->format('%a');
                                             echo $days;
                                                @endphp
                                            </td>
                                            <td>{{$item->receive_amount}}</td>
                                            <td>{{$item->remaining}}</td>
                                            
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
