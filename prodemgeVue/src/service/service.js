export default class Service {

    url = 'http://127.0.0.1:8000/api';
    cepApiUrl = 'https://viacep.com.br/ws'; 

    constructor() { }

    // GET ID
    getPessoa(id) {
        return fetch(`${this.url}/pessoas/${id}`, { method: 'GET' })
          .then(res => res.json())
          .catch(error => console.error('Erro ao buscar pessoa:', error));
    }

    // GET
    getPessoas() {
        return fetch(this.url + '/pessoas', { method: 'GET' })
            .then(res => res.json())
            .catch(error => console.error(error));
    }

    // POST
    createPessoa(pessoa) {
        return fetch(this.url + '/pessoas', { method: 'POST',
            headers: {'Content-Type': 'application/json',},
            body: JSON.stringify(pessoa),
        })
        .then(res => {
            console.log('Status da resposta:', res.status); // Log do status
            console.log('Headers da resposta:', res.headers); // Log dos headers

            if (!res.ok) {
                return res.text().then(text => { throw new Error(text); });
            }
            return res.json();
        })
        .catch(error => console.error('Error ao Criar pessoa:', error));
    }

    // PUT
    updatePessoa(id, pessoa) {
        return fetch(`${this.url}/pessoas/${id}`, { method: 'PUT',
            headers: {'Content-Type': 'application/json',},
            body: JSON.stringify(pessoa),
        })
        .then(res => {
          if (!res.ok) {
            throw new Error('Falha ao editar pessoa');
          }
          return res.json();
        })
        .catch(error => console.error('Error de editar de pessoa:', error));
    }

    // DELETE
    deletePessoa(id) {
        return fetch(`${this.url}/pessoas/${id}`, { method: 'DELETE',})
        .then(res => {
        if (!res.ok) {
            throw new Error('Failed to delete pessoa');
        }
        return res.json();
        })
        .catch(error => console.error('Error delete pessoa:', error));
    }

    // POST Endereço
    addEndereco(id, endereco) {
        return fetch(`${this.url}/pessoas/${id}/enderecos`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(endereco)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao adicionar endereço');
            }
            return response.json();
        })
        .catch(error => {
            console.error('Erro ao adicionar endereço:', error);
            throw error; // Re-throw error for further handling
        });
    }

    // GET ID Endereco
    getEndereco(id) {
        return fetch(`${this.url}/endereco/${id}`, { method: 'GET' })
          .then(res => res.json())
          .catch(error => console.error('Erro ao buscar endereco:', error));
    }

    // API CEP GET
    buscarEnderecoPorCep(cep) {
        return fetch(`${this.cepApiUrl}/${cep}/json/`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao buscar endereço');
                }
                return response.json();
            })
            .catch(error => {
                console.error('Erro ao buscar endereço:', error);
                throw error;
            });
    }
}