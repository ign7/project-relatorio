<div class="px-8">
    <div class="py-6">
        @if (session()->has('erro') && $showAlert)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Failure!</strong>
                <span class="block sm:inline">{{ session('erro') }}.</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg wire:click.prevent='closealert' class="fill-current h-6 w-6 text-red-500" role="button"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path
                            d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                    </svg>
                </span>
            </div>
        @endif
        @if (session()->has('sucesso') && $showAlert)
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Sucesso !!</strong>
                <span class="block sm:inline">{{ session('sucesso') }}.</span>
                <span wire:click.prevent='closealert' class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <title>Close</title>
                        <path
                            d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                    </svg>
                </span>
            </div>
        @endif

        <div>
            <div class="flex py-2">
                <div class="w-1/2 flex flex-col gap-2 pr-6">
                    <x-label for="selectuser" class="">Numero Do Pedido:</x-label>
                    <x-input value="" class="rounded-md" type="number" wire:model.live="num_pedido" />
                </div>

                <div class="w-1/2 flex flex-col gap-2 pl-6">
                    <x-label for="selectuser" class="">Carga:</x-label>
                    <select wire:model.live="carga_id" id="selectuser" class="rounded-md">

                        <option value="" selected>-- Cargas --</option>
                        @foreach ($cargas as $carga)
                            <option value="{{ $carga->id }}">{{ $carga->numero_carga }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-1/2 flex flex-col gap-2 pl-6">
                    <x-label for="selectuser" class="">Cliente:</x-label>
                    <select wire:model.live="cliente_id" id="selectuser" class="rounded-md">

                        <option value="" selected>-- clientes --</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex py-2">

                <div class="flex flex-col gap-2 w-1/3 pr-4">
                    <div class="flex flex-row items-center">
                        <div class="mr-2">
                            <x-label for="selectcliente" class="">Cidade:</x-label>
                            <x-input value="" class="rounded-md" type="text" wire:model.live="cidade" />
                        </div>
                    
                        <div class="pt-4">
                            <button wire:click="$dispatch('openModal', { component: 'form-pedido-modal' , arguments:{ mode: 'modal-cidade' }})" class="rounded-md bg-blue-500 text-slate-50 font-bold px-5 py-1">
                                <span class="material-symbols-outlined">
                                    add
                                </span>
                            </button>
                        </div>
                    </div>
                    @error('cidade')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-2 w-1/3 px-2">
                    <x-label for="selectcontrato" class="">N°/Nota Fiscal:</x-label>
                    <x-input value="" class="rounded-md" type="text" wire:model.live="num_nota_fiscal" />
                    @error('num_nota_fiscal')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-2 w-1/3 pl-4">
                    <x-label for="selectcontrato" class="">Valor Frete:</x-label>
                    <x-input value="" class="rounded-md" type="number" wire:model.live="valor_frete" />
                    @error('valor_frete')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex py-2">
                <div class="flex flex-col gap-2 w-1/3 pr-4  ">
                    <x-label for="inicaldatePicked" class="">Data Solicitação:</x-label>
                    <x-input value="" class="rounded-md" type="date" wire:model.live="data_solicitacao" />
                    @error('data_solicitacao')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-2 w-1/3 pr-4  ">
                    <x-label for="inicaldatePicked" class="">Descarga:</x-label>
                    <x-input value="" class="rounded-md" type="number" wire:model.live="descarga" />
                    @error('descarga')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-2 w-1/5 pl-4 pt-7">
                    <button wire:click.prevent="save"
                        class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                        Lançar
                    </button>
                </div>

                <div class="flex flex-col gap-2 w-1/5 pl-4 pt-7">
                    <button wire:click.prevent="exportar"
                        class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                        exportar
                    </button>
                </div>

            </div>
        </div>

    </div>

    @if ($show)
        <div class="border-t-2 pt-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
            @livewire('pedido-table', ['result' => $result, 'mode' => $mode])
        </div>
    @endif

</div>
