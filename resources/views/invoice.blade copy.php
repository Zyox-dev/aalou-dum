<!doctype html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @vite(['resources/css/invoice.css'])
</head>

<body>
    <div class="tax-invoice">
        <div class="invoice-header">
            <h1>TAX INVOICE</h1>
        </div>

        <div class="invoice-info">
            <div class="company-info">
                <div class="comapny-detail">
                    <h2>Navya Jewels.</h2>
                    <p>Daga Sethia Parakh Mohalla</p>
                    <p>Bikaner -334001</p>
                    {{-- <p>info@dhaddadiamonds.com</p> --}}
                </div>
                <div class="dispatch-address">
                    <p><strong>Dispatched Address:</strong></p>
                    {{-- <p>S. A. N. Chambers, 130, Turner Road, Bandra(West), Mumbai 400050<br>Contact : 9892627798 /
                            9969409931
                        </p> --}}

                    <p>Navya Jewels, </p>
                    <p>Daga Sethia Parakh Mohalla,</p>
                    <p>Bikaner -334001</p>
                </div>
            </div>

            <div class="invoice-details">
                <table>
                    <tbody>
                        <tr class="invoice-no">
                            <td>Invoice No :</td>
                            <td>LBL8/25-08/0002</td>
                        </tr>
                        <tr class="invoice-date">
                            <td>Date :</td>
                            <td>08/08/2025</td>
                        </tr>

                        <tr class="ref-no">
                            <td>Reference No :</td>
                            <td></td>
                        </tr>
                        <tr class="gstin-no">
                            <td>GST TIN No :</td>
                            <td>27AACCD5599J1ZO</td>
                        </tr>
                        <tr class="pan-no">
                            <td>PAN No :</td>
                            <td>AACCD5599J</td>
                        </tr>
                        <tr class="state-code">
                            <td>State Code :</td>
                            <td>27</td>
                        </tr>
                        <tr class="district-code">
                            <td>District Code :</td>
                            <td>483</td>
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
                            <td>MS VAIBHAVI SHINDE</td>
                        </tr>
                        <tr>
                            <td>Address :</td>
                            <td>MUMBAI</td>
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
                            <td></td>
                        </tr>
                        <tr>
                            <td>PAN No :</td>
                            <td></td>
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
                        <th>HSN Code</th>
                        <th>Qty.</th>
                        <th>Gross Qty. (Grams)</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td class="description">RING<br>Gold (GOLD 14KT)<br>Diamond</td>
                        <td>71131913</td>
                        <td>1 PCS</td>
                        <td>18.115</td>
                        <td class="amount">145,632.00</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td class="description">RING<br>Gold (GOLD 14KT)<br>Diamond</td>
                        <td>71131913</td>
                        <td>1 PCS</td>
                        <td>18.115</td>
                        <td class="amount">145,632.00</td>
                    </tr>
                    <tr>
                        <td>TOTAL</td>
                        <td class="description">
                            <p>GLD = 17.370 gm</p>
                            <p>DIA = 0.730 ct</p>
                            <p>GLD = 17.370 gm</p>

                        </td>
                        <td></td>

                        {{-- <td></td> --}}
                        <td>1.000</td>
                        <td>18.115</td>
                        <td class="amount">145,632.00</td>
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
                    <p>Please Remit to Our Bank A/C No: 0082100100007980,</p>
                    <p>IFC Code: PUNB0008210,</p>
                    <p>A/C With: Punjab National Bank, KEM ROAD, DRM circle, Bikaner</p>
                </div>
            </div>

            <div class="tax-summary">
                <table>
                    <tbody>
                        <tr>
                            <td>CGST 1.500 %</td>
                            <td>2,184.00</td>
                        </tr>
                        <tr>
                            <td>SGST 1.500 %</td>
                            <td>2,184.00</td>
                        </tr>
                        <tr>
                            <td>IGST 0%</td>
                            <td>-</td>
                        </tr>
                        <tr class="grand-total">
                            <td>Gr. Total</td>
                            <td>150,000.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="amount-in-words">
            <p><strong>Amount In Words:</strong> Rupees One Lakh Fifty Thousand Only</p>
            <p class="terms">Goods Sold And Delivered At: MUMBAI</p>
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
                <p>Subject to MUMBAI Jurisdiction</p>
            </div>

            <div class="signature">
                <p>For : Navya Jewels</p>
                <div class="signature-line"></div>
                <p>Authorized Signatory</p>
            </div>
        </div>

        <div class="duplicate-copy">
            <p>Duplicate Copy</p>
        </div>
    </div>
</body>

</html>