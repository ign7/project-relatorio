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
            <div class=" flex flex-row justify-between">
                <div>
                    <h1
                    class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl ">
                    Controle <span
                        class="underline underline-offset-3 decoration-8 decoration-blue-400 dark:decoration-blue-600">de
                        Custos</span></h1>
                <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">Visualização e cadastro de
                    custos.</p>

                </div>

                <div class=" pl-2 pt-6">
                    <button
                        wire:click="$dispatch('openModal', { component: 'form-veiculo-modal'})"
                        class="rounded-md bg-blue-500 text-slate-50 font-bold px-5 py-1">
                        Veiculos
                    </button>
                </div>

            </div>
            <div class="flex flex-col gap-2 w-full ">
                <div class="flex flex-row items-center">
                    <div class="flex flex-col gap-2 w-1/3 ">
                        <x-label for="selectuser" class="">Carga:</x-label>
                        <livewire:search-dropdown :modelClassName="'App\Models\Carga'" :column="'numero_carga'" :mode="'carga'" />
                            @error('carga_id')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </select>
                    </div>

                    <div class="flex flex-col gap-2 pl-4 w-1/3 ">
                        <x-label for="selectuser" class="">Veiculo:</x-label>
                        <livewire:search-dropdown :modelClassName="'App\Models\Veiculo'" :column="'name'" :mode="'veiculo'" />
                            @error('veiculo_id')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-2 w-full ">
                    <x-label for="" class="">Titulo:</x-label>
                    <x-input value="" class="rounded-md" type="text" wire:model.live="titulo" />
                    @error('titulo')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                @error('titulo')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex py-2">
                <div class="w-1/2 flex flex-col gap-2 pr-6">
                    <x-label for="selectuser" class="">Litros:</x-label>
                    <x-input value="" class="rounded-md" type="number" wire:model.live="litros" />
                </div>

                <div class="w-1/2 flex flex-col gap-2 pl-6">
                    <x-label for="selectuser" class="">Combustivel:</x-label>
                    <x-input value="" class="rounded-md" type="number" wire:model.live="combustivel" />
                </div>

                <div class="w-1/2 flex flex-col gap-2 pl-6">
                    <x-label for="selectuser" class="">Combustivel P/Litro:</x-label>
                    <x-input value="" class="rounded-md" type="number" wire:model.live="p/litro" />
                </div>

                <div class="w-1/2 flex flex-col gap-2 pl-6">
                    <x-label for="selectuser" class="">Kilometros:</x-label>
                    <x-input value="" class="rounded-md" type="number" wire:model.live="km" />
                </div>
            </div>

            <div class="flex py-2">

                <div class="flex flex-col gap-2 w-1/3 ">
                    <x-label for="selectcontrato" class="">Pedagio:</x-label>
                    <x-input value="" class="rounded-md" type="number" wire:model.live="pedagio" />
                    @error('pedagio')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-2 w-1/3 pl-4">
                    <x-label for="selectcontrato" class="">Manutenção Veicular:</x-label>
                    <x-input value="" class="rounded-md" type="number" wire:model.live="manutencao" />
                    @error('manutencao')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-2 w-1/3 pl-4">
                    <x-label for="selectcontrato" class="">Data Manutencao:</x-label>
                    <x-input value="" class="rounded-md" type="date" wire:model.live="data_manutencao" />
                    @error('data_manutencao')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex py-2">
                <div class="flex flex-col gap-2 w-1/3 pr-4  ">
                    <x-label for="inicaldatePicked" class="">Despesa:</x-label>
                    <x-input value="" class="rounded-md" type="number" wire:model.live="despesa" />
                    @error('despesa')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-2 w-1/3 pr-4  ">
                    <x-label for="inicaldatePicked" class="">Descarga:</x-label>
                    <x-input value="" class="rounded-md" type="number" wire:model.live="descarga" />
                    @error('descarga')
                    @enderror
                </div>

                <div class="flex flex-col gap-2 w-full px-2">
                    <x-label for="" class="">descricao:</x-label>
                    <x-input value="" class="rounded-md" type="text" wire:model.live="descricao" />
                    @error('descricao')
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
                    <button disabled wire:click.prevent="exportar"
                        class="bg-transparent hover:bg-gray-500 text-gray-700 font-semibold hover:text-white py-2 px-4 border border-gray-500 hover:border-transparent rounded">
                        exportar
                    </button>
                </div>

            </div>
        </div>

    </div>
  
        <div class="border-t-2 pt-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
            @livewire('custos-table')
        </div>
</div>
