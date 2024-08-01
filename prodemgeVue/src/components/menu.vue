<template>
    <v-app>
        <v-app-bar app color="primary" dark>
            <v-toolbar-title>Menu</v-toolbar-title>
            <v-spacer></v-spacer>
            <router-link :to="`/`">
                <v-btn text to="/">Home</v-btn>
            </router-link>

            <router-link :to="`/tabela`">
                <v-btn text to="/tabela">Tabela</v-btn>
            </router-link>

            <router-link :to="`/adicionar`">
                <v-btn text to="/adicionar">Adicionar Pessoa e Endereço</v-btn>
            </router-link>
        </v-app-bar>
    

        <v-main>
            <router-view></router-view>
        </v-main>

    </v-app>

</template>
  
<script setup>
</script>

<style scoped>
    .v-toolbar-title {
        font-size: 24px;
        font-weight: bold;
    }
</style>
