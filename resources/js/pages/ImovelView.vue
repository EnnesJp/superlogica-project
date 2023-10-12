<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3';
import StatusEnum from '../enums/StatusEnum'
import TypeEnum from '../enums/TypeEnum'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">View Imovel</h2>
        </template>

        <div class="wrapper">
            <div class="card">
                <h5 class="card-header">
                    <strong>Imovel {{ imovel.id }}</strong>

                    <div v-if="isAvailable(imovel.status)" class="buttons">
                        <SecondaryButton class="ml-4" @click="rent(imovel.id)">
                            Alugar
                        </SecondaryButton>

                        <PrimaryButton class="ml-4" @click="sell(imovel.id)">
                            Vender
                        </PrimaryButton>
                    </div>
                </h5>

                <div class="card-body">
                    <div class="imovel-infos top">
                        <div>
                            <h5 class="card-title">Endereço</h5>
                            <p class="card-text">{{ imovel.endereco }}</p>
                        </div>
                        <div>
                            <h5 class="card-title">Preço</h5>
                            <p class="card-text price">{{ formatPrice(imovel.preco) }}</p>
                        </div>
                    </div>

                    <div class="imovel-infos">
                        <h5 class="card-title">Tipo:</h5>
                        <p class="card-text">{{ getTipoLabel(imovel.tipo) }}</p>
                        <h5 class="card-title">Status:</h5>
                        <p class="card-text status" :class="isAvailable(imovel.status) ? 'disponivel' : ''">{{ getStatusLabel(imovel.status) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
const BASE_ROUTE = '/imoveis'

export default {
    name: 'ImovelView',
    props: {
        imovel: {
            type: Object,
            required: false,
            default: null
        }
    },
    data() {},
    methods: {
        home() {
            router.get(BASE_ROUTE)
        },
        rent(id) {
            router.get(`${BASE_ROUTE}/${id}/rent`)
        },
        sell(id) {
            router.get(`${BASE_ROUTE}/${id}/sell`)
        },
        formatPrice(preco) {
            return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL', minimumFractionDigits: 2 }).format(preco)
        },
        isAvailable (status) {
            return status === StatusEnum.DISPONIVEL;
        },
        getTipoLabel(status) {
            switch (status) {
                case TypeEnum.CASA:
                    return 'Casa'

                case TypeEnum.APARTAMENTO:
                    return 'Apartamento'

                case TypeEnum.TERRENO:
                    return 'Terreno'

                default:
                    break;
            }
        },
        getStatusLabel(status) {
            switch (status) {
                case StatusEnum.DISPONIVEL:
                    return 'Disponível'

                case StatusEnum.ALUGADO:
                    return 'Alugado'

                case StatusEnum.VENDIDO:
                    return 'Vendido'

                default:
                    break;
            }
        }
    },
}

</script>

<style scoped>
.wrapper {
    display: flex;
    padding-top: 50px;
    align-items: flex-start;
    max-width: 1000px;
    margin-left: auto;
    margin-right: auto;
}
.card {
    margin-left: 0;
    width: 100%;
}
.card-body {
    padding: 20px;
}
.card-header, .price {
    font-family: 'Montserrat', sans-serif;
}
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.imovel-infos {
    display: flex;
    gap: 32px;
    align-items: baseline;
}
.imovel-infos.top {
    justify-content: space-between;
    padding-right: 40px;
    margin-bottom: 40px;
}
.imovel-infos h5 {
    font-weight: bold;
}
.card-text.status {
    border: 2px solid gray;
    padding: 4px;
    border-radius: 8px;
    background: lightgray;
    font-weight: bold;
    color: dimgray;
}
.card-text.status.disponivel {
    border: 2px solid green;
    background: lightgreen;
    color: darkgreen;
}
.buttons {
    display: flex;
    gap: 12px;
}
</style>
