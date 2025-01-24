<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ __('custom.pdf') }}</title>
    <style>
        .ic-table-money-relatad {
            padding: 20px 0;
            color: #000;
        }

        .ic-table-money-relatad.text-right {
            text-align: right;
        }

        .ic-table-money-relatad.text-right.ic-table-font-big {
            font-size: 25px;
        }

        .ic-table-td-style {
            padding: 20px 0;
            color: #8C8D8E;
        }

        .ic-table-th {
            text-align: left;
            padding: 20px 0;
            border-bottom: 1px solid #EBEBEB;
            border-top: 1px solid #EBEBEB;
        }

        .ic-table-th.ic-table-th-text-right {
            text-align: right;
        }

        .ic-table-th.ic-table-th-text-center {
            text-align: center;
        }

        .ic-table-fixed-layout {
            table-layout: fixed;
        }

        .ic-table-tr-td-text {
            color: #8C8D8E;
            margin: 0
        }

        .ic-invoice-table-heads {
            padding-bottom: 30px;
            padding-top: 10px;
        }

        .ic-table-td {
            text-align: left;
        }

        .ic-table-td-right {
            text-align: right;
        }

        .ic-table-text-right {
            padding: 2px;
            color: #000;
            text-align: right;
        }

        .ic-table-inner-td {
            padding: 2px;
            color: #000;
            margin-bottom: 0;
        }

        .ic-top-table-heads {
            border-bottom: 1px solid #EBEBEB;
            padding-bottom: 10px;
        }

        .ic-table-app-name {
            text-align: left;
            font-size: 25px;
            color: #606770;
        }

        .text-right {
            text-align: right
        }

        /* report pdf */
        .ic-main-table {
            width: 100%;
        }

        .ic-table-td {
            padding: 5px;
            font-size: 14px;
        }

        .ic-custom-date {
            width: 15%;
        }

        .ic-custom-title {
            width: 25%;
        }

    </style>
</head>

