<script setup>
import LocalStorageView from './components/LocalStorageView.vue'
import Aufgaben from './components/Aufgaben.vue'
import WelcomeItem from "@/components/WelcomeItem.vue";
</script>

<template>
    <welcome-item/>
  <div>
    <LocalStorageView />
    <Aufgaben />
  </div>



</template>

<style scoped>

</style>
