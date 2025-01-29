@php
$authUser = auth()->guard('customer')->check();

@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('custom.invoice') }}: {{ make8digits($invoice->id) }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans&display=swap" rel="stylesheet">
</head>
<body style="align-items: center">
<table width="" cellspacing="0" cellpadding="2" border="1">
    <tbody>
    <tr>
        <td colspan="4" style="text-align: center">
            <h3 class="mt-0">
                @if(config('is_logo_show_in_invoice') == 'yes')
                <img src="{{ site_logo() }}" alt="logo" style="max-width: 60px; height: auto; display: block; margin: 0 auto;"> 
                @else
                <span style="font-size: 14px; font-weight: bold; text-decoration: underline;">{{ config('app.name') }}</span>
                @endif
            </h3>
            <p>KAABIZ BAKES PRIVATE LIMITED.<br>Sco 6, Sector 16, Panchkula, Haryana, 134109.<br>GST:
                06AALCK3315Q1Z4 <br> +91 9915708181 <br>sales@copperandcrumb.in</p>
            <hr style="border: 1px solid #000; width: 100%; margin: 5px auto;">
        </td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: center">
            <span style="font-size: 12px;">
                <strong>Customer:
                    @if($invoice->billing_info['name'])
                        {{ $invoice->billing_info['name'] ?? '' }}
                    @else
                        {{ __('custom.walk_in_customer') }}
                    @endif
                    <br>Invoice Id: {{ make8digits($invoice->id) }}
                    <br>Invoice Date: {{ date('Y-m-d H:i:s') }}
                    <br>Table No: {{ $invoice->table_number }}
                    <br>Cashier: {{ Auth::user()->name }}
                </strong>
            </span>
        </td>
    </tr>
    <tr style="">
        <td width="40%" style="border: 1px solid #333; text-align: left"><strong>{{ __('custom.item') }}</strong></td>
        <td width="20%" style="border: 1px solid #333; border-left: 0 none;text-align: center"><strong>{{ __('custom.price') }} <small>({{currencySymbol()}})</small></strong></td>
        <td width="15%" style="border: 1px solid #333; border-left: 0 none;text-align: center"><strong>{{ __('custom.qty') }}</strong></td>
        <td width="20%" style="border: 1px solid #333; border-left: 0 none;text-align: right"><strong>{{ __('custom.total') }} <small>({{currencySymbol()}})</small></strong>
        </td>
    </tr>
{{--    Loop area--}}
    @if ($invoice->items)
        @foreach ($invoice->items as $item)
        <tr>
            <td class="" style="border-left: 1px solid #333; border-right: 1px solid #333; text-align: left">
                {{ $item->product_name ?? '' }}
                @if($item->product->is_variant == 1 && isset($item->productStock))
                    ({{optional(optional($item->productStock)->attribute)->name ?? ''}} : {{optional(optional($item->productStock)->attributeItem)->name ?? ''}})
                @endif
            </td>
            <td class="" style="border-right: 1px solid #333; text-align: center">
                {{ make2decimal($item->price) ?? '' }}
            </td>
            <td class="" style="border-right: 1px solid #333; text-align: center">
                {{ $item->quantity }}
            </td>
            <td class="  " style="border-right: 1px solid #333; text-align: right"> {{ make2decimal($item->sub_total) ?? '' }}</td>
        </tr>
        @endforeach
    @endif
{{--    Loop Area End--}}
    <tr>
        <td colspan="2" style="border-top: 1px solid #333;text-align: right; font-weight: bold">{{ __('custom.discount') }}</td>
        <td colspan="2" style="border-top: 1px solid #333;text-align: right; font-weight: bold">{{ currencySymbol().make2decimal($invoice->discount_amount) }}</td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right; font-weight: bold">{{ __('custom.tax') }}</td>
        <td colspan="2" style="text-align: right; font-weight: bold">{{ currencySymbol().make2decimal($invoice->tax_amount) }}</td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right; font-weight: bold">{{ __('custom.total') }}</td>
        <td colspan="2" style="text-align: right; font-weight: bold">{{ currencySymbol().make2decimal($invoice->total) }}</td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right; font-weight: bold">{{ __('custom.total_paid') }}</td>
        <td colspan="2" style="text-align: right; font-weight: bold">{{ currencySymbol().make2decimal($invoice->total_paid) }}</td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right; font-weight: bold">{{ __('custom.sale_return_amount') }}</td>
        <td colspan="2" style="text-align: right; font-weight: bold">{{ currencySymbol().make2decimal($invoice->saleReturns()->sum('return_total_amount')) }}</td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right; font-weight: bold">{{ __('custom.total_due') }}</td>
        <td colspan="2" style="text-align: right; font-weight: bold">{{ currencySymbol().make2decimal(calculateDue($invoice->total, $invoice->total_paid)) }}</td>
    </tr>
    </tbody>
</table>

    <span style="text-align: left; font-weight: bold; margin-left:5px; margin-bottom:10px;">{{ __('custom.note') }} : {{ $invoice->notes }}</span>
<div class="no_print" style="overflow: hidden;">
    <br/>
    <button class="no_print btn backBtn" style="cursor: pointer;" onclick="history.back()">{{ __('custom.back') }}</button>
    <a onclick="location.reload();" class="no_print btn reprintBtn" href="javascript:">Print Again</a>
</div>
<style type="text/css">
    .btn {
        padding: 10px;
        text-decoration: none;
        color: #fff;
        display: inline-block;
    }

    .backBtn {
        background-color: #1221ff;
    }

    .ic-border-bottom {
        border-bottom: 1px solid #dedede;
    }

    .reprintBtn {
        background-color: #09ff88;
    }

    @media print {
        @page {
            margin: 0;
        }

        table {
            width: 2.5in;
            margin-bottom: 20px;
            margin-left:8%;
        }

        table td {
            border-collapse: collapse;
        }

        .no_print {
            display: none
        }
        * {
            font-size: 13px !important;
            word-wrap: break-word;
            font-family: 'Roboto', sans-serif;
        }
        h1{
            font-size: 20px !important;
        }
    }
</style>
<script type="text/javascript">
    window.print();
</script>

</body>
</html>
