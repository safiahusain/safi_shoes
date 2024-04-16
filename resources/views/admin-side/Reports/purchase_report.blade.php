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
                
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                @if(isset($purchase_report))
                                    <!--<h4 class="card-title">Buttons example</h4>-->
                                    <!--<p class="card-title-desc">Data table with CSV and -->
                                    <!--</p>-->
                                    
                                 <input type="button" class="btn btn-primary btn-sm ml-3" value="Print" style="height:35px; width:70px; float:right;" onclick="getPrint()">
                                    
                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100 table-sm">
                                        
                                        <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            <th>Inv#</th>
                                            <th>Date</th>
                                            <th>Company Name</th>
                                            <th>Product Name</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                           
                                        </tr>
                                        </thead>
                  
                                        <tbody>
                                        @php $i=1; @endphp
                                       
                                        @foreach ($purchase_report as $item)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$item->purchaseInoviceParti_id}}</td>
                                            <td>{{$item->date}}</td>
                                            <td>{{$item->company_name}}</td>
                                            <td>{{$item->product_name}}</td>
                                            <td>{{$item->quantity}}</td>
                                            <td>{{$item->price}}</td>
                                            <td>{{$item->total}}</td>
                                            
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

<script>
     function getPrint()
            {
                window.print();
            }
</script>


@endsection
