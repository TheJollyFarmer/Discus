import api from "../../../../api/thread";
import dataStructures from "../../../../utils/dataStructures";
import filters from "../../../../utils/filters";
import types from "./types";

export default {
  setThread({ commit, dispatch }, thread) {
    commit(types.SET_THREAD, dataStructures.threads(thread));

    dispatch("setBreadcrumbs", thread);
    dispatch("setEditForm", thread);
    dispatch("getComments", thread);
  },

  setBreadcrumbs({ commit, state }, thread) {
    commit(types.SET_CHANNEL_BREADCRUMB_LABEL, state.thread.channelName);
    commit(types.SET_CHANNEL_BREADCRUMB_LINK_DATA, state.thread.channelSlug);
    commit(types.SET_BREADCRUMB_LABEL, filters.truncate(thread.title, 30));
  },

  setEditForm({ commit, state }, thread) {
    commit(types.SET_EDIT_TITLE, thread.title);
    commit(types.SET_EDIT_BODY, thread.body);
    commit(types.SET_OLD_TITLE, thread.title);
    commit(types.SET_OLD_BODY, thread.body);
  },

  getComments({ dispatch }, thread) {
    dispatch("comments/paginator/setRequestForm");
    dispatch("comments/getData").then(() =>
      dispatch("comments/paginator/scrollToComment")
    );
  },

  submitComment({ dispatch }, comment) {
    dispatch("comments/submitComment", { body: comment }).then(() =>
      dispatch("closeForm")
    );
  },

  updateThread({ commit, dispatch, state }) {
    if (state.editForm.title && state.editForm.body) {
      if (
        state.editForm.title !== state.oldTitle ||
        state.editForm.body !== state.oldBody
      ) {
        api.updateThread(state.editForm).then(() => {
          commit(types.SET_OLD_TITLE, state.editForm.title);
          commit(types.SET_OLD_BODY, state.editForm.body);

          dispatch("closeForm");
        });
      }
    }
  },

  setEditTitle: ({ commit }, title) => commit(types.SET_EDIT_TITLE, title),
  setEditBody: ({ commit }, body) => commit(types.SET_EDIT_BODY, body),

  setBestComment: ({ commit }, id) =>
    api.setBestComment(id).then(() => commit(types.SET_BEST_COMMENT, id)),

  unsetBestComment: ({ commit }, id) =>
    api.unsetBestComment(id).then(() => commit(types.SET_BEST_COMMENT, null)),

  toggleIsSubscribed({ commit, state }) {
    let type = state.thread.isSubscribed
      ? "unsubscribeToThread"
      : "subscribeToThread";

    api[type](state.thread.slug).then(() => commit(types.TOGGLE_IS_SUBSCRIBED));
  },

  toggleIsLocked({ commit, state }) {
    let type = state.thread.isLocked ? "unlockThread" : "lockThread";

    api[type](state.thread.slug).then(() => commit(types.TOGGLE_IS_LOCKED));
  },

  deleteThread({ state }) {
    api.deleteThread(state.thread.slug).then(() => api.goToHome());
  },

  setFormType: ({ commit }, type) => commit(types.SET_FORM_TYPE, type),

  closeForm({ commit, state }) {
    if (state.formActive === "editing") {
      commit(types.SET_EDIT_TITLE, state.oldTitle);
      commit(types.SET_EDIT_BODY, state.oldBody);
    }

    commit(types.SET_FORM_TYPE, false);
  }
};
