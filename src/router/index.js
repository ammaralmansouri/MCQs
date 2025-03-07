import { createRouter, createWebHistory } from "vue-router";

const routes = [
  {
    path: "/",
    name: "signin",
    component: import("../pages/SignIn.vue"),
  },
  {
    path: "/signup",
    name: "signup",
    component: import("../pages/SignUp.vue"),
  },
  {
    path: "/home",
    name: "home",
    component: import("../pages/HomePage.vue"),
  },
  {
    path: "/tests/:id/questions",
    name: "question",
    component: import("../pages/QuestionPage.vue"),
  },
  {
    path: "/ahievements",
    name: "ahievements",
    component: import("../pages/Achievements.vue"),
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
