import api from "../../../api/threads";
import types from "./types";
import { getKeys, hasLength, normalise } from "../../../utils/helpers";

export default {
  getData({ commit, dispatch, getters, state }) {
    if (!state.progress && !state.completed) {
      commit(types.SET_FILTER, api.getFilter());
      commit(types.SET_BREADCRUMB, getters.getFilterName);
      commit(types.TOGGLE_PROGRESS);

      api.getThreads(state.filter, getters.getOffset).then(threads => {
        threads.length
          ? dispatch("addData", threads)
          : dispatch("setCompleted");
      });
    }
  },

  addData({ commit }, threads) {
    commit(types.TOGGLE_PROGRESS);
    commit(types.ADD_DATA, normalise(threads, "threads"));
    commit(types.ADD_KEYS, getKeys(threads));
  },

  setCompleted({ commit }) {
    commit(types.TOGGLE_PROGRESS);
    commit(types.SET_COMPLETED);
  },

  setFilter({ dispatch }, filter) {
    api.isThreadsRoute()
      ? dispatch("applyFilter", filter)
      : dispatch("goToThreads", filter);
  },

  goToThreads(context, filter) {
    api.setFilter(filter);
    api.goToThreads();
  },

  applyFilter({ commit, getters, state }, filter) {
    commit(types.SET_FILTER, filter);
    commit(types.SET_BREADCRUMB, getters.getFilterName);

    api.getThreads(state.filter).then(threads => {
      commit(types.SET_DATA, normalise(threads, "threads"));
      commit(types.SET_KEYS, getKeys(threads));
    });
  },

  toggleContent: ({ commit }, id) => commit(types.TOGGLE_CONTENT, id)
};
