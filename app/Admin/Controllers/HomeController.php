<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\Inventory;
use App\admin\Controllers\Dashboard;
use OpenAdmin\Admin\Admin;
// use OpenAdmin\Admin\Controllers\Dashboard;
use OpenAdmin\Admin\Layout\Column;
use OpenAdmin\Admin\Layout\Content;
use OpenAdmin\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        // Custom CSS to fix mobile overflow and footer stacking
        
        return $content
            ->css_file(Admin::asset("open-admin/css/pages/dashboard.css"))
            ->title('Dashboard')
            ->description('Data Visualization')
            ->row(Dashboard::customdashboard())
            ->row(Dashboard::chart())
            ->row(function (Row $row) {

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::environment());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::extensions());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::dependencies());
                });
            });
    }
    public function online(Content $content)
    {
        return $content
        ->title('Online')
        ->description('Seats')
        ->row(Dashboard::online());
    }
    public function debt(Content $content)
    {
        return $content
        ->title('Debt')
        ->description('list')
        ->row(Dashboard::debt());
    }
    public function unpaid(Content $content)
    {
        return $content
        ->title('Unpaid')
        ->description('list')
        ->row(Dashboard::unpaid());
    }
    public function stock(Content $content)
    {
        return $content
        ->title('Stock')
        ->description('list')
        ->row(Dashboard::stock());
    }
}
