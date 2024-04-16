<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class permissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $permissions = [
        //     'company_page',
        //     'brand_page',
        //     'customer_page',
        //     'bank_page',
        //     'manager_page',
        //     'branch_page',
        //     'purchase_invoice_page',
        //     'purchase_return_invoice_page',
        //     'sale_page',
        //     'sale_return_invoice_page',
        //     ];
            
        //     foreach($permissions as $permission)
        //     {
        //     Permission::create(['name'=> $permission]);
        //     }
        
       
        
         Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);
            
    }
}
