<template>
    <div class="card col-5 offset-3">
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
                    <td>{{ imovel.preco }}</td>
                    <td>{{ imovel.tipo }}</td>
                    <td>{{ imovel.status }}</td>
                    <td>
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

import { useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

export default {
  name: 'Home',
  props: {
    imoveis: {
        type: Object,
    }
  },
  methods: {
    destroy(id) {
        router.delete(`/imoveis/${id}`)
    },
    edit(id) {
        router.get(`/imoveis/${id}/edit`)
    },
  },
}

</script>

<style></style>
