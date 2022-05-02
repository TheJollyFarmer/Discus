import api from "../../../../api/groups";
import dataStructures from "../../../../utils/dataStructures";
import types from "./types";
import Vue from "vue";
import { normalise } from "../../../../utils/helpers";

export default {
  getGroups: ({ commit }) => commit(types.SET_DATA, api.getGroups()),

  listenForNewGroups({ dispatch, rootState }) {
    Vue.prototype.$echo
      .private("App.User." + rootState.auth.user.id)
      .listen("GroupCreated", e => dispatch("addGroup", e.group));
  },

  setMaxGroups: ({ commit }, maxGroups) =>
    commit(types.SET_MAX_GROUPS, maxGroups),

  setGroupDisplay({ commit, dispatch }, group) {
    commit(types.SET_GROUP_DISPLAY, group);

    dispatch("updateStorage");
  },

  createGroup({ dispatch, state }, payload) {
    api.createGroup(payload).then(group => {
      for (const key of state.keys) {
        if (key === group.id) return;
      }

      dispatch("addGroup", group);
    });
  },

  addGroup({ commit, dispatch, getters, state }, group) {
    if (getters.getIsMaxGroups) {
      dispatch("removeGroup", state.keys.shift());
    }

    commit(types.ADD_DATUM, dataStructures.groups(group));
    commit(types.ADD_KEY, group.id);

    dispatch("filterGroupUsers", group);
    dispatch("updateStorage");
  },

  addGroupUsers({ dispatch, getters, state }, { group, users }) {
    getters.getIsGroupType(group)
      ? dispatch("addFriends", { group, users })
      : dispatch("mergeAndCreateGroup", { group, users });
  },

  addFriends({ dispatch }, { group, users }) {
    api.addFriends({ group, users }).then(users => {
      dispatch("filterGroupUsers", { group, users });
    });
  },

  filterGroupUsers({ commit, dispatch, getters }, { id, users }) {
    commit(types.ADD_GROUP_USERS, {
      id,
      users: normalise(getters.getFilteredUsers(users), "groupUsers")
    });

    dispatch("updateStorage");
  },

  mergeAndCreateGroup({ dispatch, getters }, { group, users }) {
    dispatch("createGroup", {
      users: [getters.getGroupUsers(group), ...users],
      type: "group"
    }).then(() => dispatch("removeGroup", group));
  },

  leaveGroup({ dispatch }, group) {
    api.leaveGroup(group).then(() => dispatch("removeGroup", group));
  },

  deleteGroup({ dispatch }, group) {
    api.deleteGroup(group).then(() => dispatch("removeGroup", group));
  },

  removeGroup({ commit, dispatch }, group) {
    commit(types.DELETE_DATUM, group);
    commit(types.REMOVE_GROUP_USERS, group);
    commit(types.REMOVE_KEY, group);

    dispatch("updateStorage");
  },

  updateStorage: ({ state }) => api.setGroups(state)
};
