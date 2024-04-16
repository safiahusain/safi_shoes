<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title class="title">Purchase Invoice Modal</title>

    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="purchase-invoice-modal.css">
    <style>

            @media print{

                .btn{
                    display : none;
                }
                .border{
                    border : none;
                }
                title{
                    display : none;
                }
                .a-href{
                  display:none;
                }
            }



        .small {
          padding: 0px 5px;
        }
    
        #tbody input[type="text"] {
          width: 50px;
          border-radius: 3px;
          border: 1px solid #cccccc;
          text-align: center;
        }
    
        #tbody>tr>td,
        #tfoot>tr>td {
          padding: 4px 8px;
        }
    
        #tfoot>tr>td {
          border: 40px;
        }
    
        #tfoot .total {
          font-weight: bold;
          font-size: 16px;
        }
    
        #tfoot .total-val {
          font-weight: bold;
          font-size: 16px;
          padding-left: 10px;
        }
    
        #tfoot .prebal,
        #tfoot .prebal-val {
          font-weight: bold;
          font-size: 16px;
          border-bottom: double 3px #dddddd;
        }
    
        #tfoot .prebal-val {
          padding-left: 10px;
        }
    
        #tfoot .discount {
          font-size: 16px;
        }
    
        #tfoot .discount-td,
        #tfoot .discount {
          font-weight: bold;
          border-bottom: double 3px #dddddd;
        }
    
        #tfoot .discount-val {
          padding: 7px 0px;
          font-size: 16px;
        }
    
        .table-hover>thead>tr>th,
        .table>tbody>tr>td {
          padding: 5px 8px 5px 8px;
        }
    
        .action-btn {
          color: #333;
        }
        select {
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
        box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
        -webkit-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
        }
        .bold {
          font-weight: bold;
        }
        .box-header{
          border : 1px solid black;
          border-radius : 10px;
          width : 100%;
          height : 70px;
          padding-left : 20px;
          margin-top: 40px;
          background-color : black;
          color : white;
        }
    </style>
</head>
<body>
    <section class="container">
        <div class="box-header" style="background-color : rgba(10,10,40,0.7) !important; color:white;">
            <h2>Sale Return Invoice Detail</h2>
        </div>
        <div style="padding: 10px 20px;">
            <h3 class="text-center">Customer: <span>{{$purchaseinvoicei->customer_name}}</span></h3>
            <div style="display: flex; justify-content: space-between;">
                <div>
                    <p>Sale Return Invoice #: <span>{{$purchaseinvoicei->id}}</span></p>
                    <p>Previous Balance: <span>{{$purchaseinvoicei->old_balance}}</span></p>
                </div>
                <div>
                    <p>Date: <span>{{$purchaseinvoicei->date}}</span></p>
                    <p>Company Invoice#: <span></span></p>
                </div>
            </div>
        </div>
        <div>
            <table class="table table-striped  bootstrap-datatable responsive" id="myTable">
                <thead>
                  <tr>
                    <th width="50">S.No</th>
                    <th width="215">Product</th>
                    <th width="90">Color</th>
                    <th width="90">Size</th>
                    <th width="90">Price</th>
                    <th width="90">Quantity</th>
                    <th width="110">Total</th>
                    <th width="80">Dis (%)</th>
                    <th width="90">Dis Value</th>
                    <th width="100">Net</th>
                  </tr>
                </thead>
                <tbody id="tbody">
                    @php $i=1; @endphp
                    @foreach($purchaseinvoices as $purchaseinvoices)
                  <tr id="">
                    <td class="border" style="text-align: center" id="count">{{$i}}</td>
                    <td class="border product">{{$purchaseinvoices->product_name}}</td>
                    <td class="border color">{{$purchaseinvoices->color}}</td>
                    <td class="border size">{{$purchaseinvoices->size}}</td>
                    <td class="border price">{{$purchaseinvoices->price}}</td>
                    <td class="border quantity">{{$purchaseinvoices->quantity}}</td>
                    <td class="border total">{{$purchaseinvoices->total}}</td>
                    <td class="border discount">{{$purchaseinvoices->discount}}</td>
                    <td class="border dis-value">{{$purchaseinvoices->less}}</td>
                    <td class="border net">{{$purchaseinvoices->net}}</td>
                  </tr>
                  @php $i++ @endphp
                  @endforeach
    
                </tbody>
                <tfoot id="tfoot">
                  <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="invoice-total" style="font-weight: bold;">Invoice Total:</td>
                    <td colspan="2" class="invoice-total-value" style="font-weight: bold;">{{$purchaseinvoicei->net}}</td>
                  </tr>
                  <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="dis" style="font-weight: bold; border-bottom: 1px solid black;">Discount:</td>
                    <td colspan="2" class="dis-td" style="font-weight: bold; border-bottom: 1px solid black;">{{$purchaseinvoicei->discount}}</td>
                  </tr>
    
                  <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="payable-invoice" style="font-weight: bold;">Discount in Value:</td>
                    <td colspan="2" class="payable-invoice-value" style="font-weight: bold;">{{$purchaseinvoicei->total_discount_value}}</td>
                  </tr>
                  <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="extra-dis" style="font-weight: bold; border-bottom: 1px solid black;">Extra Discount:</td>
                    <td colspan="2" class="extra-dis-value" style="font-weight: bold; border-bottom: 1px solid black;">{{$purchaseinvoicei->less}}%</td>
                  </tr>
    
                  <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="subtotal" style="font-weight: bold;">Subtotal:</td>
                    <td colspan="2" class="subtotal-value" style="font-weight: bold;">{{$purchaseinvoicei->sub_total}}</td>
                  </tr>
                  <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="prev-balance" style="font-weight: bold; border-bottom: 1px solid black;">Previous Balance:</td>
                    <td colspan="2" class="prev-balance-value" style="font-weight: bold; border-bottom: 1px solid black;">{{$purchaseinvoicei->old_balance}}</td>
                  </tr>
    
                  <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="total" style="font-weight: bold;">Total:</td>
                    <td colspan="2" class="total-value" style="font-weight: bold;">{{$purchaseinvoicei->total_value_of_sub_previous}}</td>
                  </tr>
                  <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="paid" style="font-weight: bold; border-bottom: 1px solid black;">Paid:</td>
                    <td colspan="2" class="paid-value" style="font-weight: bold; border-bottom: 1px solid black;">{{$purchaseinvoicei->paid_customer_balance}}</td>
                  </tr>
                  
                  <tr>
                    <td colspan="4"></td>
                    <td colspan="3" class="balance" style="font-weight: bold;">Balance:</td>
                    <td colspan="2" class="balance-value" style="font-weight: bold;">{{$purchaseinvoicei->net_customer_balance}}</td>
                  </tr>
                  <tr>
                    <td style="display: flex; gap: 10px;">
                     <a class="a-href" href="{{url('edit-sale-return-invoice',$purchaseinvoicei->id)}}"> <button type="button" id="btn_aedit" class="btn btn-success btn-sm">Edit</button></a>
                     <a class="a-href" href="{{url('show-sale-return-invoice')}}"><button type="button" id="btn_close" class="btn btn-success btn-sm">Close</button> </a> 
                      <button type="button" id="btn_print" class="btn btn-success btn-sm a-href" onClick="getPrint()">Print</button> 
                    </td>
                  </tr>
                </tfoot>
            </table>
        </div>
        
    </section>
</body>

<script>

    function getPrint()
    {
        window.print();
    }
    </script>
</html>