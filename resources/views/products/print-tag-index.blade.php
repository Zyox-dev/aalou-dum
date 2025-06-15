<x-layout.default>
    <script src="/assets/js/simple-datatables.js"></script>

    <div class="panel" x-data="custom({{ $tableData }})">
        <div class="md:absolute md:top-5 ltr:md:left-5 rtl:md:right-5">
            <div class="flex items-center flex-wrap mb-5">
                <form id="print-form" method="POST" action="{{ route('products.print-tags-store') }}" target="_blank">
                    @csrf
                    <input type="hidden" name="product_ids" id="product-ids">
                    <button class="btn btn-primary btn-sm m-1" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            class="w-5 h-5 ltr:mr-2 rtl:ml-2"><!-- Icon from Solar by 480 Design - https://creativecommons.org/licenses/by/4.0/ -->
                            <g fill="none">
                                <path stroke="currentColor" stroke-width="1.5"
                                    d="M6 17.983c-1.553-.047-2.48-.22-3.121-.862C2 16.243 2 14.828 2 12s0-4.243.879-5.121C3.757 6 5.172 6 8 6h8c2.828 0 4.243 0 5.121.879C22 7.757 22 9.172 22 12s0 4.243-.879 5.121c-.641.642-1.567.815-3.121.862" />
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5" d="M9 10H6"
                                    opacity=".5" />
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5"
                                    d="M19 15H5m13 0v1c0 2.828 0 4.243-.879 5.121C16.243 22 14.828 22 12 22s-4.243 0-5.121-.879C6 20.243 6 18.828 6 16v-1" />
                                <path stroke="currentColor" stroke-width="1.5"
                                    d="M17.983 6c-.047-1.553-.22-2.48-.862-3.121C16.243 2 14.828 2 12 2s-4.243 0-5.121.879C6.237 3.52 6.064 4.447 6.017 6"
                                    opacity=".5" />
                                <circle cx="17" cy="10" r="1" fill="currentColor" opacity=".5" />
                            </g>
                        </svg>
                        Print
                        Tags
                    </button>
                </form>

            </div>
        </div>
        <table id="myTable" class="whitespace-nowrap table-checkbox"></table>
    </div>

    <style>
        table.table-checkbox thead tr th:first-child {
            width: 1px !important;
        }
    </style>
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("custom", (tableDataFromServer) => ({
                ids: [],
                datatable: null,
                tableData: tableDataFromServer, // Actual product data

                init() {
                    this.datatable = new simpleDatatables.DataTable('#myTable', {
                        data: {
                            headings: [
                                '<input type="checkbox" class="form-checkbox" @change="checkAll($event.target.checked)" />',
                                "Product No", "Name", "Gold (g)", "Diamond (ct)",
                                "Color Stone (ct)", "MRP"
                            ],
                            data: this.tableData,
                        },
                        perPage: 20,
                        // perPageSelect: [10, 20, 30, 50, 100],
                        columns: [{
                            select: 0,
                            sortable: false,
                            render: (data) => {
                                return `<input type="checkbox" class="form-checkbox product-checkbox" value="${data}" />`;
                            }
                        }],
                        layout: {
                            top: "{search}",
                            // bottom: "{info}{select}{pager}",
                        },
                    });

                    // Form submit hook
                    document.getElementById('print-form').addEventListener('submit', (e) => {
                        let selected = Array.from(document.querySelectorAll(
                            '.product-checkbox:checked')).map(cb => cb.value);
                        if (selected.length === 0) {
                            e.preventDefault();
                            alert("Select at least one product.");
                        } else if (selected.length > 20) {
                            e.preventDefault();
                            alert("You can only print 20 tag at a time");
                        } else {
                            document.getElementById('product-ids').value = selected.join(',');
                        }
                    });
                },

                checkAll(isChecked) {
                    if (isChecked) {
                        this.ids = this.tableData.map((d) => d[0]);
                    } else {
                        this.ids = [];
                    }

                    setTimeout(() => {
                        document.querySelectorAll('.product-checkbox').forEach(cb => {
                            cb.checked = isChecked;
                        });
                    }, 0);
                },
            }));

        });
    </script>
</x-layout.default>
