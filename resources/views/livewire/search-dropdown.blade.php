<div>
    <div class="w-full ">
        <input type="text" class="form-input rounded-md w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 " placeholder="{{ $atributte ?? 'Pesquisar ...' }}"
            wire:model="query" wire:keydown.escape="clear" wire:keydown.tab="clear" wire:keydown.arrow-up="decrementHighlight"
            wire:keydown.arrow-down="incrementHighlight"  wire:keydown.debounce.300ms="search" wire:keydown="selectContact" wire:model="atributte" />


        <div wire:loading class="absolute z-10 w-full bg-white rounded-t-none shadow-lg list-group">
            <div class="list-item">Searching...</div>
        </div>

        @if (!empty($query))
            <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="clear"></div>

            <div class="absolute z-10 w-full bg-white rounded-t-none shadow-lg list-group">
                @if (!empty($query))
                    <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="resetar"></div>

                    <div class="absolute z-10 w-1/2 bg-white rounded-t-none shadow-lg list-group">
                        @if (!empty($contacts))
                            @foreach ($contacts as $contact)
                                <p  wire:click.change="selectClickContact({{ $contact['id'] }})"  class="hover:bg-gray-200" value="{{ $contact['id'] }}">
                                    {{ $contact[$column] }}</p>
                            @endforeach
                        @else
                            <div class="list-item">No results!</div>
                        @endif
                    </div>
                @endif
            </div>
        @endif
    </div>

</div>