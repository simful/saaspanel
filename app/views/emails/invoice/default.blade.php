<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="initial-scale=1.0"><!-- So that mobile webkit will display zoomed in -->
        <meta name="format-detection" content="telephone=no"><!-- disable auto telephone linking in iOS -->
        <title>
            New invoice #{{ $invoice->id }} from {{ $company_name }}
        </title>
        <style type="text/css">

        /* Resets: see reset.css for details */
        .ReadMsgBody { width: 100%; background-color: #ebebeb;}
        .ExternalClass {width: 100%; background-color: #ebebeb;}
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}
        body {-webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
        body {margin:0; padding:0;}
        table {border-spacing:0;}
        table td {border-collapse:collapse;}
        .yshortcuts a {border-bottom: none !important;}


        /* Constrain email width for small screens */
        @media screen and (max-width: 600px) {
        table[class="container"] {
        width: 95% !important;
        }
        }

        /* Give content more room on mobile */
        @media screen and (max-width: 480px) {
        td[class="container-padding"] {
        padding-left: 12px !important;
        padding-right: 12px !important;
        }
        }


        /* Styles for forcing columns to rows */
        @media only screen and (max-width : 600px) {

        /* force container columns to (horizontal) blocks */
        td[class="force-col"] {
            display: block;
            padding-right: 0 !important;
        }
        table[class="col-2"] {
            /* unset table align="left/right" */
            float: none !important;
            width: 100% !important;

            /* change left/right padding and margins to top/bottom ones */
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #eee;
        }

        /* remove bottom border for last column/row */
        table[id="last-col-2"] {
            border-bottom: none !important;
            margin-bottom: 0;
        }

        /* align images right and shrink them a bit */
        img[class="col-2-img"] {
            float: right;
            margin-left: 6px;
            max-width: 130px;
        }
        }


        </style>
    </head>
    <body style="margin:0; padding:10px 0;" bgcolor="#EBEBEB" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <br>
        <!-- 100% wrapper (grey background) -->
        <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#EBEBEB">
            <tr>
                <td align="center" valign="top" bgcolor="#EBEBEB" style="background-color: #ebebeb;">
                    <!-- 600px container (white background) -->
                    <table border="0" width="600" cellpadding="0" cellspacing="0" class="container" bgcolor="#FFFFFF">
                        <tr>
                            <td class="container-padding" bgcolor="#FFFFFF" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 13px; line-height: 20px; font-family: Helvetica, sans-serif; color: #333;" align="left">
                                <br>
                                Dear {{ $customer->full_name }},<br>
                                {{ $company_name }} has sent you an invoice with the following details:
                            </td>
                        </tr>

                        <tr>
                            <td class="container-padding" bgcolor="#FFFFFF" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 14px; line-height: 20px; font-family: Helvetica, sans-serif; color: #333;">
                                <br>
                                <div style="font-weight: bold; font-size: 18px; line-height: 24px; color: #D03C0F;">
                                    Invoice #{{ $invoice->id }}
                                </div><br>
                                <table border="0" cellpadding="0" cellspacing="0" class="columns-container">
                                    <tr>
                                        <td class="force-col" style="padding-right: 20px;" valign="top">
                                            <!-- ### COLUMN 1 ### -->
                                            <table border="0" cellspacing="0" cellpadding="0" width="260" align="left" class="col-2">
                                                <tr>
                                                    <td align="left" valign="top" style="font-size:13px; line-height: 20px; font-family: Arial, sans-serif;">
                                                        <span style="color:#2469A0; font-weight:bold">{{ $customer->full_name }}</span><br>
                                                        {{ $customer->address_1 }}<br>
                                                        {{ $customer->address_2 }}<br>
                                                        {{ $customer->phone }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="force-col" valign="top">
                                            <!-- ### COLUMN 2 ### -->
                                            <table border="0" cellspacing="0" cellpadding="0" width="260" align="right" class="col-2" id="last-col-2">
                                                <tr>
                                                    <td align="left" valign="top" style="font-size:13px; line-height: 20px; font-family: Arial, sans-serif;">
                                                        <span style="color:#2469A0; font-weight:bold">Invoice #{{ $invoice->id }}</span><br>
                                                        Invoice Date: {{ $invoice->created_at }}<br>
                                                        Due Date: {{ $invoice->due_date }}<br>
                                                        Status: {{ $invoice->status }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table><!--/ end .columns-container-->
                            </td>
                        </tr>
                        <tr>
                            <td class="container-padding" bgcolor="#FFFFFF" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 13px; line-height: 20px; font-family: Helvetica, sans-serif; color: #333;" align="left">
                                <br>
                                <div style="font-weight: bold; font-size: 18px; line-height: 24px; color: #D03C0F; border-top: 1px solid #ddd;">
                                    <br>
                                    Items
                                </div><br>
                                <table>
                                    <tr>
                                        <td width="380" style="font-weight: bold; border-bottom: 1px solid #ccc">Item</td>
                                        <td width="80" style="font-weight: bold; border-bottom: 1px solid #ccc">Qty</td>
                                        <td width="140" style="font-weight: bold; border-bottom: 1px solid #ccc">Sub Total</td>
                                    </tr>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td width="380" style="border-bottom: 1px solid #eee">{{ $item->description }}</td>
                                            <td width="80" style="border-bottom: 1px solid #eee">{{ $item->quantity }}</td>
                                            <td width="140" style="text-align: right; border-bottom: 1px solid #eee">{{ $item->quantity * $item->unit_price }}</td>
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="2" style="text-align: right; font-weight: bold">Sub Total</td>
                                        <td width="140" style="text-align: right; font-weight: bold">$ 30.00</td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" style="text-align: right">Tax</td>
                                        <td width="140" style="text-align: right">$ 0.00</td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" style="text-align: right; font-weight: bold">Grand Total</td>
                                        <td width="140" style="text-align: right; font-weight: bold">$ 30.00</td>
                                    </tr>
                               </table>

                               <br>

                            </td>
                        </tr>

                        <tr>
                            <td class="container-padding" bgcolor="#FFFFFF" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 13px; line-height: 20px; font-family: Helvetica, sans-serif; color: #333; padding-bottom: 20px" align="left">
                                <br>
                                To pay this invoice, please login to <a href="">Client Area</a>.
                            </td>
                        </tr>

                        <tr>
                            <td class="container-padding" bgcolor="#FFFFFF" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 13px; line-height: 20px; font-family: Helvetica, sans-serif; color: #333; padding-bottom: 20px" align="left">
                                <br>
                                Best Regards,<br>
                                {{ $company_name }}
                            </td>
                        </tr>

                         <tr>
                            <td class="container-padding" bgcolor="#FFFFFF" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 13px; line-height: 20px; font-family: Helvetica, sans-serif; color: #777; padding-bottom: 20px; font-size: 12px" align="left">
                                <br>
                                This invoice is sent using Simbill, an open source billing system.<br>
                                You are receiving this e-mail because you are registered as customer.<br>
                            </td>
                        </tr>
                    </table><!--/600px container -->
                </td>
            </tr>
        </table><!--/100% wrapper-->
        <br>
        <br>
    </body>
</html>