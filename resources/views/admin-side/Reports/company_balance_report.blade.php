@extends('admin-side.home')
@section('content')
@include('admin-side.purchases.purchase-modal-css')
<div class="main-content">
  

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                @if(isset($company_balance))
                                <h4 class="text-center mb-5 mt-3 text-decoration-underline">Companies Balance Report</h4>

                                    <form action="{{url('show-company-balance-report')}}" method="GET">

                                        <div class="d-flex">

                                        <select class="js-example-basic-single selectpicker mb-4 mr-4 p-none" name="select_company_name" id="select_company_name" width="150px;">
                                            <option value="">All Company Name</option>
                                            @foreach($company_name as $company_name)
                                                <option value="{{$company_name->name}}">{{$company_name->name}}</option>
                                                @endforeach
                                        </select>


                                        <input type="submit" class="btn btn-success btn-sm ml-3" value="Search" style="height:35px; width:70px">
                                        <input type="button" class="btn btn-success btn-sm ml-3" value="Print" style="height:35px; width:70px" onclick="getPrint()">

                                        </div>
                                        <hr class="bg-black">


                                        </form>
                                 
                                    
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 table-sm">
                                        
                                        <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            
                                            <th>Date</th>
                                            <th>Company Name</th>
                                            <th>Opening Balance</th>
                                            <th>Purchase</th>
                                            <th>Purchase Return</th>
                                            <th>Paid</th>
                                            <th>Balance</th>
                                           
                                        </tr>
                                        </thead>
                  
                                        <tbody>
                                        @php $i=1; @endphp
                                       
                                        @foreach ($company_balance as $item)
                                        <tr>
                                            <td>{{$i}}</td>
                                            
                                            <td>{{$item->date}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->open_balance}}</td>
                                            <td>{{$item->purchase_price}}</td>
                                            <td>{{$item->purchase_return}}</td>
                                            <td>{{$item->total_paid_balance}}</td>
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


@endsection
