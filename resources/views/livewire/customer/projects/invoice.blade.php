<div id="section-print" class="pg-container max-w-5xl space-y-6 py-6 px-6 bg-white">
    <div>
        <span x-data @click="printSection('section-print')" class="print:hidden text-secondary cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                        </span>
    </div>
    <div class="flex gap-4">
        <div class="flex-1">
            <img src="{{ asset('img/logo.png') }}" class="h-12 w-auto" />
        </div>
        <div class="flex-1 self-end">
            <span>Invoice</span>
        </div>
    </div>
    <div class="flex gap-4 pt-8">
        <div class="flex-1">
            <div class="font-bold">{{ __('B2E HUB PRIVATE LIMITED') }}</div>
            <div>No 87, S3, II Floor,<br />Sree Anantha Lakshmi Complex,<br />MTH Road, Ambattur Industrial Estate,<br />Chennai - 600050, Tamilnadu</div>
            <div class="pt-4">
                info@b2ehub.com<br />
                7094 010 010<br />
                {{ url('') }}
            </div>
            <div class="pt-4">
                GST NO<br />
                33AAKCB2374H1ZR
            </div>
        </div>
        <div class="flex-1">
            <div class="pb-4">CUSTOMER</div>
            <div class="font-bold">{{ $project->user->name }}</div>
            <div>{{ $project->manufacturing_unit->address.' - '.$project->manufacturing_unit->pincode }}</div>
            <div class="pt-4">{{ $project->user->email }}</div>
            <div class="pt-4">
                GST NO<br />
                {{ $project->user->gst_number }}
            </div>
        </div>
    </div>
    <div class="flex gap-4 pt-8">
        <div class="flex-1">
            <div class="flex gap-4">
                <strong>Invoice No.: </strong>
                <span>{{ $project->invoice_id }}</span>
            </div>
            <div class="flex gap-4">
                <strong>Invoice Date.: </strong>
                <span>{{ $project->transaction->paid_at->format('d M, Y') }}</span>
            </div>
        </div>
    </div>
    <table class="table table-compact">
        <thead>
        <tr>
            <td>Item</td>
            <td>HSN Code</td>
            <td>Rate</td>
            <td>Tax</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                {{ __('Service charge for Posting a project') }}<br />
                <strong>{{ $project->txn_id }}</strong>
            </td>
            <td>9983</td>
            <td>{{ config('app.currency_symbol').number_format($project->transaction->base_amount, 2) }}</td>
            <td>GST(18%)</td>
        </tr>
        </tbody>
    </table>

    <div class="flex gap-4 pt-4">
        <div class="flex-1">

        </div>
        <div class="flex-1 border-b border-t divide-y">
            <div class="w-full bg-gray-100 text-center p-2 font-bold">
                {{ __('Invoice summary') }}
            </div>
            <div class="flex justify-between py-2">
                <span>Project Fees</span>
                <span>{{ config('app.currency_symbol').number_format($project->transaction->base_amount, 2) }}</span>
            </div>
            <div class="flex justify-between py-2">
                <span>GST (18%)</span>
                <span>{{ config('app.currency_symbol').number_format($project->transaction->gst_amount, 2) }}</span>
            </div>
            <div class="flex justify-between py-2">
                <span>Total</span>
                <span>{{ config('app.currency_symbol').number_format($project->transaction->final_amount, 2) }}</span>
            </div>
        </div>
    </div>
    <div class="text-center">{{ __('This is a computer generated document. No signature is required') }}</div>
</div>
