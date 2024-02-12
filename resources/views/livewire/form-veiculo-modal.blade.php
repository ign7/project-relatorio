<div>
   
        <div class="p-8">

            <div class="pb-8">
                <span class="font-bold text-2xl pb-4">Cadastrar Novo Veiculo</span>
            </div>

            <div class="flex">

                <div class="w-1/2 flex flex-col gap-2 pb-4 pr-2">
                    <x-label for="selectuser" class="">Numero Do Pedido:</x-label>
                    <x-input value="" class="rounded-md" type="number" wire:model.live="num_pedido" />
                </div>

                <div class="w-1/2 flex flex-col gap-2 pb-4 pr-2 pr-4">
                    <x-label for="selectcliente" class="">Cidade:</x-label>
                    <x-input value="" class="rounded-md bg-gray-200" readonly type="text" wire:model.live="cidade" />
                    @error('cidade')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

            </div>



            <div class="flex">
                <div class="w-1/2 flex flex-col gap-2 pb-4 pr-2 px-2">
                    <x-label for="selectcontrato" class="">N°/Nota Fiscal:</x-label>
                    <x-input value="" class="rounded-md" type="text" wire:model.live="num_nota_fiscal" />
                    @error('num_nota_fiscal')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="w-1/2 flex flex-col gap-2 pb-4 pr-2 pl-4">
                    <x-label for="selectcontrato" class="">Valor Frete:</x-label>
                    <x-input value="" class="rounded-md" type="number" wire:model.live="valor_frete" />
                    @error('valor_frete')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>


            </div>

            <div class="flex">
                <div class="w-1/2 flex flex-col gap-2 pb-4 pr-2 pr-4  ">
                    <x-label for="inicaldatePicked" class="">Data Solicitação:</x-label>
                    <x-input value="" class="rounded-md" type="date" wire:model.live="data_solicitacao" />
                    @error('data_solicitacao')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="w-1/2 flex flex-col gap-2 pb-4 pr-2 pr-4  ">
                    <x-label for="inicaldatePicked" class="">Descarga:</x-label>
                    <x-input value="" class="rounded-md" type="number" wire:model.live="descarga" />
                    @error('descarga')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="pt-6">
                <button wire:click="editarpedido"
                    class="rounded-md bg-green-500 text-slate-50 font-bold px-10 py-2">Salvar</button>
            </div>
        </div>
   
    </div>

</div>
