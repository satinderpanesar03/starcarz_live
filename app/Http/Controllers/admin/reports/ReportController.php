<?php

namespace App\Http\Controllers\admin\reports;

use App\Exports\BaseRateExport;
use App\Exports\CarInsuranceExport;
use App\Exports\CarLoanExport;
use App\Exports\GeneralInsuranceExport;
use App\Exports\GrossMarginExport;
use App\Exports\HealthInsuranceExport;
use App\Exports\MatchMakingExport;
use App\Exports\MortageLoanExport;
use App\Exports\PendingDocumentExport;
use App\Exports\PurchaseExport;
use App\Exports\RefurbishmentExport;
use App\Exports\SaleEnquiryExport;
use App\Exports\TermInsuranceExport;
use App\Http\Controllers\Controller;
use App\Models\AdminLogin;
use App\Models\CarInsurance;
use App\Models\CarLoan;
use App\Models\CustomerDemandVehcile;
use App\Models\GeneralInsurance;
use App\Models\HealthInsurance;
use App\Models\MortageLoan;
use App\Models\MstBrandType;
use App\Models\MstDealer;
use App\Models\MstExecutive;
use App\Models\MstModel;
use App\Models\MstParty;
use App\Models\PendingDocument;
use App\Models\Purchase;
use App\Models\PurchasedImage;
use App\Models\PurchaseOrder;
use App\Models\RcTransfer;
use App\Models\Refurbishment;
use App\Models\RefurbnishmentOrder;
use App\Models\Role;
use App\Models\SaleDetail;
use App\Models\SaleOrder;
use App\Models\TermInsurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PDO;

class ReportController extends Controller
{
    public function purchaseIndex(Request $request)
    {
        $list = true;
        if ($request->has('clear_search')) {
            return redirect()->route('admin.purchase-report.index');
        } else {
            $executiveFilter = $request->input('executiveFilter');
            $modelFilter = $request->input('modelFilter');
            $partyFilter = $request->input('partyFilter');
            $statusFilter = $request->input('statusFilter');
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            // Start with the base query
            $query = Purchase::query()->where('status', '!=', 5);

            // Apply filters based on form data
            if ($executiveFilter) {
                $query->where('mst_executive_id', $executiveFilter);
            }
            if ($modelFilter) {
                $query->where('mst_model_id', $modelFilter);
            }
            if ($partyFilter) {
                $query->where('mst_party_id', $partyFilter);
            }
            if ($statusFilter) {
                $query->where('status', $statusFilter);
            }
            if ($fromDate) {
                $query->whereDate('created_at', '>=', $fromDate);
            }
            if ($toDate) {
                $query->whereDate('created_at', '<=', $toDate);
            }


            // Fetch filtered results
            if (Auth::guard('admin')->user()->role_id == AdminLogin::ADMIN) {
                $purchases = $query->with('executiveName:id,name,email')->orderBy('id', 'desc')->paginate($request->limit ?: 10);
            } else {
                // Add user_executive_id condition for non-admin users
                $purchases = $query->with('executiveName:id,name,email')->where('user_executive_id', Auth::guard('admin')->id())
                    ->orderBy('id', 'desc')
                    ->paginate($request->limit ?: 10);
            }

            // $role = Role::where('title', ucfirst('executive'))->first();
            // if ($role) {
            //     $executives = AdminLogin::where('role_id', $role->id)->pluck('name', 'id');
            // } else {
            //     $executives = collect();
            // }
            $executives = MstExecutive::pluck('name', 'id');
            $models = MstModel::pluck('model', 'id');
            $party = MstParty::pluck('party_name', 'id');
            $status = Purchase::getStatus();
        }

        return view('admin.reports.purchase-index', compact('purchases', 'executives', 'models', 'party', 'status', 'list'));
    }

    public function purchaseExport(Request $request, $extension = null)
    {
        $start_date = $request->query('fromDate');
        $end_date = $request->query('toDate');
        $executiveFilter = $request->query('executiveFilter');
        $partyFilter = $request->query('partyFilter');
        $modelFilter = $request->query('modelFilter');
        $statusFilter = $request->query('statusFilter');

        if ($extension == 'csv') {
            $extension = 'csv';
            $exportFormat = \Maatwebsite\Excel\Excel::CSV;
        } else {
            $extension = 'xlsx';
            $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
        }

        $filename = 'purchase_enquiry-' . date('d-m-Y') . '.' . $extension;
        $purchaseExport = new PurchaseExport($start_date, $end_date, $executiveFilter, $partyFilter, $modelFilter, $statusFilter);

        return Excel::download($purchaseExport, $filename, $exportFormat);
    }

