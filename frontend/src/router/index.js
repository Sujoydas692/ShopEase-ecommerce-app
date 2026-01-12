import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/Auth/Login.vue";
import Profile from "../views/Profile.vue";
import Home from "../views/Home.vue";
import MyAccount from "../views/Dashboard/MyAccount.vue";
import { useAuth } from "../store/auth";
import WishList from "../views/Dashboard/WishList.vue";
import Carts from "../views/Dashboard/Carts.vue";
import CheckOut from "../views/Dashboard/CheckOut.vue";
import OrderComplete from "../views/Dashboard/OrderComplete.vue";
import ProductDetail from "../views/ProductDetail.vue";
import CategoryProducts from "../views/CategoryProducts.vue";

const routes = [
  {
    path: "/",
    name: "home",
    component: Home,
  },
  {
    path: "/product-detail/:slug",
    name: "productdetail",
    component: ProductDetail,
  },
  {
    path: "/products/category/:slug",
    name: "category.products",
    component: CategoryProducts,
  },
  {
    path: "/login",
    name: "login",
    component: Login,
    meta: { requiresGuest: true },
  },
  {
    path: "/profile",
    name: "profile",
    component: Profile,
    meta: { requiresAuth: true },
  },
  {
    path: "/dashboard/wish-list",
    name: "wishlist",
    component: WishList,
    meta: { requiresAuth: true },
  },
  {
    path: "/dashboard/carts",
    name: "carts",
    component: Carts,
    meta: { requiresAuth: true },
  },
  {
    path: "/dashboard/checkout",
    name: "checkout",
    component: CheckOut,
    meta: { requiresAuth: true },
  },
  {
    path: "/dashboard/order-complete",
    name: "ordercomplete",
    component: OrderComplete,
    meta: { requiresAuth: true },
  },
  {
    path: "/dashboard/my-account",
    name: "myaccount",
    component: MyAccount,
    meta: { requiresAuth: true },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach(async (to) => {
  const auth = useAuth();

  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    return { name: "login" };
  }
  if (to.meta.requiresGuest && auth.isAuthenticated) {
    return { name: "myaccount" };
  }
});
export default router;
