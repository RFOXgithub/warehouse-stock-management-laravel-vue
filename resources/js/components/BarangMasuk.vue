<template>
  <div class="table-container">
    <div class="table-header">
      <h2 class="table-title">Barang Masuk</h2>
      <button class="btn-add" @click="showModal = true">Tambah Barang Masuk</button>
    </div>

    <table class="modern-table">
      <thead>
        <tr>
          <th>Kode Barang</th>
          <th>Nama Barang</th>
          <th>Jumlah Masuk</th>
          <th>Tanggal</th>
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in masukList" :key="item.id">
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
        <h3>Tambah Barang Masuk</h3>

        <select v-model="form.asset_id">
          <option disabled value="">-- Pilih Barang --</option>
          <option v-for="asset in assetList" :key="asset.id" :value="asset.id">
            {{ asset.kode }} - {{ asset.nama }}
          </option>
        </select>

        <input type="date" v-model="form.tanggal" />

        <input type="number" v-model.number="form.jumlah" min="1" placeholder="Jumlah Masuk" />

        <input type="text" v-model="form.keterangan" placeholder="Keterangan (opsional)" />

        <div class="modal-actions">
          <button @click="submitBarangMasuk" class="btn-save" :disabled="isLoading">
            <span v-if="isLoading" class="spinner"></span>
            <span v-else>Simpan</span>
          </button>
          <button @click="showModal = false" class="btn-cancel" :disabled="isLoading">
            Batal
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "BarangMasuk",
  data() {
    return {
      assetList: [],
      masukList: [],
      showModal: false,
      isLoading: false,
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
    this.getBarangMasuk();
  },
  methods: {
    async getAssets() {
      try {
        const response = await axios.get("/api/assets");
        this.assetList = response.data;
      } catch (error) {
        console.error("Gagal mengambil daftar barang:", error);
      }
    },
    async getBarangMasuk() {
      try {
        const response = await axios.get("/api/barang-masuk");
        this.masukList = response.data;
      } catch (error) {
        console.error("Gagal mengambil barang masuk:", error);
      }
    },
    async submitBarangMasuk() {
      if (!this.form.asset_id || !this.form.tanggal || !this.form.jumlah) {
        alert("Lengkapi semua field!");
        return;
      }

      if (this.form.jumlah <= 0) {
        alert("Jumlah harus lebih dari 0!");
        return;
      }

      this.isLoading = true;

      try {
        const response = await axios.post("/api/barang-masuk", this.form);
        this.masukList.push(response.data);

        this.form = { asset_id: "", tanggal: "", jumlah: null, keterangan: "" };
        this.showModal = false;
        alert("Barang masuk berhasil disimpan!");
      } catch (error) {
        console.error("Gagal menyimpan barang masuk:", error);
        alert("Gagal menyimpan barang masuk!");
      } finally {
        this.isLoading = false;
      }
    }
  }
};
</script>