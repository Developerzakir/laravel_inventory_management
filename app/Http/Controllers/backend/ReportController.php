<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\WareHouse;
use App\Models\Sale;
use App\Models\SaleReturn;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase;
use App\Models\ReturnPurchase;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function allReport()
    {
        $purchases = Purchase::with(['purchaseItems.product', 'supplier', 'warehouse'])->get();
        return view('admin.report.all_report', compact('purchases'));
    }

    public function purchaseReturnReport()
    {
        $returnPurchases = ReturnPurchase::with(['purchaseItems.product', 'supplier', 'warehouse'])->get();
        return view('admin.report.purchase_return_report', compact('returnPurchases'));
    }

    public function filterPurchases(Request $request)
    {

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $query = Purchase::with(['purchaseItems.product', 'supplier', 'warehouse']);

        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        $purchases = $query->get();
        return response()->json(['purchases' => $purchases]);
    }

    public function saleReport()
    {
        $saleReports = Sale::with(['saleItems.product', 'customer', 'warehouse'])->get();
        return view('admin.report.sale_report', compact('saleReports'));
    }


    public function saleReturnReport()
    {
        $returnSales = SaleReturn::with(['saleReturnItems.product', 'customer', 'warehouse'])->get();
        return view('admin.report.sales_return_report', compact('returnSales'));
    }

    public function productStockReport()
    {
        $products = Product::with(['category', 'warehouse'])->get();
        return view('admin.report.stock_report', compact('products'));
    }

    public function filterSales(Request $request)
    {

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $query = Sale::with(['saleItems.product', 'customer', 'warehouse']);

        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        $sales = $query->get();
        return response()->json(['sales' => $sales]);
    }
}
