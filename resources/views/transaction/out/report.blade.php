<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report</title>
</head>
<body>

<table style="width:100%;"  >
    <tr>
        <td>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%;">
                        <h3 style="text-align: center; margin-bottom:0; text-decoration: underline;">NOTA FAKTUR</h3>
                        <p style="text-align: center; margin-top:2px; ">NO: {{$transaction[0]['transaction_id']}}</p>
                        <table style="width: 100%;">
                            <tr>
                                <td>SALES</td>
                                <td>:</td>
                                <td>{{$transaction[0]['transaction_user_name']}}</td>
                            </tr>
                            <tr>
                                <td>NO PO CUST</td>
                                <td>:</td>
                                <td>NO PO CUST</td>
                            </tr>
                            <tr>
                                <td>JATUH TEMPO</td>
                                <td>:</td>
                                <td>TANGGAL JATUH TEMPO</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 50%;">
                        <p>JAKARTA, {{date('d-M-Y H:i:s')}}</p>
                        <p style="font-weight: bold; text-decoration: underline;">Kepada Yth:</p>
                        <p>
<pre>
{{$transaction[0]['transaction_recipient']}}
</pre>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr >
        <td>
            <table style="width:100%; border: 1px solid black;">
                <tr>
                    <th style="text-align: left;" >No.</th>
                    <th style="text-align: left;" >NAMA BARANG</th>
                    <th style="text-align: left;" >JUMLAH/SATUAN</th>
                    <th style="text-align: left;" >HRG SATUAN</th>
                    <th style="text-align: left;" >DISKON</th>
                    <th style="text-align: left;" >TOTAL HRG</th>
                </tr>
                @foreach($transaction[0]['transaction_details'] as $transactionDetail)
                    <tr>
                        <td>1</td>
                        <td>{{$transactionDetail['product_name']}}</td>
                        <td>{{$transactionDetail['product_quantity']}}</td>
                        <td>Rp{{number_format($transactionDetail['product_price'],0,',','.')}}</td>
                        <td>0%</td>
                        <td>
                            Rp{{number_format($transactionDetail['product_price']*$transactionDetail['product_quantity'],0,',','.')}}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" style="height: 40px; vertical-align: bottom" >
                        Terbilang: {{$transaction[0]['transaction_total_text']}} Rupiah
                    </td>
                    <td style="vertical-align: bottom">
                        Rp{{number_format($transaction[0]['transaction_total'],0,',','.')}}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="height: 150px; vertical-align: bottom">
            <table style="width: 100%;" >
                <tr style="text-align:center;" >
                    <td style="width: 25%;">
                        Tanda Terima
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        (..............................................)
                    </td>
                    <td style="width: 50%;"></td>
                    <td style="width: 25%;">
                        Hormat Kami
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        (..............................................)
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>