import api from "../../../../api/notifications";
import dataStructures from "../../../../utils/dataStructures";
import filters from "../../../../utils/filters";
import types from "./types";
import Vue from "vue";
import { getKeys, normalise } from "../../../../utils/helpers";

export default {
  getData({ commit, dispatch, getters, rootState, state }) {
    dispatch("listenForNotifications");

    if (!state.progress && !state.completed) {
      commit(types.TOGGLE_PROGRESS);

      return api
        .getNotifications(rootState.auth.user.username, getters.getOffset)
        .then(data => {
          data.notifications.length
            ? dispatch("addData", data)
            : dispatch("setCompleted");
        });
    }
  },

  addData({ commit }, { count, notifications }) {
    commit(types.TOGGLE_PROGRESS);
    commit(types.ADD_DATA, normalise(notifications, "notifications"));
    commit(types.ADD_KEYS, getKeys(notifications));
    commit(types.SET_UNREAD_COUNT, count);
  },

  setCompleted({ commit }) {
    commit(types.TOGGLE_PROGRESS);
    commit(types.SET_COMPLETED);
  },

  listenForNotifications({ dispatch, rootState, state }) {
    let user = rootState.auth.user.id;

    Vue.prototype.$echo.private("App.User." + user).notification(e => {
      dispatch("addDatum", e);
    });
  },

  addDatum({ commit }, datum) {
    commit(types.ADD_DATUM, dataStructures.notifications(datum));
    commit(types.ADD_KEY, datum.id);
    commit(types.INCREMENT_UNREAD_COUNT);
  },

  markAllAsRead({ dispatch, state, rootState }) {
    if (state.unreadCount !== 0) {
      api
        .markAllAsRead(rootState.auth.user.username)
        .then(dispatch("setAllAsRead"));
    }
  },

  setAllAsRead({ commit, state }) {
    commit(types.SET_UNREAD_COUNT_TO_ZERO);

    for (const item of Object.values(state.data)) {
      if (!item.read_at) {
        commit(types.SET_AS_READ, {
          id: item.id,
          value: filters.timestamp()
        });
      }
    }
  },

  markAs({ dispatch, rootState }, { id, marked }) {
    api.markAs(rootState.auth.user.username, id, marked).then(() => {
      marked ? dispatch("setAsUnread", id) : dispatch("setAsRead", id);
    });
  },

  setAsRead({ commit }, id) {
    commit(types.DECREMENT_UNREAD_COUNT);
    commit(types.SET_AS_READ, { id, value: filters.timestamp() });
  },

  setAsUnread({ commit }, id) {
    commit(types.INCREMENT_UNREAD_COUNT);
    commit(types.SET_AS_UNREAD, { id, value: null });
  },

  generateLink({ dispatch, rootState }, { reply, thread, channel, slug }) {
    api.generateLink(reply).then(link => {
      let currentPageThread = rootState.auth.thread.thread.id;

      currentPageThread === thread
        ? dispatch("goToComment", link)
        : api.goToThread(channel, slug, link);
    });
  },

  goToComment({ dispatch }, link) {
    dispatch("threads/thread/comments/paginator/updateHash", link, {
      root: true
    });
  }
};
