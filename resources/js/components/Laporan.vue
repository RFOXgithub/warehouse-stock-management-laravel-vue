<template>
  <div class="laporan-container">
    <h2>Laporan Barang</h2>

    <div class="filter-container">
      <input type="date" v-model="filterStart" />
      <input type="date" v-model="filterEnd" />
      <button class="btn-filter" @click="filterLaporan">Filter</button>
    </div>

    <table class="modern-table">
      <thead>
        <tr>
          <th>Kode Barang</th>
          <th>Nama Barang</th>
          <th>Stock Awal</th>
          <th>Total Masuk</th>
          <th>Total Keluar</th>
          <th>Stok Akhir</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in laporanList" :key="item.id">
          <td>{{ item.kode }}</td>
          <td>{{ item.nama }}</td>
          <td>{{ item.stock_awal }}</td>
          <td>{{ item.total_masuk }}</td>
          <td>{{ item.total_keluar }}</td>
          <td>{{ item.stok_akhir }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Laporan",
  data() {
    return {
      laporanList: [],
      filterStart: "",
      filterEnd: "",
    };
  },
  mounted() {
    this.getLaporan();
  },
  methods: {
    async getLaporan(start = null, end = null) {
      try {
        const params = {};
        if (start) params.start = start;
        if (end) params.end = end;

        const response = await axios.get("http://127.0.0.1:8000/api/laporan", { params });
        this.laporanList = response.data;
        console.log("Data laporan:", response.data);
      } catch (error) {
        console.error("Gagal mengambil laporan:", error);
      }
    },
    filterLaporan() {
      console.log("Filter tanggal:", this.filterStart, this.filterEnd);
      this.getLaporan(this.filterStart, this.filterEnd);
    },
  },
};
</script>