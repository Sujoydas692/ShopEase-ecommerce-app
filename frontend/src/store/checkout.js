import { defineStore } from "pinia";
import apiClient from "../lib/axiosClient";
import { toast } from "vue3-toastify";
import router from "@/router";

export const useCheckoutStore = defineStore("checkout", {
  state: () => ({
    loading: false,

    formData: {
      first_name: "",
      last_name: "",
      email: "",
      phone: "",
      address: "",
      postal_code: "",
      district_id: "",
      upazila_id: "",
      payment_method: "cod",
    },
  }),

  actions: {
    async loadCustomerProfile() {
      try {
        const { useCartStore } = await import("./cart");
        const cartStore = useCartStore();

        const { data } = await apiClient.get("/customer-profile");

        if (data && data.data) {
          const p = data.data;

          this.formData.first_name = p.first_name || "";
          this.formData.last_name = p.last_name || "";
          this.formData.email = p.email || "";
          this.formData.phone = p.phone || "";
          this.formData.address = p.address || "";
          this.formData.postal_code = p.postal_code || "";

          const d = cartStore.districts.find((x) => x.name === p.district);
          if (d) {
            this.formData.district_id = d.id;

            await cartStore.loadUpazila(d.id);

            const u = cartStore.upazilas.find((x) => x.name === p.upazila);
            this.formData.upazila_id = u ? u.id : "";
          }
        }
      } catch (error) {
        console.log("No customer profile found.");
      }
    },

    async processCheckout(payload) {
      const { useAuth } = await import("./auth");
      const { useCartStore } = await import("./cart");
      const auth = useAuth();
      const cart = useCartStore();

      if (!auth.isAuthenticated) {
        toast.warning("You need to login first!");
        setTimeout(() => router.push("/login"), 2000);
        return;
      }

      if (cart.carts.length === 0) {
        toast.error("Your cart is empty!");
        return;
      }

      this.loading = true;

      try {
        const { data } = await apiClient.post("/checkout", payload);

        toast.success(
          Array.isArray(data?.message)
            ? data.message[0]
            : data?.message || "Order placed successfully!"
        );

        cart.carts = [];
        cart.saveCartToLocal();

        setTimeout(() => router.push("/dashboard/order-complete"), 2000);
      } catch (error) {
        toast.error(error.response?.data?.message || "Checkout failed!");
      } finally {
        this.loading = false;
      }
    },
  },
});
