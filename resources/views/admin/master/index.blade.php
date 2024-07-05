@extends('admin.layouts.header')

@section('title', 'Master')
@section('content')
    <div class="wrapper">
        <div class="main-panel">
            <!-- BEGIN : Main Content-->
            <div class="main-content">
                <div class="content-overlay"></div>
                <div class="content-wrapper">

                    <!-- Minimal statistics section start -->
                    <section id="minimal-statistics-bg">
                        <div class="row">
                            <div class="col-12 mb-1">
                                <div class="content-header">Showroom Master</div>
                                <p class="content-sub-header mb-1"></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12">
                                <a href="{{route('admin.master.color.index')}}" class="card card-inverse bg-warning">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-body text-left">
                                                    <h3 class="card-text">{{ \App\Models\MstColor::count() }}</h3>
                                                    <span>Colors</span>
                                                </div>
                                                <div class="media-right align-self-center">
                                                    <i class="ft-briefcase font-large-2 float-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12">
                                <a href="{{route('admin.master.executive.index')}}" class="card card-inverse bg-success">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-body text-left">
                                                    <h3 class="card-text">{{\App\Models\MstExecutive::count()}}</h3>
                                                    <span>Executive</span>
                                                </div>
                                                <div class="media-right align-self-center">
                                                    <i class="ft-briefcase font-large-2 float-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12">
                                <a href="{{route('admin.master.brand-type.index')}}" class="card card-inverse bg-danger">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-body text-left">
                                                    <h3 class="card-text">{{\App\Models\MstBrandType::count()}}</h3>
                                                    <span>Brands</span>
                                                </div>
                                                <div class="media-right align-self-center">
                                                    <i class="ft-briefcase font-large-2 float-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12">
                                <a href="{{route('admin.master.model.index')}}" class="card card-inverse bg-primary">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-body text-left">
                                                    <h3 class="card-text">{{\App\Models\MstModel::count()}}</h3>
                                                    <span>Model</span>
                                                </div>
                                                <div class="media-right align-self-center">
                                                    <i class="ft-briefcase font-large-2 float-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12">
                                <a href="{{route('admin.master.supplier.index')}}" class="card card-inverse bg-primary">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-left align-self-center">
                                                    <i class="ft-book-open font-large-2 float-left"></i>
                                                </div>
                                                <div class="media-body text-right">
                                                    <h3 class="card-text">{{ \App\Models\MstSupplier::count() }}</h3>
                                                    <span>Supplier</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12">
                                <a href="{{route('admin.master.rto.agent.index')}}" class="card card-inverse bg-danger">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-left align-self-center">
                                                    <i class="ft-message-square font-large-2 float-left"></i>
                                                </div>
                                                <div class="media-body text-right">
                                                    <h3 class="card-text">{{ \App\Models\MstRtoAgent::count() }}</h3>
                                                    <span>RTO Agent</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12">
                                <a href="{{route('admin.master.upload.file.index')}}" class="card card-inverse bg-success">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-left align-self-center">
                                                    <i class="ft-trending-up font-large-2 float-left"></i>
                                                </div>
                                                <div class="media-body text-right">
                                                    <h3 class="card-text">{{ \App\Models\MstUploads::count() }}</h3>
                                                    <span>Upload File</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </section>
                    <!-- // Minimal statistics section end -->

                    <!-- Minimal statistics with bg color section start -->
                    <section id="minimal-statistics-bg">
                        <div class="row">
                            <div class="col-12 mb-1">
                                <div class="content-header">Fin/Ins Master</div>
                                <p class="content-sub-header mb-1"></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12">
                                <a href="{{route('admin.master.party.index')}}" class="card card-inverse bg-warning">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-body text-left">
                                                    <h3 class="card-text">{{ \App\Models\MstParty::count() }}</h3>
                                                    <span>Party</span>
                                                </div>
                                                <div class="media-right align-self-center">
                                                    <i class="ft-briefcase font-large-2 float-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12">
                                <a href="{{route('admin.master.broker.index')}}" class="card card-inverse bg-success">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-body text-left">
                                                    <h3 class="card-text">{{ \App\Models\MstBroker::count() }}</h3>
                                                    <span>Broker</span>
                                                </div>
                                                <div class="media-right align-self-center">
                                                    <i class="ft-user font-large-2 float-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12">
                                <a href="{{ route('admin.master.article.index') }}" class="card card-inverse bg-danger">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-body text-left">
                                                    <h3 class="card-text">{{ \App\Models\MstArticle::count()}}</h3>
                                                    <span>Article</span>
                                                </div>
                                                <div class="media-right align-self-center">
                                                    <i class="ft-pie-chart font-large-2 float-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12">
                                <a href="{{route('admin.master.dealer.index')}}" class="card card-inverse bg-primary">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-body text-left">
                                                    <h3 class="card-text">{{ \App\Models\MstDealer::count() }}</h3>
                                                    <span>Dealer</span>
                                                </div>
                                                <div class="media-right align-self-center">
                                                    <i class="ft-life-buoy font-large-2 float-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12">
                                <a href="{{route('admin.master.bank.index')}}" class="card card-inverse bg-success">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-left align-self-center">
                                                    <i class="ft-book-open font-large-2 float-left"></i>
                                                </div>
                                                <div class="media-body text-right">
                                                    <h3 class="card-text">{{ \App\Models\MstBank::count() }}</h3>
                                                    <span>Bank Details</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12">
                                <a href="" class="card card-inverse bg-danger">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-left align-self-center">
                                                    <i class="ft-message-square font-large-2 float-left"></i>
                                                </div>
                                                <div class="media-body text-right">
                                                    <h3 class="card-text">0</h3>
                                                    <span>Se Details</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12">
                                <a href="{{route('admin.master.insurance.index')}}" class="card card-inverse bg-primary">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-left align-self-center">
                                                    <i class="ft-trending-up font-large-2 float-left"></i>
                                                </div>
                                                <div class="media-body text-right">
                                                    <h3 class="card-text">{{ \App\Models\MstInsurance::count() }}</h3>
                                                    <span>Insurance</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12">
                                <a href="{{route('admin.master.insurance-type.index')}}" class="card card-inverse bg-danger">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-left align-self-center">
                                                    <i class="ft-message-square font-large-2 float-left"></i>
                                                </div>
                                                <div class="media-body text-right">
                                                    <h3 class="card-text">{{ \App\Models\MstInsuranceType::count() }}</h3>
                                                    <span>Insurance Type</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12">
                                <a href="{{route('admin.master.coveredinsurance.index')}}" class="card card-inverse bg-success">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-left align-self-center">
                                                    <i class="ft-book-open font-large-2 float-left"></i>
                                                </div>
                                                <div class="media-body text-right">
                                                    <h3 class="card-text">{{ \App\Models\InsuranceCovered::count() }}</h3>
                                                    <span>Covered Insurance</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </section>

                    <!-- // Minimal statistics with bg color section end -->

                </div>
            </div>
            <!-- END : End Main Content-->

        </div>
    </div
@endsection
