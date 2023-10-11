<template>
    <div
        v-if="showMessage"
        id="feedbackMessage"
        class="alert alert-success text-center"
    >
        <strong>{{ message }}</strong>
    </div>
    <div
        v-if="showError"
        id="feedbackMessage"
        class="alert alert-danger text-center"
    >
        <strong>{{ error }}</strong>
    </div>
    <div class="wrapper">
        <button class="btn btn-primary my-btn" @click="create()">
            Novo Imóvel
        </button>
        <div class="card offset-3">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Endereço</th>
                            <th scope="col">Preço</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="imovel in imoveis">
                            <td>{{ imovel.endereco }}</td>
                            <td class="price">{{ formatPrice(imovel.preco) }}</td>
                            <td>{{ getTipoLabel(imovel.tipo) }}</td>
                            <td>{{ getStatusLabel(imovel.status) }}</td>
                            <td class="actions">
                                <button class="btn btn-outline-info">View</button>
                                <button class="btn btn-outline-primary" @click="edit(imovel.id)">Edit</button>
                                <button class="btn btn-outline-danger" @click="destroy(imovel.id)">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

import { usePage } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3';
import StatusEnum from '../enums/StatusEnum'
import TypeEnum from '../enums/TypeEnum'

export default {
    name: 'Home',
    props: {
        imoveis: {
            type: Object,
        }
    },
    data() {
        return {
            page: usePage(),
            showMessage: false,
            showError: false,
            message: '',
            error: '',
        }
    },
    watch: {
        page() {
            this.flash(this.page.props.flash.message, this.page.props.flash.error)
        }
    },
    methods: {
        destroy(id) {
            router.delete(`/imoveis/${id}`)
        },
        edit(id) {
            router.get(`/imoveis/${id}/edit`)
        },
        create() {
            router.get(`/imoveis/create`)
        },
        flash(message = null, error = null) {
            if (message) this.showMessage = true
            if (error) this.showError = true

            this.message = message
            this.error = error

            setTimeout(() => {
                this.hide()
            },4000)
        },
        hide() {
            this.page.props.flash.message = ''
            this.page.props.flash.error = ''
            this.showMessage = false
            this.showError = false
        },
        checkFlash() {
            if(this.page.props.flash.message || this.page.props.flash.error) {
                this.flash(this.page.props.flash.message, this.page.props.flash.error)
            }
        },
        formatPrice(preco) {
            return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL', minimumFractionDigits: 2 }).format(preco)
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
    updated() {
        this.checkFlash()
    },
    created() {
        this.checkFlash()
    },
}

</script>

<style scoped>
.wrapper {
    display: flex;
    flex-direction: column;
    gap: 32px;
    padding-top: 50px;
}
.card {
    margin-left: 0;
    background-color: #edf2fb;
}
.table-responsive {
  max-height: 700px;
}
th {
    background-color: #c1d4f9;
}
tbody {
    width: 700px;
    overflow-y: scroll;
}
thead {
  position: sticky;
  top: -1px;
}
.actions {
    display: flex;
    justify-content: space-evenly;
}
.my-btn {
    max-width: 150px;
    align-self: flex-end;
}
.price {
    font-family: 'Montserrat', sans-serif;
}
#feedbackMessage {
    position: absolute;
    max-width: 400px;
    top: 5px;
    left: 50%;
    margin-left: -200px;
}
/* width */
::-webkit-scrollbar {
    width: 8px;
}

/* Track */
::-webkit-scrollbar-track {
    background: #edf2fb;
    border-radius: 10px;
}

/* Handle */
::-webkit-scrollbar-thumb {
    background: #c1d4f9;
    border-radius: 10px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: #3e7cf9;
}
</style>
