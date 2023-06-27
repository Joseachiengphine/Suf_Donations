<x-filament::page>
    <div class="payment-info">
        <span class="payment-info-text">Note: The displayed information represents payments that have been made.</span>
    </div>
    @if (!is_null($fromSuppDate) || !is_null($toSuppDate) || !is_null($relation))
        <div class="active-filters">
            <span class="active-filters-label">Active Filters:</span>
            <div class="filters">
                @if (!is_null($fromSuppDate) || !is_null($toSuppDate))
                    <span class="badge badge-success">
                        {{ $fromSuppDate }} - {{ $toSuppDate }}
                        <button class="badge-remove" wire:click="resetoneFilter(['fromSuppDate', 'toSuppDate'])">X</button>
                    </span>
                @endif

                @if (!is_null($relation))
                        <span class="badge badge-success">
                        {{ $relation }}
                        <button class="badge-remove" wire:click="resetoneFilter('relation')">X</button>
                    </span>
                    @endif
            </div>

            @if (!is_null($fromSuppDate) || !is_null($toSuppDate)  || !is_null($relation))
                <button class="clear-filters" wire:click="resetFilters()" title="Reset all filters">
                    <span class="clear-filters-text">Clear Filters</span>
                </button>
            @endif
        </div>
    @endif
    <livewire:report-vcrunsupporter />

    <style>
        /* CSS styles for the payment info */
        .payment-info {
            text-align: center;
            background-color: #f0f0f0;
            padding: 10px;
        }
        .payment-info-text {
            font-weight: bold;
        }

        .active-filters {
            display: none;
            align-items: center;
            margin-bottom: 20px;
        }

        .active-filters-label {
            font-weight: bold;
            margin-right: 10px;
        }

        .filters {
            display: flex;
            gap: 10px;
        }

        .badge {
            position: relative;
            display: inline-block;
            padding: 5px 10px;
            border-radius: 10px;
            background-color: #fff;
            border: 2px solid #ccc;
            color: #000;
            font-size: 12px;
        }

        .badge-remove {
            position: absolute;
            top: -5px;
            right: -5px;
            padding: 0;
            width: 15px;
            height: 15px;
            border: none;
            background-color: #ccc;
            color: #000;
            font-size: 10px;
            line-height: 1;
            border-radius: 50%;
            cursor: pointer;
        }

        .clear-filters {
            display: none;
            margin-left: auto;
            cursor: pointer;
            position: relative;
        }

        .clear-filters-text::after {
            content: attr(title);
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            /*background-color: rgba(0, 0, 0, 0.8);*/
            color: #fff;
            padding: 5px;
            border-radius: 5px;
            font-size: 12px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .clear-filters:hover .clear-filters-text::after {
            opacity: 1;
        }
    </style>

        <script>
            document.addEventListener('livewire:load', function () {
                Livewire.hook('message.processed',
                    function () {
                        // Check if there are active filters
                        var activeFilters = document.querySelector('.filters').children.length > 0;
                        // Show/hide the active filters container based on the presence of active filters
                        var activeFiltersContainer = document.querySelector('.active-filters');
                        activeFiltersContainer.style.display = activeFilters ? 'flex' : 'none';

                        // Show/hide the clear filters button based on the presence of active filters
                        var clearFiltersButton = document.querySelector('.clear-filters');
                        clearFiltersButton.style.display = activeFilters ? 'block' : 'none';
                    });
            });
        </script>
</x-filament::page>


