import api from "../api";
import filters from "../utils/filters";
import types from "./types";

export default {
  getChannels({ commit }) {
    api
      .request("get", api.route("channels.index"))
      .then(channels => commit(types.SET_CHANNELS, channels));
  },

  toggleContent({ commit }, type) {
    type === "modal"
      ? commit(types.TOGGLE_MODAL)
      : commit(types.TOGGLE_USER_PANEL);
  },

  openModal({ commit, state }, { type, image }) {
    commit(types.SET_MODAL, filters.capitalise(type));
    commit(types.SET_MODAL_IMAGE, image);

    if (!state.displayOverlay) {
      commit(types.SET_OVERLAY, "modal");
    }
  },

  openUserPanel: ({ commit }) => commit(types.SET_OVERLAY, "panel"),
  closeOverlay: ({ commit }) => commit(types.SET_OVERLAY, ""),
  setErrors: ({ commit }, errors) => commit(types.SET_ERRORS, errors),
  addBreadcrumbs: ({ commit }, breadcrumbs) =>
    commit(types.ADD_BREADCRUMBS, breadcrumbs),
  replaceBreadcrumb: ({ commit }, breadcrumb) => {
    commit(types.REPLACE_BREADCRUMB, breadcrumb);
  }
};
