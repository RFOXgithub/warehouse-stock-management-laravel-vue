<template>
  <div class="d-flex">
    <div class="sidebar">
      <h4 class="mb-4">Dashboard</h4>
      <b-nav vertical>
<b-nav-item
  v-for="item in menuItems"
  :key="item.id"
  class="sidebar-item"
  :class="{ active: activeItem === item.id }"
  :to="item.route"
  router
  @click="setActive(item.id)"
>
  <i :class="item.icon + ' me-2'"></i> {{ item.name }}
</b-nav-item>

      </b-nav>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      activeItem: 1,
menuItems: [
  { id: 1, name: "Master Barang", icon: "bi bi-house-door-fill", route: "/master-barang" },
  { id: 2, name: "Barang Masuk", icon: "bi bi-folder-fill", route: "/barang-masuk" },
  { id: 3, name: "Barang Keluar", icon: "bi bi-gear-fill", route: "/barang-keluar" },
  { id: 4, name: "Laporan", icon: "bi bi-file-earmark-text-fill", route: "/laporan" },
],
    };
  },
  methods: {
    setActive(id) {
      this.activeItem = id;
    }
  }
};
</script>
