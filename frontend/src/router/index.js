import Vue from "vue";
import VueRouter from "vue-router";
import Homepage from "../views/Homepage.vue";
import Project from "../views/Project.vue";
import Skill from "../views/Skill.vue";
import Presentation from "../views/Presentation.vue";
import Career from "../views/Career.vue";
import Whaterror from "../views/Whaterror.vue";

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
    path: "/whaterror",
    name: "Whaterror",
    component: Whaterror
  },
  {
    path: "*",
    redirect: "/"
  }
];

const router = new VueRouter({
  mode: 'history',
  routes
});

export default router;
