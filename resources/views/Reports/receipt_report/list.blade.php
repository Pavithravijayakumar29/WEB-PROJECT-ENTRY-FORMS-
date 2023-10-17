<button class="btn btn-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="tableExport" onclick="exportToCSV()">Excel</button>
<button class="btn btn-secondary buttons-pdf buttons-html5" tabindex="0" aria-controls="tableExport" onclick="generatePDF()">PDF</button>
<button class="btn btn-secondary buttons-print" tabindex="0" aria-controls="tableExport" onclick="printTable()">Print</button>

<div class="table-responsive"><br>
    <table class="table table-hover" id="tableExport" style="width:100%;" border='1'>
        <div class="table-responsive">
            <thead>
                <tr>
                    <th style="width: 5%;">Sno</th>
                    <th style="width: 8%;">Place</th>
                    <th style="width: 10%;">Dealer Name</th>
                    <th style="width: 10%;">Contact</th>
                    <th style="width: 10%;">Bill No</th>
                    <th style="width: 8%;">Date</th>
                    <th style="width: 8%;">Days Count</th>
                    <th style="width: 8%;">Total Amount</th>
                    <th style="width: 8%;">Paid Amount</th>
                    <th style="width: 8%;">Balance Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                    $total_amount_123 = 0;
                    $total_paid_amount = 0;
                    $total_bal_amount = 0;
                @endphp
                @foreach($result as $results)
                    @php
                        $orderDate = new DateTime($results->order_date);
                        $dispatchDate = new DateTime($results->dispatch_date);

                        $interval = $orderDate->diff($dispatchDate);
                        $daysDifference = $interval->days;
                    @endphp
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{$results->address}}</td>
                        <td>{{$results->dealer_name}}</td>
                        <td>{{$results->whatsapp_no}}</td>
                        <td>{{$results->tally_no}}</td>
                        <td>{{$results->order_date}}</td>
                        <td>{{$daysDifference}}</td>
                        <td>{{$results->total_amount}}
                            @php
                                $total_amount_123 += $results->total_amount;
                            @endphp
                        </td>
                        <td>{{$results->paid_amount}}
                            @php
                                $total_paid_amount += $results->paid_amount;
                            @endphp
                        </td>
                        <td>
                            {{$results->bal_amount}}
                            @php
                                $total_bal_amount += $results->bal_amount;
                            @endphp
                        </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
            <tr>
                <td hidden></td>
                <td hidden></td>
                <td hidden></td>
                <td hidden></td>
                <td hidden></td>
                <td hidden></td>
                <td hidden></td>
                <td colspan="7" style="color: MediumSeaGreen"><center><b>Total</b></center></td>
                <td style="background-color: yellow; color: red;">{{$total_amount_123}}</td>
                <td style="background-color: yellow; color: red;">{{$total_paid_amount}}</td>
                <td style="background-color: yellow; color: red;">{{$total_bal_amount}}</td>
            </tr>
        </div>
    </table>
</div>
@foreach($result as $results)
    @php
        // $sales_rep = $results->sales_ref_name;
        //  $tally = $results->tally_no;
    @endphp
@endforeach

<script>
function exportToCSV() {
    var from_date = '{{$from_date}}';
    var to_date = '{{$to_date}}';
    var tally_no = '{{$final_tally}}';
    var sales_rep_name = '{{$final_rep}}';
    const table = document.getElementById('tableExport');
    const rows = table.querySelectorAll('tr');
    const csvData = [];
    csvData.push('\uFEFF');
    const headerRow1 = ['', '', '', '', '', '', '', 'PPS AGRO FOODS - ERODE', '', '', '', '', '', '', ''];
    csvData.push(headerRow1.join(','));

    const headerRow2 = ['', '', '', '', '', '', '', 'RECEIPT REPORT', '', '', '', '', '', '', ''];
    csvData.push(headerRow2.join(','));

    const headerRow3 = ['FROM DATE', from_date, '', 'TO DATE', to_date, '', 'TALLY NO', tally_no, '', 'DISTRIBUTOR', sales_rep_name];
    csvData.push(headerRow3.join(','));

    const headerRow4 = [' '];
    csvData.push(headerRow4.join(','));

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const rowData = [];
        const cells = row.querySelectorAll('td, th');

        for (let j = 0; j < cells.length; j++) {
            const cellData = cells[j].textContent.trim();
            rowData.push(`"${cellData.replace(/"/g, '""')}"`);
        }

        csvData.push(rowData.join(','));
    }

    const csvContent = csvData.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const url = window.URL.createObjectURL(blob);

    const a = document.createElement('a');
    a.style.display = 'none';
    a.href = url;
    a.download = 'Receipt Reports.csv';

    document.body.appendChild(a);
    a.click();

    window.URL.revokeObjectURL(url);
}


    </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    function generatePDF() {
    var from_date = '{{$from_date}}';
    var to_date = '{{$to_date}}';
    const { jsPDF } = window.jspdf;


    var doc = new jsPDF('l', 'mm', [2500, 2050]);

    doc.setFontSize(30);
    doc.text("Receipt Entry Reports-{{$from_date}} TO {{$to_date}}", 15, 10);

    var headers = ['FROM DATE', from_date, 'TO DATE', to_date, 'SALES PERSON','DISTRIBUTOR'];
    var pdfjs = document.querySelector('#tableExport');

    doc.html(pdfjs, {
        callback: function(doc) {
            doc.save("Receipt Reports.pdf");
        },
        x: 10,
        y: 50
    });
}
function printTable() {
    const table = document.getElementById('tableExport');
    const printWindow = window.open('', '', 'width=1800,height=900');

    const headerRow1 = ['PPS AGRO FOODS - ERODE'];
    const headerRow2 = ['RECEIPT REPORT-{{$from_date}} TO {{$to_date}}'];

    printWindow.document.open();
    printWindow.document.write('<html><head><title>Print</title></head><body>');
    printWindow.document.write('<h1>Receipt Entry Reports </h1>');

    printWindow.document.write('<div style="display:flex;">');
    for (const header of headerRow1) {
        printWindow.document.write('<div style="flex:1; text-align:center;">' + header + '</div>');
    }
    printWindow.document.write('</div>');

    printWindow.document.write('<div style="display:flex;">');
    for (const header of headerRow2) {
        printWindow.document.write('<div style="flex:1; text-align:center;">' + header + '</div>');
    }
    printWindow.document.write('</div>');


    printWindow.document.write('</div>');

    printWindow.document.write(table.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
    printWindow.close();
}
</script>
