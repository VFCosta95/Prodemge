<template>
    <h1 style="text-align: center; margin: 24px 0px;">Cadastro de Pessoas</h1>
    <br>
    <v-container>
            <v-row class="d-flex align-center">
                <v-col cols="12" >
                <v-text-field
                    v-model="queryNome"
                    label="Pesquisar por Nome"
                    @input="onSearch"
                ></v-text-field>
                </v-col>
            </v-row>

            <v-row class="d-flex align-center">
                <v-col cols="12" >
                <v-text-field
                    v-model="queryCPF"
                    label="Pesquisar por CPF"
                    @input="onSearch"
                ></v-text-field>
                </v-col>
            </v-row>
  
      <v-row>
        <v-col cols="12">
          <v-data-table
            :headers="headers"
            :items="filteredPessoas"
            item-key="id"
          >
            <template v-slot:items="props">
              <tr :key="props.item.id">
                <td>{{ props.item.id }}</td>
                <td>{{ props.item.nome }}</td>
                <td>{{ props.item.cpf }}</td>                
              </tr>
            </template>
          </v-data-table>
        </v-col>
      </v-row>
    </v-container>
</template>

<script setup>
    import { ref, computed, onMounted } from 'vue';
    import Service from '../service/service';

    const queryNome = ref('');
    const queryCPF = ref('');
    const pessoas = ref([]);
    const service = new Service();

    const headers = [
    { text: 'ID', value: 'id' },
    { text: 'Nome', value: 'nome' },
    { text: 'CPF', value: 'cpf' },
    ];

    // Função para Obter Pessoas
    const obterPessoas = () => {
    service.getPessoas()
        .then(data => {
        pessoas.value = data;
        })
        .catch(error => console.error('Erro ao obter pessoas:', error));
    };

    // Função para Pesquisar Nome e CPF
    const filteredPessoas = computed(() => {
    const nomeTerm = queryNome.value.toLowerCase();
    const cpfTerm = queryCPF.value.toLowerCase();
    return pessoas.value.filter(pessoa => 
        (pessoa.nome.toLowerCase().includes(nomeTerm) || !nomeTerm) &&
        (pessoa.cpf.toLowerCase().includes(cpfTerm) || !cpfTerm)
    );
    });

    const onSearch = () => {
    };

    onMounted(() => {
        obterPessoas();
    });
</script>

  