<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="ic-top-table-heads">
                <tr>
                    <td>
                        @if(config('is_logo_show_in_invoice') == 'yes')
                        <img src="{{ site_logo() }}" class="ic-logo-height" width="100" alt="logo">
{{--                        <p class="ic-table-app-name">{{ Config::get('app.name', 'Laravel') }}</p>--}}
                            @endif
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="ic-invoice-table-heads">
    <tr>
        <td class="ic-table-td">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td class="ic-table-inner-td">
                        <P class="ic-table-inner-td"><b>{{ __('custom.billing_to') }}:</b></P>
                        <p class="ic-table-tr-td-text">{{ @$data->billing_info['name'] ?? '' }}</p>
                        <p class="ic-table-tr-td-text">{{ @$data->billing_info['email'] ?? '' }}</p>
                        <p class="ic-table-tr-td-text">{{ @$data->billing_info['phone_number'] ?? '' }}</p>
                        <p class="ic-table-tr-td-text">{{ @$data->billing_info['address_line_1'] ?? '' }}</p>
                        <p class="ic-table-tr-td-text">{{ @$data->billing_info['address_line_2'] ?? '' }}</p>
                        <p class="ic-table-tr-td-text">{{ @$data->billing_info['zip'] ?? '' }},
                            {{ @$data->billing_info['city'] ?? ''}},
                            {{ @$data->billing_info['state'] ?? ''}}, {{ @$data->billing_info['country'] ?? ''}}</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="ic-table-td">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td class="ic-table-inner-td">
                        <P class="ic-table-inner-td"><b>{{ __('custom.shipped_to') }}:</b></P>
                        <p class="ic-table-tr-td-text">{{ @$data->billing_info['name'] ?? '' }}</p>
                        <p class="ic-table-tr-td-text">{{ @$data->billing_info['email'] ?? '' }}</p>
                        <p class="ic-table-tr-td-text">{{ @$data->billing_info['phone_number'] ?? '' }}</p>
                        <p class="ic-table-tr-td-text">{{ @$data->billing_info['address_line_1'] ?? '' }}</p>
                        <p class="ic-table-tr-td-text">{{ @$data->billing_info['address_line_2'] ?? '' }}</p>
                        <p class="ic-table-tr-td-text">{{ @$data->billing_info['zip'] ?? '' }},
                            {{ @$data->billing_info['city'] ?? ''}},
                            {{ @$data->billing_info['state'] ?? ''}}, {{ @$data->billing_info['country'] ?? ''}}</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="ic-table-td-right" valign="top">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td class="ic-table-text-right">
                        <P class="ic-table-inner-td"><b>{{ __('custom.invoice') }}:</b></P>
                        <p class="ic-table-tr-td-text">{{ __('custom.invoice_id') }} : {{ make8digits($data->id)
                            }}</p>
                        <p class="ic-table-tr-td-text">{{ __('custom.status') }}: {{
                            \App\Models\Invoice::INVOICE_ALL_STATUS[$data->status] }}</p>
                        <p class="ic-table-tr-td-text">{{ __('custom.delivery_status') }}: {{ucfirst($data->delivery_status) }}</p>
                        <p class="ic-table-tr-td-text">{{ __('custom.date') }}: {{ custom_date($data->date) }}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="ic-invoice-table-heads">
    <tr>
    </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="ic-invoice-table-heads">
    <tr>
        <td class="ic-table-td">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td class="ic-table-inner-td"><b>{{ __('custom.summary') }}</b></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="ic-invoice-table-heads">
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="ic-table-fixed-layout">
                <thead>
                <tr>
                    <th class="ic-table-th">
                        {{ __('custom.sku') }}</th>
                    <th class="ic-table-th" width="40%">
                        {{ __('custom.name') }}</th>
                    <th class="ic-table-th">
                        {{ __('custom.quantity') }}</th>
                    <th class="ic-table-th">
                        {{ __('custom.price') }}</th>
                    <th class="ic-table-th">
                        {{ __('custom.discount') }}</th>
                    <th class="ic-table-th ic-table-th-text-right">
                        {{ __('custom.sub_total') }}</th>
                </tr>
                </thead>
                <tbody>
                @if (isset($data->items))
                    @foreach ($data->items as $item)
                        <tr>
                            <td class="ic-table-td-style">
                                <b>{{ $item->sku ?? '' }}</b>
                            </td>
                            <td width="40%" class="ic-table-td-style">
                                <b>{{ $item->product_name ?? '' }}</b>
                                @if($item->product->is_variant != null && $item->product->is_variant == 1 && isset($item->productStock))
                                    ({{optional(optional($item->productStock)->attribute)->name ?? ''}} : {{optional(optional($item->productStock)->attributeItem)->name ?? ''}})
                                @endif
                            </td>
                            <td>
                                <b>{{ $item->quantity ?? '' }}</b>
                            </td>
                            <td class="ic-table-td-style">
                                <b>{{ currencySymbol().make2decimal($item->price) ?? '' }}</b>
                            </td>
                            <td class="ic-table-td-style">
                                <b>{{ $data->discount }}
                                    @if($data->discount_type ==
                                    \App\Models\Invoice::DISCOUNT_PERCENT)
                                        %
                                    @endif</b>
                            </td>
                            <td class="ic-table-td-style">
                                <b>{{ currencySymbol().make2decimal($item->sub_total) ?? '' }}</b>
                            </td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <td colspan="4"></td>
                    <td class="ic-table-money-relatad"><b>{{ __('custom.discount') }}</b></td>
                    <td class="ic-table-money-relatad text-right">
                        <b>{{ currencySymbol().make2decimal($data->discount_amount) }}</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td class="ic-table-money-relatad"><b>{{ __('custom.tax') }}</b></td>
                    <td class="ic-table-money-relatad text-right">
                        <b>{{
                                currencySymbol().make2decimal($data->tax_amount) }}</b>
                    </td>
                </tr>

                <tr>
                    <td colspan="4"></td>
                    <td class="ic-table-money-relatad"><b>{{ __('custom.total') }}</b></td>
                    <td class="ic-table-money-relatad text-right ic-table-font-big">
                        <b>{{
                                currencySymbol().make2decimal($data->total) }}</b>
                    </td>
                </tr>

                <tr>
                    <td colspan="4"></td>
                    <td class="ic-table-money-relatad"><b>{{ __('custom.total_paid') }}</b></td>
                    <td class="ic-table-money-relatad text-right ic-table-font-big">
                        <b>{{
                                currencySymbol().make2decimal($data->total_paid) }}</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td class="ic-table-money-relatad"><b>{{ __('custom.sale_return_amount') }}</b></td>
                    <td class="ic-table-money-relatad text-right ic-table-font-big">
                        <b>{{
                                currencySymbol().make2decimal($data->saleReturns()->sum('return_total_amount')) }}</b>
                    </td>
                </tr>

                <tr>
                    <td colspan="4"></td>
                    <td class="ic-table-money-relatad"><b>{{ __('custom.total_due') }}</b></td>
                    <td class="ic-table-money-relatad text-right ic-table-font-big">
                        <b>{{
                                currencySymbol().make2decimal(calculateDue($data->total,
                                $data->total_paid)) }}</b>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="6">Note: {{ $data->notes }}</td>
                </tr>
                </tfoot>
            </table>
        </td>
    </tr>
</table>
</body>

</html>
