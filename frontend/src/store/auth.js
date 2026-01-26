import { defineStore } from "pinia";
import apiClient from "../lib/axiosClient";
import router from "../router";
import { toast } from "vue3-toastify";
import { useCartStore } from "./cart";
import { useWishlistStore } from "./wishList";

export const useAuth = defineStore("auth", {
  state: () => ({
    email: "",
    user: JSON.parse(localStorage.getItem("user")) || null,
    access_token: localStorage.getItem("access_token") || null,
    sending: false,
    message: "",
    verifying: false,
    otpSent: false,
  }),
  getters: {
    isAuthenticated: (check) => !!check.access_token,
  },
  actions: {
    async sendOtp(email) {
      this.sending = true;

      try {
        const { data } = await apiClient.post("login/otp/send", { email });
        this.email = email;
        this.message = Array.isArray(data?.message)
          ? data.message[0]
          : data?.message;
        toast.success(this.message);
        this.otpSent = true;
      } catch (error) {
        this.message =
          error?.response?.data?.message?.[0] || "Something went wrong";
        toast.error(this.message);
      }
      this.sending = false;
    },

    async verifyOtp(otp) {
      this.verifying = true;

      try {
        const { data } = await apiClient.post("login", {
          email: this.email,
          otp,
        });
        const token = data?.data?.access_token;
        this.message = Array.isArray(data?.message)
          ? data.message[0]
          : data?.message;

        if (token) {
          this.access_token = token;
          localStorage.setItem("access_token", token);

          this.user = { email: this.email };
          localStorage.setItem("user", JSON.stringify(this.user));

          const cartStore = useCartStore();
          const wishlistStore = useWishlistStore();

          await cartStore.loadCart();
          await wishlistStore.loadWishlist();

          toast.success(this.message);

          setTimeout(() => {
            router.push("/dashboard/my-account");
          }, 1000);
        }
      } catch (error) {
        this.message =
          error?.response?.data?.message?.[0] || "Something went wrong";
        toast.error(this.message);
      }
      this.verifying = false;
    },

    logout() {
      const cartStore = useCartStore();
      const wishlistStore = useWishlistStore();

      cartStore.clearCart();
      wishlistStore.clear();

      this.access_token = null;
      localStorage.removeItem("access_token");

      this.user = null;
      localStorage.removeItem("user");

      this.email = "";

      toast.success("Logout successful.");

      setTimeout(() => {
        router.push("/login");
      }, 500);
    },
  },
});
