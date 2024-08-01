<template>

    <div class="container">
        <h1>Lista de Pessoas</h1>
    </div>

    <v-table>
        <thead>
            <tr>
                <th class="text-left">#</th>
                <th class="text-left">Nome</th>
                <th class="text-left">CPF</th>
                <th class="text-left">Telefone</th>
                <th class="text-left">Detalhes</th>
                <th class="text-left">Editar</th>
                <th class="text-left">Deletar</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in pessoas" :key="item.id">
                <td>{{ item.id }}</td>
                <td>{{ item.nome }}</td>
                <td>{{ item.cpf }}</td>
                <td>{{ item.telefone }}</td>
                <td>
                    <v-btn @click="viewDetails(item.id)" color="success">Clique Aqui</v-btn>
                </td>
                <td>
                    <router-link :to="`/editar/${item.id}`">
                        <img width="32" height="32" src="https://img.icons8.com/windows/32/edit--v1.png" alt="edit--v1"/>          
                    </router-link>
                </td>
                <td>
                    <a href="#" @click.prevent="deletePessoa(item.id)">
                        <img width="24" height="24" src="https://img.icons8.com/material-rounded/24/filled-trash.png" alt="filled-trash"/>
                    </a>
                </td>
            </tr>
        </tbody>
    </v-table>

    <v-dialog v-model="showDetails" max-width="600px">
            <v-card>
                <v-card-title>
                    Detalhes
                </v-card-title>
                <v-card-subtitle>
                    <v-btn @click="showDetails = false" text>Fechar</v-btn>
                </v-card-subtitle>
                <v-card-text>
                    <div v-if="selectedPessoa">
                        <h3>Detalhes da Pessoa</h3>
                        <p><strong>Nome:</strong> {{ selectedPessoa.nome }}</p>
                        <p><strong>CPF:</strong> {{ selectedPessoa.cpf }}</p>
                        <p><strong>Email:</strong> {{ selectedPessoa.email }}</p>
                    </div>
                    <div v-if="selectedEndereco">
                        <h3>Detalhes do Endereço</h3>
                        <p><strong>Tipo:</strong> {{ selectedEndereco.tipo_endereco }}</p>
                        <p><strong>CEP:</strong> {{ selectedEndereco.cep }}</p>
                        <p><strong>Logradouro:</strong> {{ selectedEndereco.logradouro }}</p>
                        <p><strong>Número:</strong> {{ selectedEndereco.numero }}</p>
                        <p><strong>Complemento:</strong> {{ selectedEndereco.complemento }}</p>
                        <p><strong>Bairro:</strong> {{ selectedEndereco.bairro }}</p>
                        <p><strong>Cidade:</strong> {{ selectedEndereco.cidade }}</p>
                        <p><strong>Estado:</strong> {{ selectedEndereco.estado }}</p>
                    </div>
                </v-card-text>
            </v-card>
        </v-dialog>


</template>

<script setup>

    import Service from '../service/service'
    import { ref, onMounted } from 'vue';

    const pessoas = ref([]);
    const service = new Service();
    const showDetails = ref(false);
    const selectedPessoa = ref(null);
    const selectedEndereco = ref(null);

    const headers = [
        { text: 'ID', value: 'id' },
        { text: 'Nome', value: 'nome' },
        { text: 'CPF', value: 'cpf' },
        { text: 'Ações', value: 'actions', sortable: false }
    ];

    const viewDetails = (id) => {
        service.getPessoa(id)
            .then(pessoaData => {
                selectedPessoa.value = pessoaData;
                return service.getEndereco(id);
            })
            .then(enderecoData => {
                selectedEndereco.value = enderecoData;
                showDetails.value = true;
            })
            .catch(error => {
                console.error('Erro ao obter detalhes:', error);
            });
    };

    // GET
    const obterPessoas = () => {
        service.getPessoas()
        .then(data => {
                console.log('Dados recebidos:', data);
                pessoas.value = data;
                console.log(data)
            })
        .catch(error => console.error('Erro ao obter pessoas:', error));
    };

    // DELETE
    const deletePessoa = (id) => {
      service.deletePessoa(id)
        .then(() => {
          console.log('Pessoa deletada com sucesso');
          alert('Pessoa deletada com sucesso');
        })
        .catch(error => console.error('Erro ao deletar pessoa:', error));
    };

    onMounted(obterPessoas);

</script>

<style>
    .container{
        display: flex;
        justify-content: center;
        margin: 24px 0px;
    }
</style>