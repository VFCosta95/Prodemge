<template>
    <v-container>
        <v-form v-model="valid" @submit.prevent="submitForm">
            <h2>Adicionar Pessoa</h2><br><hr>
            <v-row>
                <!-- Campos do formulário para cadastrar pessoa -->
                <v-col cols="12" md="6">
                    <v-text-field v-model="form.nome" label="Nome" required></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="form.nome_social" label="Nome Social"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="form.cpf" label="CPF" required></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="form.nome_pai" label="Nome do Pai"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="form.nome_mae" label="Nome da Mãe"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="form.telefone" label="Telefone"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="form.email" label="Email" required></v-text-field>
                </v-col>
            </v-row>
            <v-btn type="submit" color="primary">Salvar Pessoa</v-btn>
        </v-form>

        <!-- Se a pessoa foi criada, mostrar o formulário para adicionar endereços -->
        <v-form v-if="pessoaCriada" @submit.prevent="submitEndereco" class="container">
            <h2>Adicionar Endereço</h2>
            <v-row>
                <!-- Campos para endereço residencial -->
                <v-select
                v-model="endereco.tipo_endereco"
                :items="tiposEnderecos"
                label="Tipo de Endereço"
                required
                placeholder="Selecione o tipo de endereço"
                ></v-select>
                <v-col cols="12" md="6">
                    <v-text-field v-model="endereco.cep" label="CEP" @blur="preencherEnderecoPorCep" required></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="endereco.logradouro" label="Logradouro" required></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="endereco.numero" label="Número" required></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="endereco.complemento" label="Complemento"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="endereco.bairro" label="Bairro" required></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="endereco.estado" label="Estado" required></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="endereco.cidade" label="Cidade" required></v-text-field>
                </v-col>
            </v-row>
            <v-btn type="submit" color="primary">Salvar Endereço</v-btn>
        </v-form>
    </v-container>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router'; 
import Service from '../service/service'; 

const service = new Service();
const router = useRouter(); 
const pessoas = ref([]);
const pessoaId = ref(null); 
const pessoaCriada = ref(false);

    // Formulario para Pessoas
    const form = ref({
        nome: '',
        nome_social: '',
        cpf: '',
        nome_pai: '',
        nome_mae: '',
        telefone: '',
        email: ''
    });

    // Formulario para Endereço
    const endereco = ref({
        tipo_endereco: '',
        cep: '',
        logradouro: '',
        numero: '',
        complemento: '',
        bairro: '',
        estado: '',
        cidade: ''
    });

    const tiposEnderecos = ref([
        'Residencial',
        'Comercial'
    ]);

    // Enviar os dados para o serviço
    const submitForm = () => {
        console.log('Dados do formulário antes de enviar:', form.value);

        const formData = { ...form.value };
        service.createPessoa(formData)
            .then(response => {
                    console.log('Pessoa criada com sucesso:', response);
                    pessoaId.value = response.id; // Armazena o ID 
                    console.log(response.id)
                    pessoaCriada.value = true; // Habilita o formulário de endereço
                    form.value = {
                        nome: '',
                        nome_social: '',
                        cpf: '',
                        nome_pai: '',
                        nome_mae: '',
                        telefone: '',
                        email: ''
                    };
                })
                .catch(error => {
                    console.error('Erro ao criar pessoa:', error);
                });
    };

    // Enviar os dados do Endereço
    const submitEndereco = () => {
        
        if (pessoaId.value === null) {
            console.error('ID da pessoa não está disponível');
            return;
        }

        const enderecoData = { ...endereco.value };
        service.addEndereco(pessoaId.value, enderecoData)
        router.push('/');
    };

    // Função viaCep
    const preencherEnderecoPorCep = () => {
        if (!endereco.value.cep) return;

        service.buscarEnderecoPorCep(endereco.value.cep)
            .then(data => {
                if (data.erro) {
                    console.error('CEP não encontrado');
                    return;
                }
                endereco.value.logradouro = data.logradouro;
                endereco.value.bairro = data.bairro;
                endereco.value.cidade = data.localidade;
                endereco.value.estado = data.uf;
            })
            .catch(error => {
                console.error('Erro ao buscar endereço:', error);
            });
    };

</script>

<style scoped>
    .container{
        margin-top: 64px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
</style>