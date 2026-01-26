import { defineStore } from "pinia";
import apiClient from "../lib/axiosClient";
import { toast } from "vue3-toastify";
import router from "@/router";

export const useCartStore = defineStore("cart", {
  state: () => ({
    carts: [],
    districts: [],
    upazilas: [],
    selectedDistrict: "",
    selectedUpazila: "",
    shippingCharge: 0,
  }),

  getters: {
    totalQty: (state) => state.carts.reduce((sum, item) => sum + item.qty, 0),

    subtotal: (state) =>
      state.carts
        .reduce((sum, item) => sum + item.qty * item.product.price, 0)
        .toFixed(2),

    grandTotal(state) {
      const subtotal = parseFloat(state.subtotal) || 0;
      const shipping = parseFloat(state.shippingCharge) || 0;

      return (subtotal + shipping).toFixed(2);
    },
  },

  actions: {
    loadCartFromLocal() {
      const savedCart = localStorage.getItem("cart_items");
      if (savedCart) {
        this.carts = JSON.parse(savedCart);
      }
    },

    saveCartToLocal() {
      localStorage.setItem("cart_items", JSON.stringify(this.carts));
    },

    saveLocationToLocal() {
      localStorage.setItem("selected_district", this.selectedDistrict);
      localStorage.setItem("selected_upazila", this.selectedUpazila);
    },

    async loadLocationFromLocal() {
      const districtId = localStorage.getItem("selected_district");
      const upazilaId = localStorage.getItem("selected_upazila");

      if (districtId) {
        this.selectedDistrict = Number(districtId);

        try {
          const { data } = await apiClient.get(
            `/shipping-charge/${districtId}`
          );
          this.shippingCharge = data?.charge ?? 0;
        } catch {
          this.shippingCharge = 0;
        }
      }

      if (upazilaId) {
        this.selectedUpazila = Number(upazilaId);
      }
    },

    async loadCart() {
      try {
        const { data } = await apiClient.get("/carts");
        this.carts = data.data;
        this.saveCartToLocal();
      } catch (error) {
        console.error("Failed to load Cart List", error);
      }
    },

    async loadDistricts() {
      try {
        const { data } = await apiClient.get("/districts");
        this.districts = data.data;
      } catch (error) {
        console.error("Failed to load districts", error);
      }
    },

    async loadUpazila(districtId) {
      try {
        const { data } = await apiClient.get(`/upazilas/${districtId}`);
        this.upazilas = data.data;
      } catch (error) {
        console.error("Failed to load upazilas", error);
      }
    },

    async setDistrict(districtId) {
      this.selectedDistrict = Number(districtId);

      if (!districtId) {
        this.shippingCharge = 0;
        return;
      }

      try {
        const { data } = await apiClient.get(`/shipping-charge/${districtId}`);
        this.shippingCharge = data?.charge ?? 0;
      } catch (error) {
        console.error("Failed to load shipping charge", error);
        this.shippingCharge = 0;
      }

      this.saveLocationToLocal();
    },

    setUpazila(upazilaId) {
      this.selectedUpazila = Number(upazilaId);
      this.saveLocationToLocal();
    },

    async addToCart({ productId, qty = 1, size = null, color = null }) {
      const { useAuth } = await import("./auth");
      const auth = useAuth();
      if (!auth.isAuthenticated) {
        toast.warning("You need to login first!");

        setTimeout(() => {
          router.push("/login");
          return;
        }, 2000);
      } else {
        try {
          const payload = {
            product_id: productId,
            qty,
          };

          if (size) payload.size = size;
          if (color) payload.color = color;

          const { data } = await apiClient.post("add/cart", payload);

          toast.success(
            Array.isArray(data?.message) ? data.message[0] : data?.message
          );

          await this.loadCart();
        } catch (error) {
          toast.error(error.response?.data?.message || "Failed to add to cart");
        }
      }
    },

    async updateCartQty(itemId, type) {
      const item = this.carts.find((c) => c.id === itemId);
      if (!item) return;

      let newQty = item.qty;

      if (type === "increase") newQty++;
      else if (type === "decrease" && item.qty > 1) newQty--;

      try {
        await apiClient.post("/update/cart", {
          id: itemId,
          qty: newQty,
        });

        item.qty = newQty;
        this.saveCartToLocal();
      } catch (error) {
        const msg =
          error.response?.data?.message || "Failed to update quantity";
        toast.error(msg);
      }
    },

    async removeCart(cartId) {
      try {
        const { data } = await apiClient.post("remove/cart", {
          cart_id: cartId,
        });

        toast.success(
          Array.isArray(data?.message) ? data.message[0] : data?.message
        );

        this.carts = this.carts.filter(
          (item) => item.cart_id !== cartId && item.id !== cartId
        );
        this.saveCartToLocal();
      } catch (error) {
        toast.error(error.response?.data?.message || "Failed to remove Cart");
      }
    },

    async flashCart() {
      try {
        const { data } = await apiClient.get("/clear/cart");

        toast.success(
          Array.isArray(data?.message) ? data.message[0] : data?.message
        );

        this.carts = [];
        this.saveCartToLocal();
      } catch (error) {
        toast.error(error.response?.data?.message || "Failed to clear cart");
      }
    },

    clearCart() {
      this.carts = [];
      localStorage.removeItem("cart_items");
    }
  },
});