    public function saleIndex(Request $request)
    {
        $type = true;
        if ($request->has('clear_search')) {
            return redirect()->route('admin.sale-report.index');
        }
        $sales = SaleDetail::with('purchase', 'party')
            ->where('status', '!=', 4)
            ->when($request->filled('partyFilter'), function ($query) use ($request) {
                $query->where('mst_party_id', $request->partyFilter);
            })
            ->when($request->filled('car_number'), function ($query) use ($request) {
                $query->whereHas('purchase', function ($subquery) use ($request) {
                    $subquery->where('reg_number', 'like', '%' . $request->car_number . '%');
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('fromDate'), function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->fromDate);
            })
            ->when($request->filled('toDate'), function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->toDate);
            })
            ->orderByDesc('id')
            ->paginate($request->limit ? $request->limit : 10);
        $party = MstParty::pluck('party_name', 'id');
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        $status = SaleDetail::getStatus();
        return view('admin.reports.sale-index', compact('sales', 'party', 'vehicles', 'status', 'type'));
    }

    public function saleExport(Request $request, $extension = null)
    {
        $start_date = $request->query('fromDate');
        $end_date = $request->query('toDate');
        $partyFilter = $request->query('partyFilter');
        $carFilter = $request->query('carFilter');
        $statusFilter = $request->query('statusFilter');

        if ($extension == 'csv') {
            $extension = 'csv';
            $exportFormat = \Maatwebsite\Excel\Excel::CSV;
        } else {
            $extension = 'xlsx';
            $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
        }

        $filename = 'sale_enquiry-' . date('d-m-Y') . '.' . $extension;
        $purchaseExport = new SaleEnquiryExport($start_date, $end_date, $partyFilter, $carFilter, $statusFilter);

        return Excel::download($purchaseExport, $filename, $exportFormat);
    }

    public function refurbishmentIndex(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.refurbishment-report.index');
        }

        $refurbishments = RefurbnishmentOrder::with('purchase', 'party')
            ->with('party', 'purchase')
            ->when($request->filled('partyFilter'), function ($query) use ($request) {
                $query->where('mst_party_id', $request->partyFilter);
            })
            ->when($request->filled('car_number'), function ($query) use ($request) {
                $query->whereHas('purchase', function ($subquery) use ($request) {
                    $subquery->where('reg_number', 'like', '%' . $request->car_number . '%');
                });
            })
            ->when($request->filled('fromDate'), function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->fromDate);
            })
            ->when($request->filled('toDate'), function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->toDate);
            })
            ->ModeSearch($request)
            ->paginate($request->limit ? $request->limit : 10);

        $party = MstParty::pluck('party_name', 'id');
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        return view('admin.reports.refurbishment-index', compact('refurbishments', 'party', 'vehicles'));
    }

    public function refurbishmentExport(Request $request, $extension = null)
    {
        $start_date = $request->query('fromDate');
        $end_date = $request->query('toDate');
        $partyFilter = $request->query('partyFilter');
        $carFilter = $request->query('carFilter');
        $statusFilter = $request->query('statusFilter');

        if ($extension == 'csv') {
            $extension = 'csv';
            $exportFormat = \Maatwebsite\Excel\Excel::CSV;
        } else {
            $extension = 'xlsx';
            $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
        }

        $filename = 'refurbishment_enquiry-' . date('d-m-Y') . '.' . $extension;
        $purchaseExport = new RefurbishmentExport($start_date, $end_date, $partyFilter, $carFilter, $statusFilter);

        return Excel::download($purchaseExport, $filename, $exportFormat);
    }

    public function generalInsuranceIndex(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.general-insurance-report.index');
        } else {
            $insurances = GeneralInsurance::with('party:id,party_name')
                ->when($request->filled('partyFilter'), function ($query) use ($request) {
                    $query->where('mst_party_id', $request->partyFilter);
                })
                ->when($request->filled('fromDate'), function ($query) use ($request) {
                    $query->whereDate('created_at', '>=', $request->fromDate);
                })
                ->when($request->filled('toDate'), function ($query) use ($request) {
                    $query->whereDate('created_at', '<=', $request->toDate);
                })
                ->PolicyNumber($request)
                ->orderBy('id', 'desc')
                ->paginate($request->limit ? $request->limit : 10);
        }
        $party = MstParty::pluck('party_name', 'id');
        return view('admin.reports.generalinsurance-index', compact('insurances', 'party'));
    }

    public function generalInsuranceExport(Request $request, $extension = null)
    {
        $start_date = $request->query('fromDate');
        $end_date = $request->query('toDate');
        $partyFilter = $request->query('partyFilter');
        $ploicyFilter = $request->query('ploicyFilter');
        $statusFilter = $request->query('statusFilter');

        if ($extension == 'csv') {
            $extension = 'csv';
            $exportFormat = \Maatwebsite\Excel\Excel::CSV;
        } else {
            $extension = 'xlsx';
            $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
        }

        $filename = 'general-insurance_enquiry-' . date('d-m-Y') . '.' . $extension;
        $purchaseExport = new GeneralInsuranceExport($start_date, $end_date, $partyFilter, $ploicyFilter, $statusFilter);

        return Excel::download($purchaseExport, $filename, $exportFormat);
    }

    public function carInsuranceIndex(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.car.insurance.index');
        } else {
            $insurances = CarInsurance::with('party:id,party_name')
                ->when($request->filled('partyFilter'), function ($query) use ($request) {
                    $query->where('party_id', $request->partyFilter);
                })
                ->when($request->filled('fromDate'), function ($query) use ($request) {
                    $query->whereDate('created_at', '>=', $request->fromDate);
                })
                ->when($request->filled('toDate'), function ($query) use ($request) {
                    $query->whereDate('created_at', '<=', $request->toDate);
                })
                ->PolicyNumber($request)
                ->CarNumber($request)
                ->orderBy('id', 'desc')
                ->paginate($request->limit ? $request->limit : 10);
        }
        $party = MstParty::pluck('party_name', 'id');
        return view('admin.reports.carinsurance-index', compact('insurances', 'party'));
    }

    public function carInsuranceExport(Request $request, $extension = null)
    {
        $start_date = $request->query('fromDate');
        $end_date = $request->query('toDate');
        $partyFilter = $request->query('partyFilter');
        $ploicyFilter = $request->query('ploicyFilter');
        $statusFilter = $request->query('statusFilter');

        if ($extension == 'csv') {
            $extension = 'csv';
            $exportFormat = \Maatwebsite\Excel\Excel::CSV;
        } else {
            $extension = 'xlsx';
            $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
        }

        $filename = 'car-insurance_enquiry-' . date('d-m-Y') . '.' . $extension;
        $purchaseExport = new CarInsuranceExport($start_date, $end_date, $partyFilter, $ploicyFilter, $statusFilter);

        return Excel::download($purchaseExport, $filename, $exportFormat);
    }

    public function pendingCarLoanIndex(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.pendingcar-loan-report.index');
        }

        $query = CarLoan::with('party:id,party_name')->where('status', 1);
        $query->when($request->filled('partyFilter'), function ($query) use ($request) {
            $query->where('mst_party_id', $request->partyFilter);
        });
        // $query->when($request->filled('statusFilter'), function ($query) use ($request) {
        //     $query->where('status', $request->statusFilter);
        // });
        $query->when($request->filled('modelFilter'), function ($query) use ($request) {
            $query->where('mst_model_id', $request->modelFilter);
        });
        $query->when($request->filled('dealerFilter'), function ($query) use ($request) {
            $query->where('mst_dealer_id', $request->dealerFilter);
        });
        $query->when($request->filled('fromDate'), function ($query) use ($request) {
            $query->whereDate('created_at', '>=', $request->fromDate);
        });
        $query->when($request->filled('toDate'), function ($query) use ($request) {
            $query->whereDate('created_at', '<=', $request->toDate);
        });
        $carLoans = $query->orderBy('id', 'desc')
            ->paginate($request->limit ? $request->limit : 10);

        $models = MstModel::pluck('model', 'id');
        $dealers = MstDealer::pluck('name', 'id');
        $status = CarLoan::getStatus();
        $party = MstParty::pluck('party_name', 'id');
        return view('admin.reports.pending-carloan-index', compact('carLoans', 'models', 'dealers', 'status', 'party'));
    }

    public function businessCarLoanIndex(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.businesscar-loan-report.index');
        }

        $query = CarLoan::with('party:id,party_name')->where('status', 2);
        $query->when($request->filled('partyFilter'), function ($query) use ($request) {
            $query->where('mst_party_id', $request->partyFilter);
        });
        // $query->when($request->filled('statusFilter'), function ($query) use ($request) {
        //     $query->where('status', $request->statusFilter);
        // });
        $query->when($request->filled('modelFilter'), function ($query) use ($request) {
            $query->where('mst_model_id', $request->modelFilter);
        });
        $query->when($request->filled('dealerFilter'), function ($query) use ($request) {
            $query->where('mst_dealer_id', $request->dealerFilter);
        });
        $query->when($request->filled('fromDate'), function ($query) use ($request) {
            $query->whereDate('created_at', '>=', $request->fromDate);
        });
        $query->when($request->filled('toDate'), function ($query) use ($request) {
            $query->whereDate('created_at', '<=', $request->toDate);
        });
        $carLoans = $query->orderBy('id', 'desc')
            ->paginate($request->limit ? $request->limit : 10);

        $models = MstModel::pluck('model', 'id');
        $dealers = MstDealer::pluck('name', 'id');
        $status = CarLoan::getStatus();
        $party = MstParty::pluck('party_name', 'id');
        return view('admin.reports.business-carloan-index', compact('carLoans', 'models', 'dealers', 'status', 'party'));
    }

    public function carLoanExport(Request $request, $extension = null)
    {
        $start_date = $request->query('fromDate');
        $end_date = $request->query('toDate');
        $partyFilter = $request->query('partyFilter');
        $modelFilter = $request->query('modelFilter');
        $statusFilter = 1;
        $dealerFilter = $request->query('dealerFilter');

        if ($extension == 'csv') {
            $extension = 'csv';
            $exportFormat = \Maatwebsite\Excel\Excel::CSV;
        } else {
            $extension = 'xlsx';
            $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
        }

        $filename = 'car-loan_enquiry-' . date('d-m-Y') . '.' . $extension;
        $purchaseExport = new CarLoanExport($start_date, $end_date, $partyFilter, $modelFilter, $statusFilter, $dealerFilter);

        return Excel::download($purchaseExport, $filename, $exportFormat);
    }

    public function businessCarLoanExport(Request $request, $extension = null)
    {
        $start_date = $request->query('fromDate');
        $end_date = $request->query('toDate');
        $partyFilter = $request->query('partyFilter');
        $modelFilter = $request->query('modelFilter');
        $statusFilter = 4;
        $dealerFilter = $request->query('dealerFilter');

        if ($extension == 'csv') {
            $extension = 'csv';
            $exportFormat = \Maatwebsite\Excel\Excel::CSV;
        } else {
            $extension = 'xlsx';
            $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
        }

        $filename = 'car-loan_enquiry-' . date('d-m-Y') . '.' . $extension;
        $purchaseExport = new CarLoanExport($start_date, $end_date, $partyFilter, $modelFilter, $statusFilter, $dealerFilter);

        return Excel::download($purchaseExport, $filename, $exportFormat);
    }

    public function mortageLoanIndex(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.mortage-loan-report.index');
        }

        $query = MortageLoan::with('party:id,party_name')->where('status', 1);
        $query->when($request->filled('partyFilter'), function ($query) use ($request) {
            $query->where('mst_party_id', $request->partyFilter);
        });
        // $query->when($request->filled('statusFilter'), function ($query) use ($request) {
        //     $query->where('status', $request->statusFilter);
        // });
        $query->when($request->filled('loanFilter'), function ($query) use ($request) {
            $query->where('loan_type', $request->loanFilter);
        });
        $query->when($request->filled('fromDate'), function ($query) use ($request) {
            $query->whereDate('created_at', '>=', $request->fromDate);
        });
        $query->when($request->filled('toDate'), function ($query) use ($request) {
            $query->whereDate('created_at', '<=', $request->toDate);
        });
        $mortageLoans = $query->orderBy('id', 'desc')
            ->paginate($request->limit ? $request->limit : 10);
        $status = MortageLoan::getStatus();
        $loanType = MortageLoan::getLoanType();
        $party = MstParty::pluck('party_name', 'id');
        return view('admin.reports.mortageloan-index', compact('mortageLoans', 'status', 'loanType', 'party'));
    }

    public function businessMortageLoanIndex(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.mortage-loan-report.index');
        }

        $query = MortageLoan::with('party:id,party_name')->where('status', 2);
        $query->when($request->filled('partyFilter'), function ($query) use ($request) {
            $query->where('mst_party_id', $request->partyFilter);
        });
        // $query->when($request->filled('statusFilter'), function ($query) use ($request) {
        //     $query->where('status', $request->statusFilter);
        // });
        $query->when($request->filled('loanFilter'), function ($query) use ($request) {
            $query->where('loan_type', $request->loanFilter);
        });
        $query->when($request->filled('fromDate'), function ($query) use ($request) {
            $query->whereDate('created_at', '>=', $request->fromDate);
        });
        $query->when($request->filled('toDate'), function ($query) use ($request) {
            $query->whereDate('created_at', '<=', $request->toDate);
        });
        $mortageLoans = $query->orderBy('id', 'desc')
            ->paginate($request->limit ? $request->limit : 10);
        $status = MortageLoan::getStatus();
        $loanType = MortageLoan::getLoanType();
        $party = MstParty::pluck('party_name', 'id');
        return view('admin.reports.business-mortageloan-index', compact('mortageLoans', 'status', 'loanType', 'party'));
    }

    public function mortageLoanExport(Request $request, $extension = null)
    {
        $start_date = $request->query('fromDate');
        $end_date = $request->query('toDate');
        $partyFilter = $request->query('partyFilter');
        $loanFilter = $request->query('loanFilter');
        $statusFilter = 1;

        if ($extension == 'csv') {
            $extension = 'csv';
            $exportFormat = \Maatwebsite\Excel\Excel::CSV;
        } else {
            $extension = 'xlsx';
            $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
        }

        $filename = 'mortage-loan_enquiry-' . date('d-m-Y') . '.' . $extension;
        $purchaseExport = new MortageLoanExport($start_date, $end_date, $partyFilter, $loanFilter, $statusFilter);

        return Excel::download($purchaseExport, $filename, $exportFormat);
    }

    public function businessMortageLoanExport(Request $request, $extension = null)
    {
        $start_date = $request->query('fromDate');
        $end_date = $request->query('toDate');
        $partyFilter = $request->query('partyFilter');
        $loanFilter = $request->query('loanFilter');
        $statusFilter = 4;

        if ($extension == 'csv') {
            $extension = 'csv';
            $exportFormat = \Maatwebsite\Excel\Excel::CSV;
        } else {
            $extension = 'xlsx';
            $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
        }

        $filename = 'mortage-loan_enquiry-' . date('d-m-Y') . '.' . $extension;
        $purchaseExport = new MortageLoanExport($start_date, $end_date, $partyFilter, $loanFilter, $statusFilter);

        return Excel::download($purchaseExport, $filename, $exportFormat);
    }

    public function pendingDocuments(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.document-report.index');
        }
        $limit = $request->limit ? $request->limit : 10;

        $documents = PendingDocument::where(function ($query) {
            $query->where('rc', 'Pending')
                ->orWhere('insurance', 'Pending')
                ->orWhere('delivery_document', 'Pending')
                ->orWhere('key', 'Pending')
                ->orWhere('pancard', 'Pending')
                ->orWhere('aadharcard', 'Pending')
                ->orWhere('photograph', 'Pending')
                ->orWhere('transfer_set', 'Pending');
        })
            ->when($request->filled('fromDate'), function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->fromDate);
            })
            ->when($request->filled('toDate'), function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->toDate);
            })
            ->orderBy('id', 'desc')
            ->paginate($limit);
        return view('admin.reports.pending-document', compact('documents'));
    }

    public function documentExport(Request $request, $extension = null)
    {
        $start_date = $request->query('fromDate');
        $end_date = $request->query('toDate');

        if ($extension == 'csv') {
            $extension = 'csv';
            $exportFormat = \Maatwebsite\Excel\Excel::CSV;
        } else {
            $extension = 'xlsx';
            $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
        }

        $filename = 'pending-document-' . date('d-m-Y') . '.' . $extension;
        $purchaseExport = new PendingDocumentExport($start_date, $end_date);

        return Excel::download($purchaseExport, $filename, $exportFormat);
    }

    public function grossMarginIndex(Request $request)
    {
        $type = true;
        if ($request->has('clear_search')) {
            return redirect()->route('admin.gross-margin-report.index');
        }

        $sales = SaleOrder::join('purchase_orders', 'sale_orders.purchase_id', '=', 'purchase_orders.purchase_id')
            ->with('party')
            ->when($request->filled('partyFilter'), function ($query) use ($request) {
                $query->where('sale_orders.mst_party_id', $request->partyFilter);
            })
            ->when($request->filled('car_number'), function ($query) use ($request) {
                $query->where('purchase_orders.reg_number', 'like', '%' . $request->car_number . '%');
            })
            ->when($request->filled('fromDate'), function ($query) use ($request) {
                $query->whereDate('sale_orders.created_at', '>=', $request->fromDate);
            })
            ->when($request->filled('toDate'), function ($query) use ($request) {
                $query->whereDate('sale_orders.created_at', '<=', $request->toDate);
            })
            ->orderByDesc('sale_orders.id')
            ->select('sale_orders.*', 'purchase_orders.price_p1 as purchase_price')
            ->paginate($request->limit ? $request->limit : 10);

        // foreach ($sales as $sale) {
        //     $sale->gross_margin = $sale->price_p1 - $sale->purchase_price;
        // }

        foreach ($sales as $sale) {
            $gross_margin = $sale->price_p1 - $sale->purchase_price;

            if ($sale->price_p1 != 0) {
                $gross_margin_percentage = ($gross_margin / $sale->price_p1) * 100;
            } else {
                $gross_margin_percentage = 0; // Avoid division by zero
            }

            $sale->gross_margin_percentage = $gross_margin_percentage;
        }

        $party = MstParty::pluck('party_name', 'id');
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        $status = SaleDetail::getStatus();

        return view('admin.reports.gross-margin', compact('sales', 'party', 'vehicles', 'status', 'type'));
    }

    public function grossMarginExport(Request $request, $extension = null)
    {
        $start_date = $request->query('fromDate');
        $end_date = $request->query('toDate');
        $partyFilter = $request->query('partyFilter');
        $carFilter = $request->query('carFilter');

        if ($extension == 'csv') {
            $extension = 'csv';
            $exportFormat = \Maatwebsite\Excel\Excel::CSV;
        } else {
            $extension = 'xlsx';
            $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
        }

        $filename = 'sale_enquiry-' . date('d-m-Y') . '.' . $extension;
        $purchaseExport = new GrossMarginExport($start_date, $end_date, $partyFilter, $carFilter);

        return Excel::download($purchaseExport, $filename, $exportFormat);
    }

    public function healthInsuranceIndex(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.health-insurance-report.index');
        } else {
            $insurances = HealthInsurance::with('party:id,party_name')
                ->when($request->filled('partyFilter'), function ($query) use ($request) {
                    $query->where('party_id', $request->partyFilter);
                })
                ->when($request->filled('fromDate'), function ($query) use ($request) {
                    $query->whereDate('created_at', '>=', $request->fromDate);
                })
                ->when($request->filled('toDate'), function ($query) use ($request) {
                    $query->whereDate('created_at', '<=', $request->toDate);
                })
                ->PolicyNumber($request)
                ->paginate($request->limit ? $request->limit : 10);

            $party = MstParty::pluck('party_name', 'id');
            return view('admin.reports.healthinsurance-index', compact('insurances', 'party'));
        }
    }

    public function healthInsuranceExport(Request $request, $extension = null)
    {
        $start_date = $request->query('fromDate');
        $end_date = $request->query('toDate');
        $partyFilter = $request->query('partyFilter');
        $ploicyFilter = $request->query('ploicyFilter');

        if ($extension == 'csv') {
            $extension = 'csv';
            $exportFormat = \Maatwebsite\Excel\Excel::CSV;
        } else {
            $extension = 'xlsx';
            $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
        }

        $filename = 'health-insurance-' . date('d-m-Y') . '.' . $extension;
        $purchaseExport = new HealthInsuranceExport($start_date, $end_date, $partyFilter, $ploicyFilter);

        return Excel::download($purchaseExport, $filename, $exportFormat);
    }

    public function termInsuranceIndex(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.term-insurance-report.index');
        } else {
            $insurances = TermInsurance::with('party:id,party_name')
                ->when($request->filled('partyFilter'), function ($query) use ($request) {
                    $query->where('mst_party_id', $request->partyFilter);
                })
                ->when($request->filled('fromDate'), function ($query) use ($request) {
                    $query->whereDate('created_at', '>=', $request->fromDate);
                })
                ->when($request->filled('toDate'), function ($query) use ($request) {
                    $query->whereDate('created_at', '<=', $request->toDate);
                })
                ->PolicyNumber($request)
                ->paginate($request->limit ? $request->limit : 10);

            $party = MstParty::pluck('party_name', 'id');
            return view('admin.reports.terminsurance-index', compact('insurances', 'party'));
        }
    }

    public function termInsuranceExport(Request $request, $extension = null)
    {
        $start_date = $request->query('fromDate');
        $end_date = $request->query('toDate');
        $partyFilter = $request->query('partyFilter');
        $ploicyFilter = $request->query('ploicyFilter');

        if ($extension == 'csv') {
            $extension = 'csv';
            $exportFormat = \Maatwebsite\Excel\Excel::CSV;
        } else {
            $extension = 'xlsx';
            $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
        }

        $filename = 'term-insurance-' . date('d-m-Y') . '.' . $extension;
        $purchaseExport = new TermInsuranceExport($start_date, $end_date, $partyFilter, $ploicyFilter);

        return Excel::download($purchaseExport, $filename, $exportFormat);
    }

    public function matchMakingIndex(Request $request)
    {
        $type = true;

        // Redirect if clear_search parameter is present
        if ($request->has('clear_search')) {
            return redirect()->route('admin.match-making-report.index');
        }

        // Retrieve brands, vehicles, and models
        $brands = MstBrandType::pluck('type', 'id');
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        $modelsQuery = MstModel::with('brand');

        // Apply filters
        if ($request->filled('brandFilter')) {
            $modelsQuery->whereHas('brand', function ($query) use ($request) {
                $query->where('id', $request->brandFilter);
            });
        }

        if ($request->filled('modelFilter')) {
            $modelsQuery->where('id', $request->modelFilter);
        }

        $models = $modelsQuery->get();
        $modelData = MstModel::pluck('model', 'id');
        $data = [];

        // Iterate over models to calculate counts
        foreach ($models as $model) {
            $brandId = $model->brand->id;

            // Calculate counts
            $purchased = $this->calculatePurchasedCount($brandId, $model->id);
            $parkAndSaleCount = $this->calculateParkAndSaleCount($brandId, $model->id);
            $customerDemand = $this->calculateCustomerDemand($model->model);
            $totalCars = $purchased + $parkAndSaleCount + $customerDemand;

            // Store the counts for the current brand and model combination
            $data[] = [
                'model_id' => $model->id,
                'brand' => $model->brand->type,
                'model' => $model->model,
                'park_and_sale_count' => $parkAndSaleCount,
                'purchased' => $purchased,
                'customer_demand' => $customerDemand,
                'total_cars' => $totalCars,
            ];
        }

        // Pass data to the view
        return view('admin.reports.match-making', compact('brands', 'vehicles', 'models', 'type', 'data', 'modelData'));
    }

    public function matchMakingExport(Request $request, $extension = null)
    {
        $brandFilter = $request->query('brandFilter');
        $modelFilter = $request->query('modelFilter');

        if ($extension == 'csv') {
            $extension = 'csv';
            $exportFormat = \Maatwebsite\Excel\Excel::CSV;
        } else {
            $extension = 'xlsx';
            $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
        }

        $filename = 'match-making-' . date('d-m-Y') . '.' . $extension;
        $purchaseExport = new MatchMakingExport($brandFilter, $modelFilter);

        return Excel::download($purchaseExport, $filename, $exportFormat);
    }

    public function calculatePurchasedCount($brandId, $modelId)
    {
        // Perform a query to count the number of purchases matching the brand, model, and in-stock status
        $purchased = Purchase::where('mst_brand_type_id', $brandId)
            ->where('mst_model_id', $modelId)
            ->where('status', 6)
            ->count();

        return $purchased;
    }

    public function calculateParkAndSaleCount($brandId, $modelId)
    {
        // Perform a query to count the number of purchases matching the brand, model, and in-stock status
        $parkAndSaleCount = Purchase::where('mst_brand_type_id', $brandId)
            ->where('mst_model_id', $modelId)
            ->where('status', 7)
            ->count();

        return $parkAndSaleCount;
    }

    public function calculateCustomerDemand($modelName)
    {
        // Perform a query to count the number of records in the Customer Demand table
        $customerDemand = CustomerDemandVehcile::whereRaw("FIND_IN_SET('$modelName', vehicle)")->count();

        return $customerDemand;
    }

    public function partyIndex(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.party-report.index');
        } else {
            $mergedData = collect();

            if ($request->filled('partyFilter')) {
                $healthInsuranceData = HealthInsurance::with('party:id,party_name')
                    ->where('party_id', $request->partyFilter)->get();

                $saleDetailData = SaleDetail::with('party:id,party_name')
                    ->where('mst_party_id', $request->partyFilter)->get();

                $purchaseData = Purchase::with('party:id,party_name')
                    ->where('mst_party_id', $request->partyFilter)->get();

                $carLoanData = CarLoan::with('party:id,party_name')
                    ->where('mst_party_id', $request->partyFilter)->get();

                $mortgageLoanData = MortageLoan::with('party:id,party_name')
                    ->where('mst_party_id', $request->partyFilter)->get();

                $generalInsuranceData = GeneralInsurance::with('party:id,party_name')
                    ->where('mst_party_id', $request->partyFilter)->get();

                $termInsuranceData = TermInsurance::with('party:id,party_name')
                    ->where('mst_party_id', $request->partyFilter)->get();

                $carInsuranceData = CarInsurance::with('party:id,party_name')
                    ->where('party_id', $request->partyFilter)->get();

                $rcData = RcTransfer::with('party:id,party_name')
                    ->where('mst_party_id', $request->partyFilter)->get();

                $refurbishmentData = RefurbnishmentOrder::with('party:id,party_name')
                    ->where('mst_party_id', $request->partyFilter)->get();

                $mergedData = $mergedData
                    ->concat($healthInsuranceData)
                    ->concat($purchaseData)
                    ->concat($carLoanData)
                    ->concat($generalInsuranceData)
                    ->concat($termInsuranceData)
                    ->concat($carInsuranceData)
                    ->concat($rcData)
                    ->concat($refurbishmentData)
                    ->concat($mortgageLoanData)
                    ->concat($saleDetailData);
            }

            $party = MstParty::pluck('party_name', 'id');
            return view('admin.reports.party-index', compact('mergedData', 'party'));
        }
    }

    public function baseRateIndex(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.base-rate-report.index');
        } else {
            $mortgageLoanData = collect();

            $query = MortageLoan::query();

            if ($request->filled('partyFilter')) {
                $query->where('mst_party_id', $request->partyFilter);
            }

            if ($request->filled('base_rate')) {
                $query->where('mclr', $request->base_rate);
            }

            $mortgageLoanData = $query->with('party:id,party_name')->paginate($request->limit ? $request->limit : 10);

            $party = MstParty::pluck('party_name', 'id');
            return view('admin.reports.baserate-index', compact('mortgageLoanData', 'party'));
        }
    }

    public function baseRateExport(Request $request, $extension = null)
    {
        $rateFilter = $request->query('rateFilter');
        $partyFilter = $request->query('partyFilter');

        if ($extension == 'csv') {
            $extension = 'csv';
            $exportFormat = \Maatwebsite\Excel\Excel::CSV;
        } else {
            $extension = 'xlsx';
            $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
        }

        $filename = 'base-rate-' . date('d-m-Y') . '.' . $extension;
        $purchaseExport = new BaseRateExport($rateFilter, $partyFilter);

        return Excel::download($purchaseExport, $filename, $exportFormat);
    }

    public function refurbishmentView($id)
    {
        $refurbishment = RefurbnishmentOrder::with('purchase', 'party')->find($id);
        $purchase = Purchase::find($refurbishment->purchase_id);
        return view('admin.reports.refurbishment-view', compact('refurbishment', 'purchase'));
    }

    public function vehicleIndex(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.vehicle-report.index');
        } else {
            $mergedData = collect();

            if ($request->filled('vehicleFilter')) {

                $purchaseData = PurchaseOrder::with('party:id,party_name')
                    ->where('purchase_id', $request->vehicleFilter)
                    ->orderBy('created_at', 'desc')
                    ->get();

                $saleDetailData = SaleOrder::with('party:id,party_name')
                    ->where('purchase_id', $request->vehicleFilter)
                    ->orderBy('created_at', 'desc')
                    ->get();


                $mergedData = $mergedData
                    ->concat($purchaseData)
                    ->concat($saleDetailData);
            }

            $party = MstParty::pluck('party_name', 'id');
            $regNumbers = Purchase::whereIn('status', [6, 7])->pluck('reg_number', 'id');
            return view('admin.reports.vehicle-index', compact('mergedData', 'party', 'regNumbers'));
        }
    }

    public function stockIndex(Request $request){

        if ($request->has('clear_search')) {
            return redirect()->route('admin.stock-report.index');
        }

        $purchased = Purchase::with('carModel:id,mst_brand_type_id,model','color:id,color','brand:id,type','purchaseOrder:id,purchase_id,price_p1')
        ->CarNumberSearch($request)
        ->whereIn('status', [6,7])
        // ->where('is_sold',null)
        ->where(function($q) {
            $q->whereNull('is_sold')
              ->orWhere('is_sold', 0);
        })
        ->orderBy('id','desc')->paginate($request->limit ? $request->limit : 10);

        return view('admin.reports.stock', compact('purchased'));
    }

    public function addSellingPrice(Request $request){
        $purchase = Purchase::find($request->item_id);
        $purchase->update(['selling_price' => $request->selling_price]);

        return redirect()->back();
    }


}
