<template>
    <div class="container">
        <form @submit.prevent="submitForm">
        
            <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome"v-model="form.nome" required />
            </div>

            <div class="form-group">
            <label for="nome_social">Nome Social:</label>
            <input type="text" id="nome"v-model="form.nome_social" required />
            </div>
    
            <div class="form-group">
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" v-model="form.cpf" required />
            </div>

            <div class="form-group">
            <label for="nome_pai">Nome do Pai:</label>
            <input type="text" id="nome_pai" v-model="form.nome_pai" required />
            </div>

            <div class="form-group">
            <label for="nome_mae">Nome da Mãe:</label>
            <input type="text" id="nome_mae" v-model="form.nome_mae" required />
            </div>

            <div class="form-group">
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" v-model="form.telefone" required />
            </div>

            <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" id="email" v-model="form.email" required />
            </div>
    
            <v-btn type="submit" color="primary">Enviar</v-btn>

        </form>
    </div>
</template>

<script setup>

    import Service from '../service/service'
    import { ref } from 'vue';
    import { useRoute, useRouter } from 'vue-router';

    const pessoas = ref([]);
    const service = new Service();

    const form = ref({
        nome: '',
        nome_social: '',
        cpf: '',
        nome_pai: '',
        nome_mae: '',
        telefone: '',
        email: ''
    });

    const route = useRoute();
    const router = useRouter();

    const loadPessoa = async (id) => {
      try {
        const pessoa = await service.getPessoa(id); 
        form.value = { ...pessoa };
      } catch (error) {
        console.error('Erro ao carregar pessoa:', error);
      }
    };

    const submitForm = () => {
        console.log('Dados do formulário antes de enviar:', form.value);
        const formData = {...form.value}

        const id = route.params.id;
        console.log(id)

        service.updatePessoa(id, formData)
            .then(res => {
                console.log(res);
                const index = pessoas.value.findIndex(pessoa => pessoa.id === id);
                if (index !== -1) {
                    pessoas.value[index] = formData;
                }
                router.push('/'); 
            })
    };

    onMounted(() => {
      const id = route.params.id;
      if (id) {
        loadPessoa(id);
      }
    });
    
</script>

<style scoped>
.form-container {
  max-width: 600px;
  margin: 0 auto;
  padding: 1rem;
  background: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

h1 {
  text-align: center;
  margin-bottom: 1.5rem;
  color: #333;
}

input{
    color:darkgray;
}
.form {
  display: flex;
  flex-direction: column;
}

.form-group {
  margin-bottom: 1rem;
}

label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: bold;
  color: #555;
}

input[type="text"],
input[type="tel"],
input[type="email"] {
  width: 100%;
  padding: 0.8rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type="text"]:focus,
input[type="tel"]:focus,
input[type="email"]:focus {
  border-color: #007bff;
  outline: none;
}

.submit-btn {
  padding: 0.8rem;
  border: none;
  border-radius: 4px;
  background-color: #007bff;
  color: #fff;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.submit-btn:hover {
  background-color: #0056b3;
}

.submit-btn:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}
</style>