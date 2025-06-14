<!doctype html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @vite(['resources/css/invoice.css'])
</head>

<body>
    @php
        $totalGoldQty = 0;
        $totalDiamondQty = 0;
        $totalColorQty = 0;
        $totalItemQty = 0;
        $itemTotalAmount = 0;
    @endphp
    <div class="tax-invoice">
        <div class="invoice-header">
            <h1>TAX INVOICE</h1>
        </div>

        <div class="invoice-info">
            <div class="company-info">
                <div class="comapny-detail">
                    <h2>{{ $storeData->company_name }}</h2>
                    <p>{{ $storeData->address }}</p>
                    {{-- <p>info@dhaddadiamonds.com</p> --}}
                </div>
                <div class="dispatch-address">
                    <p><strong>Dispatched Address:</strong></p>
                    {{-- <p>S. A. N. Chambers, 130, Turner Road, Bandra(West), Mumbai 400050<br>Contact : 9892627798 /
                            9969409931
                        </p> --}}
                    <p>{{ $invoice->customer_address }}</p>
                </div>
            </div>

            <div class="invoice-details">
                <table>
                    <tbody>
                        <tr class="invoice-no">
                            <td>Invoice No :</td>
                            <td>{{ $invoice->invoice_no }}</td>
                        </tr>
                        <tr class="invoice-date">
                            <td>Date :</td>
                            <td>{{ $invoice->purchase_date }}</td>
                        </tr>

                        <tr class="ref-no">
                            <td>Reference No :</td>
                            <td></td>
                        </tr>
                        <tr class="gstin-no">
                            <td>GST TIN No :</td>
                            <td>{{ $storeData->gstin }}</td>
                        </tr>
                        <tr class="pan-no">
                            <td>PAN No :</td>
                            <td>{{ $storeData->pan_no }}</td>
                        </tr>
                        <tr class="state-code">
                            <td>State Code :</td>
                            <td>{{ $storeData->state_code }}</td>
                        </tr>
                        <tr class="district-code">
                            <td>District Code :</td>
                            <td>{{ $storeData->district_code }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="customer-info">
            <div class="customer-details">
                <table>
                    <tbody>
                        <tr>
                            <td>Name :</td>
                            <td>{{ $invoice->customer_name }}</td>
                        </tr>
                        <tr>
                            <td>Address :</td>
                            <td>{{ $invoice->customer_address }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="customer-tax-details">
                <table>
                    <tbody>
                        <tr>
                            <td>Reference :</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>GST TIN No :</td>
                            <td>{{ $invoice->customer_gstin }}</td>
                        </tr>
                        <tr>
                            <td>PAN No :</td>
                            <td>{{ $invoice->customer_pan }}</td>
                        </tr>
                        <tr>
                            <td>Terms :</td>
                            <td>C.O.D</td>
                        </tr>
                        <tr>
                            <td>Place of Supply :</td>
                            <td>Mumbai</td>
                        </tr>
                        <tr>
                            <td>Terms of Delivery :</td>
                            <td>Hand Delivery</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="invoice-items">
            <table>
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Description</th>
                        {{-- <th>HSN Code</th> --}}
                        <th>Qty.</th>
                        {{-- <th>Gross Qty. (Grams/Carrat)</th> --}}
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $invoiceItem)
                        @php
                            $totalGoldQty += $invoiceItem->product->gold_qty ?? 0;
                            $totalDiamondQty += $invoiceItem->product->diamond_qty ?? 0;
                            $totalColorQty += $invoiceItem->product->color_stone_qty ?? 0;
                            $totalItemQty += $invoiceItem->quantity ?? 0;
                            $itemTotalAmount += $invoiceItem->total ?? 0;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="description">{{ $invoiceItem->product->name }}<br>
                                {{ $invoiceItem->product->gold_qty > 0 ? 'Gold (' . $invoiceItem->product->gold_qty . ' Gram ' . $invoiceItem->product->gold_carat . ')' : '' }}</br>
                                {{ $invoiceItem->product->diamond_qty > 0 ? 'DIAMOND (' . $invoiceItem->product->diamond_qty . ' KT)' : '' }}</br>
                                {{ $invoiceItem->product->color_stone_qty > 0 ? 'Color Stone (' . $invoiceItem->product->color_stone_qty . ' KT)' : '' }}</br>
                            </td>
                            {{-- <td></td> --}}
                            <td>{{ $invoiceItem->quantity }} PCS</td>
                            {{-- <td>18.115</td> --}}
                            <td class="amount">{{ $invoiceItem->total }}</td>
                        </tr>
                    @endforeach

                    {{-- <tr>
                        <td>1</td>
                        <td class="description">RING<br>Gold (GOLD 14KT)<br>Diamond</td>
                        <td>71131913</td>
                        <td>1 PCS</td>
                        <td>18.115</td>
                        <td class="amount">145,632.00</td>
                    </tr> --}}
                    <tr>
                        <td>TOTAL</td>
                        <td class="description">

                            <p>GLD = {{ $totalGoldQty }} Gram</p>
                            <p>DIA = {{ $totalDiamondQty }} KT</p>
                            <p>CS = {{ $totalColorQty }} KT</p>

                        </td>
                        {{-- <td></td> --}}

                        {{-- <td></td> --}}
                        <td>{{ $totalItemQty }} PCS</td>
                        {{-- <td>18.115</td> --}}
                        <td class="amount">{{ round($itemTotalAmount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="invoice-summary">
            <div class="totals-left">
                {{-- <table>
                        <tbody>
                            <tr>
                                <td>TOTAL</td>
                                <td class="description">GLD = 17.370 gm</td>
                                <td>DIA = 0.730 ct</td>
                                <td>1.000</td>
                                <td>18.115</td>
                                <td class="amount">145,632.00</td>
                            </tr>
                        </tbody>
                    </table> --}}

                <div class="bank-details">
                    <p>Please Remit to Our Bank A/C No: {{ $storeData->bank_account_no }},</p>
                    <p>IFSC Code: {{ $storeData->bank_ifsc_code }},</p>
                    <p>A/C With: {{ $storeData->bank_name }}</p>
                </div>
            </div>

            <div class="tax-summary">
                @php
                    $cgstAmount = round(($itemTotalAmount * $invoice->cgst_percent) / 100, 2);
                    $sgstAmount = round(($itemTotalAmount * $invoice->sgst_percent) / 100, 2);
                    $igstAmount = round(($itemTotalAmount * $invoice->igst_percent) / 100, 2);
                @endphp
                <table>
                    <tbody>
                        <tr>
                            <td>CGST {{ $invoice->cgst_percent }} %</td>
                            <td>{{ $cgstAmount }}</td>
                        </tr>
                        <tr>
                            <td>SGST {{ $invoice->sgst_percent }} %</td>
                            <td>{{ $sgstAmount }}</td>
                        </tr>
                        <tr>
                            <td>IGST {{ $invoice->igst_percent }} %</td>
                            <td>{{ $igstAmount }}</td>
                        </tr>
                        <tr class="grand-total">
                            <td>Gr. Total</td>
                            <td>{{ round($itemTotalAmount + $cgstAmount + $sgstAmount + $igstAmount, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="amount-in-words">
            {{-- <p><strong>Amount In Words:</strong> Rupees One Lakh Fifty Thousand Only</p> --}}
            <p class="terms">Goods Sold And Delivered At: {{ $storeData->city_location }}</p>
            <p class="terms">
                We hereby certify that our registration certificate under the Goods and Service Tax Act, 2017 is in
                force on
                the date on which the sale of the
                specified in this Tax Invoice is made by us and that the transaction of sale covered by This Invoice
                has
                been effected by us and it shall be
                account for in the turnover of sales while filing of return and the due tax, if any, payable on the
                sale
                has
                been paid or shall be paid.
            </p>
            <p class="terms">
                No E-way bill is required to be generated as the goods covered under this invoice are exempted as
                per
                serial
                number 5 of the Annexure to Rule 138
                (14) of the CGST Rules, 2017
            </p>
            <p class="terms">The Invoice is exclusive of all other taxes and levies which will be collected if
                applicable</p>

        </div>

        {{-- <div class="delivery-info">
                <p>Goods Sold And Delivered At: MUMBAI</p>
            </div> --}}

        {{-- <div class="gst-declaration">
                <p>
                    We hereby certify that our registration certificate under the Goods and Service Tax Act, 2017 is in
                    force on
                    the date on which the sale of the
                    specified in this Tax Invoice is made by us and that the transaction of sale covered by This Invoice
                    has
                    been effected by us and it shall be
                    account for in the turnover of sales while filing of return and the due tax, if any, payable on the
                    sale
                    has
                    been paid or shall be paid.
                </p>
                <p>
                    No E-way bill is required to be generated as the goods covered under this invoice are exempted as
                    per
                    serial
                    number 5 of the Annexure to Rule 138
                    (14) of the CGST Rules, 2017
                </p>
            </div> --}}

        <div class="invoice-footer">
            <div class="jurisdiction">
                {{-- <p>The Invoice is exclusive of all other taxes and levies which will be collected if applicable</p> --}}
                <p>Subject to {{ $storeData->city_location }} Jurisdiction</p>
            </div>

            <div class="signature">
                <p>For : {{ $storeData->company_name }}</p>
                <div class="signature-line"></div>
                <p>Authorized Signatory</p>
            </div>
        </div>

        <div class="duplicate-copy">
            <p>Office Copy</p>
        </div>
    </div>


    <div class="page-break"></div>

    <div class="tax-invoice">
        <div class="invoice-header">
            <h1>TAX INVOICE</h1>
        </div>

        <div class="invoice-info">
            <div class="company-info">
                <div class="comapny-detail">
                    <h2>{{ $storeData->company_name }}</h2>
                    <p>{{ $storeData->address }}</p>
                    {{-- <p>info@dhaddadiamonds.com</p> --}}
                </div>
                <div class="dispatch-address">
                    <p><strong>Dispatched Address:</strong></p>
                    {{-- <p>S. A. N. Chambers, 130, Turner Road, Bandra(West), Mumbai 400050<br>Contact : 9892627798 /
                            9969409931
                        </p> --}}
                    <p>{{ $invoice->customer_address }}</p>
                </div>
            </div>

            <div class="invoice-details">
                <table>
                    <tbody>
                        <tr class="invoice-no">
                            <td>Invoice No :</td>
                            <td>{{ $invoice->invoice_no }}</td>
                        </tr>
                        <tr class="invoice-date">
                            <td>Date :</td>
                            <td>{{ $invoice->purchase_date }}</td>
                        </tr>

                        <tr class="ref-no">
                            <td>Reference No :</td>
                            <td></td>
                        </tr>
                        <tr class="gstin-no">
                            <td>GST TIN No :</td>
                            <td>{{ $storeData->gstin }}</td>
                        </tr>
                        <tr class="pan-no">
                            <td>PAN No :</td>
                            <td>{{ $storeData->pan_no }}</td>
                        </tr>
                        <tr class="state-code">
                            <td>State Code :</td>
                            <td>{{ $storeData->state_code }}</td>
                        </tr>
                        <tr class="district-code">
                            <td>District Code :</td>
                            <td>{{ $storeData->district_code }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="customer-info">
            <div class="customer-details">
                <table>
                    <tbody>
                        <tr>
                            <td>Name :</td>
                            <td>{{ $invoice->customer_name }}</td>
                        </tr>
                        <tr>
                            <td>Address :</td>
                            <td>{{ $invoice->customer_address }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="customer-tax-details">
                <table>
                    <tbody>
                        <tr>
                            <td>Reference :</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>GST TIN No :</td>
                            <td>{{ $invoice->customer_gstin }}</td>
                        </tr>
                        <tr>
                            <td>PAN No :</td>
                            <td>{{ $invoice->customer_pan }}</td>
                        </tr>
                        <tr>
                            <td>Terms :</td>
                            <td>C.O.D</td>
                        </tr>
                        <tr>
                            <td>Place of Supply :</td>
                            <td>Mumbai</td>
                        </tr>
                        <tr>
                            <td>Terms of Delivery :</td>
                            <td>Hand Delivery</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="invoice-items">
            <table>
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Description</th>
                        {{-- <th>HSN Code</th> --}}
                        <th>Qty.</th>
                        {{-- <th>Gross Qty. (Grams/Carrat)</th> --}}
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $invoiceItem)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="description">{{ $invoiceItem->product->name }}<br>
                                {{ $invoiceItem->product->gold_qty > 0 ? 'Gold (' . $invoiceItem->product->gold_qty . ' Gram ' . $invoiceItem->product->gold_carat . ')' : '' }}</br>
                                {{ $invoiceItem->product->diamond_qty > 0 ? 'DIAMOND (' . $invoiceItem->product->diamond_qty . ' KT)' : '' }}</br>
                                {{ $invoiceItem->product->color_stone_qty > 0 ? 'Color Stone (' . $invoiceItem->product->color_stone_qty . ' KT)' : '' }}</br>
                            </td>
                            {{-- <td></td> --}}
                            <td>{{ $invoiceItem->quantity }} PCS</td>
                            {{-- <td>18.115</td> --}}
                            <td class="amount">{{ $invoiceItem->total }}</td>
                        </tr>
                    @endforeach

                    {{-- <tr>
                        <td>1</td>
                        <td class="description">RING<br>Gold (GOLD 14KT)<br>Diamond</td>
                        <td>71131913</td>
                        <td>1 PCS</td>
                        <td>18.115</td>
                        <td class="amount">145,632.00</td>
                    </tr> --}}
                    <tr>
                        <td>TOTAL</td>
                        <td class="description">

                            <p>GLD = {{ $totalGoldQty }} Gram</p>
                            <p>DIA = {{ $totalDiamondQty }} KT</p>
                            <p>CS = {{ $totalColorQty }} KT</p>

                        </td>
                        {{-- <td></td> --}}

                        {{-- <td></td> --}}
                        <td>{{ $totalItemQty }} PCS</td>
                        {{-- <td>18.115</td> --}}
                        <td class="amount">{{ round($itemTotalAmount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="invoice-summary">
            <div class="totals-left">
                {{-- <table>
                        <tbody>
                            <tr>
                                <td>TOTAL</td>
                                <td class="description">GLD = 17.370 gm</td>
                                <td>DIA = 0.730 ct</td>
                                <td>1.000</td>
                                <td>18.115</td>
                                <td class="amount">145,632.00</td>
                            </tr>
                        </tbody>
                    </table> --}}

                <div class="bank-details">
                    <p>Please Remit to Our Bank A/C No: {{ $storeData->bank_account_no }},</p>
                    <p>IFSC Code: {{ $storeData->bank_ifsc_code }},</p>
                    <p>A/C With: {{ $storeData->bank_name }}</p>
                </div>
            </div>

            <div class="tax-summary">
                <table>
                    <tbody>
                        <tr>
                            <td>CGST {{ $invoice->cgst_percent }} %</td>
                            <td>{{ $cgstAmount }}</td>
                        </tr>
                        <tr>
                            <td>SGST {{ $invoice->sgst_percent }} %</td>
                            <td>{{ $sgstAmount }}</td>
                        </tr>
                        <tr>
                            <td>IGST {{ $invoice->igst_percent }} %</td>
                            <td>{{ $igstAmount }}</td>
                        </tr>
                        <tr class="grand-total">
                            <td>Gr. Total</td>
                            <td>{{ round($itemTotalAmount + $cgstAmount + $sgstAmount + $igstAmount, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="amount-in-words">
            {{-- <p><strong>Amount In Words:</strong> Rupees One Lakh Fifty Thousand Only</p> --}}
            <p class="terms">Goods Sold And Delivered At: {{ $storeData->city_location }}</p>
            <p class="terms">
                We hereby certify that our registration certificate under the Goods and Service Tax Act, 2017 is in
                force on
                the date on which the sale of the
                specified in this Tax Invoice is made by us and that the transaction of sale covered by This Invoice
                has
                been effected by us and it shall be
                account for in the turnover of sales while filing of return and the due tax, if any, payable on the
                sale
                has
                been paid or shall be paid.
            </p>
            <p class="terms">
                No E-way bill is required to be generated as the goods covered under this invoice are exempted as
                per
                serial
                number 5 of the Annexure to Rule 138
                (14) of the CGST Rules, 2017
            </p>
            <p class="terms">The Invoice is exclusive of all other taxes and levies which will be collected if
                applicable</p>

        </div>

        {{-- <div class="delivery-info">
                <p>Goods Sold And Delivered At: MUMBAI</p>
            </div> --}}

        {{-- <div class="gst-declaration">
                <p>
                    We hereby certify that our registration certificate under the Goods and Service Tax Act, 2017 is in
                    force on
                    the date on which the sale of the
                    specified in this Tax Invoice is made by us and that the transaction of sale covered by This Invoice
                    has
                    been effected by us and it shall be
                    account for in the turnover of sales while filing of return and the due tax, if any, payable on the
                    sale
                    has
                    been paid or shall be paid.
                </p>
                <p>
                    No E-way bill is required to be generated as the goods covered under this invoice are exempted as
                    per
                    serial
                    number 5 of the Annexure to Rule 138
                    (14) of the CGST Rules, 2017
                </p>
            </div> --}}

        <div class="invoice-footer">
            <div class="jurisdiction">
                {{-- <p>The Invoice is exclusive of all other taxes and levies which will be collected if applicable</p> --}}
                <p>Subject to {{ $storeData->city_location }} Jurisdiction</p>
            </div>

            <div class="signature">
                <p>For : {{ $storeData->company_name }}</p>
                <div class="signature-line"></div>
                <p>Authorized Signatory</p>
            </div>
        </div>

        <div class="duplicate-copy">
            <p>Customer Copy</p>
        </div>
    </div>
</body>

</html>
