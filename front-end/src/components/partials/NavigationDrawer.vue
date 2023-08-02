<template>
  <div>
    <v-navigation-drawer v-model="drawer" temporary>
      <v-list-item
        prepend-avatar="https://randomuser.me/api/portraits/men/78.jpg"
        title="John Leider"
      ></v-list-item>

      <v-divider></v-divider>

      <v-list density="compact" nav>
        <v-list-item title="Home" value="home"></v-list-item>
        <v-list-item title="About" value="about"></v-list-item>
      </v-list>
    </v-navigation-drawer>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps({
  opened: {
    type: Boolean,
    default: false
  }
})

const drawer = computed(() => props.opened)
</script>

<style scoped></style>
