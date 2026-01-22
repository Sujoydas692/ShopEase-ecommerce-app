import { defineStore } from "pinia";
import apiClient from "../lib/axiosClient";
import { useAuth } from "./auth";
import { toast } from "vue3-toastify";

export const useWishlistStore = defineStore("wishlist", {
  state: () => ({
    items: [],
    products: [],
    loading: false,
  }),

  getters: {
    has: (state) => (productId) => state.items.includes(productId),
    count: (state) => state.items.length,
  },

  actions: {
    async loadWishlist() {
      const auth = useAuth();

      if (!auth.isAuthenticated) {
        this.clear();
        return;
      }

      const cached = localStorage.getItem("wishlist_products");
      if (cached && this.products.length === 0) {
        this.products = JSON.parse(cached);
        this.items = this.products.map((i) => i.product_id);
      }

      try {
        this.loading = true;
        const { data } = await apiClient.get("/wish-list");

        this.products = data.data;
        this.items = data.data.map((i) => i.product_id);

        localStorage.setItem(
          "wishlist_products",
          JSON.stringify(this.products)
        );
      } catch (error) {
        console.error("Wishlist load failed", error);
      } finally {
        this.loading = false;
      }
    },

    async toggle(productId) {
      const auth = useAuth();

      if (!auth.isAuthenticated) {
        toast.warning("You need to login first!");
        return false;
      }

      try {
        const { data } = await apiClient.post("add/wish-list", {
          product_id: productId,
        });

        toast.success(
          Array.isArray(data?.message) ? data.message[0] : data?.message
        );

        if (this.items.includes(productId)) {
          this.items = this.items.filter((id) => id !== productId);
          this.products = this.products.filter(
            (p) => p.product_id !== productId
          );
        } else {
          this.items.push(productId);
        }

        localStorage.setItem(
          "wishlist_products",
          JSON.stringify(this.products)
        );

        return true;
      } catch (error) {
        toast.error(
          error.response?.data?.message || "Failed to update wishlist"
        );
        return false;
      }
    },

    async remove(productId) {
      try {
        const { data } = await apiClient.post("remove/wish-list", {
          product_id: productId,
        });

        toast.success(
          Array.isArray(data?.message) ? data.message[0] : data?.message
        );

        this.products = this.products.filter(
          (item) => item.product_id !== productId
        );
        this.items = this.items.filter((id) => id !== productId);

        localStorage.setItem(
          "wishlist_products",
          JSON.stringify(this.products)
        );
      } catch (error) {
        toast.error(
          error.response?.data?.message || "Failed to remove wishlist"
        );
      }
    },

    clear() {
      this.items = [];
      this.products = [];
      localStorage.removeItem("wishlist_products");
    },
  },
});
