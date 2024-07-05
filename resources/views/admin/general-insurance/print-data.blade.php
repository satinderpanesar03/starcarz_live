<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Insurance</title>
    <!-- Include print-specific styles -->
    <link rel="stylesheet" href="{{ asset('css/print.css') }}">
    <!-- Include Bootstrap or other CSS styles as needed -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>

<body>
    <div class="container">
        <h2>All Insurance Details</h2>
        <table class="table table-striped table-bordered dom-jQuery-events">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th>Party</th>
                    <th>Policy Number</th>
                    <th>Insurance Company</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                @foreach ($insurances as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->party ? ucfirst($item->party->party_name) : '' }}</td>
                    <td>{{ ucfirst($item->policy_number) }}</td>
                    <td>{{ $item->insurance ? ucfirst($item->insurance->name) : '' }}</td>
                    <!-- Add more cells as needed -->
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Buttons for printing and downloading PDF -->
        <div class="mt-3">
            <button class="btn btn-primary" onclick="window.print()">Print</button>
            <button class="btn btn-secondary" onclick="downloadPDF()">Download PDF</button>
        </div>
    </div>

    <!-- Include jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script>
        async function downloadPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            
            // Capture the HTML content of the table
            const table = document.querySelector('.table').outerHTML;
            
            // Add the table content to the PDF document
            doc.html(table, {
                callback: function (doc) {
                    // Save the PDF file
                    doc.save('insurance-data.pdf');
                },
                x: 10,
                y: 10
            });
        }
    </script>
</body>
</html>
