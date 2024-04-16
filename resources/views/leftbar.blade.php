 <!-- ========== Left Sidebar Start ========== -->
        @php
            $user   =   Auth::user();
            $user_role  =   $user->role;
            $permission =   $user_role->permissions;
        @endphp

 <div class="vertical-menu">
     <input type='hidden' id='permission_data' value='{{json_encode($permission)}}'>
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>
                <li>
                    <a href="{{ url('/home') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        {{-- <span class="badge rounded-pill bg-info float-end">04</span> --}}
                        <span key="t-dashboards">Dashboards</span>
                    </a>
                </li>
                <li id='user' class='d-none'>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-user">User(s)</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('show-user/')}}" key="t-profile">Users</a></li>
                    </ul>
                </li>
                <li id='role_permission' class='d-none'>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-user">Roles & Permissions</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li id='role' class='d-none'>
                            <a href="{{ route('admin.roles.index')}}" key="t-profile">Roles</a>
                        </li>
                        <li id='permission' class='d-none'>
                            <a  href="{{ route('admin.permissions.index')}}" key="t-user-list">Permission</a>
                        </li>
                    </ul>
                </li>
                <li id='company_brand' class='d-none'>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-user">Companies & Brand(s)</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li id='company' class='d-none'>
                            <a href="{{ url('show-company')}}" key="t-profile">Company(s)</a>
                        </li>
                        <li id='brand' class='d-none'>
                            <a href="{{ url('show-brand')}}" key="t-profile">Brand(s)</a>
                        </li>
                    </ul>
                </li>
                <li id='branch_details' class='d-none'>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-user">Branches Detail(s)</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ url('show-branch')}}" key="t-profile">Branches</a>
                        </li>
                    </ul>
                </li>
                <li id='stock_detail' class='d-none'>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-user">Stock Detail(s)</span> 
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li id='assign_stock_to_branch' class='d-none'>
                            <a href="{{ url('show/warehouse/stock/'.'branch')}}" key="t-profile">Assign Stock to branch</a>
                        </li>
                        <li id='return_stock_to_admin'>
                            <a href="{{ url('show/warehouse/stock/'.'return')}}" key="t-profile">Return Stock to admin</a>
                        </li>
                        <!--<li>-->
                        <!--    <a href="{{ url('show/branch/stock/'.'return')}}" key="t-profile">Return Stock</a>-->
                        <!--</li>-->
                        <li id='assign_stock_by_super_admin' class='d-none'>
                            <a href="{{ url('show/warehouse/stock/'.'invoice')}}" key="t-profile">Assign stock by Super Admin</a>
                        </li>
                    </ul>
                </li>
                <li id='customer_details' class='d-none'>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-user">Customer Detail(s)</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ url('show-customer')}}" key="t-profile">Customer(s)</a>
                        </li>
                    </ul>
                </li>
                <li id='salesman_details' class='d-none'>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-user">Salesmen Detail(s)</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ url('show-saleman')}}" key="t-profile">Saleman(s)</a>
                        </li>
                    </ul>
                </li>
                <li id='product_details' class='d-none'>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-user-detail"></i>
                            <span key="t-user">Product Detail(s)</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li id='size' class='d-none'>
                                <a href="{{ url('show-size')}}" key="t-profile">Size</a>
                            </li>
                            <li id='color' class='d-none'>
                                <a href="{{ url('show-color')}}" key="t-profile">Color</a>
                            </li>
                            <li id='category' class='d-none'>
                                <a href="{{ url('show-product-category')}}" key="t-profile">Category</a>
                            </li>
                            <li id='product' class='d-none'>
                                <a href="{{ url('show-product')}}" key="t-profile">Product(s)</a>
                            </li>
                            <li id='assign_stock' class='d-none'>
                                <a href="{{ url('show/warehouse/stock/'.'invoice')}}" key="t-profile">Assign Stock</a>
                            </li>
                        </ul>
                    </li>
                <li id='sales_details' class='d-none'>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-user">Sales Detail(s)</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li id='sale_invoice' class='d-none'>
                            <a href="{{ url('show-sale-invoice')}}" key="t-profile">Sale Invoice(s)</a>
                        </li>
                        <li id='sales' class='d-none'>
                            <a href="{{ url('show/sale/'.'invoice')}}" key="t-profile">Sale</a>
                        </li>
                        <li id='sale_return' class='d-none'>
                            <a href="{{ url('show/sale/'.'return')}}" key="t-profile">Sale Return</a>
                        </li>
                        <li id='sale_return_invoice' class='d-none'>
                            <a href="{{ url('show-sale-return-invoice')}}" key="t-profile">Sale Return Invoice(s)</a>
                        </li>
                        <li  id='return_stock_to_warehouse' class='d-none'>
                            <a href="{{ url('show/warehouse/stock/'.'return')}}" key="t-profile">Return Stock to Warehouse</a>
                        </li>
                        
                        <li id='assign_stock_by_warehouse' class='d-none'>
                            <a href="{{ url('show/warehouse/stock/'.'invoice')}}" key="t-profile">Assign stock by Warehouse</a>
                        </li>
                    </ul>
                </li>
                <li id='purchase_details' class='d-none'>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-user-detail"></i>
                            <span key="t-user">Purchase Detail(s)</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li id='purchase_invoice' class='d-none'>
                                <a href="{{ url('show-purchase-invoice')}}" key="t-profile">Purchase Invoice(s)</a>
                            </li>
                            <li id='purchase_return_invoice' class='d-none'>
                                <a href="{{ url('show-purchase-return-invoice')}}" key="t-profile">Purchase Return Invoice(s)</a>
                            </li>
                        </ul>
                    </li>
                <li id='expanse_details' class='d-none'>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-user">Expanse Detail(s)</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li id='expanse_head' class='d-none'>
                            <a href="{{ url('show-expanse')}}" key="t-profile">Expanse's Head</a>
                        </li>
                        <li id='expanse_entry' class='d-none'>
                            <a href="{{ url('show-expanse-entry')}}" key="t-profile">Expanse's Entry</a>
                        </li>
                    </ul>
                </li>
                <li id='bank_details' class='d-none'>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-user">Bank Detail(s)</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li id='bank_head' class='d-none'>
                            <a href="{{ url('show-bank-head')}}" key="t-profile">Bank Head</a>
                        </li>
                        <li id='bank_entry' class='d-none'>
                            <a href="{{ url('show-bank-entry')}}" key="t-profile">Bank Entry</a>
                        </li>
                    </ul>
                </li>
                <li id='vouchers' class="menu-title d-none" key="t-pages">Vouchers</li>
                <li id='voucher' class='d-none'>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-detail"></i>
                            <span key="t-user">Voucher(s)</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li id='payment_voucher' class='d-none'>
                                <a href="{{url('show-payment-voucher')}}" key="t-blog-list">Payment Voucher(s)</a>
                            </li>
                            <li id='cash_voucher' class='d-none'>
                                <a href="{{url('show-cash-voucher')}}" key="t-blog-grid">Cash Voucher(s)</a>
                            </li>
                        </ul>
                    </li>
                <li id='reports' class="menu-title d-none" key="t-pages">Reports</li>
                <li id='report_section' class='d-none'>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-task"></i>
                        <span key="t-tasks">Reports Section</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li id='purchase_report' class='d-none'>
                            <a href="{{url('show-purchase-report')}}" key="t-task-list">Purchase Report</a>
                        </li>
                        <li id='purchase_return_report' class='d-none'>
                            <a href="{{url('show-purchase-return-report')}}" key="t-task-list">Purchase Return Report</a>
                        </li>
                        <li id='sale_report' class='d-none'>
                            <a href="{{url('show-sale-report')}}" key="t-kanban-board">Sale Report</a>
                        </li>
                        <li id='sale_return_report' class='d-none'>
                            <a href="{{url('show-sale-return-report')}}" key="t-kanban-board">Sale Return Report</a>
                        </li>
                        <li id='cash_report' class='d-none'>
                            <a href="{{url('show-cash-report')}}" key="t-kanban-board">Cash Report</a>
                        </li>
                        <li id='payment_report' class='d-none'>
                            <a href="{{url('show-payment-report')}}" key="t-task-list">Payment Report</a>
                        </li>
                        <li id='company_balance_report' class='d-none'>
                            <a href="{{url('show-company-balance-report')}}" key="t-kanban-board">Company Balance Report</a>
                        </li>
                        <li id='customer_balance_reports' class='d-none'>
                            <a href="{{url('show-customer-balance-report')}}" key="t-kanban-board">Customer Balance Report</a>
                        </li>
                        <li id='company_ledger_report' class='d-none'>
                            <a href="{{url('show-company-ledger-report')}}" key="t-kanban-board">Company Ledger Report</a>
                        </li>
                        <li id='customer_ledger_reports' class='d-none'>
                            <a href="{{url('show-customer-ledger-report')}}" key="t-kanban-board">Customer Ledger Report</a>
                        </li>
                        <li id='product_report' class='d-none'>
                            <a href="{{url('show-product-report')}}" key="t-create-task">Product Report</a>
                        </li>
                        <li id='ageing_detail' class='d-none'>
                            <a href="{{url('show-ageing-report')}}" key="t-create-task">Ageing Detail</a>
                        </li>
                        <li id='exit' class='d-none'>
                            <a href="tasks-create.html" key="t-create-task">Exit</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<script>
    
    $(document).ready(function() 
    {
        let permission_data = $('#permission_data').val();
        permission_data = JSON.parse(permission_data);
        
        $.each(permission_data, function(key, value)
        {
            if(value.name == 'user')
            {
                $('#user').removeClass('d-none');
            }
            
            if(value.name == 'role_permission')
            {
                $('#role_permission').removeClass('d-none');
            }
            
            if(value.name == 'role')
            {
                $('#role').removeClass('d-none');
            }
            
            if(value.name == 'permission')
            {
                $('#permission').removeClass('d-none');
            }
            
            if(value.name == 'company_brand')
            {
                $('#company_brand').removeClass('d-none');
            }
            
            if(value.name == 'company')
            {
                $('#company').removeClass('d-none');
            }
            
            if(value.name == 'brand')
            {
                $('#brand').removeClass('d-none');
            }
            
            if(value.name == 'branch_details')
            {
                $('#branch_details').removeClass('d-none');
            }
            
            if(value.name == 'stock_detail')
            {
                $('#stock_detail').removeClass('d-none');
            }
            
            if(value.name == 'customer_details')
            {
                $('#customer_details').removeClass('d-none');
            }
            
            if(value.name == 'salesman_details')
            {
                $('#salesman_details').removeClass('d-none');
            }
            
            if(value.name == 'product_details')
            {
                $('#product_details').removeClass('d-none');
            }
            
            if(value.name == 'size')
            {
                $('#size').removeClass('d-none');
            }
            
            if(value.name == 'color')
            {
                $('#color').removeClass('d-none');
            }
            
            if(value.name == 'category')
            {
                $('#category').removeClass('d-none');
            }
            
            if(value.name == 'product')
            {
                $('#product').removeClass('d-none');
            }
            
            if(value.name == 'assign_stock')
            {
                $('#assign_stock').removeClass('d-none');
            }
            
            if(value.name == 'return_stock_to_admin')
            {
                $('#return_stock_to_admin').removeClass('d-none');
            }
            
            if(value.name == 'assign_stock_by_super_admin')
            {
                $('#assign_stock_by_super_admin').removeClass('d-none');
            }
            
            if(value.name == 'sales_details')
            {
                $('#sales_details').removeClass('d-none');
            }
            
            if(value.name == 'sale_invoice')
            {
                $('#sale_invoice').removeClass('d-none');
            }
            
            if(value.name == 'sales')
            {
                $('#sales').removeClass('d-none');
            }
            
            if(value.name == 'assign_stock_by_warehouse')
            {
                $('#assign_stock_by_warehouse').removeClass('d-none');
            }
            
            if(value.name == 'sale_return_invoice')
            {
                $('#sale_return_invoice').removeClass('d-none');
            }
            
            if(value.name == 'sale_return')
            {
                $('#sale_return').removeClass('d-none');
            }
            
            if(value.name == 'return_stock_to_warehouse')
            {
                $('#return_stock_to_warehouse').removeClass('d-none');
            }
            
            if(value.name == 'purchase_details')
            {
                $('#purchase_details').removeClass('d-none');
            }
            
            if(value.name == 'purchase_invoice')
            {
                $('#purchase_invoice').removeClass('d-none');
            }
            
            if(value.name == 'purchase_return_invoice')
            {
                $('#purchase_return_invoice').removeClass('d-none');
            }
            
            if(value.name == 'expanse_details')
            {
                $('#expanse_details').removeClass('d-none');
            }
            
            if(value.name == 'expanse_head')
            {
                $('#expanse_head').removeClass('d-none');
            }
            
            if(value.name == 'expanse_entry')
            {
                $('#expanse_entry').removeClass('d-none');
            }
            
            if(value.name == 'bank_details')
            {
                $('#bank_details').removeClass('d-none');
            }
            
            if(value.name == 'bank_head')
            {
                $('#bank_head').removeClass('d-none');
            }
            
            if(value.name == 'bank_entry')
            {
                $('#bank_entry').removeClass('d-none');
            }
            
            if(value.name == 'voucher')
            {
                $('#vouchers').removeClass('d-none');
                $('#voucher').removeClass('d-none');
            }
            
            if(value.name == 'payment_voucher')
            {
                $('#payment_voucher').removeClass('d-none');
            }
            
            if(value.name == 'cash_voucher')
            {
                $('#cash_voucher').removeClass('d-none');
            }
            
            if(value.name == 'report_section')
            {
                $('#reports').removeClass('d-none');
                $('#report_section').removeClass('d-none');
            }
            
            if(value.name == 'purchase_report')
            {
                $('#purchase_report').removeClass('d-none');
            }
            
            if(value.name == 'purchase_return_report')
            {
                $('#purchase_return_report').removeClass('d-none');
            }
            
            if(value.name == 'sale_report')
            {
                $('#sale_report').removeClass('d-none');
            }
            
            if(value.name == 'sale_return_report')
            {
                $('#sale_return_report').removeClass('d-none');
            }
            
            if(value.name == 'cash_report')
            {
                $('#cash_report').removeClass('d-none');
            }
            
            if(value.name == 'payment_report')
            {
                $('#payment_report').removeClass('d-none');
            }
            
            if(value.name == 'company_balance_report')
            {
                $('#company_balance_report').removeClass('d-none');
            }
            
            if(value.name == 'customer_balance_reports')
            {
                $('#customer_balance_reports').removeClass('d-none');
            }
            
            if(value.name == 'company_ledger_report')
            {
                $('#company_ledger_report').removeClass('d-none');
            }
            
            if(value.name == 'customer_ledger_reports')
            {
                $('#customer_ledger_reports').removeClass('d-none');
            }
            
            if(value.name == 'product_report')
            {
                $('#product_report').removeClass('d-none');
            }
            
            if(value.name == 'ageing_detail')
            {
                $('#ageing_detail').removeClass('d-none');
            }
            
            if(value.name == 'exit')
            {
                $('#exit').removeClass('d-none');
            }
            
            if(value.name == 'assign_stock_to_branch')
            {
                $('#assign_stock_to_branch').removeClass('d-none');
            }
        });
    });

</script>
