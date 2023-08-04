<template>
  <div>
    <!-- <header>
      <v-img src="" title="img"></v-img>
      <v-icon icon="fas fa-list"></v-icon>
      <router-link to="#">123</router-link>
      <router-link to="#">123</router-link>
      <router-link to="#">123</router-link>
    </header> -->
    <div>
      <v-app-bar>
        <v-app-bar-nav-icon icon="mdi-menu" @click="drawer = !drawer">
          <!-- <v-icon icon="mdi-menu" color="black"></v-icon> -->
        </v-app-bar-nav-icon>
        <v-app-bar-title>
          <v-img :src="logo" contain width="50px"></v-img>
        </v-app-bar-title>
      </v-app-bar>
      <navigation-drawer :opened="drawer" />
      <br /><br /><br />
      <div id="main">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import NavigationDrawer from '../partials/NavigationDrawer.vue'
import logo from '@/assets/logo.svg'

const drawer = ref(false)
</script>

<style scoped>
/* #main{
    max-width: 1280px;
    margin: auto;
} */
</style>
