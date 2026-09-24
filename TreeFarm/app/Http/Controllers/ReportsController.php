<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use App\Models\PotSize;
use App\Models\Tree;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsController extends Controller
{

    /***************************************************

    sales_reports()

    This function displays the page which contains the 
    different sales report options.

    ****************************************************/
    public function sales_reports()
    {

        // Return the sales reports view
        return view('menu_top.reports.sales_reports');

    }


    /***************************************************

    sales_by_user(Request $request)

    This function displays the Total Sales for a specified period
    with totals for each salesperson who made a sale in that period.

    ****************************************************/
    public function sales_by_user(Request $request)
    {
        // Validate the request
        $validated = $request->validate([

            'user_start_date' => 'required|date',
            'user_end_date' => 'required|date',
            
        ]);

        // If the start date is the same as or after the end date
        if (Carbon::parse($validated['user_start_date'])->greaterThanOrEqualTo(Carbon::parse($validated['user_end_date'])))
        {
            // Return back to the sales reports page with errors
            return back()
                    ->withErrors(['user_start_date' => "The Start Date must be earlier than the End Date."])
                    ->withInput();
        }

        // Get the delivered sales from the database for the date range
        $sales = Sale::with(['user', 'sale_items'])
                        ->whereBetween('date', [
                            $validated['user_start_date'],
                            $validated['user_end_date']
                        ])
                        ->where('status', 'Delivered')
                        ->get();

        // Group the sales by salesperson
        $grouped_sales = $sales->groupBy('user_id')
                                ->map(function ($userSales) {
                                    
                                    // Build a summary array for each salesperson
                                    return [

                                        // The User model for this salesperson
                                        'user'          => $userSales->first()->user,

                                        // Total sales amount across all their sales
                                        'total_sales'   => $userSales->sum('total_sales_price'),

                                        // Total discount applied across all their sales
                                        'total_discount'=> $userSales->sum('discount'),

                                        // Total delivery fees across all their sales
                                        'delivery_fees' => $userSales->sum('delivery_fee'),

                                        // Total quantity of all sale_items across all their sales
                                        'quantity'      => $userSales->sum(function ($sale) {
                                            return $sale->sale_items->sum('quantity');
                                        }),

                                        // The raw sales collection (if needed for future detail views)
                                        'sales'         => $userSales,
                                    ];

                                });

        // Sort the grouped results alphabetically by salesperson name
        $grouped_sales = $grouped_sales->sortBy(function ($row) {
            return $row['user']->last_name . ' ' . $row['user']->first_name;
        });

        // Return the sales_by_user view and pass it the array and date range
        return view('menu_top.reports.sales_by_user', [
            'grouped_sales' => $grouped_sales,
            'start_date' => $validated['user_start_date'],
            'end_date' => $validated['user_end_date'],
        ]);

    }


    /***************************************************

    sales_by_tree_pot(Request $request)

    This function displays the Total Sales for a specified period
    with totals for each tree/pot size combination in that period.

    ****************************************************/
    public function sales_by_tree_pot(Request $request)
    {
        // Validate the request
        $validated = $request->validate([

            'tree_start_date' => 'required|date',
            'tree_end_date' => 'required|date',
            
        ]);

        // If the start date is the same as or after the end date
        if (Carbon::parse($validated['tree_start_date'])->greaterThanOrEqualTo(Carbon::parse($validated['tree_end_date'])))
        {
            // Return back to the sales reports page with errors
            return back()
                    ->withErrors(['tree_start_date' => "The Start Date must be earlier than the End Date."])
                    ->withInput();
        }

        // Get the sales from the database for the date range
        $sales = Sale::with(['sale_items'])
                        ->whereBetween('date', [
                            $validated['tree_start_date'],
                            $validated['tree_end_date']
                        ])
                        ->where('status', 'Delivered')
                        ->get();

        // Flatten all sale_items into one collection
        // Each flattened item contains only the fields needed for reporting
        $items = $sales->flatMap(function ($sale) {

            return $sale->sale_items->map(function ($item) use ($sale) {

                // Build a simplified item array for grouping
                return [
                    'common_name'   => $item->common_name,
                    'pot_size'      => $item->pot_size,
                    'quantity'      => $item->quantity,
                    'total_price'   => $item->total_price,
                    'discount'      => $item->discount,
                ];

            });

        });

        // Group items by a composite key: "common_name|pot_size"
        $grouped_sales = $items->groupBy(function ($item) {
                                return $item['common_name'] . '|' . $item['pot_size'];
                            })->map(function ($group) {

                                // Build a summary array for each tree/pot size combination
                                return [
                                    'common_name'   => $group->first()['common_name'],
                                    'pot_size'      => $group->first()['pot_size'],
                                    'quantity'      => $group->sum('quantity'),
                                    'total_sales'   => $group->sum('total_price'),
                                    'total_discount'=> $group->sum('discount'),
                                ];

                            });

        // Sort alphabetically by tree name then pot size
        $grouped_sales = $grouped_sales->sortBy(function ($row) {
            return $row['common_name'] . ' ' . $row['pot_size'];
        });
        
        // Return the sales_by_tree_pot view and pass it the array and date range
        return view('menu_top.reports.sales_by_tree_pot', [
            'grouped_sales' => $grouped_sales,
            'start_date' => $validated['tree_start_date'],
            'end_date' => $validated['tree_end_date'],
        ]);

    }


    /***************************************************

    sales_by_user_csv(Request $request)

    This function gets the Total Sales for a specified period
    with totals for each salesperson who made a sale in that period
    and exports it to a CSV file.

    ****************************************************/
    public function sales_by_user_csv(Request $request)
    {
        // Grab the headings and rows from the request
        // Decode the JSON-encoded headings and rows.
        $headings = json_decode($request->headings, true);
        $rows     = json_decode($request->rows, true);

        // Build a filename with a timestamp so each download is unique.
        $filename = "sales_by_user_" . now()->format('Ymd_His') . ".csv";

        // Set the HTTP headers so the browser downloads the response as a CSV file.
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        // The callback function is executed while streaming the CSV output.
        $callback = function () use ($headings, $rows) {

            // Open a write-only stream to the browser output buffer.
            $file = fopen('php://output', 'w');

            // Write the CSV header row (column names).
            fputcsv($file, $headings);

            // Write each row of the table into the CSV.
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }

            // Close the output stream.
            fclose($file);
        };

        // Stream the CSV back to the browser using the callback.
        return response()->stream($callback, 200, $headers);

    }


    /***************************************************

    sales_by_tree_pot_csv(Request $request)

    This function displays the Total Sales for a specified period
    with totals for each tree/pot size combination in that period.

    ****************************************************/
    public function sales_by_tree_pot_csv(Request $request)
    {
        // Grab the headings and rows from the request
        // Decode the JSON-encoded headings and rows.
        $headings = json_decode($request->headings, true);
        $rows     = json_decode($request->rows, true);

        // Build a filename with a timestamp so each download is unique.
        $filename = "sales_by_tree_pot_" . now()->format('Ymd_His') . ".csv";

        // Set the HTTP headers so the browser downloads the response as a CSV file.
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        // The callback function is executed while streaming the CSV output.
        $callback = function () use ($headings, $rows) {

            // Open a write-only stream to the browser output buffer.
            $file = fopen('php://output', 'w');

            // Write the CSV header row (column names).
            fputcsv($file, $headings);

            // Write each row of the table into the CSV.
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }

            // Close the output stream.
            fclose($file);
        };

        // Stream the CSV back to the browser using the callback.
        return response()->stream($callback, 200, $headers);

    }

}
