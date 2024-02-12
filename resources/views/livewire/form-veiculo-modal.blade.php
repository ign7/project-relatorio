<div>
   
        <div class="p-8">

            <div class="pb-8">
                <span class="font-bold text-2xl pb-4">Cadastrar Novo Veiculo</span>
            </div>

            <div class="flex">

                <div class="w-1/2 flex flex-col gap-2 pb-4 pr-2">
                    <x-label for="selectuser" class="">Nome:</x-label>
                    <x-input value="" class="rounded-md" type="text" wire:model.live="name" />
                </div>

                <div class="w-1/2 flex flex-col gap-2 pb-4 pr-2 pr-4">
                    <x-label for="selectcliente" class="">placa:</x-label>
                    <x-input value="" class="rounded-md " type="text" wire:model.live="placa" />
                    @error('placa')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

            </div>



            <div class="flex">
                <div class="w-1/2 flex flex-col gap-2 pb-4 pr-2 px-2">
                    <x-label for="selectcontrato" class="">Marca:</x-label>
                    <x-input value="" class="rounded-md" type="text" wire:model.live="marca" />
                    @error('marca')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="w-1/2 flex flex-col gap-2 pb-4 pr-2 pl-4">
                    <x-label for="selectcontrato" class="">Proprietario:</x-label>
                    <livewire:search-dropdown :modelClassName="'App\Models\User'" :column="'name'" :mode="'veiculo'" />
                </div>
            </div>

            <div class="pt-6">
                <button wire:click="saveVeiculo"
                    class="rounded-md bg-green-500 text-slate-50 font-bold px-10 py-2">Salvar</button>
            </div>
        </div>
   
    </div>

</div>
