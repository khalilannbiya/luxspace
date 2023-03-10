<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaction &raquo; #{{ $transaction->id }} {{ $transaction->name }}
        </h2>
    </x-slot>

    <x-slot name="script">
        <script>
            // AJAX Datatable

            var datatable = $('#crudTable').DataTable({
                ajax:{
                    url:'{!! url()->current() !!}'
                },
                columns:[
                    {data:'id', name:'id', width:'5%'},
                    {data:'product.name', name:'product.name'},
                    {data:'product.price', name:'product.price'},
                ]
            });
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mb-12 mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-lg text-gray-800 leading-tight mb-5">Transaction Details</h2>
            <div class="shadow overflow-hidden sm-rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6 overflow-x-auto">
                    <table class="table-auto w-full bg-gray-200 rounded-lg">
                        <tbody>
                            <tr class="transition duration-300 hover:duration-300 bg-gray-50 hover:bg-gray-200">
                                <td class="border px-4 py-2 font-bold w-1/4">Nama</td>
                                <td class="border px-4 py-2">{{ $transaction->name }}</td>
                            </tr>
                            <tr class="transition duration-300 hover:duration-300 bg-gray-50 hover:bg-gray-200">
                                <td class="border px-4 py-2 font-bold w-1/4">Email</td>
                                <td class="border px-4 py-2">{{ $transaction->email }}</td>
                            </tr>
                            <tr class="transition duration-300 hover:duration-300 bg-gray-50 hover:bg-gray-200">
                                <td class="border px-4 py-2 font-bold w-1/4">Address</td>
                                <td class="border px-4 py-2">{{ $transaction->address }}</td>
                            </tr>
                            <tr class="transition duration-300 hover:duration-300 bg-gray-50 hover:bg-gray-200">
                                <td class="border px-4 py-2 font-bold w-1/4">Phone</td>
                                <td class="border px-4 py-2">{{ $transaction->phone }}</td>
                            </tr>
                            <tr class="transition duration-300 hover:duration-300 bg-gray-50 hover:bg-gray-200">
                                <td class="border px-4 py-2 font-bold w-1/4">Courier</td>
                                <td class="border px-4 py-2">{{ $transaction->courier }}</td>
                            </tr>
                            <tr class="transition duration-300 hover:duration-300 bg-gray-50 hover:bg-gray-200">
                                <td class="border px-4 py-2 font-bold w-1/4">Payment</td>
                                <td class="border px-4 py-2">{{ $transaction->payment }}</td>
                            </tr>
                            <tr class="transition duration-300 hover:duration-300 bg-gray-50 hover:bg-gray-200">
                                <td class="border px-4 py-2 font-bold w-1/4">Payment URL</td>
                                <td class="border px-4 py-2">{{ $transaction->payment_url }}</td>
                            </tr>
                            <tr class="transition duration-300 hover:duration-300 bg-gray-50 hover:bg-gray-200">
                                <td class="border px-4 py-2 font-bold w-1/4">Total Price</td>
                                <td class="border px-4 py-2">{{ number_format($transaction->total_price) }}</td>
                            </tr>
                            <tr class="transition duration-300 hover:duration-300 bg-gray-50 hover:bg-gray-200">
                                <td class="border px-4 py-2 font-bold w-1/4">Status</td>
                                <td class="border px-4 py-2">{{ $transaction->status }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-lg text-gray-800 leading-tight mb-5">Transaction Items</h2>
            <div class="shadow overflow-hidden sm-rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Produk</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>