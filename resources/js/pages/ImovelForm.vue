<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, router } from '@inertiajs/vue3';
import StatusEnum from '../enums/StatusEnum'
import TypeEnum from '../enums/TypeEnum'
import CurrencyInput from '../components/CurrencyInput.vue'
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Novo Imovel</h2>
        </template>

        <div class="wrapper">
            <div class="card">
                <div class="card-header">
                    <strong>{{ imovel ? 'Editando Imóvel' : 'Cadastre um novo Imóvel' }}</strong>
                </div>

                <div class="card-body">
                    <form @submit.prevent="imovel ? editImovel() : createImovel()">
                        <div class="mb-3">
                            <InputLabel for="endereco" value="Endereço" />

                            <TextInput
                                id="endereco"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.endereco"
                                required
                                autofocus
                                autocomplete="endereco"
                            />

                            <InputError class="mt-2" :message="errors.endereco" />
                        </div>

                        <div class="mb-3">
                            <InputLabel for="preco" value="Preço" />

                            <CurrencyInput
                                v-model="form.preco"
                                :options="{ currency: 'BRL' }"
                            />

                            <InputError class="mt-2" :message="errors.preco" />
                        </div>

                        <div class="mb-3">
                            <InputLabel for="tipo" value="Tipo" />

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
                            <InputLabel for="status" value="Status" />

                            <select v-model="form.status" class="form-select">
                                <option
                                    v-for="status in statusOptions"
                                    :value="status.value"
                                >
                                    {{ status.label }}
                                </option>
                            </select>
                        </div>

                        <div class="button-wrapper">
                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                {{ imovel ? 'Salvar' : 'Finalizar Cadastro' }}
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
const BASE_ROUTE = '/imoveis'

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
        router.post(BASE_ROUTE, this.form)
    },
    editImovel() {
        router.put(`${BASE_ROUTE}/${this.imovel.id}`, this.form)
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
}
.form-control, .form-select {
    border-radius: 8px;
}
.btn-primary {
    color: black;
}
.btn-primary:hover {
    color: white;
}
.button-wrapper {
    width: 100%;
    display: flex;
    justify-content: flex-end;
    margin-top: 40px;
}
</style>
