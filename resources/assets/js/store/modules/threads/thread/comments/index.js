import actions from "./actions";
import getters from "./getters";
import mutations from "./mutations";
import paginator from "./paginator/index";
import state from "./state";

export default {
  namespaced: true,

  modules: {
    paginator
  },

  state,
  actions,
  mutations,
  getters
};
