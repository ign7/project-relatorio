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

            <div class="py-6">
                <div class="bg-orange-500 p-4 rounded">
                    <h1 class="font-bold text-3xl pb-4 text-white  ">Cadastrar Clientes</h1>
                </div>
            </div>

            <div class="flex py-2">

                <div class="w-1/2 flex flex-col gap-2 pr-6">
                    <x-label for="selectuser" class="">Nome Cliente:</x-label>
                    <x-input value="" class="rounded-md" type="text" wire:model.live="nome" />

                    @error('nome')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>



                <div class="w-1/2 flex flex-col gap-2 pr-6">
                    <x-label for="selectcliente" class="">Pesquisar Cliente:</x-label>
                    <select wire:model.live="selectcliente" id="selectcliente" class="rounded-md">

                        <option value="" selected>-- clientes --</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                        @endforeach
                    </select>
                    @error('selectcliente')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="flex py-2 justify-between">

                <div class="flex flex-col gap-2 w-1/5 pl-4 pt-7">
                    <button wire:click.prevent="save"
                        class="bg-transparent hover:bg-orange-500 text-black-700 font-semibold hover:text-white py-2 px-4 border border-gray-500 hover:border-transparent rounded">
                        Lançar
                    </button>
                </div>

                <div class="pr-8">
                    <div class="flex flex-col pl-4 pb-2">
                        <button wire:click.prevent="pesquisar"
                            class="bg-transparent hover:bg-orange-500 text-black-700 font-semibold hover:text-white py-2 px-4 border border-gray-500 hover:border-transparent rounded">
                            Pesquisar
                        </button>
                    </div>

                    <div class="flex flex-col pl-4 pb-2">
                        <button disabled wire:click.prevent="exportar"
                            class="bg-transparent  hover:bg-gray-500 text-black-700 font-semibold hover:text-white py-2 px-4 border border-gray-500 hover:border-transparent rounded">
                            Exportar
                        </button>
                    </div>

                    <div class="flex flex-col pl-4">
                        <button wire:click.prevent="limpar"
                            class="bg-transparent hover:bg-orange-500 text-black-700 font-semibold hover:text-white py-2 px-4 border border-gray-500 hover:border-transparent rounded">
                            Limpar
                        </button>
                    </div>

                </div>



            </div>
        </div>


        @if ($show)
            <div class="border-t-2 pt-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire('pedido-table', ['result' => $result,'mode'=> $mode])
            </div>
        @endif
        
    </div>



</div>
