<template>
    <div class="wrapper">
        <button class="btn" @click="home()">
            <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 320 512" fill="#FFF">
                <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/>
            </svg>
        </button>
        <div class="card">
            <h5 class="card-header">
                <span>Imovel {{ imovel.id }}</span>

                <div v-if="isAvailable(imovel.status)" class="buttons">
                    <a class="btn btn-info" @click="rent(imovel.id)">Alugar</a>
                    <a class="btn btn-success" @click="sell(imovel.id)">Vender</a>
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
</template>

<script>
import { router } from '@inertiajs/vue3';
import StatusEnum from '../enums/StatusEnum'
import TypeEnum from '../enums/TypeEnum'

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
    background-color: #edf2fb;
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
