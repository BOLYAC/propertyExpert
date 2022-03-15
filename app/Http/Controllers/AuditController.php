<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $audits = \OwenIt\Auditing\Models\Audit::with(['user'])
                ->where('event', '=', 'created')

                ->where('auditable_type', '=', 'App\Models\Client')
                ->orderBy('created_at', 'desc')->get();
//            \OwenIt\Auditing\Models\Audit::with(['user'])->chunk(10000, function ($audits) {
//                $audits->where('event', '=', 'created')
//                    ->where('auditable_type', '=', 'App\Models\Client')
//                    ->orderBy('created_at', 'desc');
//            });

            return DataTables::of($audits)
                ->addColumn('auditable_type', function ($audit) {
                    return $audit->auditable_type . 'id:' . $audit->auditable_id;
                })
                ->addColumn('event', function ($audit) {
                    return $audit->event;
                })
                ->addColumn('username', function ($audit) {
                    return $audit->user->name ?? '';
                })
                ->addColumn('created_at', function ($audit) {
                    return $audit->created_at->format('Y/m/d');
                })
                ->addColumn('old_values', function ($audit) {
                    $options = '';
                    foreach ($audit->old_values as $attribute => $value) {
                        $options .= '<tr><td><strong>' . $attribute . '</strong></td><td>' . $value . '</td></tr>';
                    }
                    return '<table class="table">' . $options . '</table>';
                })
                ->addColumn('new_values', function ($audit) {
                    $options = '';
                    foreach ($audit->new_values as $attribute => $value) {
                        $options .= '<tr><td><strong>' . $attribute . '</strong></td><td>' . $value . '</td></tr>';
                    }
                    return '<table class="table">' . $options . '</table>';
                })
                ->rawColumns(['new_values', 'old_values'])
                ->make(true);
        }
        return view('audits');
    }
}
