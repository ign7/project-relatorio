<div class="py-12">
    <div class="py-4 px-12 pb-8 border-b-2">
        <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl ">
            Controle <span class="underline underline-offset-3 decoration-8 decoration-blue-400 decoration-blue-600">de
                Custos e Gastos !</span></h1>
        <p class="text-lg font-normal text-gray-500 lg:text-xl text-gray-400">controle e versionamento de
            pedidos,cargas e clientes.</p>
    </div>
    {{--  <div class="pt-6 max-w-7xl mx-auto sm:px-6 lg:px-8"> 
        <div class="pt-4 bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="flex flex-row justify-between px-5 py-2">
                <div class="block max-w-[18rem] rounded-lg bg-blue-500 hover:bg-blue-600 transition-transform transform scale-105">
                    <div class="p-6">
                        <div class="p-2 text-white">
                            <div class="border-2 rounded-md bg-blue-700">
                                <h1 class="text-base text-white text-neutral-200 pl-1">
                                    Cargas
                                </h1>
                            </div>
                            <p class="p-2 text-base text-white text-neutral-200">
                                Cadastro e visualização de Novas Cargas
                            </p>
                        </div>
                    </div>
                </div>
    
                <div class="block max-w-[18rem] rounded-lg bg-blue-500 hover:bg-blue-600 transition-transform transform scale-105">
                    <div class="p-6">
                        <div class="p-2 text-white">
                            <div class="border-2 rounded-md bg-blue-700">
                                <h1 class="text-base text-white text-neutral-200 pl-1">
                                    Clientes
                                </h1>
                            </div>
                            <p class="p-2 text-base text-white text-neutral-200">
                                Cadastro e visualização de Novas Clientes
                            </p>
                        </div>
                    </div>
                </div>
    
                <div class="block max-w-[18rem] rounded-lg bg-blue-500 hover:bg-blue-600 transition-transform transform scale-105">
                    <div class="p-6">
                        <div class="p-2 text-white">
                            <div class="border-2 rounded-md bg-blue-700">
                                <h1 class="text-base text-white text-neutral-200 pl-1">
                                    Pedidos
                                </h1>
                            </div>
                            <p class="p-2 text-base text-white text-neutral-200">
                                Cadastro e visualização de Novas Pedidos
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  --}}


    <div id="accordion-collapse" class="pt-8" data-accordion="collapse">
        <h2 id="accordion-collapse-heading-1">
            <button type="button" wire:click="activecarga"
                class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 focus:ring-gray-800 border-gray-200 text-gray-400 hover:bg-gray-100  gap-3"
                data-accordion-target="#accordion-collapse-body-1" aria-expanded="true"
                aria-controls="accordion-collapse-body-1">
                <span>Cargas</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
            </button>
        </h2>
        @if ($flagcargas)
            <div class="" >
                <div class="p-5 border border-b-0 border-gray-200 border-gray-200 ">
                    <p class="mb-2 text-gray-500 text-gray-400">Flowbite is an open-source library of interactive
                        components
                        built on top of Tailwind CSS including buttons, dropdowns, modals, navbars, and more.</p>
                    <p class="text-gray-500 text-gray-400">Check out this guide to learn how to <a
                            href="/docs/getting-started/introduction/"
                            class="text-blue-600 text-blue-500 hover:underline">get started</a> and start developing
                        websites even faster with components on top of Tailwind CSS.</p>
                </div>
            </div>
        @endif


        <h2 id="accordion-collapse-heading-1">
            <button type="button" wire:click="activepedido"
                class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 focus:ring-gray-800 border-gray-200 text-gray-400 hover:bg-gray-100  gap-3"
                data-accordion-target="#accordion-collapse-body-1" aria-expanded="true"
                aria-controls="accordion-collapse-body-1">
                <span>pedidos</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
            </button>
        </h2>
        @if ($flagpedidos)
            <div class="" >
                <div class="p-5 border border-b-0 border-gray-200 border-gray-200 ">
                    <p class="mb-2 text-gray-500 text-gray-400">Flowbite is an open-source library of interactive
                        components
                        built on top of Tailwind CSS including buttons, dropdowns, modals, navbars, and more.</p>
                    <p class="text-gray-500 text-gray-400">Check out this guide to learn how to <a
                            href="/docs/getting-started/introduction/"
                            class="text-blue-600 text-blue-500 hover:underline">get started</a> and start developing
                        websites even faster with components on top of Tailwind CSS.</p>
                </div>
            </div>
        @endif


        <h2 id="accordion-collapse-heading-1">
            <button type="button" wire:click="activecliente"
                class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 focus:ring-gray-800 border-gray-200 text-gray-400 hover:bg-gray-100  gap-3"
                data-accordion-target="#accordion-collapse-body-1" aria-expanded="true"
                aria-controls="accordion-collapse-body-1">
                <span>clientes</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
            </button>
        </h2>
        @if ($flagclientes)
            <div class="" >
                <div class="p-5 border border-b-0 border-gray-200 border-gray-200 ">
                    <p class="mb-2 text-gray-500 text-gray-400">Flowbite is an open-source library of interactive
                        components
                        built on top of Tailwind CSS including buttons, dropdowns, modals, navbars, and more.</p>
                    <p class="text-gray-500 text-gray-400">Check out this guide to learn how to <a
                            href="/docs/getting-started/introduction/"
                            class="text-blue-600 text-blue-500 hover:underline">get started</a> and start developing
                        websites even faster with components on top of Tailwind CSS.</p>
                </div>
            </div>
        @endif
    </div>


</div>
