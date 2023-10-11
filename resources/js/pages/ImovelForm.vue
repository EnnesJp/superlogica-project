<template>
    <div class="wrapper">
        <button class="btn" @click="home()">
            <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 320 512" fill="#FFF">
                <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/>
            </svg>
        </button>
        <div class="card">
            <div class="card-header">
                <strong>{{ imovel ? 'Editando Imóvel' : 'Cadastre um novo Imóvel' }}</strong>
            </div>
            <div class="card-body">
                <form @submit.prevent="imovel ? editImovel() : createImovel()">
                    <div class="mb-3">
                        <label class="form-label">
                            Endereço
                        </label>
                        <input
                            v-model="form.endereco"
                            type="text"
                            class="form-control"
                        >
                        <div class="text-danger text-xs" v-if="errors.endereco">{{ errors.endereco }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Preço
                        </label>
                        <CurrencyInput
                            v-model="form.preco"
                            :options="{ currency: 'BRL' }"
                        />
                        <div class="text-danger text-xs" v-if="errors.preco">{{ errors.preco }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo</label>
                        <select v-model="form.tipo" class="form-select">
                            <option
                                v-for="tipo in typeOptions"
                                :value="tipo.value"
                            >
                                {{ tipo.label }}
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select v-model="form.status" class="form-select">
                            <option
                                v-for="status in statusOptions"
                                :value="status.value"
                            >
                                {{ status.label }}
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        {{ imovel ? 'Salvar' : 'Finalizar Cadastro' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

import { useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import StatusEnum from '../enums/StatusEnum'
import TypeEnum from '../enums/TypeEnum'
import CurrencyInput from '../components/CurrencyInput.vue'

export default {
  name: 'ImovelForm',
  components: {
    CurrencyInput,
  },
  props: {
    errors: {
        type: Object,
    },
    imovel: {
        type: Object,
        required: false,
        default: null
    }
  },
  data() {
    return {
        form: useForm({
            endereco: null,
            preco: null,
            tipo: null,
            status: null
        }),
        typeOptions: [
            {
                label: 'Casa',
                value: TypeEnum.CASA
            },
            {
                label: 'Apartamento',
                value: TypeEnum.APARTAMENTO
            },
            {
                label: 'Terreno',
                value: TypeEnum.TERRENO
            },
        ],
        statusOptions: [
            {
                label: 'Disponível',
                value: StatusEnum.DISPONIVEL
            },
            {
                label: 'Alugado',
                value: StatusEnum.ALUGADO
            },
            {
                label: 'Vendido',
                value: StatusEnum.VENDIDO
            },
        ],
    }
  },
  methods: {
    createImovel() {
        router.post('/imoveis', this.form)
    },
    editImovel() {
        router.put(`/imoveis/${this.imovel.id}`, this.form)
    },
    home() {
        router.get(`/imoveis`)
    },
  },
  mounted() {
    if (this.imovel) {
        this.form.endereco = this.imovel.endereco
        this.form.preco = this.imovel.preco
        this.form.tipo = this.imovel.tipo
        this.form.status = this.imovel.status
    }
  },
}

</script>

<style scoped>
.wrapper {
    display: flex;
    padding-top: 50px;
    align-items: flex-start;
}
.card {
    margin-left: 0;
    width: 100%;
    background-color: #edf2fb;
}
</style>
