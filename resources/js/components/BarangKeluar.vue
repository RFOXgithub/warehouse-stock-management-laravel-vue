<template>
  <div class="table-container">
    <div class="table-header">
      <h2 class="table-title">Barang Keluar</h2>
      <button class="btn-add" @click="showModal = true">Tambah Barang Keluar</button>
    </div>

    <table class="modern-table">
      <thead>
        <tr>
          <th>Kode Barang</th>
          <th>Nama Barang</th>
          <th>Jumlah Keluar</th>
          <th>Tanggal</th>
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in keluarList" :key="item.id">
          <td>{{ item.asset.kode }}</td>
          <td>{{ item.asset.nama }}</td>
          <td>{{ item.jumlah }}</td>
          <td>{{ item.tanggal }}</td>
          <td>{{ item.keterangan }}</td>
        </tr>
      </tbody>
    </table>

    <div class="modal" :class="{ 'modal-active': showModal }">
      <div class="modal-content">
        <h3>Tambah Barang Keluar</h3>

        <select v-model="form.asset_id">
          <option disabled value="">-- Pilih Barang --</option>
          <option v-for="asset in assetList" :key="asset.id" :value="asset.id">
            {{ asset.kode }} - {{ asset.nama }} (Stok: {{ asset.stock_awal }})
          </option>
        </select>

        <input type="date" v-model="form.tanggal" />

        <input
          type="number"
          v-model.number="form.jumlah"
          min="1"
          placeholder="Jumlah Keluar"
        />

        <input type="text" v-model="form.keterangan" placeholder="Keterangan (opsional)" />

        <div class="modal-actions">
          <button @click="submitBarangKeluar" class="btn-save" :disabled="isLoading">
            <span v-if="isLoading" class="spinner"></span>
            <span v-else>Simpan</span>
          </button>
          <button @click="showModal = false" class="btn-cancel" :disabled="isLoading">
            Batal
          </button>
        </div>

        <div v-if="errorMessage" class="error-message">
          Error: {{ errorMessage }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "BarangKeluar",
  data() {
    return {
      assetList: [],
      keluarList: [],
      showModal: false,
      isLoading: false,
      errorMessage: "",
      form: {
        asset_id: "",
        tanggal: "",
        jumlah: null,
        keterangan: ""
      }
    };
  },
  mounted() {
    this.getAssets();
    this.getBarangKeluar();
  },
  methods: {
    async getAssets() {
      try {
        const response = await axios.get("/api/assets");
        this.assetList = response.data;
      } catch (error) {
        console.error("Gagal mengambil daftar barang:", error);
        this.errorMessage = error.message;
      }
    },
    async getBarangKeluar() {
      try {
        const response = await axios.get("/api/barang-keluar");
        this.keluarList = response.data;
      } catch (error) {
        console.error("Gagal mengambil barang keluar:", error);
        this.errorMessage = error.message;
      }
    },
    async submitBarangKeluar() {
      this.errorMessage = "";
      if (!this.form.asset_id || !this.form.tanggal || !this.form.jumlah) {
        this.errorMessage = "Lengkapi semua field!";
        return;
      }
      if (this.form.jumlah <= 0) {
        this.errorMessage = "Jumlah harus lebih dari 0!";
        return;
      }

      this.isLoading = true;

      try {
        console.log("Kirim data:", this.form);
        const response = await axios.post("/api/barang-keluar", this.form);
        console.log("Response:", response.data);

        this.keluarList.push(response.data);
        this.form = { asset_id: "", tanggal: "", jumlah: null, keterangan: "" };
        this.showModal = false;
      } catch (error) {
        console.error("Gagal menyimpan barang keluar:", error);
        if (error.response && error.response.data && error.response.data.error) {
          this.errorMessage = error.response.data.error;
        } else {
          this.errorMessage = "Gagal menyimpan barang keluar!";
        }
      } finally {
        this.isLoading = false;
      }
    }
  }
};
</script>