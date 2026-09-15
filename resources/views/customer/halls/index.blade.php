<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Wedding Halls</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="min-h-screen bg-gray-50">


    <div class="max-w-7xl mx-auto px-6 py-10">


        {{-- Header --}}
        <div class="flex items-center justify-between gap-4">

            <div>

                <h1 class="text-3xl font-bold text-gray-900">
                    Wedding Halls
                </h1>

                <p class="mt-2 text-gray-600">
                    Find the perfect hall for your wedding
                </p>

            </div>


            {{-- My Reservations --}}
            <a
                href="{{ route('customer.reservations.index') }}"
                class="inline-block
                       rounded-lg
                       bg-blue-600
                       px-5 py-3
                       text-white
                       font-semibold
                       hover:bg-blue-700
                       transition"
            >
                My Reservations
            </a>

        </div>



        {{-- Search Section --}}
        <div class="mt-8 bg-white p-6 rounded-xl shadow">

            {{-- Hall Name Search --}}
            <div>

                <label
                    for="hall-search"
                    class="block
                           text-sm
                           font-semibold
                           text-gray-700
                           mb-2"
                >
                    Search Hall Name
                </label>


                <input
                    type="text"
                    id="hall-search"
                    placeholder="Search by hall name..."
                    class="w-full
                           rounded-lg
                           border
                           border-gray-300
                           px-4 py-3
                           focus:border-blue-500
                           focus:ring
                           focus:ring-blue-200
                           outline-none"
                >

            </div>



            {{-- Address Search --}}
            <div class="mt-5">

                <label
                    for="address-search"
                    class="block
                           text-sm
                           font-semibold
                           text-gray-700
                           mb-2"
                >
                    Address
                </label>


                <input
                    type="text"
                    id="address-search"
                    placeholder="Enter your address..."
                    class="w-full
                           rounded-lg
                           border
                           border-gray-300
                           px-4 py-3
                           focus:border-blue-500
                           focus:ring
                           focus:ring-blue-200
                           outline-none"
                >


                <p class="mt-2 text-sm text-gray-500">
                    Enter your address to show halls with the same
                    or similar address.
                </p>

            </div>

        </div>



        {{-- Halls Table --}}
        <div class="mt-8 bg-white rounded-xl shadow overflow-hidden">

            <div class="overflow-x-auto">

                <table
                    id="halls-table"
                    class="w-full"
                >

                    {{-- Table Header --}}
                    <thead class="bg-gray-100">

                        <tr>

                            <th
                                class="text-left
                                       px-6 py-4
                                       font-semibold
                                       text-gray-700"
                            >
                                Hall Name
                            </th>


                            <th
                                class="text-right
                                       px-6 py-4
                                       font-semibold
                                       text-gray-700"
                            >
                                Action
                            </th>

                        </tr>

                    </thead>



                    {{-- Table Body --}}
                    <tbody class="divide-y divide-gray-200">


                        @forelse($halls as $hall)

                            <tr
                                class="hall-row hover:bg-gray-50"
                                data-hall-name="{{ strtolower($hall->name) }}"
                                data-hall-address="{{ strtolower($hall->address ?? '') }}"
                            >


                                {{-- Hall Name --}}
                                <td class="px-6 py-4">

                                    <span
                                        class="hall-name
                                               font-semibold
                                               text-gray-900"
                                    >
                                        {{ $hall->name }}
                                    </span>

                                </td>



                                {{-- View --}}
                                <td
                                    class="px-6 py-4
                                           text-right"
                                >

                                    <a
                                        href="{{ route(
                                            'customer.halls.show',
                                            $hall
                                        ) }}"
                                        class="inline-block
                                               bg-blue-600
                                               hover:bg-blue-700
                                               text-white
                                               font-semibold
                                               px-5 py-2
                                               rounded-lg
                                               transition"
                                    >
                                        View
                                    </a>

                                </td>


                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="2"
                                    class="px-6 py-10
                                           text-center
                                           text-gray-600"
                                >
                                    No Wedding Halls Available
                                </td>

                            </tr>

                        @endforelse



                        {{-- No Results --}}
                        <tr
                            id="no-search-results"
                            style="display: none;"
                        >

                            <td
                                colspan="2"
                                class="px-6 py-10
                                       text-center
                                       text-gray-600"
                            >

                                No halls found for this search.

                            </td>

                        </tr>


                    </tbody>

                </table>

            </div>

        </div>


    </div>



    {{-- Search JavaScript --}}
    <script>

        const hallSearch =
            document.getElementById('hall-search');

        const addressSearch =
            document.getElementById('address-search');

        const hallRows =
            document.querySelectorAll('.hall-row');

        const noSearchResults =
            document.getElementById('no-search-results');



        function normalizeText(text) {

            return text
                .toLowerCase()
                .trim()
                .replace(/\s+/g, ' ');

        }



        function searchHalls() {

            const hallName =
                normalizeText(
                    hallSearch.value
                );


            const customerAddress =
                normalizeText(
                    addressSearch.value
                );


            let visibleRows = 0;



            hallRows.forEach(function (row) {


                const currentHallName =
                    normalizeText(
                        row.dataset.hallName
                    );


                const currentHallAddress =
                    normalizeText(
                        row.dataset.hallAddress
                    );



                /*
                 * Hall name search
                 */
                const nameMatches =
                    hallName === ''
                    ||
                    currentHallName.includes(
                        hallName
                    );



                /*
                 * Address search
                 */
                let addressMatches = true;


                if (customerAddress !== '') {

                    /*
                     * Exact address
                     */
                    const exactMatch =
                        currentHallAddress
                            .includes(
                                customerAddress
                            );


                    /*
                     * Search by individual words
                     */
                    const addressWords =
                        customerAddress
                            .split(' ')
                            .filter(
                                word =>
                                    word.length > 1
                            );


                    let matchedWords = 0;


                    addressWords.forEach(
                        function (word) {

                            if (
                                currentHallAddress
                                    .includes(word)
                            ) {

                                matchedWords++;

                            }

                        }
                    );


                    /*
                     * Show if:
                     *
                     * 1. Full address matches
                     * OR
                     * 2. At least one address word matches
                     */
                    addressMatches =
                        exactMatch
                        ||
                        matchedWords > 0;

                }



                /*
                 * Final result
                 */
                if (
                    nameMatches
                    &&
                    addressMatches
                ) {

                    row.style.display = '';

                    visibleRows++;

                } else {

                    row.style.display = 'none';

                }

            });



            /*
             * Show "No results"
             */
            if (
                visibleRows === 0
                &&
                (
                    hallName !== ''
                    ||
                    customerAddress !== ''
                )
            ) {

                noSearchResults.style.display = '';

            } else {

                noSearchResults.style.display = 'none';

            }

        }



        /*
         * Search by Hall Name
         */
        hallSearch.addEventListener(
            'input',
            searchHalls
        );



        /*
         * Search by Address
         */
        addressSearch.addEventListener(
            'input',
            searchHalls
        );

    </script>
</body>
</html>