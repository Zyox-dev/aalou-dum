<div class='flex items-center gap-2'>
    <a href="{{ route('invoices.print', $id) }}" class='ltr:mr-2 rtl:ml-2' target="_blank">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
            viewBox="0 0 24 24"><!-- Icon from Solar by 480 Design - https://creativecommons.org/licenses/by/4.0/ -->
            <g fill="none">
                <path stroke="currentColor" stroke-width="1.5"
                    d="M6 17.983c-1.553-.047-2.48-.22-3.121-.862C2 16.243 2 14.828 2 12s0-4.243.879-5.121C3.757 6 5.172 6 8 6h8c2.828 0 4.243 0 5.121.879C22 7.757 22 9.172 22 12s0 4.243-.879 5.121c-.641.642-1.567.815-3.121.862" />
                <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5" d="M9 10H6" opacity=".5" />
                <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5"
                    d="M19 15H5m13 0v1c0 2.828 0 4.243-.879 5.121C16.243 22 14.828 22 12 22s-4.243 0-5.121-.879C6 20.243 6 18.828 6 16v-1" />
                <path stroke="currentColor" stroke-width="1.5"
                    d="M17.983 6c-.047-1.553-.22-2.48-.862-3.121C16.243 2 14.828 2 12 2s-4.243 0-5.121.879C6.237 3.52 6.064 4.447 6.017 6"
                    opacity=".5" />
                <circle cx="17" cy="10" r="1" fill="currentColor" opacity=".5" />
            </g>
        </svg>
    </a>


    <form method="POST" action="{{ url("/invoices/$id") }}" class="delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" x-tooltip="Delete">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http:www.w3.org/2000/svg"
                class="w-5 h-5">
                <path opacity="0.5"
                    d="M9.17065 4C9.58249 2.83481 10.6937 2 11.9999 2C13.3062 2 14.4174 2.83481 14.8292 4"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                <path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                <path
                    d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                <path opacity="0.5" d="M9.5 11L10 16" stroke="currentColor" stroke-width="1.5"
                    stroke-linecap="round" />
                <path opacity="0.5" d="M14.5 11L14 16" stroke="currentColor" stroke-width="1.5"
                    stroke-linecap="round" />
            </svg>
        </button>
    </form>
</div>
