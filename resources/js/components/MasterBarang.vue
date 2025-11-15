<template>
  <div class="table-container">
    <div class="table-header">
      <h2 class="table-title">Daftar Barang</h2>
      <button class="btn-add" @click="showModal = true">Tambah Barang</button>
    </div>

    <table class="modern-table">
      <thead>
        <tr>
          <th>Kode Barang</th>
          <th>Nama Barang</th>
          <th>Satuan</th>
          <th>Stock Awal</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in assetList" :key="item.id">
          <td>{{ item.kode }}</td>
          <td>{{ item.nama }}</td>
          <td>{{ item.satuan }}</td>
          <td>{{ item.stock_awal }}</td>
          <td>
            <button @click="deleteAsset(item.id)" class="btn-delete">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="modal" :class="{ 'modal-active': showModal }">
      <div class="modal-content">
        <h3>Tambah Barang</h3>

        <input v-model="newAsset.kode" placeholder="Kode Barang" readonly />

        <input v-model="newAsset.nama" placeholder="Nama Barang" />

        <select v-model="newAsset.satuan">
          <option disabled value="">Pilih Satuan</option>
          <option value="pcs">pcs</option>
          <option value="box">box</option>
          <option value="kg">kg</option>
          <option value="ltr">ltr</option>
        </select>

        <input
          v-model.number="newAsset.stock_awal"
          type="number"
          placeholder="Stock Awal"
          min="0"
        />

        <div class="modal-actions">
          <button @click="addAsset" class="btn-save" :disabled="isLoading">
            <span v-if="isLoading" class="spinner"></span>
            <span v-else>Simpan</span>
          </button>
          <button @click="showModal = false" class="btn-cancel" :disabled="isLoading">Batal</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "MasterBarang",
  data() {
    return {
      assetList: [],
      showModal: false,
      isLoading: false,
      newAsset: { kode: "", nama: "", satuan: "", stock_awal: null },
    };
  },
  mounted() {
    this.getAssets();
  },
  methods: {
    async getAssets() {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/assets");
        this.assetList = response.data;
        this.generateKode();
      } catch (error) {
        console.error("Gagal mengambil data assets:", error);
      }
    },

    generateKode() {
      let lastId = 0;
      if (this.assetList.length > 0) {
        const lastItem = this.assetList[this.assetList.length - 1];
        const parts = lastItem.kode.split("-");
        lastId = parseInt(parts[1]) || 0;
      }
      this.newAsset.kode = `BRG-${String(lastId + 1).padStart(3, "0")}`;
    },

    async addAsset() {
      if (!this.newAsset.nama || !this.newAsset.satuan || this.newAsset.stock_awal === null) {
        alert("Isi semua field!");
        return;
      }

      if (this.newAsset.stock_awal < 0) {
        alert("Stock Awal tidak boleh minus!");
        return;
      }

      this.isLoading = true;
      try {
        const response = await axios.post("http://127.0.0.1:8000/api/assets", this.newAsset);
        this.assetList.push(response.data);
        this.newAsset = { kode: "", nama: "", satuan: "", stock_awal: null };
        this.showModal = false;
        this.generateKode();
      } catch (error) {
        console.error("Gagal menambahkan barang:", error);
        alert("Gagal menambahkan barang!");
      } finally {
        this.isLoading = false;
      }
    },

    async deleteAsset(id) {
      if (!confirm("Apakah Anda yakin ingin menghapus barang ini?")) return;

      try {
        await axios.delete(`http://127.0.0.1:8000/api/assets/${id}`);
        this.assetList = this.assetList.filter(item => item.id !== id);
      } catch (error) {
        console.error("Gagal menghapus barang:", error);
        alert("Gagal menghapus barang!");
      }
    }
  },
  watch: {
    showModal(val) {
      if (val) this.generateKode();
    },
  },
};
</script>