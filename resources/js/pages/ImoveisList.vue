<template>
    <div
        v-if="show"
        id="feedbackMessage"
        class="alert alert-success text-center"
    >
        <strong>{{ message }}</strong>
    </div>
    <div class="card offset-3">
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
                    <td>{{ formatPrice(imovel.preco) }}</td>
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
            show: false,
            message: '',
        }
    },
    methods: {
        destroy(id) {
            router.delete(`/imoveis/${id}`)
        },
        edit(id) {
            router.get(`/imoveis/${id}/edit`)
        },
        flash(message) {
            this.show = true
            this.message = message

            setTimeout(() => {
                this.hide()
            },3000)
        },
        hide() {
            this.show = false
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
    mounted() {
        setTimeout(function() {
            $('#feedbackMessage').remove();
        }, 30000);
    },
    created() {
        if(this.page.props.flash.message) {
            this.flash(this.page.props.flash.message)
        }
    },
}

</script>

<style scoped>
.card {
    margin-top: 50px;
    margin-left: 0;
}
.actions {
    display: flex;
    justify-content: space-evenly;
}
</style>
