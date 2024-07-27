@extends('admin.layouts.header')

@section('title', 'Dashboard')
@section('content')
<style>
    .grid-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .grid-item {
        border: 1px solid #ccc;
        padding: 10px;
    }
</style>
<div class="main-panel">
    <!-- BEGIN : Main Content-->
    <div class="main-content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <!--Statistics cards Starts-->
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="card border-primary" style="border-radius: 15px;">
                        <div class="card-content d-flex justify-content-center align-items-center">
                            <div class="card-body py-3">
                                <div class="media align-items-center">
                                    <div class="media-body pr-2">
                                        <h3 class="font-large-1 mb-0 text-warning">{{ $userCount }}</h3>
                                        <span>Users</span>
                                    </div>
                                    <div class="media-right">
                                        <i class="ft-users font-large-2 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="card border-primary" style="border-radius: 15px;">
                        <div class="card-content">
                            <div class="card-body py-3">
                                <div class="media align-items-center">
                                    <div class="media-body pr-2">
                                        <h3 class="font-large-1 mb-0 text-primary">{{ $purchase }}</h3>
                                        <span>Purchase</span>
                                    </div>
                                    <div class="media-right">
                                        <i class="fa fa-shopping-cart font-large-2 text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="card border-primary" style="border-radius: 15px;">
                        <div class="card-content">
                            <div class="card-body py-3">
                                <div class="media align-items-center">
                                    <div class="media-body pr-2">
                                        <h3 class="font-large-1 mb-0 text-secondary">{{ $purchase }}</h3>
                                        <span>Purchase</span>
                                    </div>
                                    <div class="media-right">
                                        <i class="fa fa-shield font-large-2 text-secondary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="card border-primary" style="border-radius: 15px;">
                        <div class="card-content">
                            <div class="card-body py-3">
                                <div class="media align-items-center">
                                    <div class="media-body pr-2">
                                        <h3 class="font-large-1 mb-0 text-info">{{ $sales }}</h3>
                                        <span>Sales</span>
                                    </div>
                                    <div class="media-right">
                                        <i class="fa fa-tags font-large-2 text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row match-height">
                <div class="col-xl-12 col-lg-12 col-12">
                    <div class="card shopping-cart">
                        <div class="card-header pb-2">
                            <h4 class="card-title mb-0">Stocks Statistics</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <div class="card-header">
                                        <h5 class="mb-3">Luxury Cars</h5>
                                    </div>
                                    <div class="overflow-auto">
                                        <div class="d-flex flex-nowrap">
                                            <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                                                <div class="card border-primary shadow" style="border-radius: 15px;">
                                                    <div class="card-content d-flex justify-content-center align-items-center">
                                                        <div class="card-body">
                                                            <div class="media align-items-center">
                                                                <div class="media-body pr-2">
                                                                    <h3 class="font-large-1 mb-0 text-warning">{{ $userCount }}</h3>
                                                                    <span>Owned Stock</span>
                                                                </div>
                                                                <div class="media-right">
                                                                    <i class="fa fa-money font-large-2 text-warning"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                                                <div class="card border-primary shadow" style="border-radius: 15px;">
                                                    <div class="card-content d-flex justify-content-center align-items-center">
                                                        <div class="card-body">
                                                            <div class="media align-items-center">
                                                                <div class="media-body pr-2">
                                                                    <h3 class="font-large-1 mb-0 text-primary">{{ $purchase }}</h3>
                                                                    <span>Refurbished Stock</span>
                                                                </div>
                                                                <div class="media-right">
                                                                    <i class="fa fa-money font-large-2 text-primary"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                                                <div class="card border-primary shadow" style="border-radius: 15px;">
                                                    <div class="card-content d-flex justify-content-center align-items-center">
                                                        <div class="card-body">
                                                            <div class="media align-items-center">
                                                                <div class="media-body pr-2">
                                                                    <h3 class="font-large-1 mb-0 text-secondary">{{ $purchase }}</h3>
                                                                    <span>Park & Sale Stock</span>
                                                                </div>
                                                                <div class="media-right">
                                                                    <i class="fa fa-money font-large-2 text-secondary"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Repeat for other cards -->
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <div class="card-header">
                                        <h5 class="mb-3">Not Luxury Cars</h5>
                                    </div>
                                    <div class="overflow-auto">
                                        <div class="d-flex flex-nowrap">
                                            <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                                                <div class="card border-primary shadow" style="border-radius: 15px;">
                                                    <div class="card-content d-flex justify-content-center align-items-center">
                                                        <div class="card-body">
                                                            <div class="media align-items-center">
                                                                <div class="media-body pr-2">
                                                                    <h3 class="font-large-1 mb-0 text-warning">{{ $userCount }}</h3>
                                                                    <span>Owned Stock</span>
                                                                </div>
                                                                <div class="media-right">
                                                                    <i class="fa fa-money font-large-2 text-warning"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                                                <div class="card border-primary shadow" style="border-radius: 15px;">
                                                    <div class="card-content d-flex justify-content-center align-items-center">
                                                        <div class="card-body">
                                                            <div class="media align-items-center">
                                                                <div class="media-body pr-2">
                                                                    <h3 class="font-large-1 mb-0 text-primary">{{ $purchase }}</h3>
                                                                    <span>Refurbished Stock</span>
                                                                </div>
                                                                <div class="media-right">
                                                                    <i class="fa fa-money font-large-2 text-primary"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                                                <div class="card border-primary shadow" style="border-radius: 15px;">
                                                    <div class="card-content d-flex justify-content-center align-items-center">
                                                        <div class="card-body">
                                                            <div class="media align-items-center">
                                                                <div class="media-body pr-2">
                                                                    <h3 class="font-large-1 mb-0 text-secondary">{{ $purchase }}</h3>
                                                                    <span>Park & Sale Stock</span>
                                                                </div>
                                                                <div class="media-right">
                                                                    <i class="fa fa-money font-large-2 text-secondary"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid-container">
                <div class="grid-item" style="border-radius: 5%;">
                    <div class="card-header pb-2">
                        <h5 class="mb-3">Finance Statistics</h5>
                    </div>
                    <canvas id="section1" width="300" height="200"></canvas>
                </div>
                <div class="grid-item" style="border-radius: 5%;">
                    <div class="card-header pb-2">
                        <h5 class="mb-3">Insurance Statistics</h5>
                    </div>
                    <canvas id="section2" width="300" height="200"></canvas>
                </div>
                <div class="grid-item" style="border-radius: 5%;">
                    <div class="card-header pb-2">
                        <h5 class="mb-3">Bank Wise</h5>
                    </div>
                    <canvas id="section3" width="300" height="200"></canvas>
                </div>
                <div class="grid-item" style="border-radius: 5%;">
                    <div class="card-header pb-2">
                        <h5 class="mb-3">Company Wise</h5>
                    </div>
                    <canvas id="section4" width="300" height="200"></canvas>
                </div>
            </div>
            <!--Statistics cards Ends-->
            <!-- <div class="row match-height">
                <div class="col-xl-12 col-lg-12 col-12">
                    <div class="card shopping-cart">
                        <div class="row match-height">
                            <div class="col-xl-12 col-lg-12 col-12">
                                <div class="card shopping-cart">
                                    <div class="card-header pb-2">
                                        <h4 class="card-title mb-1">General Insurance</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table text-center m-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Person Name</th>
                                                            <th>Executive</th>
                                                            <th>Insurance Date</th>
                                                            <th>Company</th>
                                                            <th>Policy No.</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($insurances as $value => $insurance)
                                                        <tr>
                                                            <td>{{($insurance->person_name) ? $insurance->person_name : ''}}</td>
                                                            <td>{{ ($insurance->executive->name) ? $insurance->executive->name : '' }}</td>
                                                            <td>{{ ($insurance->insurance_date) ? \Carbon\Carbon::parse($insurance->insurance_date)->format('Y-m-d') : '' }}</td>
                                                            <td>{{ ($insurance->company->name) ? $insurance->company->name : '' }}</td>
                                                            <td>{{($insurance->policy_number) ? $insurance->policy_number : ''}}</td>
                                                            <td>
                                                                <a href="{{ route('admin.insurance.delete', $insurance->id) }}" class="danger p-0 delete-color" data-color="{{ ucfirst($insurance->id) }}">
                                                                    <i class="ft-trash-2"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div> -->
        </div>
        <!-- END : End Main Content-->

        <!-- BEGIN : Footer-->
        <footer class="footer undefined undefined">
            <p class="clearfix text-muted m-0"><span>Copyright &copy; 2024 &nbsp;</span><a href="https://starcarz.in" id="pixinventLink" target="_blank">Starcarz</a><span class="d-none d-sm-inline-block">, All rights reserved.</span></p>
        </footer>
        <!-- End : Footer-->
        <!-- Scroll to top button -->
        <button class="btn btn-primary scroll-top" type="button"><i class="ft-arrow-up"></i></button>

    </div>
