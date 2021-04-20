import Vue from "vue";
import VueRouter from "vue-router";
import Homepage from "../views/Homepage.vue";
import Project from "../views/Project.vue";
import Skill from "../views/Skill.vue";
import Presentation from "../views/Presentation.vue";
import Career from "../views/Career.vue";
import ErrorView from "../views/ErrorView.vue";
import Login from "../views/Login.vue";
import Admin from "../views/Admin.vue";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Homepage",
    component: Homepage
  },
  {
    path: "/projects",
    name: "Project",
    component: Project
  },
  {
    path: "/career",
    name: "Career",
    component: Career
  },
  {
    path: "/presentation",
    name: "Presentation",
    component: Presentation
  },
  {
    path: "/skills",
    name: "Skill",
    component: Skill
  },
  {
    path: "/ErrorView/:errorStatus",
    name: "ErrorView",
    component: ErrorView
  },
  {
    path: "/login",
    name: "Login",
    component: Login
  },
  {
    path: "/admin",
    name: "Admin",
    component: Admin
  },
  {
    path: "*",
    redirect: "/ErrorView/404"
  }
];

const router = new VueRouter({
  mode: "history",
  routes
});

router.beforeEach((to, from, next) => {
  const publicPages = [
    "/login",
    "/",
    "/projects",
    "/presentation",
    "/skills",
    "/career",
    "/ErrorView/404",
    "/ErrorView/500"
  ];
  const authRequired = !publicPages.includes(to.path);
  const loggedIn = localStorage.getItem("user");

  // trying to access a restricted page + not logged in
  // redirect to login page
  if (authRequired && !loggedIn) {
    next("/login");
  } else {
    next();
  }
});

router.beforeEach((to, from, next) => {
  if (to.query.wait) {
    setTimeout(() => next(), 100);
  } else if (to.query.redirect) {
    next(to.query.redirect);
  } else if (to.query.abort) {
    next(false);
  } else {
    next();
  }
});

export default router;
