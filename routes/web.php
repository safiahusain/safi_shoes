<?php

// use App\Http\Controllers\BankController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\ExpanseController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalemanController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\saleReturnController;
use App\Http\Controllers\purchaseReturnInvoiceController;
use App\Http\Controllers\ExpanseEntryController;
use App\Http\Controllers\PaymentVoucherController;
use App\Http\Controllers\SaleInvoiceController;
use App\Http\Controllers\CashVoucherController;
// use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\BranchUserController;
use App\Http\Controllers\AssignStockController;

/*

|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('asad', [CustomAuthController::class, 'asad'])->name('asad');


Route::get('/', [CustomAuthController::class, 'redirect'])->name('redirect');
Route::get('/home', [CustomAuthController::class, 'index'])->name('home');
Route::get('/front-end', [CustomAuthController::class, 'front_end'])->name('front-end');
Route::get('/login', [CustomAuthController::class, 'create_login'])->name('login');
Route::post('/check-login', [CustomAuthController::class, 'check_login'])->name('check-login');
Route::get('/register', [CustomAuthController::class, 'create_register'])->name('register-user');
Route::post('/store-register', [CustomAuthController::class, 'store_register'])->name('store-register');
Route::get('/dashboard', [CustomAuthController::class, 'dashboardView'])->name('dashboard');
Route::get('logout', [CustomAuthController::class, 'logout'])->name('logout');

// user-profile
Route::get('show-profile', [CustomAuthController::class, 'fetch_profile'])->name('show-profile');
Route::get('edit-profile', [CustomAuthController::class, 'edit_profile'])->name('edit-profile');
Route::post('update-profile/{id}', [CustomAuthController::class, 'update_profile'])->name('update-profile');
// user-cruds
// Route::get('add-user', [CustomAuthController::class, 'create_user'])->name('add-user');
Route::get('show-user/', [CustomAuthController::class, 'fetch_user'])->name('show-user');
Route::post('store-user', [CustomAuthController::class, 'store_user'])->name('store-user');
Route::get('edit-user/{id}', [CustomAuthController::class, 'edit_user'])->name('edit-user');
Route::post('update-user/{id}', [CustomAuthController::class, 'update_user'])->name('update-user');
Route::get('delete-user/{id}', [CustomAuthController::class, 'destroy_user'])->name('delete-user');

//user-roles
Route::get('show-role', [CustomAuthController::class, 'fetch_role'])->name('show-role');
Route::get('edit-role/{id}', [CustomAuthController::class, 'edit_role'])->name('edit-role');
Route::post('store-role', [CustomAuthController::class, 'store_role'])->name('store-role');
Route::post('update-role/{id}', [CustomAuthController::class, 'update_role'])->name('update-role');
Route::get('delete-role/{id}', [CustomAuthController::class, 'destroy_role'])->name('delete-role');


// *************customer route**************************************

// Route::get('add-user', [CustomerController::class, 'create_user'])->name('add-user');
Route::get('show-customer/', [CustomerController::class, 'fetch_customer'])->name('show-customer');
Route::post('store-customer', [CustomerController::class, 'store_customer'])->name('store-customer');
Route::get('edit-customer/{id}', [CustomerController::class, 'edit_customer'])->name('edit-customer');
Route::post('update-customer/{id}', [CustomerController::class, 'update_customer'])->name('update-customer');
Route::get('delete-customer/{id}', [CustomerController::class, 'destroy_customer'])->name('delete-customer');

Route::get('show-customer-balance-detail/{id}', [CustomerController::class, 'show_customer_balance_detail'])->name('show-customer-balance-detail');


// *************end customer route**************************************

// Route::get('add-product', [ProductController::class, 'create_brand'])->name('add-product');
Route::get('show-product/', [ProductController::class, 'fetch_product'])->name('show-product');
Route::get('retreive-product-detail/{id}', [ProductController::class, 'fetch_product_detail'])->name('retreive-product-detail');
Route::post('store-product', [ProductController::class, 'store_product'])->name('store-product');
Route::get('edit-product/{id}', [ProductController::class, 'edit_product'])->name('edit-product');
Route::post('update-product/{id}', [ProductController::class, 'update_product'])->name('update-product');
Route::get('delete-product/{id}', [ProductController::class, 'destroy_product'])->name('delete-product');

// Route::get('add-product-category', [ProductController::class, 'create_brand_category'])->name('add-prodproduct-categoryuct');
Route::get('show-product-category/', [ProductController::class, 'fetch_product_category'])->name('show-product-category');
Route::post('store-product-category', [ProductController::class, 'store_product_category'])->name('store-product-category');
Route::get('edit-product-category/{id}', [ProductController::class, 'edit_product_category'])->name('edit-product-category');
Route::post('update-product-category/{id}', [ProductController::class, 'update_product_category'])->name('update-product-category');
Route::get('delete-product-category/{id}', [ProductController::class, 'destroy_product_category'])->name('delete-product-category');

// Route::get('add-color', [ProductController::class, 'creatcolor'])->name('add-color');
Route::get('show-color/', [ProductController::class, 'fetch_color'])->name('show-color');
Route::post('store-color', [ProductController::class, 'store_color'])->name('store-color');
Route::get('edit-color/{id}', [ProductController::class, 'edit_color'])->name('edit-color');
Route::post('update-color/{id}', [ProductController::class, 'update_color'])->name('update-color');
Route::get('delete-color/{id}', [ProductController::class, 'destroy_color'])->name('delete-color');

// Route::get('add-size', [ProductController::class, 'creatsize'])->name('add-size');
Route::get('show-size/', [ProductController::class, 'fetch_size'])->name('show-size');
Route::post('store-size', [ProductController::class, 'store_size'])->name('store-size');
Route::get('edit-size/{id}', [ProductController::class, 'edit_size'])->name('edit-size');
Route::post('update-size/{id}', [ProductController::class, 'update_size'])->name('update-size');
Route::get('delete-size/{id}', [ProductController::class, 'destroy_size'])->name('delete-size');
Route::get('get/category/size/{id}', [ProductController::class, 'get_category_sizes'])->name('get-category-sizes');

// company routes


// Route::get('add-company', [CompanyController::class, 'create_company'])->name('add-company');
Route::get('show-company/', [CompanyController::class, 'fetch_company'])->name('show-company');
Route::get('show-company-balance-detail/{id}', [CompanyController::class, 'show_company_balance_detail'])->name('show-company-balance-detail');
Route::get('edit-purchase-invoice/fetch-company/{companyid}', [CompanyController::class, 'retreive_company'])->name('retreive-company');
Route::get('fetch-company/{company_id}', [CompanyController::class, 'retreive_company_one'])->name('retreive-company_one');
Route::post('store-company', [CompanyController::class, 'store_company'])->name('store-company');
Route::get('edit-company/{id}', [CompanyController::class, 'edit_company'])->name('edit-company');
Route::post('update-company/{id}', [CompanyController::class, 'update_company'])->name('update-company');
Route::get('delete-company/{id}', [CompanyController::class, 'destroy_company'])->name('delete-company');

// Route::get('add-brand', [BrandController::class, 'create_brand'])->name('add-brand');
Route::get('show-brand/', [BrandController::class, 'fetch_brand'])->name('show-brand');
Route::post('store-brand', [BrandController::class, 'store_brand'])->name('store-brand');
Route::get('edit-brand/{id}', [BrandController::class, 'edit_brand'])->name('edit-brand');
Route::post('update-brand/{id}', [BrandController::class, 'update_brand'])->name('update-brand');
Route::get('delete-brand/{id}', [BrandController::class, 'destroy_brand'])->name('delete-brand');

// Route::get('add-branch', [BranchController::class, 'create_user'])->name('add-user');
// Route::get('show-user/', [BranchController::class, 'fetch_branch'])->name('show-branch');
Route::post('store-branch', [BranchController::class, 'store_branch'])->name('store-branch');
Route::get('edit-branch/{id}', [BranchController::class, 'edit_branch'])->name('edit-branch');
Route::post('update-branch/{id}', [BranchController::class, 'update_branch'])->name('update-branch');
Route::get('delete-branch/{id}', [BranchController::class, 'destroy_branch'])->name('delete-branch');

// Route::get('add-branch', [StockController::class, 'create_user'])->name('add-user');
Route::get('show-stock/', [StockController::class, 'fetch_stock'])->name('show-stock');
Route::post('store-stock', [StockController::class, 'store_stock'])->name('store-stock');
Route::get('edit-stock/{id}', [StockController::class, 'edit_stock'])->name('edit-stock');
Route::post('update-stock/{id}', [StockController::class, 'update_stock'])->name('update-stock');
Route::get('delete-stock/{id}', [StockController::class, 'destroy_stock'])->name('delete-stock');

// Assign Stock to warehouse Controller

Route::get('show/warehouse/stock/{param}', [AssignStockController::class, 'index'])->name('show-warehouse-stock');
Route::get('add/warehouse/stock/{param}', [AssignStockController::class, 'create'])->name('add-warehouse-stock');
Route::get('warehouse/stock/{param}', [AssignStockController::class, 'createReturn'])->name('return-warehouse-stock');
Route::post('store/warehouse/stock/{param}', [AssignStockController::class, 'store'])->name('store-warehouse-stock');
Route::get('edit/warehouse/stock/{param}/{id}', [AssignStockController::class, 'edit'])->name('edit-warehouse-stock');
Route::get('return/warehouse/{param}/{id}', [AssignStockController::class, 'editReturn'])->name('edit-return-warehouse');
Route::post('upadte/warehouse/stock/{param}/{id}', [AssignStockController::class, 'update'])->name('upadte-warehouse-stock');
Route::get('delete/warehouse/stock/{param}/{id}', [AssignStockController::class, 'delete'])->name('delete-warehouse-stock');
Route::get('show/branch/stock/{param}', [AssignStockController::class, 'stockIndex'])->name('show-branch-stock');
Route::get('add/branch/stock/{param}', [AssignStockController::class, 'createStock'])->name('add-branch-stock');
Route::post('store/branch/stock/{param}', [AssignStockController::class, 'storeStock'])->name('store-branch-stock');
Route::get('edit/branch/stock/{param}/{id}', [AssignStockController::class, 'editStock'])->name('edit-branch-stock');
Route::post('upadte/branch/stock/{param}/{id}', [AssignStockController::class, 'updateStock'])->name('upadte-branch-stock');
Route::get('delete/branch/stock/{param}/{id}', [AssignStockController::class, 'deleteStock'])->name('delete-branch-stock');

// Sale Invoice Controller

Route::get('show/sale/{param}', [SaleInvoiceController::class, 'index'])->name('show-saleInvoice');
Route::get('add/sale/{param}', [SaleInvoiceController::class, 'create'])->name('add-saleInvoice');
Route::post('store/sale/{param}', [SaleInvoiceController::class, 'store'])->name('store-saleInvoice');
Route::get('edit/sale/{param}/{id}', [SaleInvoiceController::class, 'edit'])->name('edit-saleInvoice');
Route::post('upadte/sale/{param}/{id}', [SaleInvoiceController::class, 'update'])->name('upadte-saleInvoice');
Route::get('delete/sale/{param}/{id}', [SaleInvoiceController::class, 'delete'])->name('delete-saleInvoice');
Route::get('show/purchase/{param}', [SaleInvoiceController::class, 'purchaseIndex'])->name('show-purchaseInvoice');
Route::get('add/purchase/{param}', [SaleInvoiceController::class, 'purchaseCreate'])->name('add-purchaseInvoice');
Route::post('store/purchase/{param}', [SaleInvoiceController::class, 'purchaseStore'])->name('store-purchaseInvoice');
Route::get('edit/purchase/{param}/{id}', [SaleInvoiceController::class, 'purchaseEdit'])->name('edit-purchaseInvoice');
Route::post('upadte/purchase/{param}/{id}', [SaleInvoiceController::class, 'purchaseUpdate'])->name('upadte-purchaseInvoice');
Route::get('delete/purchase/{param}/{id}', [SaleInvoiceController::class, 'purchaseDelete'])->name('delete-purchaseInvoice');

// warehouses routes

Route::get('add-warehouse', [WarehouseController::class, 'create_warehouse'])->name('add-warehouse');
Route::get('show-warehouse', [WarehouseController::class, 'create'])->name('show-warehouse');
Route::post('store-warehouse', [WarehouseController::class, 'store_warehouse'])->name('store-warehouse');
Route::get('edit-warehouse/{id}', [WarehouseController::class, 'edit_warehouse'])->name('edit-warehouse');
Route::post('update-warehouse/{id}', [WarehouseController::class, 'update_warehouse'])->name('update-warehouse');
Route::get('delete-warehouse/{id}', [WarehouseController::class, 'delete_warehouse'])->name('delete-warehouse');

// *************************** sale controller ***********************************

Route::get('fetch-shoes-sizes/{id}', [SaleController::class, 'fetch_shoes_sizes'])->name('fetch-shoes-sizes');
Route::get('fetch-product-data/{id}', [SaleController::class, 'fetch_product_data'])->name('fetch-product');
Route::get('show-sale-invoice/', [SaleController::class, 'show_sale_invoice'])->name('show-sale');
Route::post('store-sale-invoice', [SaleController::class, 'store_sale_invoice'])->name('store-sale');
Route::get('fetch-customer-data/{id}', [SaleController::class, 'fetch_customer_data'])->name('fetch-customer-data');
Route::get('edit-sale-invoice/{id}', [SaleController::class, 'edit_sale_invoice'])->name('edit-sale');
Route::post('update-sale-invoice/{id}', [SaleController::class, 'update_sale_invoice'])->name('update-sale');
Route::get('delete-sale-invoice/{id}', [SaleController::class, 'delete_sale_invoice'])->name('delete-sale');
Route::get('sale-invoice-form', [SaleController::class, 'sale_invoice_form'])->name('sale-invoice-form');
Route::get('fetch-sale-invoice-detail-ajax/{id}', [SaleController::class, 'fetch_sale_invoice_detail_ajax'])->name('fetch-sale-invoice-detail-ajax');

Route::get('fetch-customer-for-sale/{id}', [SaleController::class, 'fetch_customer_for_sale'])->name('fetch-customer-for-sale');
Route::get('customer-sale-detail/{id}', [SaleController::class, 'customer_sale_detail'])->name('customer-sale-detail');




Route::get('show-purchase-invoice/', [SaleController::class, 'fetch_purchase_invoice'])->name('show-purchase-invoice');
Route::post('store-purchase-invoice', [SaleController::class, 'store_purchase_invoice'])->name('store-purchase-invoice');
Route::get('edit-purchase-invoice/{id}', [SaleController::class, 'edit_purchase_invoice'])->name('edit-purchase-invoice');
Route::post('update-purchase-invoice/{id}', [SaleController::class, 'update_purchase_invoice'])->name('update-purchase-invoice');
Route::get('delete-purchase-invoice/{id}', [SaleController::class, 'destroy_purchase_invoice'])->name('delete-purchase-invoice');


// **********************Sale  return controller ********************************

// Route::get('add-sale', [SaleController::class, 'create_sale'])->name('add-sale');
// Route::get('show-sale-return-invoice', [saleReturnController::class, 'fetch_sale_return_invoice'])->name('show-sale-return-invoice');
Route::get('show-sale-return-invoice', [saleReturnController::class, 'show_sale_return_invoice'])->name('show-sale-return-invoice');
Route::post('store-sale-return-invoice', [saleReturnController::class, 'store_sale_return_invoice'])->name('store-sale-return');
Route::get('edit-sale-return-invoice/{id}', [saleReturnController::class, 'edit_sale_return_invoice'])->name('edit-sale-return');
Route::post('update-sale-return-invoice/{id}', [saleReturnController::class, 'update_sale_return_invoice'])->name('update-sale-return');
Route::get('delete-sale-return-invoice/{id}', [saleReturnController::class, 'delete_sale_return_invoice'])->name('delete-sale-return');
Route::get('fetch-sale-return-invoice-detail-ajax/{id}', [saleReturnController::class, 'fetch_sale_return_invoice_detail_ajax'])->name('fetch-sale-return-invoice-detail-ajax');
Route::get('show-product-name-in-li-sale-return', [saleReturnController::class, 'show_product_name_in_li_sale_return'])->name('show-product-name-in-li-sale-return');

Route::get('sale-invoice-return-form', [saleReturnController::class, 'sale_invoice_return_form'])->name('sale-invoice-return-form');
Route::get('customer-sale-return-detail/{id}', [saleReturnController::class, 'customer_sale_return_detail'])->name('sale-invoice-return-detail');


// *************************end of sale return controller****************************


// Route::get('add-purchase', [PurchaseController::class, 'create_user'])->name('add-purchase');
Route::get('show-purchase/', [PurchaseController::class, 'fetch_purchase'])->name('show-purchase');
Route::post('store-purchase', [PurchaseController::class, 'store_purchase'])->name('store-purchase');
Route::get('edit-purchase/{id}', [PurchaseController::class, 'edit_purchase'])->name('edit-purchase');
Route::post('update-purchase/{id}', [PurchaseController::class, 'update_purchase'])->name('update-purchase');
Route::get('delete-purchase/{id}', [PurchaseController::class, 'destroy_purchase'])->name('delete-purchase');

// purchase invoice controller

// Route::get('add-purchase-invoice', [PurchaseController::class, 'create_user'])->name('add-purchase-invoice');
Route::get('show-purchase-invoice/', [PurchaseController::class, 'fetch_purchase_invoice'])->name('show-purchase-invoicess');
Route::get('invoice/', [PurchaseController::class, 'invoice'])->name('show-purchase-invoices');
Route::get('purchase-invoice-form/', [PurchaseController::class, 'purchase_invoice_form'])->name('purchase-invoice-form');
Route::get('fetch-product-using-code/{code}', [PurchaseController::class, 'fetch_product_using_code'])->name('fetch-product-using-codes');
Route::get('edit-purchase-invoice/fetch-product-using-code/{code}', [PurchaseController::class, 'fetch_product_using_code'])->name('fetch-product-using-codess');
Route::get('show-invoice-detail', [PurchaseController::class, 'show_invoice_detail'])->name('show-invoice-detail');
Route::post('store-purchase-invoice', [PurchaseController::class, 'store_purchase_invoice'])->name('store-purchase-invoice');
Route::get('edit-purchase-invoice/{id}', [PurchaseController::class, 'edit_purchase_invoice'])->name('edit-purchase-invoice');
Route::post('update-purchase-invoice/{id}', [PurchaseController::class, 'update_purchase_invoice'])->name('update-purchase-invoice');
Route::get('delete-purchase-invoice/{id}', [PurchaseController::class, 'delete_purchase_invoice'])->name('delete-purchase-invoice');
Route::get('fetch-product-detail', [PurchaseController::class, 'fetch_product_detail'])->name('fetch-product-detail');
Route::get('customer-purchase-detail/{id}', [PurchaseController::class, 'customer_purchase_detail'])->name('customer-purchase-detail');
Route::get('fetch-purchase-invoice-detail-ajax/{id}', [PurchaseController::class, 'fetch_purchase_invoice_detail_ajax'])->name('fetch-purchase-invoice-detail-ajax');


Route::get('show-product-name-in-li', [PurchaseController::class, 'show_product_name_in_li'])->name('show-product-name-in-li');

route::get('multiple-data-form', [CompanyController::class, 'multiple_data_form']);
route::get('edit-multiple-data/{id}', [CompanyController::class, 'edit_multiple_data']);
route::put('update-multiple-data/{id}', [CompanyController::class, 'update_multiple_data']);
route::post('add-multiple-data', [CompanyController::class, 'add_multiple_data']);


// **********purchase return invoice controller *******************************


// Route::get('add-purchase-return', [PurchaseController::class, 'create_user'])->name('add-purchase-return');
Route::get('show-purchase-return-invoice/', [purchaseReturnInvoiceController::class, 'fetch_purchase_return_invoice'])->name('show-purchase-return-invoices');
Route::get('customer-purchase-return-detail/{id}', [purchaseReturnInvoiceController::class, 'customer_purchase_return_detail'])->name('show-purchase-return-invoicess');
Route::post('store-purchase-return-invoice', [purchaseReturnInvoiceController::class, 'store_purchase_return_invoice'])->name('store-purchase-return');
Route::get('edit-purchase-return-invoice/{id}', [purchaseReturnInvoiceController::class, 'edit_purchase_return_invoice'])->name('edit-purchase-return');
Route::post('update-purchase-return-invoice/{id}', [purchaseReturnInvoiceController::class, 'update_purchase_return_invoice'])->name('update-purchase-return');
Route::get('delete-purchase-return-invoice/{id}', [purchaseReturnInvoiceController::class, 'delete_purchase_return_invoice'])->name('delete-purchase-return');
Route::get('fetch-purchase-return-invoice-detail-ajax/{id}', [purchaseReturnInvoiceController::class, 'fetch_purchase_return_invoice_detail_ajax'])->name('fetch-purchase-return-invoice-detail-ajax');


Route::get('purchase-invoice-return-form/', [purchaseReturnInvoiceController::class, 'purchase_invoice_return_form'])->name('purchase-invoice-return-form');


// **********end of purchase return invoice controller *******************************



// Route::get('add-manager', [ManagerController::class, 'create_manager'])->name('add-manager');
// Route::get('show-manager/', [ManagerController::class, 'fetch_manager'])->name('show-manager');
// Route::post('store-manager', [ManagerController::class, 'store_manager'])->name('store-manager');
// Route::get('edit-manager/{id}', [ManagerController::class, 'edit_manager'])->name('edit-manager');
// Route::put('updated-manager/{id}', [ManagerController::class, 'update_manager'])->name('update-manager');
// Route::get('delete-manager/{id}', [ManagerController::class, 'destroy_manager'])->name('delete-manager');


// ********************* saleman controllers******************************************

// Route::get('add-saleman', [SalemanController::class, 'create_saleman'])->name('add-saleman');
Route::get('show-saleman/', [SalemanController::class, 'fetch_saleman'])->name('show-saleman');
Route::post('store-saleman', [SalemanController::class, 'store_saleman'])->name('store-saleman');
Route::get('edit-saleman/{id}', [SalemanController::class, 'edit_saleman'])->name('edit-saleman');
Route::post('update-saleman/{id}', [SalemanController::class, 'update_saleman'])->name('update-saleman');
Route::get('delete-saleman/{id}', [SalemanController::class, 'delete_saleman'])->name('delete-saleman');


// **********************************expanses routes************************

// Route::get('add-expanse', [ExpanseController::class, 'create_expanse'])->name('add-expanse');
Route::get('show-expanse/', [ExpanseController::class, 'fetch_expanse'])->name('show-expanse');
Route::post('store-expanse', [ExpanseController::class, 'store_expanse'])->name('store-expanse');
Route::get('edit-expanse/{id}', [ExpanseController::class, 'edit_expanse'])->name('edit-expanse');
Route::post('update-expanse/{id}', [ExpanseController::class, 'update_expanse'])->name('update-expanse');
Route::get('delete-expanse/{id}', [ExpanseController::class, 'delete_expanse'])->name('delete-expanse');

// **********************************end of expanses routes************************


// **********************************start of expanses entry routes************************


Route::get('show-expanse-entry/', [ExpanseEntryController::class, 'fetch_expanse_entry'])->name('show-expanditure');
Route::post('store-expanse-entry', [ExpanseEntryController::class, 'store_expanse_entry'])->name('store-expanditure');
Route::get('edit-expanse-entry/{id}', [ExpanseEntryController::class, 'edit_expanse_entry'])->name('edit-expanditure');
Route::post('update-expanse-entry/{id}', [ExpanseEntryController::class, 'update_expanse_entry'])->name('update-expanditure');
Route::get('delete-expanse-entry/{id}', [ExpanseEntryController::class, 'delete_expanse_entry'])->name('delete-expanditure');


// **********************************end of expanses entry routes************************


// *********************** bank controller *************************

Route::get('show-bank-head', [BankController::class, 'fetch_bank_head'])->name('add-bank');
Route::get('show-bank/', [BankController::class, 'fetch_bank'])->name('show-bank');
Route::post('store-bank-head', [BankController::class, 'store_bank_head'])->name('store-bank-head');
Route::get('edit-bank-head/{id}', [BankController::class, 'edit_bank_head'])->name('edit-bank');
Route::post('update-bank-head/{id}', [BankController::class, 'update_bank_head'])->name('update-banks');
Route::get('delete-bank-head/{id}', [BankController::class, 'delete_bank_head'])->name('delete-bank');



Route::get('show-bank-entry', [BankController::class, 'fetch_bank_entry'])->name('add-banks');
Route::post('store-bank-entry', [BankController::class, 'store_bank_entry'])->name('store-bank-heads');
Route::get('edit-bank-entry/{id}', [BankController::class, 'edit_bank_entry'])->name('edit-banks');
Route::post('update-bank-entry/{id}', [BankController::class, 'update_bank_entry'])->name('update-bank');
Route::get('delete-bank-entry/{id}', [BankController::class, 'delete_bank_entry'])->name('delete-banks');

// ********************* cash Voucher routes***********************************

// Route::get('add-cash-voucher', [VoucherController::class, 'createvoucher'])->name('add-cash-voucher');
Route::get('show-cash-voucher/', [CashVoucherController::class, 'fetch_cash_voucher'])->name('show-cash-voucher');
Route::post('store-cash-voucher', [CashVoucherController::class, 'store_cash_voucher'])->name('store-cash-voucher');
Route::get('edit-cash-voucher/{id}', [CashVoucherController::class, 'edit_cash_voucher'])->name('edit-cash-voucher');
Route::post('update-cash-voucher/{id}', [CashVoucherController::class, 'update_cash_voucher'])->name('update-cash-voucher');
Route::get('delete-cash-voucher/{id}', [CashVoucherController::class, 'delete_cash_voucher'])->name('delete-cash-voucher');

Route::get('fetch-customer-invoice/{name}', [CashVoucherController::class, 'fetch_customer_invoice'])->name('fetch-customer-invoice');
Route::get('edit-cash-voucher/fetch-customer-name/{name}', [CashVoucherController::class, 'fetch_customer_name'])->name('fetch-customer-name');
Route::get('edit-cash-voucher/fetch-customer-detail-for-cash/{name}', [CashVoucherController::class, 'fetch_customer_detail_for_cash'])->name('fetch-customer-detail-for-cashs');
Route::get('fetch-customer-detail-for-cash/{name}', [CashVoucherController::class, 'fetch_customer_detail_for_cash'])->name('fetch-customer-detail-for-cash');

// *********************end cash Voucher routes***********************************

// ******************* payment voucher routes*****************************************

// Route::get('add-payment-voucher', [VoucherController::class, 'createvoucher'])->name('add-payment-voucher');
Route::get('show-payment-voucher/', [PaymentVoucherController::class, 'fetch_payment_voucher'])->name('show-payment-voucher');
Route::post('store-payment-voucher', [PaymentVoucherController::class, 'store_payment_voucher'])->name('store-payment-voucher');
Route::get('edit-payment-voucher/{id}', [PaymentVoucherController::class, 'edit_payment_voucher'])->name('edit-payment-voucher');
Route::post('update-payment-voucher/{id}', [PaymentVoucherController::class, 'update_payment_voucher'])->name('update-payment-voucher');
Route::get('delete-payment-voucher/{id}', [PaymentVoucherController::class, 'delete_payment_voucher'])->name('delete-payment-voucher');
Route::get('fetch-company-balance/{name}', [PaymentVoucherController::class, 'fetch_company_balance'])->name('fetch-company-balances');
Route::get('edit-payment-voucher/fetch-company-balance/{name}', [PaymentVoucherController::class, 'fetch_company_balance'])->name('fetch-company-balance');

// ******************* payment voucher routes*****************************************


// All reports routes

Route::get('show-purchase-report/', [ReportController::class, 'show_purchase_report'])->name('show-purchase-reports');
Route::get('show-sale-report/', [ReportController::class, 'show_sale_report'])->name('show-purchase-report');
Route::get('show-sale-return-report/', [ReportController::class, 'show_sale_return_report'])->name('show-sale-return-report');
Route::get('show-purchase-return-report/', [ReportController::class, 'show_purchase_return_report'])->name('show-purchase-return-report');

Route::get('show-cash-report', [ReportController::class, 'show_cash_report'])->name('show-cash-reports');
Route::get('fetch-customer-name-using-saleman/{saleman_name}', [ReportController::class, 'fetch_customer_name_using_saleman'])->name('show-cash-report');

Route::get('show-payment-report', [ReportController::class, 'show_payment_report'])->name('show-payment-report');
Route::get('fetch-customer-name-using-company/{company_name}', [ReportController::class, 'fetch_customer_name_using_company'])->name('fetch-customer-name-using-company');

Route::get('show-company-balance-report', [ReportController::class, 'show_company_balance_report'])->name('show-company-balance-reports');
Route::get('show-customer-balance-report', [ReportController::class, 'show_customer_balance_report'])->name('show-customer-balance-reports');

Route::get('show-company-ledger-report', [ReportController::class, 'show_company_ledger_report'])->name('show-company-balance-report');
Route::get('fetch-company-detail-using-company-name-ajax/{company_name}', [ReportController::class, 'fetch_company_detail_using_company_name_ajax'])->name('fetch-company-detail-using-company-name-ajax');

Route::get('show-customer-ledger-report', [ReportController::class, 'show_customer_ledger_report'])->name('show-customer-balance-report');
Route::get('fetch-customer-detail-using-customer-name-ajax/{salesman}', [ReportController::class, 'fetch_customer_detail_using_customer_name_ajax'])->name('fetch-customer-detail-using-saleman-name-ajax');

Route::get('show-product-report/', [ReportController::class, 'product_report'])->name('product-report');
Route::get('show-product-report-shop-warehouse/', [ReportController::class, 'product_report_shop_warehouse'])->name('show-product-report-shop-warehouse');

// using ajax

Route::get('fetch-product-name-and-details/{warehouse_name}', [ReportController::class, 'fetch_product_name_and_details'])->name('fetch-product-name-and-details');



// ageing report

Route::get('show-ageing-report/', [ReportController::class, 'show_ageing_report'])->name('show-ageing-report');


Route::post('update-report/{id}', [ReportController::class, 'update_report'])->name('update-report');
Route::get('delete-report/{id}', [ReportController::class, 'destroy_report'])->name('delete-report');


// roles and permissions for all user routes

Route::middleware(['auth'])->name('admin.')->prefix('admin')->group(function(){

    Route::resource('/roles', RoleController::class);
    Route::post('/roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions');
    Route::get('/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');
    Route::delete('/permissions/{permission}/roles/{role}', [PermissionController::class, 'revokeRole'])->name('permissions.roles.remove');
    Route::post('/permissions/{permission}/roles', [PermissionController::class, 'giveRole'])->name('permissions.roles');
    Route::resource('/permissions', PermissionController::class);
});



// Route::get('add-branch', [BranchController::class, 'create_user'])->name('add-user');
Route::get('show-branch/', [BranchUserController::class, 'fetch_branch_user'])->name('show-branchone');
Route::post('store-branchs', [BranchUserController::class, 'store_branch_user'])->name('store-branchone');
Route::get('edit-branchs/{id}', [BranchUserController::class, 'edit_branch_user'])->name('edit-branchone');
Route::post('update-branchs/{id}', [BranchUserController::class, 'update_branch_user'])->name('update-branchone');
Route::get('delete-branchs/{id}', [BranchUserController::class, 'destroy_branch_user'])->name('delete-branchone');