</div>
@endsection
@push('scripts')

<script>
    $(document).ready(function() {
        $('.delete-color').click(function(event) {
            event.preventDefault(); // Prevent the default action of the link
            var deleteUrl = $(this).attr('href');
            var colorName = $(this).data('color');

            // Display SweetAlert confirmation dialog
            Swal.fire({
                title: 'Confirm Deletion',
                text: 'Are you sure you want to delete the color "' + colorName + '"?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it'
            }).then((result) => {
                // If user confirms deletion, redirect to the delete URL
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var data1 = {
            labels: ['A', 'B', 'C', 'D'],
            datasets: [{
                label: 'Section 1',
                data: [10, 20, 30, 40],
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        };

        var data2 = {
            labels: ['X', 'Y', 'Z'],
            datasets: [{
                label: 'Section 2',
                data: [50, 60, 70],
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        var data3 = {
            labels: ['E', 'F'],
            datasets: [{
                label: 'Section 3',
                data: [80, 90],
                backgroundColor: 'rgba(255, 206, 86, 0.5)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        };

        var data4 = {
            labels: ['M', 'N', 'O', 'P', 'Q'],
            datasets: [{
                label: 'Section 4',
                data: [100, 110, 120, 130, 140],
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        // Configuration options for each section
        var options = {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        // Get the canvas elements for each section
        var ctx1 = document.getElementById('section1').getContext('2d');
        var ctx2 = document.getElementById('section2').getContext('2d');
        var ctx3 = document.getElementById('section3').getContext('2d');
        var ctx4 = document.getElementById('section4').getContext('2d');

        // Create the charts for each section
        var chart1 = new Chart(ctx1, {
            type: 'bar',
            data: data1,
            options: options
        });

        var chart2 = new Chart(ctx2, {
            type: 'bar',
            data: data2,
            options: options
        });

        var chart3 = new Chart(ctx3, {
            type: 'bar',
            data: data3,
            options: options
        });

        var chart4 = new Chart(ctx4, {
            type: 'bar',
            data: data4,
            options: options
        });
    });
</script>
@endpush
