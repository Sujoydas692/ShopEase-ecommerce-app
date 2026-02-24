import { defineStore } from "pinia";
import { toast } from "vue3-toastify";
import apiClient from "../lib/axiosClient";

export const useCompareStore = defineStore("compare", {
  state: () => ({
    items: [],
    allProducts: [],
    cachedItems: JSON.parse(localStorage.getItem("compare_items")) || [],
    itemIds: JSON.parse(localStorage.getItem("compare_ids")) || [],
    maxItems: 4,
    loading: false,
    lastUpdated: null,
  }),

  actions: {
    saveToStorage() {
      localStorage.setItem("compare_items", JSON.stringify(this.cachedItems));
      localStorage.setItem("compare_ids", JSON.stringify(this.itemIds));
    },

    loadFromStorage() {
      this.cachedItems = JSON.parse(localStorage.getItem("compare_items")) || [];
      this.itemIds = JSON.parse(localStorage.getItem("compare_ids")) || [];
    },

    async loadLiveData() {
      if (this.itemIds.length === 0) {
        this.items = [];
        return;
      }

      this.loading = true;
      
      try {
        const response = await apiClient.post('/products/batch', { 
          ids: this.itemIds 
        });
        
        this.items = response.data.data || response.data;
        this.lastUpdated = new Date();
        
        console.log('Live data loaded:', this.items);
        
      } catch (error) {
        console.error("Failed to load live data:", error);
        
        this.items = this.cachedItems;
        toast.error("Showing cached data. Please refresh.");
        
      } finally {
        this.loading = false;
      }
    },

    async addToCompare(product) {
      if (this.itemIds.includes(product.id)) {
        toast.error("Already added to compare");
        return;
      }

      if (this.itemIds.length >= this.maxItems) {
        toast.error("You can compare up to 4 products only");
        return;
      }

      this.itemIds.push(product.id);
      
      const normalizedProduct = {
        ...product,
        variations: Array.isArray(product.variations) ? product.variations : [],
      };
      this.cachedItems.push(normalizedProduct);
      
      this.saveToStorage();
      
      await this.loadLiveData();
      
      toast.success("Product added to compare");
    },

    async removeFromCompare(id) {
      this.itemIds = this.itemIds.filter(itemId => itemId !== id);
      
      this.cachedItems = this.cachedItems.filter(item => item.id !== id);
      
      this.saveToStorage();
      
      await this.loadLiveData();
      
      toast.error("Product removed from compare");
    },

    async refreshData() {
      await this.loadLiveData();
      toast.success("Data refreshed");
    },

    getProductStock(product) {
      const variations = Array.isArray(product.variations) ? product.variations : [];
      if (variations.length > 0) {
        return variations.reduce((total, v) => total + Number(v.stock || 0), 0);
      }
      return Number(product.stock || 0);
    },
  },
});