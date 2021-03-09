import Vue from "vue";
import VueRouter from "vue-router";
import Homepage from "../views/Homepage.vue";
import Project from "../views/Project.vue";
import Skill from "../views/Skill.vue";
import Presentation from "../views/Presentation.vue";
import Career from "../views/Career.vue";
import ErrorView from '../views/ErrorView.vue';

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
    path: "*",
    redirect: "/ErrorView/404"
  }
];

const router = new VueRouter({
  mode: 'history',
  routes
});

router.beforeEach((to, from, next) => {
  console.log('from', from.fullPath)
  console.log('going to', to.fullPath)
  if (to.query.wait) {
    setTimeout(() => next(), 100)
  } else if (to.query.redirect) {
    next(to.query.redirect)
  } else if (to.query.abort) {
    next(false)
  } else {
    next()
  }
})

export default router;
