<template>
    <div class="card text-center">
        <div class="card-header">
            Featured
        </div>
        <div class="card-body">
            <form @submit.prevent="createImovel()">
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
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
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
        statusOptions: [
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
        typeOptions: [
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
    }
  }
}

</script>

<style></style>
