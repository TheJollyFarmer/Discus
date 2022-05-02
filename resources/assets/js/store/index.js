import admin from "./modules/admin/index";
import actions from "./actions";
import auth from "./modules/auth/index";
import getters from "./getters";
import mutations from "./mutations";
import state from "./state";
import threads from "./modules/threads/index";
import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);

export default new Vuex.Store({
  strict: process.env.NODE_ENV !== "production",

  modules: {
    admin,
    auth,
    threads
  },

  state,
  actions,
  mutations,
  getters
});
