<template>
  <div class="d-flex">
    <SideBar />
    <div class="flex-grow-1 p-4">
      <router-view></router-view> 
    </div>
  </div>
</template>


<script>
import SideBar from './components/SideBar.vue' 

export default {
  name: 'App',
  components: {
    SideBar
  },
}
</script>

<style>
#app {
  text-align: center;
}
</style>
