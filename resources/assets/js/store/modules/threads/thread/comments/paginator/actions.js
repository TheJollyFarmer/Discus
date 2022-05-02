import api from "../../../../../../api/paginator";
import types from "./types";

export default {
  setPaginator({ commit }, paginator) {
    commit(types.SET_PAGINATOR, paginator);
  },

  setRequestForm({ commit }) {
    if (api.getRequestForm()) {
      commit(types.SET_REQUEST_FORM, api.getRequestForm());
    }
  },

  updatePage({ commit, dispatch }, page) {
    commit(types.UPDATE_PAGE, page);

    dispatch("fetchComments");
  },

  updatePerPage({ commit, dispatch }, value) {
    commit(types.UPDATE_PER_PAGE, value);
    commit(types.UPDATE_PAGE, 1);

    dispatch("fetchComments");
  },

  updateOrderBy({ commit, dispatch }, orderBy) {
    commit(types.UPDATE_ORDER_BY, orderBy);
    commit(types.UPDATE_PAGE, 1);

    dispatch("fetchComments");
  },

  updateHash({ commit, dispatch }, { page, hash }) {
    commit(types.UPDATE_PAGE, page);
    commit(types.UPDATE_HASH, hash);

    dispatch("fetchComments");
  },

  updateStorage({ commit, state }, { page, hash }) {
    commit(types.UPDATE_PAGE, page);
    commit(types.UPDATE_HASH, hash);

    api.setRequestForm(state.requestForm);
  },

  fetchComments({ dispatch, state }) {
    dispatch("threads/thread/comments/getData", null, { root: true }).then(() =>
      dispatch("scrollToComment")
    );
  },

  scrollToComment({ dispatch, state }) {
    if (state.requestForm.hash) {
      document
        .getElementById(state.requestForm.hash)
        .scrollIntoView({ behaviour: "smooth" });
    }

    dispatch("updateHistory");
    dispatch("updateStorage", { page: 1, hash: null });
  },

  updateHistory({ state }) {
    let page = state.requestForm.page;

    history.replaceState(
      { page: page },
      null,
      "?page=" + page + state.requestForm.hash
    );
  }
};
