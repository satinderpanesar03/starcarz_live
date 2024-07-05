<div class="wrapper">


    <!-- main menu-->
    <!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
    <div class="app-sidebar menu-fixed" data-background-color="man-of-steel" data-image="{{asset('app-assets/img/sidebar-bg/01.jpg')}}" data-scroll-to-active="true">
        <!-- main menu header-->
        <!-- Sidebar Header starts-->
        <div class="sidebar-header">
            <div class="logo clearfix">
                <a class="logo-text float-left" href="{{ route('admin.dashboard.index') }}">
                    <div class="logo-img">
                        @if($company)
                        <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }} Logo" style="width: 125px;height: 60px;margin-left: 30px;" />
                        @else
                        <img src="{{ asset('app-assets/img/logo.png') }}" alt="Apex Logo" style="width: 140px;height: 78px;margin-left: 25px;" />
                        @endif
                    </div>
                </a>
                <a class="nav-toggle d-none d-lg-none d-xl-block" id="sidebarToggle" href="javascript:;"><i class="toggle-icon ft-toggle-right" data-toggle="expanded"></i></a>
                <a class="nav-close d-block d-lg-block d-xl-none" id="sidebarClose" href="javascript:;"><i class="ft-x"></i></a>
            </div>
        </div>
        <!-- Sidebar Header Ends-->
        <!-- / main menu header-->
        <!-- main menu content-->
        <div class="sidebar-content main-menu-content">
            <div class="nav-container">
                <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                    <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}"><a href="{{route('admin.dashboard.index')}}"><i class="ft-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
                    </li>

                    <!-- {{--master--}}
                    <li class="nav-item {{ request()->routeIs('admin.master.index') ? 'active' : '' }}"><a href="{{route('admin.master.index')}}"><i class="fa fa-bars"></i><span class="menu-title" data-i18n="Master">Master</span></a>
                    </li> -->

                    @if(EnsureModule('party') || EnsureModule('sub_type') || EnsureModule('rto_agent'))
                    <li class="has-sub nav-item"><a href="javascript:;"><i class="fa fa-home"></i><span class="menu-title" data-i18n="settings">Master</span></a>
                        @if(EnsureModule('party'))
                        <ul class="menu-content">
                            <li class="nav-item {{ request()->routeIs('admin.master.party.index') ? 'active' : '' }}""><a href=" {{route('admin.master.party.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Party</span></a>
                            </li>
                        </ul>
                        @endif
                        @if(EnsureModule('rto_agent'))
                        <ul class="menu-content">
                            <li class="nav-item {{ request()->routeIs('admin.master.rto.agent.index') ? 'active' : '' }}""><a href=" {{route('admin.master.rto.agent.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Agents</span></a>
                            </li>
                        </ul>
                        @endif
                        @if(EnsureModule('sub_type'))
                        <ul class="menu-content">
                            <li class="nav-item {{ request()->routeIs('admin.master.insurance-type.index') ? 'active' : '' }}""><a href=" {{route('admin.master.insurance-type.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Sub Type</span></a>
                            </li>
                        </ul>
                        @endif
                        @if(EnsureModule('color'))
                        <ul class="menu-content">
                            <li class="nav-item {{ request()->routeIs('admin.master.color.index') ? 'active' : '' }}""><a href=" {{route('admin.master.color.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Color</span></a>
                            </li>
                        </ul>
                        @endif
                        @if(EnsureModule('brand'))
                        <ul class="menu-content">
                            <li class="nav-item {{ request()->routeIs('admin.master.brand-type.index') ? 'active' : '' }}""><a href=" {{route('admin.master.brand-type.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Brand</span></a>
                            </li>
                        </ul>
                        @endif
                        @if(EnsureModule('model'))
                        <ul class="menu-content">
                            <li class="nav-item {{ request()->routeIs('admin.master.model.index') ? 'active' : '' }}""><a href=" {{route('admin.master.model.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Model</span></a>
                            </li>
                        </ul>
                        @endif
                        @if(EnsureModule('model'))
                        <ul class="menu-content">
                            <li class="nav-item {{ request()->routeIs('admin.master.dealer.index') ? 'active' : '' }}""><a href=" {{route('admin.master.dealer.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Dealer</span></a>
                            </li>
                        </ul>
                        @endif
                        @if(EnsureModule('executive'))
                        <ul class="menu-content">
                            <li class="nav-item {{ request()->routeIs('admin.master.executive.index') ? 'active' : '' }}""><a href=" {{route('admin.master.executive.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Sale Executive</span></a>
                            </li>
                        </ul>
                        @endif
                        @if(EnsureModule('bank'))
                        <ul class="menu-content">
                            <li class="nav-item {{ request()->routeIs('admin.master.bank.index') ? 'active' : '' }}""><a href=" {{route('admin.master.bank.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Bank</span></a>
                            </li>
                        </ul>
                        @endif
                        @if(EnsureModule('supplier'))
                        <ul class="menu-content">
                            <li class="nav-item {{ request()->routeIs('admin.master.supplier.index') ? 'active' : '' }}""><a href=" {{route('admin.master.supplier.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Supplier</span></a>
                            </li>
                        </ul>
                        @endif
                        @endif

                    </li>
                    <!-- {{--Insurance--}}
                    @if(EnsureModule('insurance'))
                        <li class="nav-item {{ request()->routeIs('admin.insurance.index') || request()->routeIs('admin.insurance.add') ? 'active' : '' }}"><a href="{{route('admin.insurance.index')}}"><i class="fa fa-shield"></i><span class="menu-title" data-i18n="Master">Insurance</span></a>
                        </li>
                    @endif
                    @if(EnsureModule('general_insraunce'))
                        <li class="nav-item {{ request()->routeIs('admin.insurance.general.index') || request()->routeIs('admin.insurance.general.create') ? 'active' : '' }}"><a href="{{route('admin.insurance.general.index')}}"><i class="fa fa-shield"></i><span class="menu-title" data-i18n="Master">General Insurance</span></a>
                        </li>
                    @endif -->

                    <!-- Loans -->
                    {{--Loans--}}
                    @if(EnsureModule('car_loans') || EnsureModule('mortage_loans'))
                    <li class="has-sub nav-item"><a href="javascript:;"><i class="fa fa-home"></i><span class="menu-title" data-i18n="settings">Loans</span></a>
                        <ul class="menu-content">
                            @if (EnsureModule('car_loans'))
                            <li class="nav-item {{ request()->routeIs('admin.loan.car-loan.index') ? 'active' : '' }}""><a href=" {{route('admin.loan.car-loan.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Car Loans</span></a>
                            </li>
                            @endif
                            @if(EnsureModule('mortage_loans'))
                            <li class="nav-item {{ request()->routeIs('admin.loan.mortage-loan.index') ? 'active' : '' }}""><a href=" {{route('admin.loan.mortage-loan.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="permissions">Mortage Loans</span></a>
                            </li>
                            @endif
                            @if(EnsureModule('aggregrator_loans'))
                            <li class="nav-item {{ request()->routeIs('admin.loan.aggregrator-loan.index') ? 'active' : '' }}""><a href=" {{route('admin.loan.aggregrator-loan.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="permissions">Aggregrator Loans</span></a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    {{--Purchase--}}
                    @if(EnsureModule('purchase'))
                    <li class="has-sub nav-item"><a href="javascript:;"><i class="fa fa-list"></i><span class="menu-title" data-i18n="settings">Purchase</span></a>
                        <ul class="menu-content">
                            <li class="nav-item {{ request()->routeIs('admin.purchase.purchase.index') ? 'active' : '' }}""><a href=" {{route('admin.purchase.purchase.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Enquiry</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.purchase.purchase.follow-up') ? 'active' : '' }}""><a href=" {{route('admin.purchase.purchase.follow-up')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Follow Up</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.purchase.purchase.orders') ? 'active' : '' }}""><a href=" {{route('admin.purchase.purchase.orders')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="permissions">Orders</span></a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    {{--Sales--}}
                    @if(EnsureModule('sale'))
                    <li class="has-sub nav-item"><a href="javascript:;"><i class="fa fa-list"></i><span class="menu-title" data-i18n="settings">Sale</span></a>
                        <ul class="menu-content">
                            <li class="nav-item {{ request()->routeIs('admin.sale.sale.index') ? 'active' : '' }}""><a href=" {{route('admin.sale.sale.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Enquiry</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.test-drive.index') ? 'active' : '' }}""><a href=" {{route('admin.test-drive.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Test Drive</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.sale.sale.follow-up') ? 'active' : '' }}""><a href=" {{route('admin.sale.sale.follow-up')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Follow Up</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.sale.sale.order-index') ? 'active' : '' }}""><a href=" {{route('admin.sale.sale.order-index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="permissions">Orders</span></a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(EnsureModule('purchase'))
                    <li class="nav-item {{ request()->routeIs('admin.purchase.purchase.ready-sale-index') ? 'active' : '' }}""><a href=" {{route('admin.purchase.purchase.ready-sale-index')}}"><i class="fa fa-gears"></i><span class="menu-item " data-i18n="roles">Ready For Sale</span></a>
                    </li>
                    @endif
                    @if(EnsureModule('rc_transfer'))
                    <li class="nav-item {{ request()->routeIs('admin.rc-transfer.index') ? 'active' : '' }}""><a href=" {{route('admin.rc-transfer.index')}}"><i class="fa fa-gears"></i><span class="menu-item " data-i18n="roles">RC Transfer</span></a>
                    </li>
                    @endif

                    <!-- //health -->
                    @if(EnsureModule('health_insurance'))
                    <li class="has-sub nav-item"><a href="javascript:;"><i class="fa fa-list"></i><span class="menu-title" data-i18n="settings">Health Insurance</span></a>
                        <ul class="menu-content">
                            @if(EnsureModule('health_insurance'))
                            <li class="nav-item {{ request()->routeIs('admin.health.index') || request()->routeIs('admin.health.create') ? 'active' : '' }}""><a href=" {{route('admin.health.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Health Insurance</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.health.insurance.renewal-index') ? 'active' : '' }}"><a href="{{route('admin.health.insurance.renewal-index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Renewal</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.claim.health-insurance.index') || request()->routeIs('admin.claim.health-insurance.create')? 'active' : '' }}"><a href="{{route('admin.claim.health-insurance.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Claim</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.endorsement.health.insurance.index') || request()->routeIs('admin.endorsement.health.insurance.index') ? 'active' : '' }}"><a href="{{route('admin.endorsement.health.insurance.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Endorsement</span></a>
                            </li>
                            @endif
                        </ul>
                        @endif
                    </li>

                    @if(EnsureModule('term_insurance'))
                    <li class="has-sub nav-item"><a href="javascript:;"><i class="fa fa-list"></i><span class="menu-title" data-i18n="settings">Term Insurance</span></a>
                        <ul class="menu-content">
                            @if(EnsureModule('term_insurance'))
                            <li class="nav-item {{ request()->routeIs('admin.term.insurance.index') || request()->routeIs('admin.term.insurance.create') ? 'active' : '' }}"><a href="{{route('admin.term.insurance.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Term Insurance</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.term.insurance.renewal-index') ? 'active' : '' }}"><a href="{{route('admin.term.insurance.renewal-index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Renewal</span></a>
                            </li>
                            <!-- <li class="nav-item {{ request()->routeIs('admin.claim.term-insurance.index') || request()->routeIs('admin.claim.term-insurance.create')? 'active' : '' }}"><a href="{{route('admin.claim.term-insurance.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Claim</span></a>
                            </li> -->
                            <li class="nav-item {{ request()->routeIs('admin.endorsement.term.insurance.index') || request()->routeIs('admin.endorsement.term.insurance.index') ? 'active' : '' }}"><a href="{{route('admin.endorsement.term.insurance.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Endorsement</span></a>
                            </li>
                            @endif
                        </ul>
                        @endif
                    </li>
                    @if(EnsureModule('general_insurance'))
                    <li class="has-sub nav-item"><a href="javascript:;"><i class="fa fa-list"></i><span class="menu-title" data-i18n="settings">General Insurance</span></a>
                        <ul class="menu-content">
                            <li class="nav-item {{ request()->routeIs('admin.general.insurance.index') || request()->routeIs('admin.general.insurance.create') ? 'active' : '' }}"><a href="{{route('admin.general.insurance.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Insurance</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.general.insurance.renewal-index') ? 'active' : '' }}"><a href="{{route('admin.general.insurance.renewal-index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Renewal</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.claim.general-insurance.index') || request()->routeIs('admin.claim.general-insurance.create')? 'active' : '' }}"><a href="{{route('admin.claim.general-insurance.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Claim</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.endorsement.general.insurance.index') || request()->routeIs('admin.endorsement.general.insurance.index') ? 'active' : '' }}"><a href="{{route('admin.endorsement.general.insurance.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Endorsement</span></a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    @if(EnsureModule('motor_insurance') || EnsureModule('motor_insurance_claim'))
                    <li class="has-sub nav-item"><a href="javascript:;"><i class="fa fa-list"></i><span class="menu-title" data-i18n="settings">Motor Insurance</span></a>
                        <ul class="menu-content">

                            <li class="nav-item {{ request()->routeIs('admin.car.insurance.index') || request()->routeIs('admin.car.insurance.create') ? 'active' : '' }}""><a href=" {{route('admin.car.insurance.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Motor Insurance</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.car.insurance.renewal-index') ? 'active' : '' }}"><a href="{{route('admin.car.insurance.renewal-index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Renewal</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.claim.insurance.index') || request()->routeIs('admin.claim.insurance.create') ? 'active' : '' }}"><a href="{{route('admin.claim.insurance.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Claim Insurance</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.endorsement.insurance.index') || request()->routeIs('admin.endorsement.insurance.create') ? 'active' : '' }}"><a href="{{route('admin.endorsement.insurance.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Endorsement</span></a>
                            </li>
                        </ul>
                    </li>
                    @endif


                    <!-- <li class="nav-item {{ request()->routeIs('admin.car.insurance.index') || request()->routeIs('admin.car.insurance.create') ? 'active' : '' }}""><a href="{{route('admin.car.insurance.index')}}"><i class="ft-arrow-right submenu-ico"></i><span class="menu-item " data-i18n="roles">Motor Insurance</span></a>
                    </li> -->


                    {{--Refurbishment--}}
                    @if(EnsureModule('refurbishment'))
                    <!-- <li class="has-sub nav-item"><a href="javascript:;"><i class="fa fa-gears"></i><span class="menu-title" data-i18n="settings">Refurbishment</span></a>
                        <ul class="menu-content"> -->
                    <li class="nav-item {{ request()->routeIs('admin.refurbishment.index') ? 'active' : '' }}""><a href=" {{route('admin.refurbishment.index')}}"><i class="fa fa-list"></i><span class="menu-item " data-i18n="roles">Refurbishment</span></a>
                    </li>
                    <!-- </ul>
                    </li> -->
                    @endif

                    @if(EnsureModule('customer_demand'))
                    <li class="nav-item {{ request()->routeIs('admin.demand.vehicle.index') ? 'active' : '' }}""><a href=" {{route('admin.demand.vehicle.index')}}"><i class="fa fa-gears"></i><span class="menu-item " data-i18n="roles">Customer Demands</span></a>
                    </li>
                    @endif

                    {{--reports--}}
                    <li class="has-sub nav-item"><a href="javascript:;"><i class="fa fa-list"></i><span class="menu-title" data-i18n="settings">Reports</span></a>
                        <ul class="menu-content">

                            <li class="nav-item {{ request()->routeIs('admin.sale-report.index') ? 'active' : '' }}""><a href=" {{route('admin.sale-report.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Sale</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.purchase-report.index') ? 'active' : '' }}""><a href=" {{route('admin.purchase-report.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Purchase</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.refurbishment-report.index') ? 'active' : '' }}""><a href=" {{route('admin.refurbishment-report.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Refurbishment Deviation</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.general-insurance-report.index') ? 'active' : '' }}""><a href=" {{route('admin.general-insurance-report.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">General Insurance</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.car-insurance-report.index') ? 'active' : '' }}""><a href=" {{route('admin.car-insurance-report.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Car Insurance</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.health-insurance-report.index') ? 'active' : '' }}""><a href=" {{route('admin.health-insurance-report.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Health Insurance</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.term-insurance-report.index') ? 'active' : '' }}""><a href=" {{route('admin.term-insurance-report.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Term Insurance</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.pendingcar-loan-report.index') ? 'active' : '' }}""><a href=" {{route('admin.pendingcar-loan-report.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Pending Car Loan</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.businesscar-loan-report.index') ? 'active' : '' }}""><a href=" {{route('admin.businesscar-loan-report.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Business Car Loan</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.mortage-loan-report.index') ? 'active' : '' }}""><a href=" {{route('admin.mortage-loan-report.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Pending Mortage Loan</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.businessmortage-loan-report.index') ? 'active' : '' }}""><a href=" {{route('admin.businessmortage-loan-report.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Business Mortage Loan</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.document-report.index') ? 'active' : '' }}""><a href=" {{route('admin.document-report.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Pending Documents</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.gross-margin-report.index') ? 'active' : '' }}""><a href=" {{route('admin.gross-margin-report.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Gross Margin</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.match-making-report.index') ? 'active' : '' }}""><a href=" {{route('admin.match-making-report.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Match Making</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.party-report.index') ? 'active' : '' }}""><a href=" {{route('admin.party-report.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Party Report</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.vehicle-report.index') ? 'active' : '' }}""><a href=" {{route('admin.vehicle-report.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Vehicle Report</span></a>
                            </li>

                            <li class="nav-item {{ request()->routeIs('admin.stock-report.index') ? 'active' : '' }}"><a href="{{route('admin.stock-report.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Stock</span></a>
                            </li>
                            <!-- <li class="nav-item {{ request()->routeIs('admin.base-rate-report.index') ? 'active' : '' }}""><a href=" {{route('admin.base-rate-report.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Base Rate Report</span></a>
                            </li> -->
                        </ul>
                    </li>

                    {{--settings--}}

                    @if (\Auth::guard('admin')->user()->role_id == 1)
                    <li class="has-sub nav-item"><a href="javascript:;"><i class="fa fa-gear"></i><span class="menu-title" data-i18n="settings">Staff</span></a>
                        <ul class="menu-content">
                            <li class="nav-item {{ request()->routeIs('admin.setting.role.index') || request()->routeIs('admin.setting.role.show') ? 'active' : '' }}"><a href="{{route('admin.setting.role.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item " data-i18n="roles">Roles</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.setting.user.index') ? 'active' : '' }}"><a href="{{route('admin.setting.user.index')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="permissions">Staff</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.setting.company.create') ? 'active' : '' }}"><a href="{{route('admin.setting.company.create')}}"><i class="ft-arrow-right submenu-icon"></i><span class="menu-item" data-i18n="permissions">Company</span></a>
                            </li>
                        </ul>
                    </li>
                    @endif


                </ul>



            </div>
        </div>
        <!-- main menu content-->
        <div class="sidebar-background"></div>
        <!-- main menu footer-->
        <!-- include includes/menu-footer-->
        <!-- main menu footer-->
        <!-- / main menu-->
    </div>

    <aside class="notification-sidebar d-none d-sm-none d-md-block" id="notification-sidebar"><a class="notification-sidebar-close"><i class="ft-x font-medium-3 grey darken-1"></i></a>
        <div class="side-nav notification-sidebar-content">
            <div class="row">
                <div class="col-12 notification-nav-tabs">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="activity-tab" href="#activity-tab" aria-expanded="true">Activity</a></li>
                        <li class="nav-item"><a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="settings-tab" href="#settings-tab" aria-expanded="false">Settings</a></li>
                    </ul>
                </div>
                <div class="col-12 notification-tab-content">
                    <div class="tab-content">
                        <div class="row tab-pane active" id="activity-tab" role="tabpanel" aria-expanded="true" aria-labelledby="base-tab1">
                            <div class="col-12" id="activity">
                                <h5 class="my-2 text-bold-500">System Logs</h5>
                                <div class="timeline-left timeline-wrapper mb-3" id="timeline-1">
                                    <ul class="timeline">
                                        <li class="timeline-line mt-4"></li>
                                        <li class="timeline-item">
                                            <div class="timeline-badge"><span class="bg-primary bg-lighten-4" data-toggle="tooltip" data-placement="right" title="Portfolio project work"><i class="ft-download primary"></i></span></div>
                                            <div class="activity-list-text">
                                                <h6 class="mb-1"><span>New Update Available</span><span class="float-right grey font-italic font-small-2">1 min ago</span></h6>
                                                <p class="mt-0 mb-2 font-small-3">Android Pie 9.0.0_r52v availabe (658MB).</p>
                                                <div class="notification-note">
                                                    <div class="p-1 pl-2"><span class="text-bold-500">Download Now!</span></div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="timeline-item">
                                            <div class="timeline-badge"><span class="bg-primary bg-lighten-4" data-toggle="tooltip" data-placement="right" title="Portfolio project work"><img class="avatar" src="{{asset('app-assets/img/portrait/small/avatar-s-15.png')}}" alt="avatar" width="40"></span></div>
                                            <div class="activity-list-text">
                                                <h6 class="mb-1"><span>Reminder!</span><span class="float-right grey font-italic font-small-2">52 min ago</span></h6>
                                                <p class="mt-0 mb-2 font-small-3">Your meeting is scheduled with Mr. Derrick Walters at 16:00.</p>
                                                <div class="notification-note">
                                                    <div class="p-1 pl-2"><span class="text-bold-500">Snooze</span></div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="timeline-item">
                                            <div class="timeline-badge"><span class="bg-primary bg-lighten-4" data-toggle="tooltip" data-placement="right" title="Portfolio project work"><img class="avatar" src="{{asset('app-assets/img/portrait/small/avatar-s-16.png')}}" alt="avatar" width="40"></span></div>
                                            <div class="activity-list-text">
                                                <h6 class="mb-1"><span>Recieved a File</span><span class="float-right grey font-italic font-small-2">4 hours ago</span></h6>
                                                <p class="mt-0 mb-2 font-small-3">Christina Rogers sent you a file for the next conference.</p>
                                                <div class="notification-note">
                                                    <div class="p-1 pl-2"><img src="{{asset('app-assets/img/icons/sketch-mac-icon.png')}}" alt="icon" width="20"><span class="text-bold-500 ml-2">Diamond.sketch</span></div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="timeline-item">
                                            <div class="timeline-badge"><span class="bg-primary bg-lighten-4" data-toggle="tooltip" data-placement="right" title="Portfolio project work"><i class="ft-mic primary"></i></span></div>
                                            <div class="activity-list-text">
                                                <h6 class="mb-1"><span>Voice Message</span><span class="float-right grey font-italic font-small-2">10 hours ago</span></h6>
                                                <p class="mt-0 mb-2 font-small-3">Natalya Parker sent you a voice message.</p>
                                                <div class="notification-note">
                                                    <div class="p-1 pl-2"><span class="text-bold-500">Listen</span></div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="timeline-item">
                                            <div class="timeline-badge"><span class="bg-primary bg-lighten-4" data-toggle="tooltip" data-placement="right" title="Portfolio project work"><i class="ft-cloud-drizzle primary"></i></span></div>
                                            <div class="activity-list-text">
                                                <h6 class="mb-1"><span>Weather Update</span><span class="float-right grey font-italic font-small-2">Yesterday</span></h6>
                                                <p class="mt-0 mb-2 font-small-3">Hi John! It is a rainy day with 16&deg;C.</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <h5 class="my-2 text-bold-500">Applications Logs</h5>
                                <div class="timeline-left timeline-wrapper" id="timeline-2">
                                    <ul class="timeline">
                                        <li class="timeline-line mt-4"></li>
                                        <li class="timeline-item">
                                            <div class="timeline-badge"><span class="bg-primary bg-lighten-4" data-toggle="tooltip" data-placement="right" title="Portfolio project work"><img class="avatar" src="{{asset('app-assets/img/portrait/small/avatar-s-26.png')}}" alt="avatar" width="40"></span></div>
                                            <div class="activity-list-text">
                                                <h6 class="mb-1"><span>Gmail</span><span class="float-right grey font-italic font-small-2">Just now</span></h6>
                                                <p class="mt-0 mb-2 font-small-3">Victoria Hampton sent you a mail and has a file attachment with it.</p>
                                                <div class="notification-note">
                                                    <div class="p-1 pl-2"><img src="{{asset('app-assets/img/icons/pdf.png')}}" alt="pdf icon" width="20"><span class="text-bold-500 ml-2">Register.pdf</span></div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="timeline-item">
                                            <div class="timeline-badge"><span class="bg-primary bg-lighten-4" data-toggle="tooltip" data-placement="right" title="Portfolio project work"><i class="ft-droplet primary"></i></span></div>
                                            <div class="activity-list-text">
                                                <h6 class="mb-1"><span>MakeMyTrip</span><span class="float-right grey font-italic font-small-2">7 hours ago</span></h6>
                                                <p class="mt-0 mb-2 font-small-3">Your next flight for San Francisco will be on 24th March.</p>
                                                <div class="notification-note">
                                                    <div class="p-1 pl-2"><span class="text-bold-500">Important</span></div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="timeline-item">
                                            <div class="timeline-badge"><span class="bg-primary bg-lighten-4" data-toggle="tooltip" data-placement="right" title="Portfolio project work"><img class="avatar" src="{{asset('app-assets/img/portrait/small/avatar-s-23.png')}}" alt="avatar" width="40"></span></div>
                                            <div class="activity-list-text">
                                                <h6 class="mb-1"><span>CNN</span><span class="float-right grey font-italic font-small-2">16 hours ago</span></h6>
                                                <p class="mt-0 mb-2 font-small-3">U.S. investigating report says email account linked to CIA Director was hacked.</p>
                                                <div class="notification-note">
                                                    <div class="p-1 pl-2"><span class="text-bold-500">Read full article</span></div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="timeline-item">
                                            <div class="timeline-badge"><span class="bg-primary bg-lighten-4" data-toggle="tooltip" data-placement="right" title="Portfolio project work"><i class="ft-map primary"></i></span></div>
                                            <div class="activity-list-text">
                                                <h6 class="mb-1"><span>Maps</span><span class="float-right grey font-italic font-small-2">Yesterday</span></h6>
                                                <p class="mt-0 mb-2 font-small-3">You visited Walmart Supercenter in Chicago.</p>
                                                <div class="notification-note">
                                                    <div class="p-1 pl-2"><span class="text-bold-500">Write a Review!</span></div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="timeline-item">
                                            <div class="timeline-badge"><span class="bg-primary bg-lighten-4" data-toggle="tooltip" data-placement="right" title="Portfolio project work"><i class="ft-package primary"></i></span></div>
                                            <div class="activity-list-text">
                                                <h6 class="mb-1"><span>Updates Available</span><span class="float-right grey font-italic font-small-2">2 days ago</span></h6>
                                                <p class="mt-0 mb-2 font-small-3">19 app updates found.</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row tab-pane" id="settings-tab" aria-labelledby="base-tab2">
                            <div class="col-12" id="settings">
                                <h5 class="mt-2 mb-3">General Settings</h5>
                                <ul class="list-unstyled mb-0 mx-2">
                                    <li class="mb-3">
                                        <div class="mb-1"><span class="text-bold-500">Notifications</span>
                                            <div class="float-right">
                                                <div class="custom-switch">
                                                    <input class="custom-control-input" id="noti-s-switch-1" type="checkbox">
                                                    <label class="custom-control-label" for="noti-s-switch-1"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="font-small-3 m-0">Use switches when looking for yes or no answers.</p>
                                    </li>
                                    <li class="mb-3">
                                        <div class="mb-1"><span class="text-bold-500">Show recent activity</span>
                                            <div class="float-right">
                                                <div class="checkbox">
                                                    <input id="noti-s-checkbox-1" type="checkbox" checked>
                                                    <label for="noti-s-checkbox-1"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="font-small-3 m-0">The "for" attribute is necessary to bind checkbox with the input.</p>
                                    </li>
                                    <li class="mb-3">
                                        <div class="mb-1"><span class="text-bold-500">Product Update</span>
                                            <div class="float-right">
                                                <div class="custom-switch">
                                                    <input class="custom-control-input" id="noti-s-switch-4" type="checkbox" checked>
                                                    <label class="custom-control-label" for="noti-s-switch-4"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="font-small-3 m-0">Message and mail me on weekly product updates.</p>
                                    </li>
                                    <li class="mb-3">
                                        <div class="mb-1"><span class="text-bold-500">Email on Follow</span>
                                            <div class="float-right">
                                                <div class="custom-switch">
                                                    <input class="custom-control-input" id="noti-s-switch-3" type="checkbox">
                                                    <label class="custom-control-label" for="noti-s-switch-3"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="font-small-3 m-0">Mail me when someone follows me.</p>
                                    </li>
                                    <li class="mb-3">
                                        <div class="mb-1"><span class="text-bold-500">Announcements</span>
                                            <div class="float-right">
                                                <div class="checkbox">
                                                    <input id="noti-s-checkbox-2" type="checkbox" checked>
                                                    <label for="noti-s-checkbox-2"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="font-small-3 m-0">Receive all the news and announcements from my clients.</p>
                                    </li>
                                    <li class="mb-3">
                                        <div class="mb-1"><span class="text-bold-500">Date and Time</span>
                                            <div class="float-right">
                                                <div class="checkbox">
                                                    <input id="noti-s-checkbox-3" type="checkbox">
                                                    <label for="noti-s-checkbox-3"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="font-small-3 m-0">Show date and time on top of every page.</p>
                                    </li>
                                    <li>
                                        <div class="mb-1"><span class="text-bold-500">Email on Comments</span>
                                            <div class="float-right">
                                                <div class="custom-switch">
                                                    <input class="custom-control-input" id="noti-s-switch-2" type="checkbox" checked>
                                                    <label class="custom-control-label" for="noti-s-switch-2"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="font-small-3 m-0">Mail me when someone comments on my article.</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>