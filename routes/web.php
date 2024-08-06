<?php

use App\Http\Controllers\admin\auth\ForgetPasswordController;
use App\Http\Controllers\admin\auth\LoginController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\insurance\CarInsurance;
use App\Http\Controllers\admin\insurance\GeneralInsuranceClaimController;
use App\Http\Controllers\admin\insurance\GeneralInsuranceController;
use App\Http\Controllers\admin\insurance\HealthInsurance;
use App\Http\Controllers\admin\insurance\HealthInsuranceClaimController;
use App\Http\Controllers\admin\insurance\MotorInsuranceClaimController;
use App\Http\Controllers\admin\insurance\TermInsuranceClaimController;
use App\Http\Controllers\admin\insurance\TermInsuranceController;
use App\Http\Controllers\admin\loans\AggregatorLoanController;
use App\Http\Controllers\admin\loans\CarLoanController;
use App\Http\Controllers\admin\loans\MortageLoanController;
use App\Http\Controllers\admin\master\ArticleController;
use App\Http\Controllers\admin\master\BankController;
use App\Http\Controllers\admin\master\BrandTypeController;
use App\Http\Controllers\admin\master\BrokerController;
use App\Http\Controllers\admin\master\ColorController;
use App\Http\Controllers\admin\master\CoveredInsurance;
use App\Http\Controllers\admin\master\DealerController;
use App\Http\Controllers\admin\master\ExecutiveController;
use App\Http\Controllers\admin\master\InsuranceController;
use App\Http\Controllers\admin\master\InsuranceTypeController;
use App\Http\Controllers\admin\master\ModelController;
use App\Http\Controllers\admin\master\PartyController;
use App\Http\Controllers\admin\master\RemoveImageController;
use App\Http\Controllers\admin\master\RtoAgentController;
use App\Http\Controllers\admin\master\ShowroomMasterController;
use App\Http\Controllers\admin\master\SupplierController;
use App\Http\Controllers\admin\master\UploadFileController;
use App\Http\Controllers\admin\profile\ProfileController;
use App\Http\Controllers\admin\refurbishment\RefurbishmentController;
use App\Http\Controllers\admin\reports\ReportController;
use App\Http\Controllers\admin\saleandpurchase\CustomerDemandVehicleController;
use App\Http\Controllers\admin\saleandpurchase\PurchaseController;
use App\Http\Controllers\admin\saleandpurchase\RcTransferController;
use App\Http\Controllers\admin\saleandpurchase\SaleController;
use App\Http\Controllers\admin\saleandpurchase\SaleOrderController;
use App\Http\Controllers\admin\saleandpurchase\TestDriveController;
use App\Http\Controllers\admin\settings\CompanyController;
use App\Http\Controllers\admin\settings\PermissionController;
use App\Http\Controllers\admin\settings\RoleController;
use App\Http\Controllers\admin\settings\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\insurance\InsuranceController as InsuranceInsuranceController;
use App\Http\Middleware\Ensure;
use App\Models\Role;
use App\Models\RoleAndPermission;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('migrate-table', function () {
    Artisan::call('migrate');
});
Route::redirect('/', '/admin');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('/', [LoginController::class, 'loginForm']);
    Route::post('/', [LoginController::class, 'login'])->name('login');
    Route::get('forget-password', [ForgetPasswordController::class, 'forgetPasswordForm'])->name('forget.password');
    Route::post('forget-password', [ForgetPasswordController::class, 'forgetPassword'])->name('forget.password.link');
    Route::get('reset-password/{link}', [ForgetPasswordController::class, 'resetPasswordForm'])->name('reset.password');
    Route::post('reset-password', [ForgetPasswordController::class, 'resetPassword'])->name('reset.password.submit');

    Route::group(['middleware' => 'isAdminLogin'], function () {
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');

        Route::any('remove-image/{table}/{id}/{field}', [RemoveImageController::class, 'delete'])->name('remove.uploaded.image');

        Route::controller(DashboardController::class)->group(function () {
            Route::get('dashboard', 'index')->name('dashboard.index');
        });

        //master
        Route::group(['prefix' => 'master', 'as' => 'master.'], function () {

            Route::controller(ShowroomMasterController::class)->group(function () {
                Route::get('/', 'index')->name('index');
            });
            Route::middleware(['Ensure:view_color'])->group(function () {
                Route::get('color', [ColorController::class, 'index'])->name('color.index');
                Route::get('view-color/{id}', [ColorController::class, 'view'])->name('color.view');
                Route::get('color/{color}', [ColorController::class, 'show'])->name('color.show');
            });
            Route::middleware(['Ensure:add_color'])->group(function () {
                Route::get('add-color', [ColorController::class, 'create'])->name('color.add');
                Route::post('color', [ColorController::class, 'store'])->name('color.store')->middleware('Ensure:edit_color');
            });

            Route::middleware(['Ensure:delete_color'])->group(function () {
                Route::get('color-delete/{color}', [ColorController::class, 'delete'])->name('color.delete');
            });


            Route::middleware(['Ensure:view_executive'])->group(function () {
                Route::get('executive', [ExecutiveController::class, 'index'])->name('executive.index');
                Route::get('executive/{executive}', [ExecutiveController::class, 'show'])->name('executive.show');
            });
            Route::middleware(['Ensure:add_executive'])->group(function () {
                Route::get('create-executive', [ExecutiveController::class, 'create'])->name('executive.add');
            });
            Route::middleware(['Ensure:edit_executive'])->group(function () {
                Route::post('executive', [ExecutiveController::class, 'store'])->name('executive.store');
            });
            Route::middleware(['Ensure:delete_executive'])->group(function () {
                Route::get('executive-delete/{executive}', [ExecutiveController::class, 'delete'])->name('executive.delete');
            });
            Route::middleware(['Ensure:show_executive'])->group(function () {
                Route::get('view-executive/{id}', [ExecutiveController::class, 'view'])->name('executive.view');
            });

            Route::any('executive-status-change/{id}/{status}', [ExecutiveController::class, 'statusChange'])->name('executive.status');

            Route::middleware(['Ensure:view_brand'])->group(function () {
                Route::get('brand-type', [BrandTypeController::class, 'index'])->name('brand-type.index');
                Route::get('view-brand/{id}', [BrandTypeController::class, 'view'])->name('brand-type.view');
            });
            Route::middleware(['Ensure:add_brand'])->group(function () {
                Route::get('create-brand-type', [BrandTypeController::class, 'create'])->name('brand-type.add');
                Route::post('brand-type', [BrandTypeController::class, 'store'])->name('brand-type.store');
            });
            Route::middleware(['Ensure:edit_brand'])->group(function () {
                Route::get('brand-type/{brand_type}', [BrandTypeController::class, 'show'])->name('brand-type.show');
            });
            Route::middleware(['Ensure:delete_brand'])->group(function () {
                Route::get('brand-type-delete/{brand_type}', [BrandTypeController::class, 'delete'])->name('brand-type.delete');
            });


            Route::middleware(['Ensure:view_model'])->group(function () {
                Route::get('model', [ModelController::class, 'index'])->name('model.index');
                Route::get('view-model/{id}', [ModelController::class, 'view'])->name('model.view');
            });
            Route::middleware(['Ensure:add_model'])->group(function () {
                Route::get('create-model', [ModelController::class, 'create'])->name('model.add');
                Route::post('model', [ModelController::class, 'store'])->name('model.store');
            });
            Route::middleware(['Ensure:edit_model'])->group(function () {
                Route::get('model-show/{id}', [ModelController::class, 'show'])->name('model.show');
            });
            Route::middleware(['Ensure:delete_model'])->group(function () {
                Route::get('model/{id}', [ModelController::class, 'delete'])->name('model.delete');
            });


            Route::middleware(['Ensure:view_supplier'])->group(function () {
                Route::get('supplier', [SupplierController::class, 'index'])->name('supplier.index');
            });
            Route::middleware(['Ensure:add_supplier'])->group(function () {
                Route::get('create-supplier', [SupplierController::class, 'create'])->name('supplier.add');
                Route::post('supplier', [SupplierController::class, 'store'])->name('supplier.store');
            });
            Route::middleware(['Ensure:edit_supplier'])->group(function () {
                Route::get('supplier-show/{id}', [SupplierController::class, 'show'])->name('supplier.show');
            });
            Route::middleware(['Ensure:view_supplier'])->group(function () {
                Route::get('supplier-view/{id}', [SupplierController::class, 'view'])->name('supplier.view');
            });
            Route::middleware(['Ensure:delete_supplier'])->group(function () {
                Route::get('supplier/{id}', [SupplierController::class, 'delete'])->name('supplier.delete');
            });


            Route::middleware(['Ensure:view_rto_agent'])->group(function () {
                Route::get('rto-agent', [RtoAgentController::class, 'index'])->name('rto.agent.index');
            });
            Route::middleware(['Ensure:add_rto_agent'])->group(function () {
                Route::get('create-rto-agent', [RtoAgentController::class, 'create'])->name('rto.agent.add');
                Route::post('rto-agent', [RtoAgentController::class, 'store'])->name('rto.agent.store');
            });
            Route::middleware(['Ensure:edit_rto_agent'])->group(function () {
                Route::get('rto-agent-show/{id}', [RtoAgentController::class, 'show'])->name('rto.agent.show');
            });
            // Route::middleware(['Ensure:delete_rto_agent'])->group(function () {
            //     Route::get('rto-agent/{id}', [RtoAgentController::class, 'delete'])->name('rto.agent.delete');
            // });
            Route::middleware(['Ensure:show_rto_agent'])->group(function () {
                Route::get('rto-agent-view/{id}', [RtoAgentController::class, 'view'])->name('rto.agent.view');
            });
            Route::middleware(['Ensure:status_rto_agent'])->group(function () {
                Route::get('rto-agent/{id}/{status}', [RtoAgentController::class, 'status'])->name('rto.agent.status');
            });


            Route::get('rto-agent/{id}/{status}', [RtoAgentController::class, 'status'])->name('rto.agent.status');

            Route::controller(CoveredInsurance::class)->group(function () {
                Route::get('covered-insurance', 'index')->name('coveredinsurance.index');
                Route::get('create-covered-insurance', 'create')->name('coveredinsurance.add');
                Route::post('covered-insurance', 'store')->name('coveredinsurance.store');
                Route::get('covered-insurance-show/{id}', 'show')->name('coveredinsurance.show');
                Route::get('covered-insurance/{id}', 'delete')->name('coveredinsurance.delete');
            });


            Route::controller(UploadFileController::class)->group(function () {
                Route::get('upload-file', 'index')->name('upload.file.index');
                Route::get('create-upload-file', 'create')->name('upload.file.add');
                Route::post('upload-file', 'store')->name('upload.file.store');
                Route::get('upload-file-download/{file}', 'download')->name('upload.file.download');
                Route::middleware(['Ensure:view_upload_file'])->group(function () {
                    Route::get('upload-file', [UploadFileController::class, 'index'])->name('upload.file.index');
                });
                Route::middleware(['Ensure:add_upload_file'])->group(function () {
                    Route::get('create-upload-file', [UploadFileController::class, 'create'])->name('upload.file.add');
                    Route::post('upload-file', [UploadFileController::class, 'store'])->name('upload.file.store');
                });
                Route::middleware(['Ensure:delete_upload_file'])->group(function () {
                    Route::get('upload-file-download/{file}', [UploadFileController::class, 'download'])->name('upload.file.download');
                });
                Route::middleware(['Ensure:add_upload_file'])->group(function () {
                    Route::get('create-upload-file', [UploadFileController::class, 'create'])->name('upload.file.add');
                    Route::post('upload-file', [UploadFileController::class, 'store'])->name('upload.file.store');
                });
                Route::middleware(['Ensure:delete_upload_file'])->group(function () {
                    Route::get('upload-file-download/{file}', [UploadFileController::class, 'download'])->name('upload.file.download');
                });


                Route::middleware(['Ensure:view_party'])->group(function () {
                    Route::get('party', [PartyController::class, 'index'])->name('party.index');
                });
                Route::middleware(['Ensure:add_party'])->group(function () {
                    Route::get('create-party', [PartyController::class, 'create'])->name('party.add');
                    Route::post('party', [PartyController::class, 'store'])->name('party.store');
                });
                Route::middleware(['Ensure:edit_party'])->group(function () {
                    Route::get('party-show/{id}', [PartyController::class, 'show'])->name('party.show');
                });
                // Route::middleware(['Ensure:delete_party'])->group(function () {
                //     Route::get('party/{id}', [PartyController::class, 'delete'])->name('party.delete');
                // });
                Route::middleware(['Ensure:status_party'])->group(function () {
                    Route::get('party-status/{id}/{status}', [PartyController::class, 'statusChange'])->name('party.status');
                });

                Route::middleware(['Ensure:show_party'])->group(function () {
                    Route::get('view-party/{id}', [PartyController::class, 'view'])->name('party.view');
                });




                Route::middleware(['Ensure:view_broker'])->group(function () {
                    Route::get('broker', [BrokerController::class, 'index'])->name('broker.index');
                });
                Route::middleware(['Ensure:add_broker'])->group(function () {
                    Route::get('create-broker', [BrokerController::class, 'create'])->name('broker.add');
                    Route::post('broker', [BrokerController::class, 'store'])->name('broker.store');
                });
                Route::middleware(['Ensure:edit_broker'])->group(function () {
                    Route::get('broker-show/{id}', [BrokerController::class, 'show'])->name('broker.show');
                });
                Route::middleware(['Ensure:delete_broker'])->group(function () {
                    Route::get('broker/{id}', [BrokerController::class, 'delete'])->name('broker.delete');
                });


                Route::middleware(['Ensure:view_dealer'])->group(function () {
                    Route::get('dealer', [DealerController::class, 'index'])->name('dealer.index');
                });
                Route::middleware(['Ensure:add_dealer'])->group(function () {
                    Route::get('create-dealer', [DealerController::class, 'create'])->name('dealer.add');
                    Route::post('dealer', [DealerController::class, 'store'])->name('dealer.store');
                });
                Route::middleware(['Ensure:edit_dealer'])->group(function () {
                    Route::get('dealer-show/{id}', [DealerController::class, 'show'])->name('dealer.show');
                });
                Route::middleware(['Ensure:show_dealer'])->group(function () {
                    Route::get('dealer-view/{id}', [DealerController::class, 'view'])->name('dealer.view');
                });
                Route::middleware(['Ensure:delete_dealer'])->group(function () {
                    Route::get('dealer/{id}', [DealerController::class, 'delete'])->name('dealer.delete');
                });
                Route::middleware(['Ensure:status_dealer'])->group(function () {
                    Route::get('dealer-status/{id}/{status}', [DealerController::class, 'statusChange'])->name('dealer.status');
                });


                Route::middleware(['Ensure:view_bank'])->group(function () {
                    Route::get('bank', [BankController::class, 'index'])->name('bank.index');
                });
                Route::middleware(['Ensure:add_bank'])->group(function () {
                    Route::get('create-bank', [BankController::class, 'create'])->name('bank.add');
                    Route::post('bank', [BankController::class, 'store'])->name('bank.store');
                });
                Route::middleware(['Ensure:edit_bank'])->group(function () {
                    Route::get('bank-show/{id}', [BankController::class, 'show'])->name('bank.show');
                });
                Route::middleware(['Ensure:delete_bank'])->group(function () {
                    Route::get('bank/{id}', [BankController::class, 'delete'])->name('bank.delete');
                });
                Route::middleware(['Ensure:show_bank'])->group(function () {
                    Route::get('view-bank/{id}', [BankController::class, 'view'])->name('bank.view');
                });


                Route::middleware(['Ensure:view_insurance'])->group(function () {
                    Route::get('insurance', [InsuranceController::class, 'index'])->name('insurance.index');
                });
                Route::middleware(['Ensure:add_insurance'])->group(function () {
                    Route::get('create-insurance', [InsuranceController::class, 'create'])->name('insurance.add');
                    Route::post('insurance', [InsuranceController::class, 'store'])->name('insurance.store');
                });
                Route::middleware(['Ensure:edit_insurance'])->group(function () {
                    Route::get('insurance-show/{id}', [InsuranceController::class, 'show'])->name('insurance.show');
                });
                Route::middleware(['Ensure:delete_insurance'])->group(function () {
                    Route::get('insurance/{id}', [InsuranceController::class, 'delete'])->name('insurance.delete');
                });


                Route::middleware(['Ensure:view_sub_type'])->group(function () {
                    Route::get('insurance-type', [InsuranceTypeController::class, 'index'])->name('insurance-type.index');
                    Route::get('view-insurance-type/{id}', [InsuranceTypeController::class, 'view'])->name('insurance-type.view');
                });
                Route::middleware(['Ensure:edit_sub_type'])->group(function () {
                    Route::get('insurance-type-show/{id}', [InsuranceTypeController::class, 'show'])->name('insurance-type.show');
                    Route::get('insurance-type-status/{id}/{status}', [InsuranceTypeController::class, 'statusChange'])->name('insurance-type.status');
                });

                Route::middleware(['Ensure:add_sub_type'])->group(function () {
                    Route::get('create-insurance-type', [InsuranceTypeController::class, 'create'])->name('insurance-type.add');
                    Route::post('insurance-type', [InsuranceTypeController::class, 'store'])->name('insurance-type.store');
                });

                Route::middleware(['Ensure:delete_sub_type'])->group(function () {
                    Route::get('insurance-type/{id}', [InsuranceTypeController::class, 'delete'])->name('insurance-type.delete');
                });


                Route::controller(ArticleController::class)->group(function () {
                    Route::get('article', 'index')->name('article.index');
                    Route::get('create-article', 'create')->name('article.add');
                    Route::post('article', 'store')->name('article.store');
                    Route::get('article-show/{id}', 'show')->name('article.show');
                    Route::get('article/{id}', 'delete')->name('article.delete');
                });
            });
        });

        //Insurance
        Route::group(['prefix' => 'insurance', 'as' => 'insurance.'], function () {

            // Route::controller(ShowroomMasterController::class)->group(function () {
            //     Route::get('/', 'index')->name('index');
            // });
            Route::middleware(['Ensure:view_insurance'])->group(function () {
                Route::get('insurance/{type?}', [InsuranceInsuranceController::class, 'index'])->name('index');
                Route::get('insurance/{id}', [InsuranceInsuranceController::class, 'delete'])->name('delete');
            });

            Route::middleware(['Ensure:add_insurance'])->group(function () {
                Route::get('create-insurance/{type?}', [InsuranceInsuranceController::class, 'create'])->name('add');
            });

            Route::middleware(['Ensure:edit_insurance'])->group(function () {
                Route::get('insurance-show/{id}', [InsuranceInsuranceController::class, 'show'])->name('show');
            });

            Route::post('/get-insurance-subtypes', [InsuranceInsuranceController::class, 'getInsuranceSubTypes'])->name('getInsuranceSubTypes');

            Route::post('insurance', [InsuranceInsuranceController::class, 'store'])->name('store');
            Route::get('general-insurance', [InsuranceInsuranceController::class, 'generalInsurance'])->name('general.index')->middleware('Ensure:view_general_insurance');
            Route::get('create-general-insurance', [InsuranceInsuranceController::class, 'generalInsuranceCreate'])->name('general.create')->middleware('Ensure:add_general_insurance');
        });


        //        settings
        Route::group(['perfix' => 'setting', 'as' => 'setting.'], function () {
            Route::controller(RoleController::class)->group(function () {
                Route::get('roles', 'index')->name('role.index')->middleware('Ensure:view_roles');
                Route::get('create-role', 'create')->name('role.create')->middleware('Ensure:add_roles');
                Route::post('store-role', 'store')->name('role.store')->middleware('Ensure:add_roles');
                Route::get('show-role/{id}', 'show')->name('role.show')->middleware('Ensure:edit_roles');
                Route::get('delete-role/{id}', 'delete')->name('role.delete')->middleware('Ensure:delete_roles');
                Route::get('new-role', 'createRole')->name('role.new.create')->middleware('Ensure:add_roles');
                Route::post('new-role-store', 'storeRole')->name('role.new.store')->middleware('Ensure:add_roles');
                Route::get('edit-role/{id}', 'editRole')->name('role.edit')->middleware('Ensure:add_roles');
            });

            Route::controller(PermissionController::class)->group(function () {
                Route::get('permissions', 'index')->name('permission.index')->middleware('Ensure:view_permission');
            });

            Route::controller(UserController::class)->group(function () {
                Route::get('users', 'index')->name('user.index')->middleware('Ensure:view_users');
                Route::get('create-user', 'create')->name('user.create')->middleware('Ensure:add_users');
                Route::any('store-user', 'store')->name('user.store')->middleware('Ensure:add_users');
                Route::get('show-user/{id}', 'show')->name('user.show')->middleware('Ensure:edit_users');
                Route::get('delete-user/{id}', 'delete')->name('user.delete')->middleware('Ensure:delete_users');
                Route::get('view-user/{id}', 'view')->name('user.view')->middleware('Ensure:view_users');
                Route::patch('grant-access/{id}', 'grantAccess')->name('user.all_access');
            });

            Route::controller(CompanyController::class)->group(function () {
                Route::get('create-company', 'create')->name('company.create');
                Route::any('store-company', 'store')->name('company.store');
                Route::get('show-company/{id}', 'show')->name('company.show');
                Route::get('delete-company/{id}', 'delete')->name('company.delete');
            });

            // Route::controller(CarLoanController::class)->group(function () {
            //     Route::get('car-loan', 'index')->name('car-loan.index');
            //     Route::get('car-loan-user', 'create')->name('car-loan.create');
            //     Route::post('store-car-loan', 'store')->name('car-loan.store');
            //     Route::get('show-car-loan/{id}', 'show')->name('car-loan.show');
            //     Route::get('delete-car-loan/{id}', 'delete')->name('car-loan.delete');
            // });
        });

        Route::group(['perfix' => 'loan', 'as' => 'loan.'], function () {

            Route::controller(CarLoanController::class)->group(function () {
                Route::get('car-loan', 'index')->name('car-loan.index')->middleware('Ensure:view_car_loans');
                Route::get('chart/{id}', 'chartIndex')->name('chart.index')->middleware('Ensure:view_car_loans');
                Route::get('view-car-loan/{id}', 'view')->name('car-loan.view')->middleware('Ensure:view_car_loans');
                Route::get('car-loan-user', 'create')->name('car-loan.create')->middleware('Ensure:add_car_loans');
                Route::post('store-car-loan', 'store')->name('car-loan.store')->middleware('Ensure:add_car_loans');
                Route::get('show-car-loan/{id}', 'show')->name('car-loan.show')->middleware('Ensure:edit_car_loans');
                Route::get('car-loan-status/{id}/{state_id}', 'statusChange')->name('car-loan.status')->middleware('Ensure:edit_car_loans');
                Route::get('delete-car-loan/{id}', 'delete')->name('car-loan.delete')->middleware('Ensure:delete_car_loans');
            });

            Route::controller(MortageLoanController::class)->group(function () {
                Route::get('fetch-data', 'getPartyData')->name('mortage-loan.fetch-data');
                Route::middleware(['Ensure:view_mortage_loans'])->group(function () {
                    Route::get('mortage-loan', 'index')->name('mortage-loan.index');
                    Route::get('view-mortage-loan/{id}', 'view')->name('mortage-loan.view');
                });
                Route::middleware(['Ensure:add_mortage_loans'])->group(function () {
                    Route::get('mortage-loan-user', 'create')->name('mortage-loan.create');
                    Route::post('store-mortage-loan', 'store')->name('mortage-loan.store');
                });
                Route::middleware(['Ensure:edit_mortage_loans'])->group(function () {
                    Route::get('show-mortage-loan/{id}', 'show')->name('mortage-loan.show');
                    Route::get('mortage-loan-status/{id}/{state_id}', 'statusChange')->name('mortage-loan.status');
                });
                Route::middleware(['Ensure:delete_mortage_loans'])->group(function () {
                    Route::get('delete-mortage-loan/{id}', 'delete')->name('mortage-loan.delete');
                });
            });

            Route::controller(AggregatorLoanController::class)->group(function () {
                Route::get('aggregrator-loan', 'index')->name('aggregrator-loan.index')->middleware('Ensure:view_aggregrator_loans');
                Route::get('view-aggregrator-loan/{id}', 'view')->name('aggregrator-loan.view')->middleware('Ensure:view_aggregrator_loans');
                Route::get('aggregrator-loan-user', 'create')->name('aggregrator-loan.create')->middleware('Ensure:add_aggregrator_loans');
                Route::post('store-aggregrator-loan', 'store')->name('aggregrator-loan.store')->middleware('Ensure:add_aggregrator_loans');
                Route::get('show-aggregrator-loan/{id}', 'show')->name('aggregrator-loan.show')->middleware('Ensure:edit_aggregrator_loans');
                Route::get('aggregrator-loan-status/{id}/{state_id}', 'statusChange')->name('aggregrator-loan.status')->middleware('Ensure:edit_aggregrator_loans');
                Route::get('delete-aggregrator-loan/{id}', 'delete')->name('aggregrator-loan.delete')->middleware('Ensure:delete_aggregrator_loans');
            });
        });

        Route::group(['perfix' => 'purchase', 'as' => 'purchase.'], function () {
            Route::controller(PurchaseController::class)->group(function () {
                Route::middleware(['Ensure:view_purchase'])->group(function () {
                    Route::get('purchase/index', 'index')->name('purchase.index');
                    Route::get('purchase/orders', 'ordersList')->name('purchase.orders');
                    // Route::get('purchase/follow-up', 'followUp')->name('purchase.follow-up');
                    Route::get('purchase/ready-to-sale', 'readySaleIndex')->name('purchase.ready-sale-index');
                    Route::get('purchase/ready-to-sale/add-images/{id}', 'readySaleImages')->name('purchase.ready-sale-add-image');
                    Route::post('purchase/ready-to-sale/add-images', 'readySaleImagesStore')->name('purchase.ready-sale-add-image-store');
                    Route::post('remove-images', 'removeImage')->name('remove.images');
                    Route::post('ready-for-sale-status', 'changeStatus')->name('ready_for_sale.status');
                });
                Route::middleware(['Ensure:add_purchase'])->group(function () {
                    Route::get('purchase/create', 'create')->name('purchase.create');
                    Route::post('purchase/store', 'store')->name('purchase.store');
                    Route::get('purchase/create-order', 'createOrder')->name('purchase.create-order');
                    Route::post('purchase/store-order', 'storeOrder')->name('purchase.storeOrder');
                    Route::post('/store-pending-document', 'storePendingDocument')->name('purchase.storeDocument');
                });
                Route::middleware(['Ensure:edit_purchase'])->group(function () {
                    Route::get('purchase/show/{id}', 'show')->name('purchase.show');
                    Route::get('purchase/show-order/{id}', 'showOrder')->name('purchase.showOrder');
                    Route::get('view-purchase/{id}', 'view')->name('purchase.view');
                    Route::get('view-purchase-followup/{id}', 'viewFollowup')->name('purchase.view-followup');
                    Route::get('purchase/show-documents/{id}', 'showDocument')->name('purchase.show-document');
                    Route::get('purchase-status/{id}/{state_id}', 'statusChange')->name('purchase.status');
                    Route::get('purchase-order-status/{id}/{state_id}', 'statusChangeOrder')->name('purchase.status-order');
                    Route::get('purchase/ready-sale/{id}', 'showReadyForSale')->name('purchase.show-ready-sale');
                });
                // Route::middleware(['Ensure:delete_purchase'])->group(function () {
                //     Route::get('purchase/delete/{id}', 'delete')->name('purchase.delete');
                // });
                Route::get('purchase/view-order/{id}', 'viewOrder')->name('purchase.view-order');
                Route::get('purchase-enquiry/export/{extension}', 'export')->name('enquiry.export');
            });
        });

        Route::group(['perfix' => 'sale', 'as' => 'sale.'], function () {

            Route::middleware(['Ensure:view_sale'])->group(function () {
                Route::get('sale/index', [SaleController::class, 'index'])->name('sale.index');
                Route::get('sale/follow-up', [SaleController::class, 'followUp'])->name('sale.follow-up');
                Route::get('sale/order-index', [SaleOrderController::class, 'index'])->name('sale.order-index');
                Route::get('sale-enquiry/export/{extension}', [SaleController::class, 'export'])->name('enquiry.export');
            });
            Route::middleware(['Ensure:add_sale'])->group(function () {
                Route::get('sale/create', [SaleController::class, 'create'])->name('sale.create');
                Route::post('sale/store', [SaleController::class, 'store'])->name('sale.store');
                Route::get('sale/order-create', [SaleOrderController::class, 'create'])->name('sale.order-create');
                Route::post('sale/order-store', [SaleOrderController::class, 'store'])->name('sale.order-store');
            });
            Route::middleware(['Ensure:edit_sale'])->group(function () {
                Route::get('sale/show/{id}', [SaleController::class, 'show'])->name('sale.show');
                Route::get('view-sale/{id}', [SaleController::class, 'view'])->name('sale.view');
                Route::get('sale/order-show/{id}', [SaleOrderController::class, 'show'])->name('sale.order-show');
                Route::get('view-order-sale/{id}', [SaleOrderController::class, 'view'])->name('sale.order-view');
                Route::get('sale-status/{id}/{state_id}', [SaleController::class, 'statusChange'])->name('sale.status');
                Route::get('sale-order-status/{id}/{state_id}', [SaleOrderController::class, 'statusChange'])->name('sale.order-status');
            });
            // Route::middleware(['Ensure:delete_sales'])->group(function () {
            //     Route::get('sale/delete/{id}', [SaleController::class, 'delete'])->name('sale.delete');
            //     Route::get('sale/order-delete/{id}', [SaleOrderController::class, 'delete'])->name('sale.order-delete');
            // });
        });

        Route::middleware(['Ensure:view_rc_transfer'])->group(function () {
            Route::get('rc-transfer/index', [RcTransferController::class, 'index'])->name('rc-transfer.index');
        });

        Route::middleware(['Ensure:add_rc_transfer'])->group(function () {
            Route::get('RcTransfer/create', [RcTransferController::class, 'create'])->name('rc-transfer.create');
            Route::post('RcTransfer/store', [RcTransferController::class, 'store'])->name('rc-transfer.store');
        });
        Route::middleware(['Ensure:edit_rc_transfer'])->group(function () {
            Route::get('RcTransfer/show/{id}', [RcTransferController::class, 'show'])->name('rc-transfer.show');
            Route::get('RcTransfer/aggregrator-show/{id}', [RcTransferController::class, 'aggregratorShow'])->name('rc-transfer.aggregrator-show');
            Route::get('RcTransfer/car-show/{id}', [RcTransferController::class, 'carLoanShow'])->name('rc-transfer.car-show');
            Route::get('RcTransfer/sale-show/{id}', [RcTransferController::class, 'saleShow'])->name('rc-transfer.sale-show');
        });

        Route::middleware(['Ensure:show_rc_transfer'])->group(function () {
            Route::get('view-RcTransfer/{id}', [RcTransferController::class, 'view'])->name('rc-transfer.view');
            Route::get('RcTransfer/aggregrator-view/{id}', [RcTransferController::class, 'aggregratorView'])->name('rc-transfer.aggregrator-view');
            Route::get('RcTransfer/car-view/{id}', [RcTransferController::class, 'carLoanView'])->name('rc-transfer.car-view');
            Route::get('RcTransfer/sale-view/{id}', [RcTransferController::class, 'saleView'])->name('rc-transfer.sale-view');
        });

        // Route::get('RcTransfer/delete/{id}', [RcTransferController::class, 'delete'])->name('rc-transfer.delete');
        Route::middleware(['Ensure:status_rc_transfer'])->group(function () {
            Route::get('RcTransfer-status/{id}/{status}', [RcTransferController::class, 'statusChange'])->name('rc-transfer.status');
        });

        Route::middleware(['Ensure:add_customer_demand'])->group(function () {
            Route::post('demand-vehicle-store', [CustomerDemandVehicleController::class, 'store'])->name('demand.vehicle.store');
        });
        Route::middleware(['Ensure:edit_customer_demand'])->group(function () {
            Route::get('demand-vehicle-edit/{id}', [CustomerDemandVehicleController::class, 'edit'])->name('demand.vehicle.edit');
            Route::post('demand-vehicle-update', [CustomerDemandVehicleController::class, 'update'])->name('demand.vehicle.update');
        });
        Route::middleware(['Ensure:view_customer_demand'])->group(function () {
            Route::get('demand-vehicles', [CustomerDemandVehicleController::class, 'index'])->name('demand.vehicle.index');
        });
        Route::middleware(['Ensure:status_customer_demand'])->group(function () {
            Route::get('demand-vehicle-view/{id}', [CustomerDemandVehicleController::class, 'view'])->name('demand.vehicle.view');
        });



        Route::group(['perfix' => 'refurbishment'], function () {

            Route::middleware(['Ensure:view_refurbishment'])->group(function () {
                Route::get('refurbishment/index', [RefurbishmentController::class, 'index'])->name('refurbishment.index');
            });
            Route::middleware(['Ensure:add_refurbishment'])->group(function () {
                Route::get('refurbishment/create', [RefurbishmentController::class, 'create'])->name('refurbishment.create');
                Route::post('refurbishment/store', [RefurbishmentController::class, 'store'])->name('refurbishment.store');
            });
            Route::middleware(['Ensure:edit_refurbishment'])->group(function () {
                Route::get('refurbishment/show/{id}', [RefurbishmentController::class, 'show'])->name('refurbishment.show');
            });
            // Route::middleware(['Ensure:delete_refurbishment'])->group(function () {
            //     Route::get('refurbishment/delete/{id}', [RefurbishmentController::class, 'delete'])->name('refurbishment.delete');
            // });
            Route::middleware(['Ensure:show_refurbishment'])->group(function () {
                Route::get('view-refurbishment/{id}', [RefurbishmentController::class, 'view'])->name('refurbishment.view');
                Route::get('refurbishment/export/{extension}', [RefurbishmentController::class, 'export'])->name('refurbishment.export');
            });
        });

        Route::controller(ProfileController::class)->group(function () {
            Route::post('store-profile', 'store')->name('profile.store');
            Route::get('edit-profile', 'edit')->name('profile.edit');
        });
    });

    Route::middleware(['Ensure:view_motor_insurance'])->group(function () {
        Route::get('car-insurance', [CarInsurance::class, 'index'])->name('car.insurance.index');
        Route::get('endorsement-insurance', [CarInsurance::class, 'endorsementIndex'])->name('endorsement.insurance.index');
        Route::get('car-insurance/export/{extension}', [CarInsurance::class, 'export'])->name('car.insurance.export');
        Route::get('car-insurance-renewal', [CarInsurance::class, 'renewalIndex'])->name('car.insurance.renewal-index');
    });
    Route::middleware(['Ensure:add_motor_insurance'])->group(function () {
        Route::get('car-insurance-create', [CarInsurance::class, 'create'])->name('car.insurance.create');
        Route::get('endorsement-insurance-create', [CarInsurance::class, 'endorsementCreate'])->name('endorsement.insurance.create');
        Route::post('car-insurance-store', [CarInsurance::class, 'store'])->name('car.insurance.store');
        Route::post('endorsement-insurance-store', [CarInsurance::class, 'endorsementStore'])->name('endorsement.insurance.store');
    });
    Route::middleware(['Ensure:edit_motor_insurance'])->group(function () {
        Route::get('car-insurance-show/{id}', [CarInsurance::class, 'show'])->name('car.insurance.show');
        Route::get('endorsement-insurance-show/{id}', [CarInsurance::class, 'endorsementShow'])->name('endorsement.insurance.show');
    });
    Route::middleware(['Ensure:show_motor_insurance'])->group(function () {
        Route::get('car-insurance-view/{id}', [CarInsurance::class, 'view'])->name('car.insurance.view');
        Route::get('endorsement-insurance-view/{id}', [CarInsurance::class, 'endorsementView'])->name('endorsement.insurance.view');
    });




    Route::middleware(['Ensure:view_health_insurance'])->group(function () {
        Route::get('health-insurance', [HealthInsurance::class, 'index'])->name('health.index');
        Route::get('endorsement-health-insurance', [HealthInsurance::class, 'endorsementIndex'])->name('endorsement.health.insurance.index');
        Route::get('health-insurance-renewal', [HealthInsurance::class, 'renewalIndex'])->name('health.insurance.renewal-index');
    });

    Route::middleware(['Ensure:add_health_insurance'])->group(function () {
        Route::get('health-insurance-create', [HealthInsurance::class, 'create'])->name('health.create');
        Route::get('endorsement-health-insurance-create', [HealthInsurance::class, 'endorsementCreate'])->name('endorsement.health.insurance.create');
        Route::post('health-insurance-store', [HealthInsurance::class, 'store'])->name('health.store');
        Route::post('endorsement-health-insurance-store', [HealthInsurance::class, 'endorsementStore'])->name('endorsement.health.insurance.store');
    });

    Route::middleware(['Ensure:edit_health_insurance'])->group(function () {
        Route::get('health-insurance-show/{id}', [HealthInsurance::class, 'show'])->name('health.show');
        Route::get('endorsement-health-insurance-show/{id}', [HealthInsurance::class, 'endorsementShow'])->name('endorsement.health.insurance.show');
    });

    Route::middleware(['Ensure:show_health_insurance'])->group(function () {
        Route::get('health-insurance-view/{id}', [HealthInsurance::class, 'view'])->name('health.view');
        Route::get('endorsement-health-insurance-view/{id}', [HealthInsurance::class, 'endorsementView'])->name('endorsement.health.insurance.view');
    });


    Route::middleware(['Ensure:view_term_insurance'])->group(function () {
        Route::get('term-insurance', [TermInsuranceController::class, 'index'])->name('term.insurance.index');
        Route::get('endorsement-term-insurance', [TermInsuranceController::class, 'endorsementIndex'])->name('endorsement.term.insurance.index');
        Route::get('term-insurance-renewal', [TermInsuranceController::class, 'renewalIndex'])->name('term.insurance.renewal-index');
    });
    Route::middleware(['Ensure:add_term_insurance'])->group(function () {
        Route::get('term-insurance-create', [TermInsuranceController::class, 'create'])->name('term.insurance.create');
        Route::get('endorsement-term-insurance-create', [TermInsuranceController::class, 'endorsementCreate'])->name('endorsement.term.insurance.create');
        Route::post('term-insurance-store', [TermInsuranceController::class, 'store'])->name('term.insurance.store');
        Route::post('endorsement-term-insurance-store', [TermInsuranceController::class, 'endorsementStore'])->name('endorsement.term.insurance.store');
    });
    Route::middleware(['Ensure:edit_term_insurance'])->group(function () {
        Route::get('term-insurance-show/{id}', [TermInsuranceController::class, 'show'])->name('term.insurance.show');
        Route::get('endorsement-term-insurance-show/{id}', [TermInsuranceController::class, 'endorsementShow'])->name('endorsement.term.insurance.show');
    });
    Route::middleware(['Ensure:show_term_insurance'])->group(function () {
        Route::get('term-insurance-view/{id}', [TermInsuranceController::class, 'view'])->name('term.insurance.view');
        Route::get('endorsement-term-insurance-view/{id}', [TermInsuranceController::class, 'endorsementView'])->name('endorsement.term.insurance.view');
    });


    Route::middleware(['Ensure:view_motor_insurance_claim'])->group(function () {
        Route::get('claim-insurance', [MotorInsuranceClaimController::class, 'index'])->name('claim.insurance.index');
    });
    Route::middleware(['Ensure:add_motor_insurance_claim'])->group(function () {
        Route::get('claim-insurance-create', [MotorInsuranceClaimController::class, 'create'])->name('claim.insurance.create');
        Route::post('claim-insurance-store', [MotorInsuranceClaimController::class, 'store'])->name('claim.insurance.store');
    });
    Route::middleware(['Ensure:edit_motor_insurance_claim'])->group(function () {
        Route::get('claim-insurance-show/{id}', [MotorInsuranceClaimController::class, 'show'])->name('claim.insurance.show');
    });
    Route::middleware(['Ensure:show_motor_insurance_claim'])->group(function () {
        Route::get('claim-insurance-view/{id}', [MotorInsuranceClaimController::class, 'view'])->name('claim.insurance.view');
        Route::get('claim-insurance-status/{id}/{state_id}', [MotorInsuranceClaimController::class, 'statusChange'])->name('claim.insurance.status');
    });


    Route::middleware(['Ensure:view_general_insurance'])->group(function () {
        Route::get('general-insurance', [GeneralInsuranceController::class, 'index'])->name('general.insurance.index');
        Route::get('general-insurance-renewal', [GeneralInsuranceController::class, 'renewalIndex'])->name('general.insurance.renewal-index');
        Route::get('endorsement-general-insurance', [GeneralInsuranceController::class, 'endorsementIndex'])->name('endorsement.general.insurance.index');
        Route::get('general-insurance/print', [GeneralInsuranceController::class, 'printData'])->name('general.insurance.print');
    });
    Route::middleware(['Ensure:add_general_insurance'])->group(function () {
        Route::get('general-insurance-create', [GeneralInsuranceController::class, 'create'])->name('general.insurance.create');
        Route::get('endorsement-general-insurance-create', [GeneralInsuranceController::class, 'endorsementCreate'])->name('endorsement.general.insurance.create');
        Route::post('general-insurance-store', [GeneralInsuranceController::class, 'store'])->name('general.insurance.store');
        Route::post('endorsement-general-insurance-store', [GeneralInsuranceController::class, 'endorsementStore'])->name('endorsement.general.insurance.store');
    });
    Route::middleware(['Ensure:edit_general_insurance'])->group(function () {
        Route::get('general-insurance-show/{id}', [GeneralInsuranceController::class, 'show'])->name('general.insurance.show');
        Route::get('endorsement-general-insurance-show/{id}', [GeneralInsuranceController::class, 'endorsementShow'])->name('endorsement.general.insurance.show');
    });
    Route::middleware(['Ensure:show_general_insurance'])->group(function () {
        Route::get('general-insurance-view/{id}', [GeneralInsuranceController::class, 'view'])->name('general.insurance.view');
        Route::get('general-insurance/export/{extension}', [GeneralInsuranceController::class, 'export'])->name('general.insurance.export');
        Route::get('endorsement-general-insurance-view/{id}', [GeneralInsuranceController::class, 'endorsementView'])->name('endorsement.general.insurance.view');
    });

    Route::get('claim-general-insurance', [GeneralInsuranceClaimController::class, 'index'])->name('claim.general-insurance.index');
    Route::get('claim-general-insurance-create', [GeneralInsuranceClaimController::class, 'create'])->name('claim.general-insurance.create');
    Route::post('claim-general-insurance-store', [GeneralInsuranceClaimController::class, 'store'])->name('claim.general-insurance.store');
    Route::get('claim-general-insurance-show/{id}', [GeneralInsuranceClaimController::class, 'show'])->name('claim.general-insurance.show');
    Route::get('claim-general-insurance-view/{id}', [GeneralInsuranceClaimController::class, 'view'])->name('claim.general-insurance.view');
    Route::get('claim-general-insurance-status/{id}/{state_id}', [GeneralInsuranceClaimController::class, 'statusChange'])->name('claim.general-insurance.status');


    Route::get('claim-health-insurance', [HealthInsuranceClaimController::class, 'index'])->name('claim.health-insurance.index');
    Route::get('claim-health-insurance-create', [HealthInsuranceClaimController::class, 'create'])->name('claim.health-insurance.create');
    Route::post('claim-health-insurance-store', [HealthInsuranceClaimController::class, 'store'])->name('claim.health-insurance.store');
    Route::get('claim-health-insurance-show/{id}', [HealthInsuranceClaimController::class, 'show'])->name('claim.health-insurance.show');
    Route::get('claim-health-insurance-view/{id}', [HealthInsuranceClaimController::class, 'view'])->name('claim.health-insurance.view');
    Route::get('claim-health-insurance-status/{id}/{state_id}', [HealthInsuranceClaimController::class, 'statusChange'])->name('claim.health-insurance.status');

    Route::get('claim-term-insurance', [TermInsuranceClaimController::class, 'index'])->name('claim.term-insurance.index');
    Route::get('claim-term-insurance-create', [TermInsuranceClaimController::class, 'create'])->name('claim.term-insurance.create');
    Route::post('claim-term-insurance-store', [TermInsuranceClaimController::class, 'store'])->name('claim.term-insurance.store');
    Route::get('claim-term-insurance-show/{id}', [TermInsuranceClaimController::class, 'show'])->name('claim.term-insurance.show');
    Route::get('claim-term-insurance-view/{id}', [TermInsuranceClaimController::class, 'view'])->name('claim.term-insurance.view');
    Route::get('claim-term-insurance-status/{id}/{state_id}', [TermInsuranceClaimController::class, 'statusChange'])->name('claim.term-insurance.status');

    Route::get('test-drive', [TestDriveController::class, 'index'])->name('test-drive.index');
    Route::get('test-drive-viw/{id}', [TestDriveController::class, 'view'])->name('test-drive.view');

    Route::controller(ReportController::class)->group(function () {
        Route::get('purchase-report', 'purchaseIndex')->name('purchase-report.index');
        Route::get('purchase-report/export/{extension}', 'purchaseExport')->name('purchase-report.export');
        Route::get('sale-report', 'saleIndex')->name('sale-report.index');
        Route::get('sale-report/export/{extension}', 'saleExport')->name('sale-report.export');
        Route::get('refurbishment-report', 'refurbishmentIndex')->name('refurbishment-report.index');
        Route::get('refurbishment-report-view/{id}', 'refurbishmentView')->name('refurbishment-report-view.view');
        Route::get('refurbishment-report/export/{extension}', 'refurbishmentExport')->name('refurbishment-report.export');
        Route::get('general-insurance-report', 'generalInsuranceIndex')->name('general-insurance-report.index');
        Route::get('general-insurance-report/export/{extension}', 'generalInsuranceExport')->name('general-insurance-report.export');
        Route::get('car-insurance-report', 'carInsuranceIndex')->name('car-insurance-report.index');
        Route::get('car-insurance-report/export/{extension}', 'carInsuranceExport')->name('car-insurance-report.export');
        Route::get('car-loan-report', 'pendingCarLoanIndex')->name('pendingcar-loan-report.index');
        Route::get('businesscar-loan-report', 'businessCarLoanIndex')->name('businesscar-loan-report.index');
        Route::get('car-loan-report/export/{extension}', 'carLoanExport')->name('car-loan-report.export');
        Route::get('businesscar-loan-report/export/{extension}', 'businessCarLoanExport')->name('businesscar-loan-report.export');
        Route::get('mortage-loan-report', 'mortageLoanIndex')->name('mortage-loan-report.index');
        Route::get('businessmortage-loan-report', 'businessMortageLoanIndex')->name('businessmortage-loan-report.index');
        Route::get('mortage-loan-report/export/{extension}', 'mortageLoanExport')->name('mortage-loan-report.export');
        Route::get('businessmortage-loan-report/export/{extension}', 'businessMortageLoanExport')->name('businessmortage-loan-report.export');
        Route::get('document-report', 'pendingDocuments')->name('document-report.index');
        Route::get('document-report/export/{extension}', 'documentExport')->name('document-report.export');
        Route::get('gross-margin-report', 'grossMarginIndex')->name('gross-margin-report.index');
        Route::get('gross-margin-report/export/{extension}', 'grossMarginExport')->name('gross-margin-report.export');
        Route::get('health-insurance-report', 'healthInsuranceIndex')->name('health-insurance-report.index');
        Route::get('health-insurance-report/export/{extension}', 'healthInsuranceExport')->name('health-insurance-report.export');
        Route::get('term-insurance-report', 'termInsuranceIndex')->name('term-insurance-report.index');
        Route::get('term-insurance-report/export/{extension}', 'termInsuranceExport')->name('term-insurance-report.export');
        Route::get('match-making-report', 'matchMakingIndex')->name('match-making-report.index');
        Route::get('match-making-report/export/{extension}', 'matchMakingExport')->name('match-making-report.export');
        Route::get('party-report', 'partyIndex')->name('party-report.index');
        Route::get('base-rate-report', 'baseRateIndex')->name('base-rate-report.index');
        Route::get('base-rate-report/export/{extension}', 'baseRateExport')->name('base-rate-report.export');
        Route::get('vehicle-report', 'vehicleIndex')->name('vehicle-report.index');
        Route::get('stock-report', 'stockIndex')->name('stock-report.index');

        //
        Route::post('add-selling-price', 'addSellingPrice')->name('add.selling.price');
    });
});
Route::get('/fetch-party-data', [CarLoanController::class, 'getPartyData'])->name('fetch-party-data');
Route::get('/update-data', [PurchaseController::class, 'updateData']);
Route::get('/fetch-data', [PurchaseController::class, 'getPartyData'])->name('fetch-data');
Route::get('/fetch-status', [PurchaseController::class, 'getStatus'])->name('fetch.status');
Route::get('/fetch-vehicles', [PurchaseController::class, 'getVehicles'])->name('fetch.vehicle');
Route::post('/save-party-data', [PurchaseController::class, 'savePartyData'])->name('save.party.data');
Route::get('/fetch-policy-data', [MotorInsuranceClaimController::class, 'getPolicyData'])->name('fetch-policy-data');
Route::post('update-permission', [PermissionController::class, 'updatePermission'])->name('update.permission');
Route::get('insurance-type-status', [GeneralInsuranceController::class, 'getInsuranceTypeStatus'])->name('insurance-type-status');
Route::get('/policy-data', [GeneralInsuranceClaimController::class, 'getPolicyData'])->name('policy-data');
Route::get('/get-policy-data', [HealthInsuranceClaimController::class, 'getPolicyData'])->name('get-policy-data');
Route::get('/get-policy', [TermInsuranceClaimController::class, 'getPolicyData'])->name('get-policy');
Route::post('/get-subtypes', [MortageLoanController::class, 'getSubTypes'])->name('getInsuranceSubTypes');
Route::post('/get-models', [ModelController::class, 'getModels'])->name('getModels');
Route::get('/fetch-insurance-data', [CarInsurance::class, 'getInsuranceData'])->name('fetch-insurance-data');
Route::post('/get-cars', [CarInsurance::class, 'getCars'])->name('getCars');
Route::get('get-vehicle-number/{number}', [CarInsurance::class, 'getVehicleNumbers']);
