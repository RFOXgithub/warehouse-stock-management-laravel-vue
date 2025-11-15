import { createRouter, createWebHistory } from "vue-router";
import MasterBarang from "./components/MasterBarang.vue";
import BarangMasuk from "./components/BarangMasuk.vue"; 
import BarangKeluar from "./components/BarangKeluar.vue";
import Laporan from "./components/Laporan.vue";

const routes = [
  { path: "/master-barang", component: MasterBarang },
  { path: "/barang-masuk", component: BarangMasuk }, 
  { path: "/barang-keluar", component: BarangKeluar }, 
  { path: "/laporan", component: Laporan }, 
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
